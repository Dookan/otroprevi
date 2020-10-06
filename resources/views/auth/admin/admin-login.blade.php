<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Previseguros</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 login-section-wrapper">
          <div class="brand-wrapper">
            <img src="{{asset('images/lgoo2.png')}}" alt="logo" class="logo">
          </div>
          <div class="login-wrapper my-auto">
            <h1 class="login-title">Iniciar Sesion</h1>
            @if($errors->any())
              <div class="alert alert-danger m-auto text-center" role="alert" id="errorMessage">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true" style="font-size:20px">×</span>
                  </button>
                  {{-- @foreach ($errors->all() as $error)
                      {{ $error }}
                  @endforeach --}}
                  {{$errors->first()}}
              </div>
            @endif 
            <form action="{{ route('admin.login.submit') }}" method="POST" >
              @csrf
              
              <div class="form-group">
                <label for="username">Usuario</label>
                <input class="form-control" id="username" name="name" value="{{ old('name') }}" aria-describedby="emailHelp" placeholder="Nombre de Usuario" autocomplete="off" autofocus>
              </div>
              <div class="form-group mb-4">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
              </div>

{{--               <div class="form-group">
                <div>
                  <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                  @if($errors->has('g-recaptcha-response'))
                    <span class="invalid-feedback" style="display: block;">
                      <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                    </span>
                  @endif
                </div>
              </div> --}}

              <button type="submit" class="btn btn-block login-btn">
                Iniciar Sesión
              </button>

            </form>
           </div>
        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="{{asset('images/login.jpg')}}" alt="login image" class="login-img">
        </div>
      </div>
    </div>
  </main>
  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('js/jquery/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
  <script>
    let message = document.getElementById('errorMessage')
    let username = document.getElementById('username');
    let password = document.getElementById('password');
    
    if (message) {
      $(document).ready(() => {
        if (username.value.length < 1) {
          username.classList.add('is-invalid')
        }

        username.addEventListener('keyup', () => {
          if(username.value.length < 1){
            username.classList.add('is-invalid');
          } else {
            username.classList.remove('is-invalid');
            username.classList.add('is-valid');
          }
        });

        if (password.value.length < 1) {
          password.classList.add('is-invalid')
        }

        password.addEventListener('keyup', () => {
          if (password.value.length < 8) {
            password.classList.add('is-invalid');
          } else {
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
          }
        });

      });

      if(message.innerText.indexOf('Usuario') != -1){
        password.classList.add('is-invalid')
        username.classList.add('is-invalid')
      }
    }
  </script>

</body>
</html>
