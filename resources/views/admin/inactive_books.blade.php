@extends('layouts.admin_layout')
@section('title','Admin Home')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"><i class="fa fa-ban" aria-hidden="true"></i> Libros Inactivos</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item">libros</li>
              <li class="breadcrumb-item active">libros inactivos</li>
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

  <h4><span id="menup2"><i class="fa fa-bookmark" aria-hidden="true"></i> Lista de libros inactivos</span></h4>

  <div class="table-responsive mt-4">

    <table class="table table-bordered">

      <thead>
        <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">ISBN</th>
      <th scope="col">Nombre</th>
      <th scope="col">Autor</th>
      <th scope="col">Categoría</th>
      <th scope="col">Fecha publicación</th>
      <th scope="col">Estado</th>
      <th scope="col">Ejemplares</th>
      <th colspan="1">Acciones</th>
      
      
         
     
    </tr>
  </thead>

  <tbody>
   @foreach ($books as $items)
   <tr>

    <th> {!! $items->isbn !!}</th>
    <td>{!! $items->book_name !!}</td>
    <td>{!! $items->book_author !!}</td>
    <td>{!! $items->category_name !!}</td>
    <td>{!! $items->publication_date !!}</td>
     

  <td ><?php 
if ($items->book_status=="Activo") {
  echo '<span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Activo</span>';
}else{
  echo '<span class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i> Inactivo</span>';
}

  ?></td>

  <td>
<?php 

$conta=DB::table('ejemplares')
 ->select('ejemplares.id_ejemplar')
  ->where('ejemplares.book_id',  $items->book_id)
 ->count();

echo $conta;

  ?>
  </td>

<td>
   

    <a href="/activar_libro/{{$items->book_id}}"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> activar</button></a>

</td>






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
