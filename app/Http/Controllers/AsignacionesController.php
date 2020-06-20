<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asignaciones;
use App\Blog;
use App\Administradores;
use App\Estado;
use App\Etapa;
use App\Avances;
use App\Referencias;


use Illuminate\Support\Facades\DB;


class AsignacionesController extends Controller {
    public function index(){

        $join = DB::table('asignaciones')
        ->join('users','asignaciones.id_user','=','users.id')
        ->join('etapa','asignaciones.etapa_id','=','etapa.id_etapa')
        ->join('estado','asignaciones.estado_id','=','estado.id_estado')
       
        ->select('asignaciones.*','users.*','etapa.*','estado.*')->get();

    	if(request()->ajax()){

            //   return datatables()->of(Asignaciones::all())
            return datatables()->of($join)
			  ->addColumn('p_claves_asignacion', function($data){

			  		$tags = json_decode($data->p_claves_asignacion, true);

			  		$p_claves_asignacion = '<h5>';

			  		foreach ($tags as $key => $value) {
			  			
			  			$p_claves_asignacion .= '<span class="badge badge-secondary mx-1">'.$value.'</span>';
			  		}


			  		$p_claves_asignacion .= '</h5>';

			  		return $p_claves_asignacion;

              })
              ->addColumn('id_adjuntos', function($data){

                $id_adjuntos = '<div class="btn-group">
                          
                          <a href="'.url()->current().'/'.$data->id_asignacion.'" class="btn btn-warning btn-sm">
                              <i class="fas fa-pencil-alt text-white"></i>Ver
                          </a>

                        </div>';

                return $id_adjuntos;

            })
            ->addColumn('name', function($data){

                $name = '<span class="badge badge-light">'.$data->name.'</span>';

                return $name;

            })
            ->addColumn('titulo_etapa', function($data){

                $titulo_etapa = '<span class="badge badge-light">'.$data->titulo_etapa.'</span>';

                return $titulo_etapa;

            })
            ->addColumn('titulo_estado', function($data){

                $titulo_estado = '<span class="badge badge-light">'.$data->titulo_estado.'</span>';

                return $titulo_estado;

            })
            ->addColumn('avances_asignacion', function($data){

                $avnc = Avances::where('asignacion_id',$data->id_asignacion)->get();
                
                
                $avances_asignacion = '
                               
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal'.$data->id_asignacion.'">
                      Más
                    </button>

                    <!-- Modal -->
                    <div class="modal" id="exampleModal'.$data->id_asignacion.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">'.$data->titulo_asignacion.' | Avances</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <ul class="responsive-table">
                            <li class="table-header">
                            <div class="col col-1">Id</div>
                            <div class="col col-2">Asunto</div>
                            <div class="col col-3">Detalles</div>
                            <div class="col col-4">Fecha</div>
                            </li>
                            
                            
                          ';

                          foreach($avnc as $key => $value){
                                $avances_asignacion .= '
                                <li class="table-row">
                            <div class="col col-1" data-label="Job Id">'.$value->id_avance.'</div>
                            <div class="col col-2" data-label="Customer Name">'.$value->asunto_avance.'</div>
                            <div class="col col-3" data-label="Amount">'.$value->detalle_avance.'</div>
                            <div class="col col-4" data-label="Payment Status">'.$value->fecha_avance.'</div>
                            </li>
                                ';
                          }
                            
                $avances_asignacion .='
                        </ul>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
                    return $avances_asignacion;
            })
            ->addColumn('referencias_asignacion', function($data){

                $refr = Referencias::where('asignacion_id',$data->id_asignacion)->get();
                
                
                $referencias_asignacion = '
                               
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refModal'.$data->id_asignacion.'">
                      Más
                    </button>

                    <!-- Modal -->
                    <div class="modal" id="refModal'.$data->id_asignacion.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">'.$data->titulo_asignacion.' | Avances</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <ul class="responsive-table">
                            <li class="table-header">
                            <div class="col col-1">Id</div>
                            <div class="col col-2">Asunto</div>
                            <div class="col col-3">Detalles</div>
                            <div class="col col-4">Creado el</div>
                            </li>                            
                          ';

                          foreach($refr as $key => $value){
                                $referencias_asignacion .= '
                                <li class="table-row">
                            <div class="col col-1" data-label="Job Id">'.$value->id_ref.'</div>
                            <div class="col col-2" data-label="Customer Name">'.$value->titulo_ref.'</div>
                            <div class="col col-3" data-label="Amount">'.$value->detalle_ref.'</div>
                            <div class="col col-4" data-label="Payment Status">'.$value->created_at.'</div>
                            </li>
                                ';
                          }
                            
                $referencias_asignacion .='
                        </ul>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
                    return $referencias_asignacion;
            })
            
            
			  ->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_asignacion.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_asignacion.'" method="DELETE" pagina="asignaciones" token="'.csrf_token().'">
								<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			  })
			->rawColumns(['p_claves_asignacion','id_adjuntos','name','titulo_etapa','titulo_estado','avances_asignacion','referencias_asignacion','acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
        $administradores = Administradores::all();
        $etapa = Etapa::all();
        $estado = Estado::all();
        

		return view("paginas.asignaciones", array("blog"=>$blog, "administradores"=>$administradores, "etapa"=>$etapa, "estado"=>$estado));

	}

	/*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

    	// Regocer datos
    	$datos = array( "id_user"=>$request->input("id_user"),
                        "titulo_asignacion"=>$request->input("titulo_asignacion"),
    					"descripcion_asignacion"=>$request->input("descripcion_asignacion"),
                        "p_claves_asignacion"=>$request->input("p_claves_asignacion"),
                        "fecha_emision_asignacion"=>$request->input("fecha_emision_asignacion"),
                        "fecha_limite_asignacion"=>$request->input("fecha_limite_asignacion"),
                        "etapa_id"=>$request->input("etapa_id"),
                        "estado_id"=>$request->input("estado_id")
    					// "ruta_asignacion"=>$request->input("ruta_asignacion"),
                        // "imagen_temporal"=>$request->file("img_asignacion")
                        );

    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[

    			"titulo_asignacion"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
    			"descripcion_asignacion"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "p_claves_asignacion"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "fecha_emision_asignacion"=> 'required|regex:/^[0-9a-zA-Z]+$/i',
                "fecha_limite_asignacion"=> 'required|regex:/^[0-9a-zA-Z]+$/i',
                "etapa_id"=> "required|regex:/^[0-9a-zA-Z ]+$/i",
                "estado_id"=> "required|regex:/^[0-9a-zA-Z ]+$/i"
    			// "ruta_asignacion"=> "required|regex:/^[a-z0-9-]+$/i",
    			// "imagen_temporal"=> "required|image|mimes:jpg,jpeg,png|max:2000000"

    		]);

    		//Guardar asignación
    		// if(!$datos["imagen_temporal"] || $validar->fails()){

    		//  	return redirect("/asignaciones")->with("no-validacion", "");

    		// }else{

    			// $aleatorio = mt_rand(100,999);

    			// $ruta = "img/asignaciones/".$aleatorio.".".$datos["imagen_temporal"]->guessExtension();

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

                // $asignacion = new Asignaciones();
                // $asignacion->titulo_asignacion = $datos["titulo_asignacion"];
                // $asignacion->descripcion_asignacion = $datos["descripcion_asignacion"];
                // $asignacion->p_claves_asignacion = json_encode(explode(",", $datos["p_claves_asignacion"]));
                // $asignacion->fecha_emision_asignacion = $datos["fecha_emision_asignacion"];
                // $asignacion->fecha_limite_asignacion = $datos["fecha_limite_asignacion"];
                // $asignacion->id_etapa = $datos["id_etapa"];
                // $asignacion->id_estado = $datos["id_estado"];
                // $asignacion->ruta_asignacion = $datos["ruta_asignacion"];
                // $asignacion->img_asignacion = $ruta;

                // $asignacion->save(); 

                // return redirect("/asignaciones")->with("ok-crear", "");   


            // }
            
            $asignacion = new Asignaciones();
            $asignacion->id_user = $datos["id_user"];
            $asignacion->titulo_asignacion = $datos["titulo_asignacion"];
            $asignacion->descripcion_asignacion = $datos["descripcion_asignacion"];
            $asignacion->p_claves_asignacion = json_encode(explode(",", $datos["p_claves_asignacion"]));
            $asignacion->fecha_emision_asignacion = $datos["fecha_emision_asignacion"];
            $asignacion->fecha_limite_asignacion = $datos["fecha_limite_asignacion"];
            $asignacion->etapa_id = $datos["etapa_id"];
            $asignacion->estado_id = $datos["estado_id"];
            // $asignacion->ruta_asignacion = $datos["ruta_asignacion"];
            // $asignacion->img_asignacion = $ruta;

            $asignacion->save(); 

            return redirect("/asignaciones")->with("ok-crear", "");   


    	}else{

    		return redirect("/asignaciones")->with("error", "");
    	}


    }

    /*=============================================
    Mostrar un solo registro
    =============================================*/

    public function show($id){   

        $asignacion = Asignaciones::where('id_asignacion', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $etapa = Etapa::all();
        $estado = Estado::all();

        if(count($asignacion) != 0){

            return view("paginas.asignaciones", array("status"=>200, "asignacion"=>$asignacion, "blog"=>$blog, "administradores"=>$administradores, "etapa"=>$etapa, "estado"=>$estado)); 
        }

        else{
            
            return view("paginas.asignaciones", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array("id_user"=>$request->input("id_user"),
                        "titulo_asignacion"=>$request->input("titulo_asignacion"),
                        "descripcion_asignacion"=>$request->input("descripcion_asignacion"),
                        "p_claves_asignacion"=>$request->input("p_claves_asignacion"),
                        "fecha_emision_asignacion"=>$request->input("fecha_emision_asignacion"),
                        "fecha_limite_asignacion"=>$request->input("fecha_limite_asignacion"),
                        "etapa_id"=>$request->input("etapa_id"),
                        "estado_id"=>$request->input("estado_id")
                        // "ruta_asignacion"=>$request->input("ruta_asignacion"),
                        // "imagen_actual"=>$request->input("imagen_actual")
                        );

        // Recoger Imagen

        // $imagen = array("imagen_temporal"=>$request->file("img_asignacion"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[

                "titulo_asignacion" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "descripcion_asignacion" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "p_claves_asignacion" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
                
                
                
                // "ruta_asignacion" => "required|regex:/^[a-z0-9-]+$/i",
                // "imagen_actual"=> "required"

            ]);

            // if($imagen["imagen_temporal"] != ""){

            //     $validarImagen = \Validator::make($imagen,[

            //         "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"

            //     ]);

            //     if($validarImagen->fails()){
               
            //         return redirect("/asignaciones")->with("no-validacion", "");

            //     }

            // }

            if($validar->fails()){

                return redirect("/asignaciones")->with("no-validacion", "");

            }else{

                // if($imagen["imagen_temporal"] != ""){

                //     unlink($datos["imagen_actual"]);

                //     $aleatorio = mt_rand(100,999);

                //     $ruta = "img/asignaciones/".$aleatorio.".".$imagen["imagen_temporal"]->guessExtension();

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

                $datos = array( "id_user" => $datos["id_user"],
                                "titulo_asignacion" => $datos["titulo_asignacion"],
                                "descripcion_asignacion" => $datos["descripcion_asignacion"],
                                "p_claves_asignacion" => json_encode(explode(",", $datos["p_claves_asignacion"])),
                                "fecha_emision_asignacion" => $datos["fecha_emision_asignacion"],
                                "fecha_limite_asignacion" => $datos["fecha_limite_asignacion"],
                                "etapa_id" => $datos["etapa_id"],
                                "estado_id" => $datos["estado_id"]
                                // "ruta_asignacion" => $datos["ruta_asignacion"],
                                // "img_asignacion" => $ruta
                                );

                $asignacion = Asignaciones::where('id_asignacion', $id)->update($datos); 

                return redirect("/asignaciones")->with("ok-editar", "");

            }

        }else{

           return redirect("/asignaciones")->with("error", ""); 

        }


    }

    /*=============================================
    Eliminar un registro
    =============================================*/

    public function destroy($id, Request $request){

        $validar = Asignaciones::where("id_asignacion", $id)->get();
        
        if(!empty($validar)){

            // if(!empty($validar[0]["img_asignacion"])){

            //     unlink($validar[0]["img_asignacion"]);
            
            // }

            $asignacion = Asignaciones::where("id_asignacion",$validar[0]["id_asignacion"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("asignaciones")->with("no-borrar", "");   

        }

    }

}
