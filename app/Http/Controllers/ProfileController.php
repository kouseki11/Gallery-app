<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Album;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($username)
    {
        $data['user'] = User::where('username', $username)->firstOrFail();
        $data['title'] = $data['user']->name . "'s Profile";
        $data['page'] = 'profile';
        $data['album'] = $data['user']->albums;
        $data['photo'] = $data['user']->photos;
        $data['comment'] = $data['user']->comments;
        $data['like'] = $data['user']->likes;

        $totalLikes = 0;
        $totalComments = 0;
    
        foreach ($data['photo'] as $photo) {
            $totalLikes += $photo->likes->count();
            $totalComments += $photo->comments->count();
        }
    
        $data['totalLikes'] = $totalLikes;
        $data['totalComments'] = $totalComments;
        
        return view('pages.profile.index', $data);
    }

    public function photo($username)
    {
        $data['user'] = User::where('username', $username)->firstOrFail();
        $data['title'] = $data['user']->name . "'s Profile";
        $data['page'] = 'profile';
        $data['album'] = $data['user']->albums;
        $data['photo'] = $data['user']->photos;
        $data['comment'] = $data['user']->comments;
        $data['like'] = $data['user']->likes;

        $totalLikes = 0;
        $totalComments = 0;
    
        foreach ($data['photo'] as $photo) {
            $totalLikes += $photo->likes->count();
            $totalComments += $photo->comments->count();
        }
    
        $data['totalLikes'] = $totalLikes;
        $data['totalComments'] = $totalComments;
        return view('pages.profile.photo', $data);
    }
}
