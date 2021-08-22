@extends('layouts.admin_layout')
@section('title','Admin Home')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Préstamos en curso</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item">préstamos</li>
              <li class="breadcrumb-item active">préstamos en curso</li>
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

  <h4><span id="menup2"><i class="fa fa-list" aria-hidden="true"></i> Lista de préstamos en curso</span></h4>

  <div class="table-responsive mt-4">

    <table class="table table-bordered">

      <thead>
        <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">Fecha Inicio</th>
      <th scope="col">Fecha Fin</th>
      
      <th scope="col">Estado</th>
      <th scope="col">Encargado</th>
      <th scope="col">Persona</th>
      <th scope="col">Acciones</th>
      
         
     
    </tr>
  </thead>

  <tbody>
   @foreach ($prestamo as $items)
   <tr>

    <th> 

   <?php

echo date("d M Y", strtotime($items->start_date));
       
     ?>
    
   
    </th>
    <td> <?php

echo date("d M Y", strtotime($items->end_date));
       
     ?></td>
    
    <td>{!! $items->borrower_status !!}</td> 

  <td >{!! $items->manager_name !!}</td>

  <td>{!! $items->member_name !!}</td>

   <td> 

    <button data-toggle="modal" data-target="#detalles_prestamo{{ $items->borrower_id }}" type="button" class="btn btn-info btn-sm"><i class="fa fa-check-square-o" aria-hidden="true"></i> detalles</button>



<!-- The Modal -->
<div class="modal" id="detalles_prestamo{{ $items->borrower_id }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-pencil" aria-hidden="true"></i> Detalles</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container" style="width: auto;"  align="left">

          <?php

          $prestamo_info = DB::table('borrowers')
     ->select('borrowers.borrower_id','ejemplares.codigo','ejemplares.num_ejemplar','borrowers_ejemplares.detalle_prestamo','books.book_name')
     ->join('borrowers_ejemplares','borrowers.borrower_id','=','borrowers_ejemplares.borrower_id')
     ->join('ejemplares','borrowers_ejemplares.id_ejemplar','=','ejemplares.id_ejemplar')
     ->join('books','ejemplares.book_id','=','books.book_id')
     ->where([['borrowers.borrower_id', $items->borrower_id],['borrowers.borrower_status',"en curso"]])
     ->take(1)
     ->first();





           ?>

          <div class="form-group">
    <label for="nom">Nombre</label>
    <input type="text" class="form-control" value="{{ $prestamo_info->book_name }}" name="isbn">
  </div>

           <div class="form-group">
    <label for="nom">Código ejemplar</label>
    <input type="text" class="form-control" value="{{ $prestamo_info->codigo }}" name="isbn">
  </div>
  <div class="form-group">
    <label for="nom">N° ejemplar</label>
    <input type="text" class="form-control" value="{{ $prestamo_info->num_ejemplar }}" name="book_name">
  </div>
   <div class="form-group">
    <label for="nom">Detalles</label>
    <input type="text" class="form-control" value="{{  $prestamo_info->detalle_prestamo }}" name="book_author">
  </div>


        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



    <a href="/finalizar_prestamo/{{$items->borrower_id}}"><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-hourglass" aria-hidden="true"></i> finalizar</button></a>

  </td>



  </tr>
  @endforeach
</tbody>



</table>
@if (count($prestamo))
{{ $prestamo->links() }}
@endif

@if($prestamo->count()==0)
<div id="menup3" class="alert alert-warning" role="alert">
  <span id="menup3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> No hay resultados.</span> 
</div> 
 @endif   



</div>

</div>

@endsection
