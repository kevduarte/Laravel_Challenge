<?php

namespace App\Http\Controllers;
use App\User;
use App\Book;
use App\Borrower;
use App\Category;
use App\Manager;
use App\Ejemplar;
use App\Borrower_Ejemplar;
use App\Member;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{
    
    //INICIO ADMIN LIBRARY
  public function home(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }


   $total=DB::table('books')
      ->select('books.book_id')
      ->count();

$total2=DB::table('borrowers')
      ->select('borrowers.borrower_id')
      ->where('borrowers.borrower_status',"en curso")
      ->count();

      $total3=DB::table('books')
      ->select('borrowers.borrower_id')
      ->where('books.book_status',"Activo")
      ->count();

  $total4=DB::table('books')
      ->select('borrowers.borrower_id')
      ->where('books.book_status',"Inactivo")
      ->count();


 
return view('admin.home_admin')->with('total',$total)->with('total2',$total2)->with('total3',$total3)->with('total4',$total4);

}

//libros disponibles
  public function libros_activos(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

 $categoria=DB::table('categories')
      ->select('categories.category_id','categories.category_name')
      ->get();

$books=DB::table('books')
 ->select('books.book_id','books.isbn','book_status','books.book_name','books.book_author','books.publication_date','categories.category_id','categories.category_name','categories.category_description')
 ->join('categories', 'books.category_id', '=', 'categories.category_id')
  ->where('books.book_status', "Activo")
 ->orderBy('books.book_id', 'DESC')
 ->paginate(5);

return view('admin.active_books')->with('books',$books)->with('categoria',$categoria);

}

//metodo que registra un nuevo libro
 public function new_book(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }


    $categoria=DB::table('categories')
      ->select('categories.category_id','categories.category_name')
      ->get();
   

return view('admin.new_book')->with('categoria',$categoria);

}

public function registrar_libro(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

       
     $this->validate($request, 
    ['isbn' => ['required', 'string', 'max:100','unique:books']]);

    $data = $request;

        $book=new Book;
        $book->isbn=$data['isbn'];
        $book->book_name=$data['book_name'];
        $book->book_author=$data['book_author'];
        $book->publication_date=$data['publication_date'];
        $book->category_id=$data['category_id'];
        $book->save();

        if($book->save()){

     $book_id = DB::table('books')
     ->select('books.book_id')
     ->orderBy('created_at', 'desc')
     ->take(1)
     ->first();

     $book_id= $book_id->book_id;

     $valor=$data['num_ejemplar'];  
       
       if (empty($valor)) {
           $valor=1;
       }else{
        $valor=$data['num_ejemplar'];
       }

         for ($i = 1; $i <= $valor; $i++) {

          $ejemplar=new Ejemplar;
          $ejemplar->codigo=$i;
          $ejemplar->num_ejemplar=$i;
          $ejemplar->book_id=$book_id;
          $ejemplar->save();
        }

        Session::flash('message','¡Libro registrado!');
         return redirect()->route('libros_activos');

        }


}




    public function editar_libro($book_id){


      $id= $book_id;
    
     
      $book = DB::table('books')
     ->select('books.book_id','books.isbn','books.book_status','books.book_name','books.book_author','books.publication_date','categories.category_id','categories.category_name','categories.category_description')
     ->join('categories', 'books.category_id', '=', 'categories.category_id')
      ->where([['books.book_id', $id]])
      ->take(1)
      ->first();




      $categoria=DB::table('categories')
      ->select('categories.category_id','categories.category_name')
      ->get();



return view('admin.edit_book')->with('book', $book)->with('categoria',$categoria);

    }




    public function actualizar_libro(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

    $data = $request;

    $book_id=$data->book_id;
    $isbn=$data->isbn;
    $book_name=$data->book_name;
    $book_author=$data->book_author;
    $publication_date=$data->publication_date;
    $category_id=$data->category_id;

      
     DB::table('books')
     ->where([['books.book_id', $book_id]])
    ->update(
        ['isbn' => $isbn ,'book_name' => $book_name ,'book_author' => $book_author ,'publication_date' => $publication_date, 'category_id' => $category_id]);

 Session::flash('message','¡Libro actualizado!');
         return redirect()->route('libros_activos');

}

public function eliminar_libro($book_id){


      $id= $book_id;
    
    $book = DB::table('books')
     ->select('books.book_id')
      ->where([['books.book_id', $id]])
      ->take(1)
      ->first();


      $book_id=$book->book_id;
      $status="en curso";

     $estado=DB::table('ejemplares')
      ->select('ejemplares.id_ejemplar')
      ->join('borrowers_ejemplares','ejemplares.id_ejemplar','=','borrowers_ejemplares.id_ejemplar')
      ->join('borrowers','borrowers_ejemplares.borrower_id','=','borrowers.borrower_id')
      ->where([['borrowers.borrower_status',$status],['ejemplares.book_id',$book_id]])
      ->count();


         if (empty($estado)) {

   DB::table('ejemplares')
 ->where([['ejemplares.book_id', $book_id]])
->delete();

DB::table('books')
 ->where([['books.book_id', $book_id]])
->delete();



Session::flash('message2','¡Libro eliminado!');
         return redirect()->route('libros_activos');

          
      }


Session::flash('message2','¡No se puede eliminar el libro,
 actualmente tiene ejemplares con préstamo en curso!');
         return redirect()->route('libros_activos');


    }


    public function ver_ejemplares($book_id){
        $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

   $id=$book_id;

   $book = DB::table('books')
     ->select('books.book_name','num_ejemplar','codigo','estado_ejemplar')
     ->join('ejemplares','books.book_id','=','ejemplares.book_id')
      ->where([['books.book_id', $id]])
      ->orderBy('books.book_id', 'DESC')
      ->paginate(5);

      $name = DB::table('books')
     ->select('books.book_name')
      ->where([['books.book_id', $id]])
      ->take(1)
      ->first();
      


     return view('admin.ver_ejemplares')->with('books',$book)->with('name',$name);
    }




public function desactivar_libro($book_id){
     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

     $id= $book_id;
     $status="en curso";

      $book = DB::table('books')
     ->select('books.book_id')
      ->where([['books.book_id', $id]])
      ->take(1)
      ->first();

      $book_id=$book->book_id;

      $estado=DB::table('ejemplares')
      ->select('ejemplares.id_ejemplar')
      ->join('borrowers_ejemplares','ejemplares.id_ejemplar','=','borrowers_ejemplares.id_ejemplar')
      ->join('borrowers','borrowers_ejemplares.borrower_id','=','borrowers.borrower_id')
      ->where([['borrowers.borrower_status',$status],['ejemplares.book_id',$book_id]])
      ->count();


      if (empty($estado)) {

    DB::table('books')
    ->where('books.book_id', $book_id)
    ->update(
      ['book_status' => 'Inactivo']);

      DB::table('ejemplares')
    ->where('ejemplares.book_id', $book_id)
    ->update(
      ['estado_ejemplar' => 'No Disponible']);  



Session::flash('message','¡Libro desactivado!');
         return redirect()->route('libros_inactivos');
          
      }


Session::flash('message2','¡No se puede desactivar el libro,
 actualmente tiene ejemplares con préstamo en curso!');
         return redirect()->route('libros_activos');

}


public function libros_inactivos(){

 $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

$books=DB::table('books')
 ->select('books.book_id','books.isbn','book_status','books.book_name','books.book_author','books.publication_date','categories.category_id','categories.category_name','categories.category_description')
 ->join('categories', 'books.category_id', '=', 'categories.category_id')
  ->where('books.book_status', "Inactivo")
 ->orderBy('books.book_id', 'DESC')
 ->paginate(5);

return view('admin.inactive_books')->with('books',$books);

}



public function activar_libro($book_id){
     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

     $id= $book_id;
     $status="en curso";

      $book = DB::table('books')
     ->select('books.book_id')
      ->where([['books.book_id', $id]])
      ->take(1)
      ->first();

      $book_id=$book->book_id;

      
    DB::table('books')
    ->where('books.book_id', $book_id)
    ->update(
      ['book_status' => 'Activo']);

      DB::table('ejemplares')
    ->where('ejemplares.book_id', $book_id)
    ->update(
      ['estado_ejemplar' => 'Disponible']);  



         Session::flash('message','¡Libro activado!');
         return redirect()->route('libros_activos');

}



public function nuevo_prestamo(){
     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }


   $books=DB::table('books')
 ->select('books.book_id','books.isbn','book_status','books.book_name','books.book_author','books.publication_date','categories.category_id','categories.category_name','categories.category_description')
 ->join('categories', 'books.category_id', '=', 'categories.category_id')
  ->where('books.book_status', "Activo")
 ->orderBy('books.book_id', 'DESC')
 ->paginate(5);


$member=DB::table('members')
 ->select('member_id','members.member_name','members.member_address')
 ->orderBy('members.member_id', 'DESC')
 ->paginate(5);

 return view('admin.nuevo_prestamo')->with('books',$books)->with('member',$member);


   }


   public function aceptar_prestamo(Request $request){

       $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }

   $manager_id=$usuario_actual->manager_id;
   $data = $request;

     $borrow=new Borrower;
        $borrow->start_date=$data['start_date'];
        $borrow->end_date=$data['end_date'];
        $borrow->member_id=$data['member_id'];
        $borrow->manager_id=$manager_id;
        $borrow->save();

         if($borrow->save()){

     $borrow_id = DB::table('borrowers')
     ->select('borrowers.borrower_id')
     ->orderBy('created_at', 'desc')
     ->take(1)
     ->first();

     $borrow_id=$borrow_id->borrower_id;

     $id_ejemplar = DB::table('ejemplares')
     ->select('ejemplares.id_ejemplar')
     ->where('ejemplares.book_id', $data['book_id'])
     ->take(1)
     ->first();

     $id_ejemplar=$id_ejemplar->id_ejemplar;

     $borrow_ejemplar=new Borrower_Ejemplar;
        $borrow_ejemplar->detalle_prestamo="préstamo en curso";
        $borrow_ejemplar->id_ejemplar=$id_ejemplar;
        $borrow_ejemplar->borrower_id=$borrow_id;
        $borrow_ejemplar->save();


        if ($borrow_ejemplar->save()) {


             $estado=DB::table('ejemplares')
      ->select('ejemplares.id_ejemplar')
      ->where([['ejemplares.book_id',$data['book_id']],['ejemplares.estado_ejemplar',"Disponible"]])
      ->count();

      if ($estado>0) {
          DB::table('ejemplares')
    ->where('ejemplares.id_ejemplar', $id_ejemplar)
    ->update(
      ['estado_ejemplar' => 'No Disponible']); 

     Session::flash('message','¡Préstamo realizado!');
         return redirect()->route('prestamo_encurso');

      }else{

         Session::flash('message2','¡El libro ya no tiene ejemplares disponibles!');
         return redirect()->back();

      }

    
       
            
        }

 }



}


 public function prestamo_encurso(){

     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }


 $prestamo=DB::table('borrowers')
      ->select('borrowers.borrower_id','borrowers.start_date','borrowers.end_date','borrowers.borrower_status','manager.manager_name','members.member_name')
      ->join('members','borrowers.member_id','=','members.member_id')
      ->join('manager','borrowers.manager_id','=','manager.manager_id')
      ->where('borrowers.borrower_status','=',"en curso")
      ->orderBy('borrowers.updated_at', 'DESC')
      ->paginate(5);

  return view('admin.prestamo_encurso')->with('prestamo',$prestamo);



    }



public function prestamo_finalizado(){

     $usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }


 $prestamo=DB::table('borrowers')
      ->select('borrowers.borrower_id','borrowers.start_date','borrowers.end_date','borrowers.borrower_status','manager.manager_name','members.member_name')
      ->join('members','borrowers.member_id','=','members.member_id')
      ->join('manager','borrowers.manager_id','=','manager.manager_id')
      ->where('borrowers.borrower_status','=',"finalizado")
      ->orderBy('borrowers.updated_at', 'DESC')
      ->paginate(5);


return view('admin.prestamo_finalizado')->with('prestamo',$prestamo);

    }



public function finalizar_prestamo($borrower_id){
$usuario_actual=\Auth::user();
     if($usuario_actual->rol!='encargado'){
       return redirect()->back();
   }


   $id=$borrower_id;

   $fin=DB::table('borrowers')
     ->select('borrowers.borrower_id','ejemplares.codigo','ejemplares.num_ejemplar','borrowers_ejemplares.detalle_prestamo','ejemplares.id_ejemplar')
     ->join('borrowers_ejemplares','borrowers.borrower_id','=','borrowers_ejemplares.borrower_id')
     ->join('ejemplares','borrowers_ejemplares.id_ejemplar','=','ejemplares.id_ejemplar')
     ->where([['borrowers.borrower_id', $id],['borrowers.borrower_status',"en curso"]])
     ->take(1)
     ->first();

$id_ejemplar=$fin->id_ejemplar;

  DB::table('ejemplares')
    ->where('ejemplares.id_ejemplar', $id_ejemplar)
    ->update(
      ['estado_ejemplar' => 'Disponible']);

       DB::table('borrowers')
    ->where('borrowers.borrower_id', $id)
    ->update(
      ['borrower_status' => 'Finalizado']);  


 $prestamo=DB::table('borrowers')
      ->select('borrowers.borrower_id','borrowers.start_date','borrowers.end_date','borrowers.borrower_status','manager.manager_name','members.member_name')
      ->join('members','borrowers.member_id','=','members.member_id')
      ->join('manager','borrowers.manager_id','=','manager.manager_id')
      ->where('borrowers.borrower_status','=',"finalizado")
      ->orderBy('borrowers.updated_at', 'DESC')
      ->paginate(5);


 return redirect()->route('prestamo_finalizado');



}




}
