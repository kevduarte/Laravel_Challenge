@extends('layouts.admin_layout')
@section('title','Admin Home')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><span id="menup"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Préstamos finalizados</span></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Home</a></li>
              <li class="breadcrumb-item">préstamos</li>
              <li class="breadcrumb-item active">préstamos finalizados</li>
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

  <h4><span id="menup2"><i class="fa fa-list" aria-hidden="true"></i> Lista de préstamos finalizados</span></h4>

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
