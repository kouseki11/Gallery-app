<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; Stisla</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/components.css">
</head>

<body>
    <div id="app">
        @if (session('error'))
            <div class="alert alert-danger pb-0" role="alert">
                <h4 class="alert-heading">Terjadi Masalah</h4>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="login-brand">
                        <img src="{{ asset('assets') }}/img/logo.png" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>
                </div>
                <div class="col-md-6 mx-auto mt-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.auth') }}" class="needs-validation"
                                novalidate="">
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email @error('email') is-invalid @enderror" type="email"
                                        class="form-control" name="email" tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Please fill in your email
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password @error('password') is-invalid @enderror" type="password"
                                        class="form-control" name="password" tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Please fill in your password
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Your custom scripts -->
    <script src="{{ asset('assets') }}/js/scripts.js"></script>
    <script src="{{ asset('assets') }}/js/custom.js"></script>
</body>

</html>
