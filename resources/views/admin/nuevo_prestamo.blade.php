@extends('layouts.admin_layout')
@section('title','Admin Home')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo préstamo</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item">prestamos</li>
              <li class="breadcrumb-item active">nuevo préstamo</li>
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
      
      <th scope="col">Categoría</th>
    
      <th scope="col">Estado</th>
      <th scope="col">Total de Ejemplares</th>
      <th scope="col">Ejemplares disponibles</th>
      <th scope="col">Ejemplares en préstamo</th>
      <th colspan="1">Acciones</th>
      
      
         
     
    </tr>
  </thead>

  <tbody>
   @foreach ($books as $items)
   <tr>

    <th> {!! $items->isbn !!}</th>
    <td>{!! $items->book_name !!}</td>
    
    <td>{!! $items->category_name !!}</td> 

  <td ><?php 
if ($items->book_status=="Activo") {
  echo '<span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i> Activo</span>';
}else{
  echo '<span class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i> Inactivo</span>';
}

  ?></td>

  <td><?php

       $conta1=DB::table('ejemplares')
      ->select('ejemplares.id_ejemplar')
      ->where([['ejemplares.book_id',$items->book_id]])
      ->count();


      echo $conta1;


     ?></td>

  <td>

    <?php

       $conta=DB::table('ejemplares')
      ->select('ejemplares.id_ejemplar')
      ->where([['ejemplares.book_id',$items->book_id],['ejemplares.estado_ejemplar',"Disponible"]])
      ->count();


      echo $conta;


     ?>
    
  </td>

   <td>

    <?php

       $conta2=DB::table('ejemplares')
      ->select('ejemplares.id_ejemplar')
      ->where([['ejemplares.book_id',$items->book_id],['ejemplares.estado_ejemplar',"No Disponible"]])
      ->count();


      echo $conta2;


     ?>
    
  </td>

<td>

   <?php

      if (!empty($conta)) {
        echo ' <button  data-toggle="modal" data-target="#nuevo_prestamo{{ $items->book_id }}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Prestar</button>';
      }else{
        echo '<span class="badge badge-danger">No hay ejemplares<br/> disponibles</span>';
      }


     ?>
  



<!-- The Modal -->
<div class="modal" id="nuevo_prestamo{{ $items->book_id }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo prestamo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container" style="width: auto;"  align="left">

          <form action="{{ route('aceptar_prestamo') }}" method="POST">
           @csrf
<div class="form-row">
           <div class="form-group col-md-6">
    <label for="nom">ISBN</label>
    <input type="text" class="form-control" value="{{ $items->isbn }}" name="isbn">
  </div>
  <div class="form-group col-md-6">
    <label for="nom">Nombre</label>
    <input type="text" class="form-control" value="{{ $items->book_name }}" name="book_name">
  </div>

    </div>

    <div class="form-row">
 <div class="form-group col-md-6">
    <label for="nom">Fecha inicio</label>
    <input type="date" class="form-control" name="start_date" required>
  </div>

    <div class="form-group col-md-6">
    <label for="nom">Fecha inicio</label>
    <input type="date" class="form-control" name="end_date" required>
  </div>
 
  </div>


  <div class="form-group">
    <label for="nom">Persona</label>
    <select name="member_id" required class="form-control">
     
      @foreach ($member as $mem)
      <option value="{!! $mem->member_id !!}"> {!! $mem->member_name !!}</option>
        @endforeach
      </select>
      
  </div>


  <input type="text" value="{{  $items->book_id }}" name="book_id" hidden>

  <div align="center"><button type="submit" class="btn btn-success">aceptar</button></div>
  

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
