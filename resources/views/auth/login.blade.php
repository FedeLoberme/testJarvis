<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JARVIS</title>
    <link href="public/css/app.css" rel="stylesheet">
    <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="public/bootstrap/css/animate.css" rel="stylesheet">
    <link href="public/bootstrap/css/style.css" rel="stylesheet">
    <link href="public/bootstrap/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('public/img/logo1.png') }}" />
</head>
<body class="gray-bg">
<div class="container">
    <div class="row">
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <h1 class="logo-name">JARVIS</h1>
                </div>
                <h3>Bienvenidos</h3>
                <p>JARVIS es un proyecto de software que hará tus ingenierías más facil.</p>
                <p>Inicio de sesión.</p>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form onkeypress="return enter(event)" class="form-horizontal" role="form" method="POST" id="login" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <button id="inicio" style="display: none;"></button>
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                           <input id="sec" name="sec" type="hidden" value="0">
                        <input style="text-transform: uppercase;" id="username"  placeholder="Usuario de Red Claro" type="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus onkeypress="mayus(this);">
                            @if ($errors->has('username'))
                                <span class="help-block">
                                     <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif  
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">   
                        <input id="password" placeholder="CONTRASEÑA" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif   
                    </div>

                   <!--  <div class="form-group">        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Recuérdame
                            </label>
                        </div>       
                    </div> -->
                    
<!-- {{ url('/password/reset') }} -->
<!--                     <a href="#"><small>Olvidé mi clave</small></a>
                    <p class="text-muted text-center"><small>No recuerdo mi cuenta</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="register.html">Solicitar acceso</a> -->
                </form>
                <button onclick="login_resul();" class="btn btn-danger block full-width m-b">Iniciar sesión</button>
            </div>
        </div>   
    </div>
</div>
@include('confir')
    <script src="public/bootstrap/js/jquery-3.1.1.min.js"></script>
    <script src="public/bootstrap/js/bootstrap.min.js"></script>
    <script src="public/bootstrap/js/plugins/toastr/toastr.min.js"></script>
     <script src="public/js/jarvis.js"></script>
    <script>
        @if(Session::has('message'))
            var type="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>
</body>
</html>