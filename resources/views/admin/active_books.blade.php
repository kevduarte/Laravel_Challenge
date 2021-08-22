@extends('layouts.admin_layout')
@section('title','Admin Home')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"><i class="fa fa-check" aria-hidden="true"></i> Libros Activos</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item">libros</li>
              <li class="breadcrumb-item active">libros activos</li>
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

  <h4><span id="menup2"><i class="fa fa-bookmark" aria-hidden="true"></i> Lista de libros activos</span></h4>

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

  <td><a href="/ver_ejemplares/{{$items->book_id}}"><button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> ver</button></a></td>

<td>
   <button  data-toggle="modal" data-target="#update_user_modal{{ $items->book_id }}" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button>



<!-- The Modal -->
<div class="modal" id="update_user_modal{{ $items->book_id }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Editar libro</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container" style="width: auto;"  align="left">

          <form action="{{ route('actualizar_libro') }}" method="POST">
           @csrf

           <div class="form-group">
    <label for="nom">ISBN</label>
    <input type="text" class="form-control" value="{{ $items->isbn }}" name="isbn">
  </div>
  <div class="form-group">
    <label for="nom">Nombre</label>
    <input type="text" class="form-control" value="{{ $items->book_name }}" name="book_name">
  </div>
   <div class="form-group">
    <label for="nom">Autor</label>
    <input type="text" class="form-control" value="{{  $items->book_author }}" name="book_author">
  </div>
  <div class="form-group">
    <label for="nom">Fecha publicación</label>
    <input type="date" class="form-control" value="{{  $items->publication_date }}" name="publication_date">
  </div>

  <div class="form-group">
    <label for="nom">Categoría</label>
      <select name="category_id" required class="form-control">
      <option value="{!!  $items->category_id !!}">{!! $items->category_name !!}</option>
      @foreach ($categoria as $cat)
      <option value="{!! $cat->category_id !!}"> {!! $cat->category_name !!}</option>
        @endforeach
      </select>
  </div>
  <input type="text" value="{{  $items->book_id }}" name="book_id" hidden>

  <div align="center"><button type="submit" class="btn btn-primary">actualizar</button></div>
  

       </form>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



   <a href="/eliminar_libro/{{$items->book_id}}"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></a>

    <a href="/desactivar_libro/{{$items->book_id}}"><button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> desactivar</button></a>

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
