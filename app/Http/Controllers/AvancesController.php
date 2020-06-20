<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asignaciones;
use App\Avances;
use App\Blog;
use App\Administradores;

use Illuminate\Support\Facades\DB;


class AvancesController extends Controller {

    public function index(){

        $join = DB::table('avances')
        ->join('asignaciones','avances.asignacion_id','=','asignaciones.id_asignacion')
        ->select('avances.*','asignaciones.*')->get();

    	if(request()->ajax()){

            //   return datatables()->of(Avances::all())
            return datatables()->of($join)
			  
            // ->addColumn('asignacion_id', function($data){

            //     $asignacion_id = '
            //     <a class="alert btn-danger btn-block flex-center" "role="alert" href="'.$data->id_adjuntos.'">
            //     <i class="material-icons">assignment_ind</i>
            //     '.$data->titulo_asignacion.'
            //     </a>
            //     ';

            //     return $asignacion_id;

            // })
            ->addColumn('asignacion_id', function($data){

                $asign = Asignaciones::where('id_asignacion',$data->asignacion_id)->get();
                
                
                $asignacion_id = '
                               
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refModal'.$data->asignacion_id.'">
                      Más
                    </button>

                    <!-- Modal -->
                    <div class="modal" id="refModal'.$data->asignacion_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg " role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">'.$data->asunto_avance.' | Asignación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="bg-danger modal-body">
                          <ul class="responsive-table">
                            <li class="table-header">
                            <div class="col col-2">Id</div>
                            <div class="col col-2">Asignacion</div>
                            <div class="col col-2">Asunto</div>
                            <div class="col col-2">P.Claves</div>
                            <div class="col col-2">Usuario</div>
                            <div class="col col-2">Adjunto</div>
                            </li>                            
                          ';

                          foreach($asign as $key => $value){
                                $asignacion_id .= '
                                <li class="table-row">
                            <div class="col col-2" data-label="Job Id">'.$value->id_asignacion.'</div>
                            <div class="col col-2" data-label="Customer Name">'.$value->titulo_asignacion.'</div>
                            <div class="col col-2" data-label="Amount">'.$value->descripcion_asignacion.'</div>
                            <div class="col col-2" data-label="Amount">';

                            $tags = json_decode($data->p_claves_asignacion, true);
                            foreach ($tags as $key => $value2) {   
                                $asignacion_id .= '<span class="badge bg-navy mx-1">'.$value2.'</span>';
                            }
                            
                            $asignacion_id .='</div>';
                            
                            $user = Administradores::where('id',$data->id_user)->get();
                            foreach ($user as $key =>$value3){
                                $asignacion_id .='
                            
                                <div class="col col-2" data-label="Amount">'.$value3->name.'</div>
                               
                                    ';
                            }
                            $asignacion_id .='<div class="col col-2" data-label="Amount">'.$value->id_adjuntos.'</div>';                           
                          }
                            
                $asignacion_id .='
                </li>
                        </ul>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
                    return $asignacion_id;
            })
            ->addColumn('file_avance', function($data){
                $file_avance='
                <a class="btn btn-info flex-center" href="'.$data->file_avance.'"><i class="material-icons">attach_file</i><font style="vertical-align: inherit;">Ver</font></a>
                ';

                return $file_avance;
            })
			  ->addColumn('acciones', function($data){

			  		$acciones = '
								
								<a href="'.url()->current().'/'.$data->id_avance.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_avance.'" method="DELETE" pagina="avances" token="'.csrf_token().'">
								<i class="fas fa-trash-alt"></i>
								</button>

			  				';

			  		return $acciones;

			  })
			->rawColumns(['asignacion_id','file_avance','acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
        $administradores = Administradores::all();
        $asignaciones = Asignaciones::all();
        

		return view("paginas.avances", array("blog"=>$blog, "administradores"=>$administradores, "asignaciones"=>$asignaciones));

	}

	/*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

    	// Regocer datos
    	$datos = array(
                        "fecha_avance"=>$request->input("fecha_avance"),
    					"asignacion_id"=>$request->input("asignacion_id"),
                        "asunto_avance"=>$request->input("asunto_avance"),
                        "detalle_avance"=>$request->input("detalle_avance"),
                        "file_avance"=>$request->file("file_avance"),
    					// "ruta_avance"=>$request->input("ruta_avance"),
                        // "imagen_temporal"=>$request->file("img_avance")
                        );


        // Recojer PDF
        // $pdf = array("pdf_temporal"=>$request->file("pdf"));                
        $blog = Blog::all();
    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[

    			// "fecha_avance"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                // "asignacion_id"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "asunto_avance"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "detalle_avance"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',  
                "file_avance"=> "required|file|mimes:pdf|max:2048"            
            ]);
           
    		//Guardar avance
    		if(!$datos["file_avance"]|| $validar->fails()){

                 return redirect("/avances")->with("no-validacion-pdf-3", "");
                

    		}else{

    			$aleatorio = mt_rand(100,999);
                $name = $datos["file_avance"]->getClientOriginalName();
                $name = strtr($name," ","_");
                $ruta = "doc/avances/".$name;
                move_uploaded_file($datos["file_avance"], $ruta);
                // return redirect("/avances")->with("no-validacion-pdf-2", "");
                
            }
            
            $avance = new Avances();
            
            $avance->fecha_avance = $datos["fecha_avance"];
            $avance->asignacion_id = $datos["asignacion_id"];
            $avance->asunto_avance = $datos["asunto_avance"];
            $avance->detalle_avance = $datos["detalle_avance"];
            $avance->file_avance = $ruta;
            

            $avance->save(); 

            return redirect("/avances")->with("ok-crear", "");   


    	}else{

    		return redirect("/avances")->with("error", "");
    	}


    }

    /*=============================================
    Mostrar un solo registro
    =============================================*/

    public function show($id){   

        $avance = Avances::where('id_avance', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $asignaciones = Asignaciones::all();

        if(count($avance) != 0){

            return view("paginas.avances", array("status"=>200, "avance"=>$avance, "blog"=>$blog, "administradores"=>$administradores, "asignaciones"=>$asignaciones)); 
        }

        else{
            
            return view("paginas.avances", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array(
                        "fecha_avance"=>$request->input("fecha_avance"),
                        "asignacion_id"=>$request->input("asignacion_id"),
                        "asunto_avance"=>$request->input("asunto_avance"),
                        "detalle_avance"=>$request->input("detalle_avance")
                        );

        // Recoger Imagen

        // $imagen = array("imagen_temporal"=>$request->file("img_avance"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[
                "asunto_avance" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "detalle_avance" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
                // "ruta_avance" => "required|regex:/^[a-z0-9-]+$/i",
                // "imagen_actual"=> "required"

            ]);

            // if($imagen["imagen_temporal"] != ""){

            //     $validarImagen = \Validator::make($imagen,[

            //         "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"

            //     ]);

            //     if($validarImagen->fails()){
               
            //         return redirect("/avances")->with("no-validacion", "");

            //     }

            // }

            if($validar->fails()){

                return redirect("/avances")->with("no-validacion", "");

            }else{

                // if($imagen["imagen_temporal"] != ""){

                //     unlink($datos["imagen_actual"]);

                //     $aleatorio = mt_rand(100,999);

                //     $ruta = "img/avances/".$aleatorio.".".$imagen["imagen_temporal"]->guessExtension();

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
                                "fecha_avance" => $datos["fecha_avance"],
                                "asignacion_id" => $datos["asignacion_id"],
                                "asunto_avance" => $datos["asunto_avance"],
                                "detalle_avance" => $datos["detalle_avance"]
                        
                                // "ruta_avance" => $datos["ruta_avance"],
                                // "img_avance" => $ruta
                                );

                $avance = Avances::where('id_avance', $id)->update($datos); 

                return redirect("/avances")->with("ok-editar", "");

            }

        }else{

           return redirect("/avances")->with("error", ""); 

        }


    }

    /*=============================================
    Eliminar un registro
    =============================================*/

    public function destroy($id, Request $request){

        $validar = Avances::where("id_avance", $id)->get();
        
        if(!empty($validar)){

            // if(!empty($validar[0]["img_avance"])){

            //     unlink($validar[0]["img_avance"]);
            
            // }

            $avance = Avances::where("id_avance",$validar[0]["id_avance"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("avances")->with("no-borrar", "");   

        }

    }

}
