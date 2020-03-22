<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/dd88fc2f98.js" crossorigin="anonymous"></script>
</head>
<body>
  @if(session()->has('flash'))
        <div class="alert alert-info">{{ session('flash') }}</div>
    @endif
  <div class="container">
    <div class="row" id="login">
      <div class="m-auto">
        <div class="card" style="width: 35rem;">
            <div class="card-header">
              <div>
                <img src="https://inba.gob.mx/app/censo/assets/img/logo-inba_1.jpg">
                <img src="https://inba.gob.mx/app/censo/assets/img/logo-cultura_2.jpg" widht="169px" height="67px" align="right">
            </div>
            </div>
            <div class="card-body">
              <h3 class="pb-3">Inicio de Sesión</h3>
                <form method="POST" action="{{route('login')}}">
                    {{ csrf_field() }}
                    <div class="form-group inputWithIcon">
                      <label for="email">Email address</label>
                      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" 
                              placeholder="Enter email" value="{{ old('email') }}">
                              <i class="fa fa-user fa-lg fa-fw" aria-hidden="true"></i>
                              @error('email')
                              <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                    </div>
                    <div class="form-group inputWithIcon">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                      <i class="fa fa-key fa-lg fa-fw" aria-hidden="true"></i>
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
