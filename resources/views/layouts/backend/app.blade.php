
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Validation Form</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  
  <!-- Navbar -->
    @include('layouts.backend.include.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('layouts.backend.include.sidebar')
  <!-- /.sidebar -->

  <!-- Content Wrapper. Contains page content -->
    @yield('content')
  <!-- /.content-wrapper -->

    @include('layouts.backend.include.footer')

</div>
<!-- ./wrapper -->

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
