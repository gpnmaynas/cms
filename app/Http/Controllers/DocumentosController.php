<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documentos;
use App\Blog;
use App\Administradores;
use App\Involucrados;
use App\Observaciones;


use Illuminate\Support\Facades\DB;


class DocumentosController extends Controller
{
    public function index(){

        $join = DB::table('documentos')
        ->join('users','documentos.id_user','=','users.id')
        //->join('involucrados','documentos.involucrado_id','=','involucrados.id_involucrado')
        // ->join('observaciones','documentos.id_documento','=','observaciones.documento_id')
        ->select('users.*','documentos.*')->get();

    	if(request()->ajax()){

            //   return datatables()->of(Documentos::all())
            return datatables()->of($join)
            ->addColumn('name', function($data){

                $name = '<span class="badge badge-light">'.$data->name.'</span>';

                return $name;

            })
            ->addColumn('file_documento', function($data){
                $file_documento='<a href="'.$data->file_documento.'" type="button" class="btn btn-primary">ver</a>';

                return $file_documento;

            })
			->addColumn('p_claves_documento', function($data){

			  		$tags = json_decode($data->p_claves_documento, true);

			  		$p_claves_documento = '<h5>';

			  		foreach ($tags as $key => $value) {
			  			
			  			$p_claves_documento .= '<span class="badge badge-secondary mx-1">'.$value.'</span>';
			  		}


			  		$p_claves_documento .= '</h5>';

			  		return $p_claves_documento;

            })
            ->addColumn('involucrados_documento', function($data){

                $tags = json_decode($data->involucrados_documento, true);

                $involucrados_documento = '<h5>';

                foreach ($tags as $key => $value) {

                    $url = Involucrados::where('id_involucrado',$value)->get();
                    foreach ($url as $key =>$value){
                        $url_titulo = $value->titulo_involucrado;
                    }
                    $involucrados_documento .= '<span class="badge badge-secondary mx-1">'.$url_titulo.'</span>';
                }


                $involucrados_documento .= '</h5>';

                return $involucrados_documento;

            })
            ->addColumn('observaciones_documento', function($data){

                $obsr = Observaciones::where('documento_id',$data->id_documento)->get();
                
                
                $observaciones_documento = '
                               
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refModal'.$data->id_documento.'">
                      Más
                    </button>

                    <!-- Modal -->
                    <div class="modal" id="refModal'.$data->id_documento.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">'.$data->titulo_documento.' | Observaciones</h5>
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
                            <div class="col col-4">Más </div>
                            </li>                            
                          ';

                          foreach($obsr as $key => $value){
                                $observaciones_documento .= '
                                <li class="table-row">
                            <div class="col col-1" data-label="Job Id">'.$value->id_obs.'</div>
                            <div class="col col-2" data-label="Customer Name">'.$value->titulo_doc_obs.'</div>
                            <div class="col col-3" data-label="Amount">'.$value->detalle_obs.'</div>
                            <div class="col col-4" data-label="Payment Status">
                            <a type="button" class="btn btn-outline-danger" href="'.$value->ruta_obs.'">
                            ver PDF
                            </a>
                            </div>
                            </li>
                                ';
                          }
                            
                $observaciones_documento .='
                        </ul>
                        </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    ';
                    return $observaciones_documento;
            })

			->addColumn('acciones', function($data){

			  		$acciones = '<div class="btn-group">
								
								<a href="'.url()->current().'/'.$data->id_documento.'" class="btn btn-warning btn-sm">
									<i class="fas fa-pencil-alt text-white"></i>
								</a>

								<button class="btn btn-danger btn-sm eliminarRegistro" action="'.url()->current().'/'.$data->id_documento.'" method="DELETE" pagina="documentos" token="'.csrf_token().'">
								<i class="fas fa-trash-alt"></i>
								</button>

			  				</div>';

			  		return $acciones;

			})
			->rawColumns(['name','p_claves_documento','file_documento','involucrados_documento','observaciones_documento','acciones'])
			  -> make(true);

		}

		$blog = Blog::all();
        $administradores = Administradores::all();
        $involucrados = Involucrados::all();
        $observaciones = Observaciones::all();

		return view("paginas.documentos", array("blog"=>$blog, "administradores"=>$administradores, "involucrados"=>$involucrados, "observaciones"=>$observaciones));

	}

	/*=============================================
    Crear un registro
    =============================================*/

    public function store(Request $request){

    	// Regocer datos
    	$datos = array( "id_user"=>$request->input("id_user"),
                        "titulo_documento"=>$request->input("titulo_documento"),
                        "involucrados_documento"=>$request->input("involucrados_documento"),
                        "detalle_documento"=>$request->input("detalle_documento"),
                        "p_claves_documento"=>$request->input("p_claves_documento"),
                        "fecha_emision_documento"=>$request->input("fecha_emision_documento"),
                        "fecha_limite_documento"=>$request->input("fecha_limite_documento"),
                        "file_documento"=>$request->file("file_documento"),
    					// "file_documento"=>$request->input("file_documento"),
                        // "imagen_temporal"=>$request->file("img_documento")
                        );
                        $blog = Blog::all();
    	// Validar datos
    	if(!empty($datos)){

    		$validar = \Validator::make($datos,[

                "titulo_documento"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
    			"detalle_documento"=> "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "p_claves_documento"=> 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i',
                "file_documento"=> "required|file|mimes:pdf|max:2048"   
                

    		]);

            //Guardar avance
            if(!$datos["file_documento"]|| $validar->fails()){

                return redirect("/documentos")->with("no-validacion-pdf-3", "");
            

            }else{

            $name = $datos["file_documento"]->getClientOriginalName();
            $name = strtr($name," ","_");
            $ruta = "doc/documentos/".$name;
            move_uploaded_file($datos["file_documento"], $ruta);
            // return redirect("/avances")->with("no-validacion-pdf-2", "");
            
            }
            
            $documento = new Documentos();
            $documento->id_user = $datos["id_user"];
            $documento->titulo_documento = $datos["titulo_documento"];
            $documento->involucrados_documento = json_encode($datos["involucrados_documento"]);
            $documento->detalle_documento = $datos["detalle_documento"];
            $documento->p_claves_documento = json_encode(explode(",", $datos["p_claves_documento"]));
            $documento->fecha_emision_documento = $datos["fecha_emision_documento"];
            $documento->fecha_limite_documento = $datos["fecha_limite_documento"];
            $documento->file_documento = $ruta;
            // $documento->file_documento = $datos["file_documento"];
            // $documento->img_documento = $ruta;

            $documento->save(); 

            return redirect("/documentos")->with("ok-crear", "");   


    	}else{

    		return redirect("/documentos")->with("error", "");
    	}


    }

    /*=============================================
    Mostrar un solo registro
    =============================================*/

    public function show($id){   

        $documento = Documentos::where('id_documento', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();
        $involucrados = Involucrados::all();

        if(count($documento) != 0){

            return view("paginas.documentos", array("status"=>200, "documento"=>$documento, "blog"=>$blog, "administradores"=>$administradores, "involucrados"=>$involucrados)); 
        }

        else{
            
            return view("paginas.documentos", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

    /*=============================================
    Editar un registro
    =============================================*/

    public function update($id, Request $request){

        // Recoger los datos

         $datos = array("id_user"=>$request->input("id_user"),
         "titulo_documento"=>$request->input("titulo_documento"),
         "involucrados_documento"=>$request->input("involucrados_documento"),
         "detalle_documento"=>$request->input("detalle_documento"),
         "p_claves_documento"=>$request->input("p_claves_documento"),
         "fecha_emision_documento"=>$request->input("fecha_emision_documento"),
         "fecha_limite_documento"=>$request->input("fecha_limite_documento"),
        // "file_documento"=>$request->file("file_documento"),
                        // "file_documento"=>$request->input("file_documento"),
                        // "imagen_actual"=>$request->input("imagen_actual")
                        );

        // Recoger Imagen

        // $imagen = array("imagen_temporal"=>$request->file("img_documento"));

        // Validar los datos

        if(!empty($datos)){

            $validar = \Validator::make($datos,[

                "titulo_documento" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "detalle_documento" => "required|regex:/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i",
                "p_claves_documento" => 'required|regex:/^[,\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i'
                
                
                
                // "file_documento" => "required|regex:/^[a-z0-9-]+$/i",
                // "imagen_actual"=> "required"

            ]);

            // if($imagen["imagen_temporal"] != ""){

            //     $validarImagen = \Validator::make($imagen,[

            //         "imagen_temporal" => "required|image|mimes:jpg,jpeg,png|max:2000000"

            //     ]);

            //     if($validarImagen->fails()){
               
            //         return redirect("/documentos")->with("no-validacion", "");

            //     }

            // }

            if($validar->fails()){

                return redirect("/documentos")->with("no-validacion", "");

            }else{

                // if($imagen["imagen_temporal"] != ""){

                //     unlink($datos["imagen_actual"]);

                //     $aleatorio = mt_rand(100,999);

                //     $ruta = "img/documentos/".$aleatorio.".".$imagen["imagen_temporal"]->guessExtension();

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
                                "titulo_documento" => $datos["titulo_documento"],
                                "involucrados_documento"=>json_encode($datos["involucrados_documento"]),
                                "detalle_documento" => $datos["detalle_documento"],
                                "p_claves_documento" => json_encode(explode(",", $datos["p_claves_documento"])),
                                "fecha_emision_documento" => $datos["fecha_emision_documento"],
                                "fecha_limite_documento" => $datos["fecha_limite_documento"]

                                // "file_documento" => $datos["file_documento"],
                                // "img_documento" => $ruta
                                );

                $documento = Documentos::where('id_documento', $id)->update($datos); 

                return redirect("/documentos")->with("ok-editar", "");

            }

        }else{

           return redirect("/documentos")->with("error", ""); 

        }


    }

    /*=============================================
    Eliminar un registro
    =============================================*/

    public function destroy($id, Request $request){

        $validar = Documentos::where("id_documento", $id)->get();
        
        if(!empty($validar)){

            // if(!empty($validar[0]["img_documento"])){

            //     unlink($validar[0]["img_documento"]);
            
            // }

            $documento = Documentos::where("id_documento",$validar[0]["id_documento"])->delete();

            //Responder al AJAX de JS
            return "ok";
        
        }else{

            return redirect("documentos")->with("no-borrar", "");   

        }

    }


    /*=============================================
    Ver observaciones
    =============================================*/

    
    public function showobs($id){   

        $observaciones = Observaciones::where('documento_id', $id)->get();
        $blog = Blog::all();
        $administradores = Administradores::all();


        if(count($observaciones) != 0){

            return view("paginas.documentos", array("status"=>200, "observaciones"=>$observaciones, "blog"=>$blog, "administradores"=>$administradores)); 
        }

        else{
            
            return view("paginas.documentos", array("status"=>404, "blog"=>$blog, "administradores"=>$administradores));

        }

    }

}
