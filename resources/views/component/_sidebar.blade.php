<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-4 mb-3">
            <div class="logo">
                <img class="mb-1 rounded-circle" src="{{ asset('assets') }}/img/logo.png" alt="" width="50"
                    height="50">
                <a href="">Shinkai Gallery</a>
            </div>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{ asset('assets') }}/img/logo.png" alt="" width="50" height="50">
        </div>
        <ul class="sidebar-menu">
            <li class="mb-3"><a class="nav-link <?= $page == 'beranda' ? 'active' : '' ?>" href="/album"><i
                        class="fa-solid fa-house"></i> <span>Beranda</span></a></li>
            <li class="mb-3"><a class="nav-link <?= $page == 'profile' ? 'active' : '' ?>" href="#"
                    data-toggle="modal" data-target="#searchUserModal"><i class="fa-solid fa-search"></i>
                    <span>Search</span></a></li>
            <li class="nav-item dropdown mb-3 <?= $page == 'user' ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-plus-square"></i>
                    <span>Buat</span></a>
                <ul class="dropdown-menu">
                    <li class=" <?= $page == 'role' ? 'active' : '' ?>"><a class="nav-link" href="#"
                            data-toggle="modal" data-target="#albumModal"><i class="fa-solid  fa-folder"></i>
                            <span>Album</span></a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li class=" <?= $page == 'role' ? 'active' : '' ?>"><a class="nav-link" href="#"
                            data-toggle="modal" data-target="#photoModal"><i class="fa-solid  fa-file"></i>
                            <span>Photo</span></a></li>
                </ul>
            </li>
            <li class="mb-3"><a class="nav-link <?= $page == 'profile' ? 'active' : '' ?>"
                    href="{{ '/' . Auth::user()->username }}"><i class="fa-solid fa-user"></i> <span>Profile</span></a>
            </li>
            <li class="nav-item dropdown mb-3 <?= $page == 'user' ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-bars"></i>
                    <span>Lainnya</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>

<div class="modal fade" id="searchUserModal" tabindex="-1" role="dialog" aria-labelledby="searchUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchUserModalLabel">Search Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="search-username" class="form-control" placeholder="Search by username"
                    value="{{ request('searchTerm') }}">
                <div id="search-results"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Album Modal -->
<div class="modal fade" id="albumModal" tabindex="-1" role="dialog" aria-labelledby="albumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="albumModalLabel">Add Album</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="recipient-name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="message-text" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Thumbnail:</label>
                        <input type="file" class="form-control" id="recipient-name" name="thumbnail">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Add Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('photo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="recipient-name">
                    </div>
                    <div class="mb-3">
                        <label for="album" class="col-form-label">Album</label>
                        <select class="form-select" name="album_id" id="select_page" onChange="check(this);">
                            <option value="" selected disabled>--Album--</option>
                            @foreach ($album as $albums)
                                <option value="{{ $albums['id'] }}">{{ $albums['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="message-text" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Photo:</label>
                        <input type="file" multiple="multiple" class="form-control" id="recipient-name"
                            name="file_location[]">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Photo</button>
            </div>
            </form>
        </div>
    </div>
</div>
