@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Respuestas</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

                        <li class="breadcrumb-item active">Respuestas</li>

                    </ol>

                </div>

            </div>

        </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <!-- Default box -->
                    <div class="card">

                        <div class="card-header">

                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#crearRespuesta">Crear nuevo respuesta</button>

                        </div>

                        <div class="card-body">

                            {{--   @foreach ($respuesta as $element)
                  {{ $element }}
                            @endforeach --}}

                            <table class="table table-bordered table-striped dt-responsive" id="tablaRespuesta" width="100%">

                                <thead>

                                    <tr>

                                        <th width="10px">#</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Fecha</th>
                                        <th>Documento</th>
                                        <th>Área Involucrada</th>
                                        <th width="10px">Usuario</th>
                                        <th>Observaciones</th>
                                        
                                        <!-- <th>Ruta</th> -->
                                        <!-- <th width="200px">Imagen</th> -->
                                        <th width="10px">Acciones</th>

                                    </tr>


                                </thead>

                                <tbody>


                                </tbody>

                            </table>

                        </div>

                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>

            </div>

        </div>
       


    </section>
    <!-- /.content -->
</div>





<!--=====================================
Crear Respuesta
======================================-->
<div class="modal fade" id="crearRespuesta">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/respuestas" method="post" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-info">
                    <h4 class="modal-title">Crear Respuesta</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group mb-3">

                        <label>Asunto <span class="small"></span></label>

                        <input type="text" class="form-control" name="asunto_respuesta"
                            placeholder="Especifica tu respuesta" value="{{old("asunto_respuesta")}}"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Detalle <span class="small"></span></label>                        
                        <textarea name="detalle_respuesta" type="text" class="form-control" cols="30" rows="3" value="{{old("detalle_respuesta")}}" required></textarea>
                    </div>
                    <div class="form-group mb-3">

                        <label>Fecha<span class="small"></span></label>

                            <input type="date" name="fecha_respuesta" class="form-control" placeholder="dd/mm/aaaa" id="" required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Documento<span class="small"></span></label>

                        <select name="documento_id" required class="form-control" >
                            <option value="">Seleccione documento</option>
                            @foreach ($documentos as $key => $value)
                            <option value="{{$value->id_documento}}">{{$value->titulo_documento}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Áreas Involucradas<span class="small"></span></label>
                        <select name="involucrados_respuesta[]" multiple="multiple" id="involucrados_respuesta" class="form-control">
                            
                            @foreach ($involucrados as $key => $value)
                            <option value="{{$value->id_involucrado}}">{{$value->titulo_involucrado}}</option>
                            @endforeach
                        </select>    
                    </div>
                   
                    <div class="form-group mb-3">
                        <label>Observaciones<span class="small"></span></label>
                        <select name="observaciones_respuesta[]" multiple="multiple" id="observaciones_respuesta" class="form-control">
                            @foreach ($observaciones as $key => $value)
                            <option value="{{$value->id_obs}}">{{$value->titulo_doc_obs}}</option>
                            @endforeach
                        </select>    
                    </div>
                    <div class="form-group mb-3">
                        <label>¿Quién eres? <span class="small"></span></label>
                        <select name="usuario_id"  class="form-control">
                            @foreach ($administradores as $key => $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                     
                    


                </div>

                <div class="modal-footer d-flex justify-content-between">

                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<!--=====================================
Editar Respuesta
======================================-->

@if (isset($status))

@if ($status == 200)

@foreach ($respuesta as $key => $value)

<div class="modal" id="editarRespuesta">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/respuestas/{{$value->id_respuesta}}" method="post"
                enctype="multipart/form-data">

                @method('PUT')

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Respuesta</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">


                    <div class="form-group mb-3">

                        <label>Asunto <span class="small"></span></label>

                        <input type="text" class="form-control" name="asunto_respuesta" id="asunto_respuesta"
                            placeholder="Especifica tu respuesta" value="{{$value->asunto_respuesta}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Detalle <span class="small"></span></label>
                            <textarea name="detalle_respuesta" id="detalle_respuesta" type="text" class="form-control" cols="30" rows="3"  required>{{$value->detalle_respuesta}}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Fecha<span class="small"></span></label>
                        <input type="date" name="fecha_respuesta" class="form-control" placeholder="dd/mm/aaaa" value="{{$value->fecha_respuesta}}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Documento<span class="small"></span></label>
                        <select name="documento_id" id="documento_id" required class="form-control">
                            @foreach ($documentos as $key => $value2)
                            @if($value2->id_documento == $value->documento_id)
                            <option selected="selected" value="{{$value->documento_id}}">{{$value2->titulo_documento}}</option>
                            @endif
                            @endforeach
                            @foreach ($documentos as $key => $value2)
                            @if($value2->id_documento != $value->documento_id)
                            <option value="{{$value2->id_documento}}">{{$value2->titulo_documento}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Áreas Involucradas<span class="small"></span></label>
                        <select name="involucrados_respuesta[]" multiple="multiple" id="involucrados_respuesta_selected" class="form-control">
                            //Select Multiple 
                       @php
                    
                        $inv   = ''; 
                        foreach ($involucrados as $key => $gsk2){
                        $inv  .= ''.$gsk2->id_involucrado.' ';
                        }
                        $inv2 = explode(" ", $inv);
                        $tags2 = json_decode($value->involucrados_respuesta, true);
                        
                        foreach ($inv2 as $gsk1) {
                            foreach ($tags2 as $gsk2) {
                                if ($gsk1 == $gsk2){
                                    foreach ($involucrados as $key =>$gsk3){
                                        if($gsk1 == $gsk3->id_involucrado){
                                            echo "<option value='$gsk1' selected>".$gsk3->titulo_involucrado."</option>";
                                        }
                                        
                                    }
                                    
                                }
                            }
                        }
                        foreach ($inv2 as $gsk1) {
                        $encontrado=false;
                        foreach ($tags2 as $gsk2) {
                            if ($gsk1 == $gsk2){
                                $encontrado=true;
                                $break;
                            }
                        }
                            if ($encontrado == false){
                                foreach ($involucrados as $key =>$gsk3){
                                        if($gsk1 == $gsk3->id_involucrado){
                                            echo "<option value='$gsk1'>".$gsk3->titulo_involucrado."</option>";
                                        }
                                        
                                    }
                            }
                        }
                       @endphp
                        </select> 
                        
                        
    
                    </div>
                   
                    <div class="form-group mb-3">
                        <label>Observaciones<span class="small"></span></label>
                        <select name="observaciones_respuesta[]" multiple="multiple" id="observaciones_respuesta_selected" class="form-control">
                            //Select Multiple 
                       @php
                    
                        $inv   = ''; 
                        foreach ($observaciones as $key => $gsk2){
                        $inv  .= ''.$gsk2->id_obs.' ';
                        }
                        $inv2 = explode(" ", $inv);
                        $tags2 = json_decode($value->observaciones_respuesta, true);
                        
                        foreach ($inv2 as $gsk1) {
                            foreach ($tags2 as $gsk2) {
                                if ($gsk1 == $gsk2){
                                    foreach ($observaciones as $key =>$gsk3){
                                        if($gsk1 == $gsk3->id_obs){
                                            echo "<option value='$gsk1' selected>".$gsk3->titulo_doc_obs."</option>";
                                        }
                                        
                                    }
                                    
                                }
                            }
                        }
                        foreach ($inv2 as $gsk1) {
                        $encontrado=false;
                        foreach ($tags2 as $gsk2) {
                            if ($gsk1 == $gsk2){
                                $encontrado=true;
                                $break;
                            }
                        }
                            if ($encontrado == false){
                                foreach ($observaciones as $key =>$gsk3){
                                        if($gsk1 == $gsk3->id_obs){
                                            echo "<option value='$gsk1'>".$gsk3->titulo_doc_obs."</option>";
                                        }
                                        
                                    }
                            }
                        }
                       @endphp
                        </select>   
                         
                    </div>
                    <div class="form-group mb-3">
                        <label>¿Quién eres? <span class="small"></span></label>
                        <select name="usuario_id" id="usuario_id_selected" class="form-control">
                        @foreach ($administradores as $key => $value4)
                        @if ($value4->id == $value->usuario_id)
                          <option value="{{$value4->id}}" selected="selected">{{$value4->name}}</option>
                        @endif
                        @endforeach
                        @foreach ($administradores as $key => $value4)
                        @if($value4->id != $value->usuario_id)
                          <option value="{{$value4->id}}">{{$value4->name}}</option>
                        @endif
                        @endforeach
                        </select>
                    </div>
                  
                    
                    
                </div>

                <div class="modal-footer d-flex justify-content-between">

                    <div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach


    

<script>
   
    $("#editarRespuesta").modal();

</script>

@endif

@endif

@if (Session::has("ok-crear"))

<script>
    notie.alert({
        type: 1,
        text: '¡El respuesta ha sido creada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-validacion"))

<script>
    notie.alert({
        type: 2,
        text: '¡Hay campos no válidos en el formulario!',
        time: 10
    })

</script>

@endif

@if (Session::has("error"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error en el gestor de respuestas!',
        time: 10
    })

</script>

@endif

@if (Session::has("ok-editar"))

<script>
    notie.alert({
        type: 1,
        text: '¡El respuesta ha sido actualizada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error al borrar el respuesta!',
        time: 10
    })

</script>

@endif

@endsection
