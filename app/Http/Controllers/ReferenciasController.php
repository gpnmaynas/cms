<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referencias;
use App\Asignaciones;
use App\Blog;
use App\Administradores;
use App\Documentos;

use Illuminate\Support\Facades\DB;


class ReferenciasController extends Controller {

    public function index(){

        $join = DB::table('referencias')
        ->join('documentos','referencias.documento_id','=','documentos.id_documento')
        ->join('asignaciones','referencias.asignacion_id','=',"asignaciones.id_asignacion")
        ->select('documentos.*','asignaciones.*','referencias.*')->get();

    	if(request()->ajax()){

            //   return datatables()->of(Referencias::all())
            return datatables()->of($join)
			  
              
           
            ->addColumn('documento', function($data){

                $documento = '
                <a class="alert btn-danger btn-block" "role="alert" href="'.$data->file_documento.'">
                <strong>Ver | </strong> '.$data->titulo_documento.'
                </a>
                ';

                return $documento;

            })
            ->addColumn('asignacion', function($data){

                $asignacion = '
                <a class="alert btn-danger btn-block" "role="alert" href="'.$data->id_adjuntos.'">
                <strong>Ver | </strong> '.$data->titulo_asignacion.'
                </a>
                ';

                return $asignacion;

            })
			  ->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_ref.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_ref.'" method="DELETE" pagina="referencias" token="'.csrf_token().'">
								<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			  })
			->rawColumns(['documento','asignacion','acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
        $administradores = Administradores::all();
        $documentos = Documentos::all();
        $asignaciones = Asignaciones::all();
        

		return view("paginas.referencias", array("blog"=>$blog, "administradores"=>$administradores, "documentos"=>$documentos, "asignaciones"=>$asignaciones));

	}

	/*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

    	// Regocer datos
    	$datos = array(
                        "documento_id"=>$request->input("documento_id"),
    					"asignacion_id"=>$request->input("asignacion_id"),
                        "titulo_ref"=>$request->input("titulo_ref"),
                        "detalle_ref"=>$request->input("detalle_ref")
    					// "ruta_referencia"=>$request->input("ruta_referencia"),
                        // "imagen_temporal"=>$request->file("img_referencia")
                        );

    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[

    			"documento_id"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "asignacion_id"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "titulo_ref"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "detalle_ref"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'                
    		]);

    		//Guardar asignación
    		// if(!$datos["imagen_temporal"] || $validar->fails()){

    		//  	return redirect("/referencias")->with("no-validacion", "");

    		// }else{

    			// $aleatorio = mt_rand(100,999);

    			// $ruta = "img/referencias/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

    			//Redimensionar Imágen

                // list($ancho, $alto) = getimagesize($datos["imagen_temporal"]);

                // $nuevoAncho = 1024;
                // $nuevoAlto = 576;

                // if($datos["imagen_temporal"]->guessExtension() == "jpeg"){

                //     $origen = imagecreatefromjpeg($datos["imagen_temporal"]);
                //     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                //     imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                //     imagejpeg($destino, $ruta);

                // }

                // if($datos["imagen_temporal"]->guessExtension() == "png"){

                //     $origen = imagecreatefrompng($datos["imagen_temporal"]);
                //     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                //     imagealphablending($destino, FALSE); 
                //     imagesavealpha($destino, TRUE);
                //     imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                //     imagepng($destino, $ruta);
                    
                // }

                // $referencia = new Referencias();
                // $referencia->titulo_referencia = $datos["titulo_referencia"];
                // $referencia->descripcion_referencia = $datos["descripcion_referencia"];
                // $referencia->p_claves_referencia = json_encode(explode(",", $datos["p_claves_referencia"]));
                // $referencia->fecha_emision_referencia = $datos["fecha_emision_referencia"];
                // $referencia->fecha_limite_referencia = $datos["fecha_limite_referencia"];
                // $referencia->id_etapa = $datos["id_etapa"];
                // $referencia->id_estado = $datos["id_estado"];
                // $referencia->ruta_referencia = $datos["ruta_referencia"];
                // $referencia->img_referencia = $ruta;

                // $referencia->save(); 

                // return redirect("/referencias")->with("ok-crear", "");   


            // }
            
            $referencia = new Referencias();
            
            $referencia->documento_id = $datos["documento_id"];
            $referencia->asignacion_id = $datos["asignacion_id"];
            $referencia->titulo_ref = $datos["titulo_ref"];
            $referencia->detalle_ref = $datos["detalle_ref"];
            
            

            $referencia->save(); 

            return redirect("/referencias")->with("ok-crear", "");   


    	}else{

    		return redirect("/referencias")->with("error", "");
    	}


    }

    /*=============================================
    Mostrar un solo registro
    =============================================*/

    public function show($id){   

        $referencia = Referencias::where('id_ref', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $documentos = Documentos::all();
        $asignaciones = Asignaciones::all();

        if(count($referencia) != 0){

            return view("paginas.referencias", array("status"=>200, "referencia"=>$referencia, "blog"=>$blog, "administradores"=>$administradores, "documentos"=>$documentos, "asignaciones"=>$asignaciones)); 
        }

        else{
            
            return view("paginas.referencias", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array(
                        "documento_id"=>$request->input("documento_id"),
                        "asignacion_id"=>$request->input("asignacion_id"),
                        "titulo_ref"=>$request->input("titulo_ref"),
                        "detalle_ref"=>$request->input("detalle_ref")
                        );

        // Recoger Imagen

        // $imagen = array("imagen_temporal"=>$request->file("img_referencia"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[
                "titulo_ref" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "detalle_ref" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
                // "ruta_referencia" => "required|regex:/^[a-z0-9-]+$/i",
                // "imagen_actual"=> "required"

            ]);

            // if($imagen["imagen_temporal"] != ""){

            //     $validarImagen = \Validator::make($imagen,[

            //         "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"

            //     ]);

            //     if($validarImagen->fails()){
               
            //         return redirect("/referencias")->with("no-validacion", "");

            //     }

            // }

            if($validar->fails()){

                return redirect("/referencias")->with("no-validacion", "");

            }else{

                // if($imagen["imagen_temporal"] != ""){

                //     unlink($datos["imagen_actual"]);

                //     $aleatorio = mt_rand(100,999);

                //     $ruta = "img/referencias/".$aleatorio.".".$imagen["imagen_temporal"]->guessExtension();

                //     //Redimensionar Imágen

                //     list($ancho, $alto) = getimagesize($imagen["imagen_temporal"]);

                //     $nuevoAncho = 1024;
                //     $nuevoAlto = 576;

                //     if($imagen["imagen_temporal"]->guessExtension() == "jpeg"){

                //         $origen = imagecreatefromjpeg($imagen["imagen_temporal"]);
                //         $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                //         imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                //         imagejpeg($destino, $ruta);

                //     }

                //     if($imagen["imagen_temporal"]->guessExtension() == "png"){

                //         $origen = imagecreatefrompng($imagen["imagen_temporal"]);
                //         $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                //         imagealphablending($destino, FALSE); 
                //         imagesavealpha($destino, TRUE);
                //         imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                //         imagepng($destino, $ruta);
                        
                //     }

                // }else{

                //     $ruta = $datos["imagen_actual"];

                // }

                $datos = array(
                                "documento_id" => $datos["documento_id"],
                                "asignacion_id" => $datos["asignacion_id"],
                                "titulo_ref" => $datos["titulo_ref"],
                                "detalle_ref" => $datos["detalle_ref"]
                        
                                // "ruta_referencia" => $datos["ruta_referencia"],
                                // "img_referencia" => $ruta
                                );

                $referencia = Referencias::where('id_ref', $id)->update($datos); 

                return redirect("/referencias")->with("ok-editar", "");

            }

        }else{

           return redirect("/referencias")->with("error", ""); 

        }


    }

    /*=============================================
    Eliminar un registro
    =============================================*/

    public function destroy($id, Request $request){

        $validar = Referencias::where("id_ref", $id)->get();
        
        if(!empty($validar)){

            // if(!empty($validar[0]["img_ref"])){

            //     unlink($validar[0]["img_ref"]);
            
            // }

            $referencias = Referencias::where("id_ref",$validar[0]["id_ref"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("referencias")->with("no-borrar", "");   

        }

    }

}
