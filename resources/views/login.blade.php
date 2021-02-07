<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kantor Pos Denpasar | Log in</title>
  <link rel="shortcut icon" href="{{asset('logo.png')}}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
            
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{asset('logo.png')}}" width="200px" height="100px" alt="">
    <br>
    
  </div>
  <center><h3>SISTEM PENGELOLAAN DAN PERAMALAN STOK BARANG GUDANG</h3></center>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h4 class="login-box-msg">Login</h4>
    @if(session('message'))
    <div class="alert alert-danger">
        {{session('message')}}
    </div>
    @endif
    <form action="{{route('login.submit')}}" method="post">
        @csrf
      <div class="form-group has-feedback">
        <input type="username" class="form-control" name="username" placeholder="username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
      
      </div>
    </form>

  </div>
  
</div>
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

</body>
</html>
