<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Administradores;



class PrincipalController extends Controller {

    public function index(){
        $blog = Blog::all();
        $administradores = Administradores::all();
       
        return view("paginas.principal", array("blog"=>$blog, "administradores"=>$administradores));

	}


}
