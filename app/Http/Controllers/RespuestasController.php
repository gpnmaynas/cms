<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuestas;
use App\Blog;
use App\Administradores;
use App\Observaciones;
use App\Documentos;
use App\Involucrados;
use Illuminate\Support\Facades\DB;


class RespuestasController extends Controller {

    public function index(){

        $join = DB::table('respuestas')
        ->join('documentos','respuestas.documento_id','=','documentos.id_documento')
        ->join('users','respuestas.usuario_id','=','users.id')
        ->select('documentos.*','respuestas.*','users.*')->get();

    	if(request()->ajax()){

            //   return datatables()->of(Respuestas::all())
            return datatables()->of($join)	       
            ->addColumn('involucrados_respuesta', function($data){

                $tags = json_decode($data->involucrados_respuesta, true);
               
                $involucrados_respuesta = '<h5>';

                foreach ($tags as $key => $value) {
                    $url = Involucrados::where('id_involucrado', $value)->get();
                    foreach($url as $key => $value) {                                             
                        $url_titulo =  $value->titulo_involucrado;                 
                    }
                    $involucrados_respuesta .= '<span class="badge badge-secondary mx-1">'.$url_titulo.'</span>';
                }


                $involucrados_respuesta .= '</h5>';

                return $involucrados_respuesta;

            })
            
            ->addColumn('documento_id', function($data){

                $documento = '
                <a class="alert btn-danger btn-block" "role="alert" href="'.$data->file_documento.'">
                <strong>Ver | </strong> '.$data->titulo_documento.'
                </a>
                ';

                return $documento;

            })
            ->addColumn('usuario_id', function($data){
                $usuario_id = '
                <div class="image" style="text-align:center"><img style="height:40px" src="http://localhost:83/gpn-prueba/cms/public/img/administradores/733.jpeg" class="img-circle elevation-2" alt="User Image">'.$data->name.'</div>
                ';
                return $usuario_id;
            })
            ->addColumn('observaciones_respuesta', function($data){
                $tags = json_decode($data->observaciones_respuesta, true);

                $observaciones_respuesta = '<h5>';
                foreach ($tags as $key => $value) {
                    // $observaciones_respuesta .= '<span class="badge badge-secondary mx-1">'.$value.'</span>';
                    $url = Observaciones::where('id_obs', $value)->get();
                   //echo "IMPRESION DE URL: <BR> '\n";
                    foreach($url as $key => $value) {                       
                        //echo "key: " . $key . " - Valor: " . $value;
                        $url_titulo =  $value->titulo_doc_obs;
                        $url_href = $value->ruta_obs;
                        //echo "fin foreach value";

                        
                    }
                    //var_dump($url); 
                    //echo "FIN DE URL: <BR> '\n";
                    
                    //derrepente poniendo json_encode o decode
                    $observaciones_respuesta .= '<a class="badge badge-secondary mx-1" href="'.$url_href.'">'. $url_titulo .'</a>';    
                }


                $observaciones_respuesta .= '</h5>';

                return $observaciones_respuesta;

            })
            
			  ->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_respuesta.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_respuesta.'" method="DELETE" pagina="respuestas" token="'.csrf_token().'">
								<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			  })
			->rawColumns(['involucrados_respuesta','documento_id','observaciones_respuesta','usuario_id','acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
        $administradores = Administradores::all();
        $documentos = Documentos::all();
        $observaciones = Observaciones::all();
        $involucrados = Involucrados::all();
        
        

		return view("paginas.respuestas", array("blog"=>$blog, "administradores"=>$administradores, "documentos"=>$documentos, "observaciones"=>$observaciones, "involucrados"=>$involucrados));

	}

	/*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

    	// Regocer datos
    	$datos = array(
                        "documento_id"=>$request->input("documento_id"),
                        "asunto_respuesta"=>$request->input("asunto_respuesta"),
                        "fecha_respuesta"=>$request->input("fecha_respuesta"),
                        "involucrados_respuesta"=>$request->input("involucrados_respuesta"),
                        "observaciones_respuesta"=>$request->input("observaciones_respuesta"),
                        "detalle_respuesta"=>$request->input("detalle_respuesta"),
                        "usuario_id"=>$request->input("usuario_id")
    					// "ruta_respuesta"=>$request->input("ruta_respuesta"),
                        // "imagen_temporal"=>$request->file("img_respuesta")
                        );
                        

    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[

    			"documento_id"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "asunto_respuesta"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "observaciones_respuesta"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "usuario_id"=> 'required|regex:/^[,\\0-9 ]+$/i',
                "involucrados_respuesta"=> "required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "detalle_respuesta"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'                
    		]);

    		//Guardar asignación
    		// if(!$datos["imagen_temporal"] || $validar->fails()){

    		//  	return redirect("/respuestas")->with("no-validacion", "");

    		// }else{

    			// $aleatorio = mt_rand(100,999);

    			// $ruta = "img/respuestas/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

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

                // $respuesta = new Respuestas();
                // $respuesta->titulo_respuesta = $datos["titulo_respuesta"];
                // $respuesta->descripcion_respuesta = $datos["descripcion_respuesta"];
                // $respuesta->p_claves_respuesta = json_encode(explode(",", $datos["p_claves_respuesta"]));
                // $respuesta->fecha_emision_respuesta = $datos["fecha_emision_respuesta"];
                // $respuesta->fecha_limite_respuesta = $datos["fecha_limite_respuesta"];
                // $respuesta->id_etapa = $datos["id_etapa"];
                // $respuesta->id_estado = $datos["id_estado"];
                // $respuesta->ruta_respuesta = $datos["ruta_respuesta"];
                // $respuesta->img_respuesta = $ruta;

                // $respuesta->save(); 

                // return redirect("/respuestas")->with("ok-crear", "");   


            // }
            
            $respuesta = new Respuestas();
            $respuesta->documento_id = $datos["documento_id"];
            $respuesta->asunto_respuesta = $datos["asunto_respuesta"];
            $respuesta->involucrados_respuesta = json_encode($datos["involucrados_respuesta"]);
            $respuesta->detalle_respuesta = $datos["detalle_respuesta"];
            $respuesta->usuario_id = $datos["usuario_id"];
            $respuesta->observaciones_respuesta = json_encode($datos["observaciones_respuesta"]);
            $respuesta->fecha_respuesta = $datos["fecha_respuesta"];
            

            $respuesta->save(); 

            return redirect("/respuestas")->with("ok-crear", "");   


    	}else{

    		return redirect("/respuestas")->with("error", "");
    	}


    }

    /*=============================================
    Mostrar un solo registro
    =============================================*/

    public function show($id){   

        $respuesta = Respuestas::where('id_respuesta', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $documentos = Documentos::all();
        $observaciones = Observaciones::all();
        $involucrados = Involucrados::all();

        if(count($respuesta) != 0){
            return view("paginas.respuestas", array("status"=>200, "respuesta"=>$respuesta, "blog"=>$blog, "administradores"=>$administradores, "documentos"=>$documentos, "observaciones"=>$observaciones,"involucrados"=>$involucrados)); 
        }

        else{       

            return view("paginas.respuestas", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array(

            "asunto_respuesta"=>$request->input("asunto_respuesta"),
            "detalle_respuesta"=>$request->input("detalle_respuesta"),
            "fecha_respuesta"=>$request->input("fecha_respuesta"),
            "documento_id"=>$request->input("documento_id"),
            "involucrados_respuesta"=>$request->input("involucrados_respuesta"),
            "usuario_id"=>$request->input("usuario_id"),
            "observaciones_respuesta"=>$request->input("observaciones_respuesta"),
        );

        // Recoger Imagen

        // $imagen = array("imagen_temporal"=>$request->file("img_respuesta"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[

                "asunto_respuesta"=> "required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "detalle_respuesta"=> "required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i"
                // "ruta_respuesta" => "required|regex:/^[a-z0-9-]+$/i",
                // "imagen_actual"=> "required"

            ]);

           

            if($validar->fails()){

                return redirect("/respuestas")->with("no-validacion", "");

            }else{

                $datos = array(
                                "documento_id" => $datos["documento_id"],
                                "asunto_respuesta" => $datos["asunto_respuesta"],
                                "involucrados_respuesta" => json_encode($datos["involucrados_respuesta"]),
                                "detalle_respuesta" => $datos["detalle_respuesta"],
                                "usuario_id" => $datos["usuario_id"],
                                "observaciones_respuesta" => json_encode($datos["observaciones_respuesta"]),
                                "fecha_respuesta" => $datos["fecha_respuesta"]
                                // "ruta_respuesta" => $datos["ruta_respuesta"],
                                // "img_respuesta" => $ruta
                                );

                $respuesta = Respuestas::where('id_respuesta', $id)->update($datos); 

                return redirect("/respuestas")->with("ok-editar", "");

            }

        }else{

           return redirect("/respuestas")->with("error", ""); 

        }


    }

    /*=============================================
    Eliminar un registro
    =============================================*/

    public function destroy($id, Request $request){

        $validar = Respuestas::where("id_respuesta", $id)->get();
        
        if(!empty($validar)){

            // if(!empty($validar[0]["img_respuesta"])){

            //     unlink($validar[0]["img_respuesta"]);
            
            // }

            $respuesta = Respuestas::where("id_respuesta",$validar[0]["id_respuesta"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("respuestas")->with("no-borrar", "");   

        }

    }

}
