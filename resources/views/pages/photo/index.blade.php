@extends('layout.master')

@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection

@section('content')

<h1 class="text-center text-dark">{{ $title }}</h1>
    <div class="sticky-top row justify-content-center" style="top: 20px; z-index: 40">
        <div class="col-md-10">
            <form action="{{ route('album.index') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                    <form>
                </div>
        </div>
    </div>

        <div class="row mt-4">
            @foreach ($photo as $photos)
                @php
                    $fileLocations = json_decode($photos->file_location, true);
                @endphp
                <div class="col-md-4">
                    <div class="card">
                        @if (!empty($fileLocations))
                            <img class="rounded" src="{{ asset('images/photo/' . $fileLocations[0]) }}" alt="{{ $photos->name }}">
                        @else
                            <p>No images available for this photo.</p>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $photos->name }}</h5>
                            <p class="card-text">{{ $photos->description }}</p>
                            @if ($photos->likes()->where('user_id', Auth::id())->exists())
                                <form action="{{ route('like.destroy', $photos->likes->first()->id) }}"
                                    method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-primary" name="photo_id"
                                        value="{{ $photos->id }}">
                                        <i class="bi bi-heart"></i> Unlike
                                    </button>
                                    <a href="#" data-toggle="modal" data-target="#commentModal{{ $photos->id }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-chat"></i> Comment
                                    </a>
                                </form>
                            @else
                                <form action="{{ route('like.store') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary" name="photo_id"
                                        value="{{ $photos->id }}">
                                        <i class="bi bi-heart"></i> Like
                                    </button>
                                    <a href="#" data-toggle="modal" data-target="#commentModal{{ $photos->id }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-chat"></i> Comment
                                    </a>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach ($photo as $photos)
            @php
                $fileLocations = json_decode($photos->file_location, true);
            @endphp
            <div class="modal fade" id="commentModal{{ $photos->id }}" tabindex="-1"
                aria-labelledby="commentModalLabel{{ $photos->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLabel{{ $photos->id }}">Photo Preview:
                                {{ $photos->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" id="closeModal{{ $photos->id }}"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7">
                                    @if (!empty($fileLocations))
                                        <div id="carouselExampleControls{{ $photos->id }}" class="carousel slide"
                                            data-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($fileLocations as $index => $fileLocation)
                                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('images/photo/' . $fileLocation) }}"
                                                            class="img-fluid" style="width: 600px; height: 500px;"
                                                            alt="{{ $photos->description }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if (count($fileLocations) > 1)
                                                <a class="carousel-control-prev"
                                                    href="#carouselExampleControls{{ $photos->id }}" role="button"
                                                    data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next"
                                                    href="#carouselExampleControls{{ $photos->id }}" role="button"
                                                    data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            @else
                                            @endif
                                        </div>
                                    @else
                                        <p>No images available for this photo.</p>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <h6>Comments:</h6>
                                    <div style="height: 312px; overflow:scroll; overflow-x: hidden;">
                                        <ul class="list-group over">
                                            <li class="list-group-item">
                                                <div class="d-flex align-items-center">
                                                    @if(!empty($photos->user->profile_photo))
                                                    <img src="{{ asset('images/profile/' . $photos->user->profile_photo) }}"
                                                        class="rounded-circle mr-2" alt="{{ $photos->user->username }}'s Profile Picture"
                                                        style="width: 30px; max-height: 30px;">
                                                    @else
                                                    <img src="https://ppdb.smkwikrama.sch.id/assets/admin/img/avatar/avatar-1.png"
                                                        class="rounded-circle mr-2" alt="{{ $photos->user->username }}'s Profile Picture"
                                                        style="width: 30px; max-height: 30px;">
                                                    @endif
                                                    <div>
                                                        <strong>{{ $photos->user->username }}</strong>
                                                        <span
                                                            class="text-muted">{{ $photos->created_at->format('M d, Y H:i') }}</span>
                                                    </div>
                                                </div>
                                                <div>{{ $photos->description }}</div>
                                            </li>
                                            @foreach ($photos->comments as $comment)
                                                <li class="list-group-item">
                                                    <div class="d-flex align-items-center">
                                                        @if(!empty($comment->user->profile_photo))
                                                        <img src="{{ asset('images/profile/' . $comment->user->profile_photo) }}"
                                                        class="rounded-circle mr-2" alt="{{ $comment->user->username }}'s Profile Picture"
                                                        style="width: 30px; max-height: 30px;">
                                                        @else
                                                        <img src="https://ppdb.smkwikrama.sch.id/assets/admin/img/avatar/avatar-1.png"
                                                        class="rounded-circle mr-2" alt="{{ $comment->user->username }}'s Profile Picture"
                                                        style="width: 30px; max-height: 30px;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $comment->user->username }}</strong>
                                                            <span
                                                                class="text-muted">{{ $comment->created_at->format('M d, Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                    <div>{{ $comment->comment }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <hr>
                                    <h6>Add a Comment:</h6>
                                    <form class="commentForm" action="{{ route('comment.store') }}"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="photo_id" value="{{ $photos->id }}">
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" rows="3" placeholder="Write your comment here"></textarea>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal"
                                            id="closeModal{{ $photos->id }}">
                                            <i class="bi bi-heart"></i> Like
                                        </button>
                                        <button type="submit" class="btn btn-primary">Comment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary">
                        <i class="bi bi-heart"></i> Like
                    </button>
                </div>
            </div>
    @endforeach
</div>
</div>


@endsection
