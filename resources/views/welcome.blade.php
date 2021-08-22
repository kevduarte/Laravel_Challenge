@extends('layouts.app')
@section('title','Home')

@section('content')
<div class="container p-4" id="font2" style="background-image: url('img/books.jpg'); background-size: cover; background-position:center; background-repeat: no-repeat; margin-top: 5%;">

  <h6>Library</h6>

  @if (Session::has('mess'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ Session::get('mess') }}</strong>
  </div>
  @endif

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"> <h5>Login</h5></div>
          
          @if (Session::has('message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('message') }}</strong>
          </div>
          @endif
          @if (Session::has('message_error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('message_error') }}</strong>
          </div>
          @endif



          <div class="card-body">
            <form method="POST" action= "{{ route('login')}} ">
              @csrf

              <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                <div class="col-md-6">
                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>

                  @error('username')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mt-4">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                  <input type="checkbox" onclick="myFunction()"> ver

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>




              <div class="form-group">
                <div class="col-md-8 offset-md-5">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Acceder') }}
                  </button>
                </div>




              </div>
            </form>




          </div>
          <!-- Remind Passowrd -->


        </div>
      </div>
      <span id="autor">Autor: Angel Kevin Pérez Duarte</span>
    </div>
  </div>


</div>
@endsection


<script>
  function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
}
</script>