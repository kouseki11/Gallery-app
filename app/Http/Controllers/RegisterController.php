<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Throwable;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.auth.register', [
            'title' => 'Register'
        ]);
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'username' => 'required',
                'email'=>'required',
                'password'=>'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            }
            $data = $validator->validated();

        // Extract words from name and email
        $password = bcrypt($data['password']);

        $data['password'] = $password;

            User::create($data);
            DB::commit();
            return redirect()->route('login')->with('success', 'Berhasil register');
        } catch (Throwable $e) {
            DB::rollback();
            Log::debug('UserController store() ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
