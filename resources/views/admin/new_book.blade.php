@extends('layouts.admin_layout')
@section('title','New book')

@section('content')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registrar libro</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item">libros</li>
              <li class="breadcrumb-item active">registrar libro</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="container" style="margin: 10px 20px; width: auto; padding: 15px;" id="font2">

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

  <h4><span id="menup2"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo libro</span></h4>

  <form action="{{ route('registrar_libro') }}" method="POST">
     @csrf

    <div class="form-row">

    <div class="form-group col-md-4">
      <label for="book">ISBN</label>
      <input type="text" class="form-control" placeholder="isbn" name="isbn" required>
    </div>

    <div class="form-group col-md-4">
      <label for="book">NOMBRE</label>
      <input type="text" class="form-control" placeholder="nombre" name="book_name" required>
    </div>

    <div class="form-group col-md-4">
      <label for="book">AUTOR</label>
      <input type="text" class="form-control" placeholder="autor" name="book_author">
    </div>

    </div>

    <div class="form-row">

    <div class="form-group col-md-4">
      <label for="book">FECHA DE PUBLICACIÓN</label>
      <input type="date" class="form-control" name="publication_date">
    </div>

    <div class="form-group col-md-4">
      <label for="book">CATEGORÍA</label>
      <select name="category_id" class="form-control" required>
      <option value="">Seleccione una categoría</option>
      @foreach ($categoria as $item)
      <option value="{!! $item->category_id !!}"> {!! $item->category_name !!}</option>
        @endforeach
      </select>

    </div>

    <div class="form-group col-md-4">
      <label for="book">N° DE EJEMPLARES</label>
      <input type="tel" class="form-control" name="num_ejemplar" required>
    </div>

    </div>

<div align="center"><button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> registrar</button></div>
   
    
  </form>

</div>


   

@endsection
