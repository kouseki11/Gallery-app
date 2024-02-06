<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] = User::where('username', Auth::user()->username)->firstOrFail();
        $data['album'] = $data['user']->albums;
        $data['title'] = 'Album List';
        $data['page'] = 'album';
        $data['albums'] = Album::latest()->filter(request(['search']))->paginate(10)->withQueryString();
        return view('pages.album.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

            $image = $request->file('thumbnail');
            $imgName = time() . rand() . '.' . $image->extension();

            if (!file_exists(public_path('/images/album' . $image->getClientOriginalName()))) {
                $destinationPath = public_path('/images/album');

                $image->move($destinationPath, $imgName);
                $uploaded = $imgName;
            } else {
                $uploaded = $image->getClientOriginalName();
            }

            $data['user_id'] = Auth::user()->id;

            $data['thumbnail'] = $uploaded;

            Album::create($data);
            DB::commit();
            return redirect()->route('album.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('AlbumController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Album $album)
    {
        $data['user'] = User::where('username', Auth::user()->username)->firstOrFail();
        $data['album'] = $data['user']->albums;
        $data['albums'] = Album::where('id', $album->id)->firstOrFail();
        $data['title'] = $data['albums']->name . "'s Album";
        $data['page'] = 'Detail Album';
        $data['photo'] = $data['albums']->photos()->get();
    
        $totalLikes = 0;
        $totalComments = 0;
    
        foreach ($data['photo'] as $photo) {
            $totalLikes += $photo->likes->count();
            $totalComments += $photo->comments->count();
        }
    
        $data['totalLikes'] = $totalLikes;
        $data['totalComments'] = $totalComments;
    
        return view('pages.album.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        //
    }
}
