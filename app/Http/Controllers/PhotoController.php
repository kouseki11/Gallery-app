<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] = User::where('username', Auth::user()->username)->firstOrFail();
        $data['title'] = "Photo List";
        $data['page'] = 'photo_list';
        $data['album'] = $data['user']->albums;
        $data['photo'] = Photo::latest()->get();
        $data['like'] = $data['user']->likes;
        return view('pages.photo.index', $data);
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
                'album_id' => 'required',
                'file_location.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }

            $data = $validator->validated();
            $user_id = Auth::user()->id;

            $uploadedFiles = [];

            foreach ($request->file('file_location') as $image) {
                $imgName = time() . rand() . '.' . $image->extension();

                $destinationPath = public_path('/images/photo');

                $image->move($destinationPath, $imgName);
                $uploadedFiles[] = $imgName;
            }

            $data['user_id'] = $user_id;
            $data['file_location'] = json_Encode($uploadedFiles); // Serialize array before storing

            // dd($data);

            Photo::create($data);

            DB::commit();
            return redirect()->route('profile.photo')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Error in PhotoController@store: ' . $e->getMessage()); // Logging error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
