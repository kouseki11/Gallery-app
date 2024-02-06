@extends('layout.master')

@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="d-flex justify-content-center align-items-center">
                    @if(!empty($user->profile_photo))
                    <img src="{{ asset('images/profile/' . $user->profile_photo) }}"
                        class="rounded-circle picture" style="width: 200px; height: 200px;">
                    @else
                    <img src="https://ppdb.smkwikrama.sch.id/assets/admin/img/avatar/avatar-1.png"
                        class="rounded-circle picture" style="width: 200px; height: 200px;">
                    @endif
                </div>
            </div>
            <div class="col-md-9 text-dark">
                <div class="profile-info">
                    <h1 class="text-center mb-3">{{ $user->username }}</h1>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Album {{ $album->count() }}</h5>
                            <span class="text-muted mx-2">|</span>
                            <h5 class="mb-0">Photo {{ $photo->count() }}</h5>
                        </div>
                        @if(Auth::user()->username == $user->username)
                        <a class="btn btn-outline-primary" href="#" data-toggle="modal"
                            data-target="#editProfileModal">Edit Profile</a>
                        @else
                        @endif
                    </div>
                    <hr class="mt-3 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <p class="mb-0"><strong>Likes</strong></p>
                            <h5 class="mb-0">{{ $totalLikes }}</h5>
                        </div>
                        <div class="col-4">
                            <p class="mb-0"><strong>Comments</strong></p>
                            <h5 class="mb-0">{{ $totalComments }}</h5>
                        </div>
                        <div class="col-4">
                            <p class="mb-0"><strong>Name</strong></p>
                            <h5 class="mb-0">{{ $user->name }}</h5>
                        </div>
                    </div>
                    <hr class="mt-4 mb-4">
                    <p class="mb-0"><strong>Address</strong></p>
                    <p class="mb-0">{{ $user->address }}</p>
                </div>
                <hr class="mt-4 mb-4">
            </div>
        </div>
        <ul class="nav nav-tabs nav-justified mt-4">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ '/' . $user['username'] }}">Album</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ '/' . $user['username'] . '/photo' }}">Photo</a>
            </li>
        </ul>

        <div class="row mt-4">
        @foreach($album as $albums)
            <div class="col-md-4">
                <div class="card" style="height: 460px">
                    <a href="{{ route('album.show', $albums->id) }}">
                    <img src="{{ asset('images/album/'. $albums['thumbnail']) }}" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ $albums->name }}</h5>
                    @if (strlen($albums->description) > 100)
                        <p class="card-text">{{ substr($albums->description, 0, 100) }}... <a href="{{ route('album.show', $albums->id) }}">Read More</a></p>
                    @else
                        <p class="card-text">{{ $albums->description }}</p>
                    @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editProfileForm" action="{{ route('user.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="profilePhoto">Profile Photo:</label>
                                    @if(!empty($user->profile_photo))
                                    <img id="previewImage"
                                        src="{{ asset('/images/profile/' . $user->profile_photo) }}"
                                        alt="Preview"
                                        style="width: 150px; height: 150px; margin-top: 10px; cursor: pointer; border-radius: 50%">
                                    @else
                                    <img id="previewImage"
                                        src="https://ppdb.smkwikrama.sch.id/assets/admin/img/avatar/avatar-1.png"
                                        alt="Preview"
                                        style="width: 150px; height: 150px; margin-top: 10px; cursor: pointer; border-radius: 50%">
                                    @endif
                                    <input type="file" class="form-control-file d-none" id="profilePhoto"
                                        name="profile_photo" onchange="previewImage(event)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ $user->username }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" required>
                                    </div>
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $user->address }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    </div>

    <script>
        // Mengambil referensi ke elemen input file
        const profilePhoto = document.getElementById('profilePhoto');

        // Menambahkan event listener untuk gambar
        document.getElementById('previewImage').addEventListener('click', function() {
            // Mengubah tipe input file menjadi visible saat gambar diklik
            profilePhoto.click();
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('previewImage');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Event listener for file input change
        document.getElementById('profilePhoto').addEventListener('change', previewImage);
    </script>
@endsection
