<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observaciones;
use App\Blog;
use App\Administradores;
use App\Documentos;

use Illuminate\Support\Facades\DB;


class ObservacionesController extends Controller {

    public function index(){

        $join = DB::table('observaciones')
        ->join('documentos','observaciones.documento_id','=','documentos.id_documento')
        ->select('documentos.*','observaciones.*')->get();

    	if(request()->ajax()){

            //   return datatables()->of(Observaciones::all())
            return datatables()->of($join)
			  
            ->addColumn('doc_obs', function($data){
                $doc = Documentos::where('id_documento',$data->doc_obs)->get();
                $doc_obs ='';
                foreach ($doc as $key =>$value){
                    $doc_obs = '<span class="badge badge-light">'.$value->titulo_documento.'</span>';
                }
                

                return $doc_obs;

            })
           
            ->addColumn('documento_id', function($data){

                $documento_id = '<span class="badge badge-light">'.$data->titulo_documento.'</span>';

                return $documento_id;

            })
			  ->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_obs.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_obs.'" method="DELETE" pagina="observaciones" token="'.csrf_token().'">
								<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			  })
			->rawColumns(['doc_obs','documento_id','acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
        $administradores = Administradores::all();
        $documentos = Documentos::all();

		return view("paginas.observaciones", array("blog"=>$blog, "administradores"=>$administradores, "documentos"=>$documentos));

	}

	/*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

    	// Regocer datos
    	$datos = array( 
                        "titulo_doc_obs"=>$request->input("titulo_doc_obs"),
    					"detalle_obs"=>$request->input("detalle_obs"),
                        "documento_id"=>$request->input("documento_id"),
                        "doc_obs"=>$request->input("doc_obs"),
                        "fecha_doc_obs"=>$request->input("fecha_doc_obs"),
                       

    					// "ruta_observacion"=>$request->input("ruta_observacion"),
                        // "imagen_temporal"=>$request->file("img_observacion")
                        );

    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[

    			"titulo_doc_obs"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
    			"detalle_obs"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                
    			// "ruta_observacion"=> "required|regex:/^[a-z0-9-]+$/i",
    			// "imagen_temporal"=> "required|image|mimes:jpg,jpeg,png|max:2000000"

    		]);

    		//Guardar asignación
    		// if(!$datos["imagen_temporal"] || $validar->fails()){

    		//  	return redirect("/observaciones")->with("no-validacion", "");

    		// }else{

    			// $aleatorio = mt_rand(100,999);

    			// $ruta = "img/observaciones/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

    			//Redimensionar Imágen

                // list($ancho, $alto) = getimagesize($datos["imagen_temporal"]);

                // $nuevoAncho = 1024;
                // $nuevoAlto = 576;

                // if($datos["imagen_temporal"]->guessExtension() == "jpeg"){

                //     $origen = imagecreatefromjpeg($datos["imagen_temporal"]);
                //     $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                //     imagecopyresized($destino, $orien, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
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

                // $observacion = new Observaciones();
                // $observacion->titulo_observacion = $datos["titulo_observacion"];
                // $observacion->descripcion_observacion = $datos["descripcion_observacion"];
                // $observacion->p_claves_observacion = json_encode(explode(",", $datos["p_claves_observacion"]));
                // $observacion->fecha_emision_observacion = $datos["fecha_emision_observacion"];
                // $observacion->fecha_limite_observacion = $datos["fecha_limite_observacion"];
                // $observacion->id_etapa = $datos["id_etapa"];
                // $observacion->id_estado = $datos["id_estado"];
                // $observacion->ruta_observacion = $datos["ruta_observacion"];
                // $observacion->img_observacion = $ruta;

                // $observacion->save(); 

                // return redirect("/observaciones")->with("ok-crear", "");   


            // }
            
            $observacion = new Observaciones();
            $observacion->titulo_doc_obs = $datos["titulo_doc_obs"];
            $observacion->detalle_obs = $datos["detalle_obs"];
            $observacion->documento_id = $datos["documento_id"];
            $observacion->doc_obs = $datos["doc_obs"];
            $observacion->fecha_doc_obs = $datos["fecha_doc_obs"];
            // $observacion->ruta_observacion = $datos["ruta_observacion"];
            // $observacion->img_observacion = $ruta;

            $observacion->save(); 

            return redirect("/observaciones")->with("ok-crear", "");   


    	}else{

    		return redirect("/observaciones")->with("error", "");
    	}


    }

    /*=============================================
    Mostrar un solo registro
    =============================================*/

    public function show($id){   

        $observacion = Observaciones::where('id_obs', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $documentos = Documentos::all();

        if(count($observacion) != 0){

            return view("paginas.observaciones", array("status"=>200, "observacion"=>$observacion, "blog"=>$blog, "administradores"=>$administradores, "documentos"=>$documentos)); 
        }

        else{
            
            return view("paginas.observaciones", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array("titulo_doc_obs"=>$request->input("titulo_doc_obs"),
         "detalle_obs"=>$request->input("detalle_obs"),
         "documento_id"=>$request->input("documento_id"),
         "doc_obs"=>$request->input("doc_obs"),
         "fecha_doc_obs"=>$request->input("fecha_doc_obs"),
                        // "ruta_observacion"=>$request->input("ruta_observacion"),
                        // "imagen_actual"=>$request->input("imagen_actual")
                        );

        // Recoger Imagen

        // $imagen = array("imagen_temporal"=>$request->file("img_observacion"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[

                "titulo_doc_obs"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
    			"detalle_obs"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                
                
                
                // "ruta_observacion" => "required|regex:/^[a-z0-9-]+$/i",
                // "imagen_actual"=> "required"

            ]);

            // if($imagen["imagen_temporal"] != ""){

            //     $validarImagen = \Validator::make($imagen,[

            //         "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"

            //     ]);

            //     if($validarImagen->fails()){
               
            //         return redirect("/observaciones")->with("no-validacion", "");

            //     }

            // }

            if($validar->fails()){

                return redirect("/observaciones")->with("no-validacion", "");

            }else{

                // if($imagen["imagen_temporal"] != ""){

                //     unlink($datos["imagen_actual"]);

                //     $aleatorio = mt_rand(100,999);

                //     $ruta = "img/observaciones/".$aleatorio.".".$imagen["imagen_temporal"]->guessExtension();

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

                // }    $datos = array("titulo_doc_obs"=>$request->input("titulo_doc_obs"),

                        // "ruta_observacion"=>$request->input("ruta_observacion"),
                        // "imagen_actual"=>$request->input("imagen_actual")
                    

                $datos = array( "titulo_doc_obs" => $datos["titulo_doc_obs"],
                                "detalle_obs" => $datos["detalle_obs"],
                                "documento_id" => $datos["documento_id"],
                                "doc_obs" => $datos["doc_obs"],
                                "fecha_doc_obs" => $datos["fecha_doc_obs"],
                              
                                // "ruta_observacion" => $datos["ruta_observacion"],
                                // "img_observacion" => $ruta
                                );

                $observacion = Observaciones::where('id_obs', $id)->update($datos); 

                return redirect("/observaciones")->with("ok-editar", "");

            }

        }else{

           return redirect("/observaciones")->with("error", ""); 

        }


    }

    /*=============================================
    Eliminar un registro
    =============================================*/

    public function destroy($id, Request $request){

        $validar = Observaciones::where("id_obs", $id)->get();
        
        if(!empty($validar)){

            // if(!empty($validar[0]["img_observacion"])){

            //     unlink($validar[0]["img_observacion"]);
            
            // }

            $observacion = Observaciones::where("id_obs",$validar[0]["id_obs"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("observaciones")->with("no-borrar", "");   

        }

    }

}
