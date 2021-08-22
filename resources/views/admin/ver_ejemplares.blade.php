@extends('layouts.admin_layout')
@section('title','Admin Home')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"><i class="fa fa-eye" aria-hidden="true"></i> Ver ejemplares</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item"><a>libros</a></li>
              <li class="breadcrumb-item"><a href="{{ route('libros_activos')}}">libros activos</a></li>
              <li class="breadcrumb-item active"><a>ver ejemplares</a></li>            
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class="container" style="margin: 10px 20px; width: auto;">

  

   @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
     {{ Session::get('message') }}
    </div>
    @endif

 @if (Session::has('message2'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
     {{ Session::get('message2') }}
    </div>
    @endif

  <h4><span id="menup2"><i class="fa fa-list-ol" aria-hidden="true"></i> Lista de ejemplares del libro {{$name->book_name}} </span></h4>

  <div class="table-responsive mt-4">

    <table class="table table-bordered">

      <thead>
        <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">N°</th>
      <th scope="col">Nombre</th>
      <th scope="col">Código ejemplar</th>
      <th scope="col">Estado ejemplar</th>
    
      
         
     
    </tr>
  </thead>

  <tbody>
   @foreach ($books as $items)
   <tr>

    <td>{!! $items->num_ejemplar !!}</td>
    <td>{!! $items->book_name !!}</td>
    <td>{!! $items->codigo !!}</td>
    <td>  <?php 
if ($items->estado_ejemplar=="Disponible") {
  echo '<span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Disponible</span>';
}else{
  echo '<span class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i> No Disponible</span>';
}

  ?></td>

  </tr>
  @endforeach
</tbody>



</table>
@if (count($books))
{{ $books->links() }}
@endif

@if($books->count()==0)
<div id="menup3" class="alert alert-warning" role="alert">
  <span id="menup3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> No hay resultados.</span> 
</div> 
 @endif   



</div>

</div>

@endsection
