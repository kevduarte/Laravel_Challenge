<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Library | @yield('title')</title>

    <link rel="stylesheet"  href="{{asset('/css/estilohome.css')}}">

   <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/requisitos/lte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('/requisitos/lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/requisitos/lte/dist/css/adminlte.min.css')}}">
  
 <!-- Fontawesome -->
    <script src="https://use.fontawesome.com/8e08875e32.js"></script>
    
  
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">

      <div id="wrapper">
         <!-- Navbar -->
         <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->

          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </li>
         </ul>

         <span class="navbar-text">Laravel library</span>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <span class="logout-spn">
             <a class="btn btn-default" href="{{ route('logout_system') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>

             <form id="logout-form" action="{{ route('logout_system') }}" method="POST" style="display: none;">
                @csrf
            </form>

            </span>
            </li>
           </ul>

        </nav>
<!-- /.navbar -->


   <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 " style="background-color: #00091D;">
   
     <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="/img/logol.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Library</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

       <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> <?php 

          $usuario_actual=\Auth::user();
          $id_user=$usuario_actual->id_user;

       $nombre_user=DB::table('users')
      ->select('manager.manager_name')
      ->join('manager','users.manager_id','=','manager.manager_id')
      ->where('users.id_user',$id_user)
      ->take(1)
      ->first();

      $nombre_user=$nombre_user->manager_name;

      echo $nombre_user;
  ?> </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <!-- Agregue íconos a los enlaces utilizando la clase .nav-icon
           con font-awesome o cualquier otra biblioteca de fuentes de iconos  -->

           <li class="nav-header">
            <i class="fa fa-bars"></i>&nbsp;MENU</li>

             <li class="nav-item has-treeview">

            <a href="{{ route('admin')}}" class="nav-link">
             <i class="fa fa-home" aria-hidden="true"></i>
              <p>
                Home
                
              </p>
            </a>

          </li>


           <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  
                  <i class="fa fa-book" aria-hidden="true"></i>
                  
                  <p>
               Libros
                    <i class="right fas fa-angle-left"></i> 
              </p>
                
                </a>
                <ul class="nav nav-treeview">
                 
                  <li class="nav-item">
               <a href="{{ route('new_book')}}" class="nav-link">
              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              <p class="itemp">
                Registrar libro
                
              </p>
            </a>
              </li>
               <li class="nav-item">
               <a href="{{ route('libros_activos')}}" class="nav-link">
                  <i class="fa fa-check" aria-hidden="true"></i>
                 <p class="itemp">
                Libros activos
                
              </p>
               </a>
              </li>
               <li class="nav-item">
               <a href="{{ route('libros_inactivos')}}" class="nav-link">
                 <i class="fa fa-ban" aria-hidden="true"></i>
                 <p class="itemp">
                Libros Inactivos
                
              </p>
               </a>
              </li>
                  
              <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
                </ul>
              </li>

          <!-- LIBROS -->

           
          <!-- LIBROS -->

         <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="fa fa-handshake-o" aria-hidden="true"></i>
              <p>
                Préstamos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

              <ul class="nav nav-treeview">
                 
                  <li class="nav-item">
               <a href="{{ route('nuevo_prestamo')}}" class="nav-link">
             <i class="fa fa-plus" aria-hidden="true"></i>
              <p class="itemp">
                Nuevo préstamos
                
              </p>
            </a>
              </li>
               <li class="nav-item">
               <a href="{{ route('prestamo_encurso')}}" class="nav-link">
                <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                 <p class="itemp">
              Préstamos en curso
                
              </p>
               </a>
              </li>
               <li class="nav-item">
               <a href="{{ route('prestamo_finalizado')}}" class="nav-link">
                 <i class="fa fa-hourglass" aria-hidden="true"></i>
                 <p class="itemp">
                Préstamos finalizados
                
              </p>
               </a>
              </li>
                  
              <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
                </ul>

          </li>

        </ul>

 <hr class="sidebar-divider" style=" background-color: #5B7194;"><!-- Heading -->
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


</div>
   

 
   <!-- jQuery -->
<script src="{{asset('/requisitos/lte/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/js/app.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('/requisitos/lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/requisitos/lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/requisitos/lte/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/requisitos/lte/dist/js/demo.js')}}"></script>


  </body>
</html>