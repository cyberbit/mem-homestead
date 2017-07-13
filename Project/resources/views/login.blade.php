@extends('base')

@section('title', 'Login')

@push('styles')
    <style>
        .login-container {
            max-width: 500px;
        }
    </style>
@endpush

@section('content')
    <div class="container login-container">
        <h1>Login to Mem</h1>
        <form action="/api/login">
            <input type="hidden" name="redirect" value="1">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

</html>