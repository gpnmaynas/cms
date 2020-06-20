@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Documentos</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

                        <li class="breadcrumb-item active">Documentos</li>

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
                                data-target="#crearDocumento">Crear nueva documento</button>

                        </div>

                        <div class="card-body">

                            {{--   @foreach ($documento as $element)
                  {{ $element }}
                            @endforeach --}}

                            <table class="table table-bordered table-striped dt-responsive" id="tablaDocumentos"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th width="10px">#</th>
                                        <th>Subido por</th>
                                        <th>Título</th>
                                        <th>Detalle</th>
                                        <th>Adjunto</th>
                                        {{-- <th>Palabras claves</th> --}}
                                        <th>Emitido el</th>
                                        <th>Hasta el</th>
                                        <th>Involucrados</th>
                                        <th>Observaciones</th>{{--
                                        <th>Respuestas</th> --}}
                                        <!-- <th>Ruta</th> -->
                                        <!-- <th width="200px">Imagen</th> -->

                                        <th>Accion</th>
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
Crear Documento
======================================-->
<div class="modal" id="crearDocumento">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{url('/')}}/documentos" method="post" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Crear Documento</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    {{-- Usuario documento --}}

                    <div class="form-group">

                        <label>Subido por: <span class="small"></span></label>
                        <select name="id_user" id="" required class="form-control" >
                          <option value="" disabled>Seleccione usuario</option>
                          @foreach ($administradores as $key => $value)
                          <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                        </select>

                    </div>

                    {{-- Título documento --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control" name="titulo_documento"
                            placeholder="Ingrese el título de la documento" value="{{old("titulo_documento")}}"
                            required>

                    </div>

                    {{-- Descripción documento --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-pencil-alt"></i>
                        </div>

                        <input type="text" class="form-control" name="detalle_documento"
                            placeholder="Ingrese la descripción de la documento"
                            value="{{old("detalle_documento")}}" maxlength="30" required>

                    </div>
                    


                    <div class="form-group mb-3">

                        <label>Palabras Claves <span class="small">(Separar por comas)</span></label>

                        <input type="text" class="form-control" value="documento" name="p_claves_documento"
                            data-role="tagsinput" required>

                    </div>
                    <label>Áreas Involucradas<span class="small"></span></label>
                    <select name="involucrados_documento[]" multiple="multiple" id="involucrados_documento" class="form-control">
                        
                        @foreach ($involucrados as $key => $value)
                        <option value="{{$value->id_involucrado}}">{{$value->titulo_involucrado}}</option>
                        @endforeach
                    </select>    

                    <div class="row">
                        {{-- Fecha Emisión documento --}}
                        <div class="form-group col-6">
                            <label>Fecha Emisión <span class="small">( ¿Desde cuando necesita esta asignación?
                                    )</span></label>
                            <input type="date" name="fecha_emision_documento" id="default-datepicker" class="form-control">
                        </div>

                        {{-- Fecha Límite documento --}}

                        <div class="form-group col-6">
                            <label>Fecha Límite <span class="small">( ¿Hasta cuando necesita esta asignación?
                                    )</span></label>
                            <input type="date" id="default-datepicker" class="form-control" name="fecha_limite_documento">
                        </div>
                    </div>

                   {{-- Archivos --}}

                   <hr class="pb-2">

                   <div class="form-group mb-3">
                       
                           <label>Subir mi archivo <span class="small">Peso Max. 2MB | Formato: PDF</span></label>
                       
                           <input type="file" name="file_documento" required>
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
Ver Observaciones
======================================-->

{{-- @foreach ($observaciones as $key => $value)

<div class="modal" id="verObservaciones">

    <div class="modal-dialog">

        <div class="modal-content">

            

        </div>

    </div>

</div>

@endforeach

<script>
    $("#verObservaciones").modal()
</script> --}}

<!--=====================================
Editar Documento
======================================-->

@if (isset($status))

@if ($status == 200)

@foreach ($documento as $key => $value)

<div class="modal" id="editarDocumento">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/documentos/{{$value->id_documento}}" method="post" enctype="multipart/form-data">

                @method('PUT')

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Documento</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    {{-- Usuario documento --}}

                    <div class="form-group">

                        <label>Subido por: <span class="small"></span></label>
                        <select name="id_user" id="" required class="form-control" >
                          <option value="" disabled>Seleccione usuario</option>
                          @foreach ($administradores as $key => $gsk)
                          @if ($gsk->id == $value->id_user)
                            <option value="{{$gsk->id}}" selected>{{$gsk->name}}</option>
                          @endif
                          @endforeach
                          @foreach ($administradores as $key => $gsk)
                          @if ($gsk->id != $value->id_user)
                            <option value="{{$gsk->id}}">{{$gsk->name}}</option>
                          @endif
                          @endforeach
                        </select>

                    </div>

                    {{-- Título documento --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control" name="titulo_documento"
                            placeholder="Ingrese el título de la documento" value="{{$value->titulo_documento}}"
                            required>

                    </div>

                    {{-- Descripción documento --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-pencil-alt"></i>
                        </div>

                        <input type="text" class="form-control" name="detalle_documento"
                            placeholder="Ingrese la descripción de la documento"
                            value="{{$value->detalle_documento}}" maxlength="30" required>

                    </div>
                    


                    <div class="form-group mb-3">

                        <label>Palabras Claves <span class="small">(Separar por comas)</span></label>

                        @php
                    
                      $tags = json_decode($value->p_claves_documento, true);
  
                      $p_claves = "";
                      
                      foreach ($tags as $element){
  
                         $p_claves .= $element.",";
  
                      }
  
                    @endphp
                      <input type="text" class="form-control" name="p_claves_documento" data-role="tagsinput" value="{{$p_claves}}" required>

                    </div>
                    <label>Áreas Involucradas<span class="small"></span></label>
                    <select name="involucrados_documento[]" multiple="multiple" id="involucrados_documento_selected" class="form-control">
                       //Select Multiple 
                       @php
                    
                        $inv   = ''; 
                        foreach ($involucrados as $key => $gsk2){
                        $inv  .= ''.$gsk2->id_involucrado.' ';
                        }
                        $inv2 = explode(" ", $inv);
                        $tags2 = json_decode($value->involucrados_documento, true);
                        
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

                    <div class="row">
                        {{-- Fecha Emisión documento --}}
                        <div class="form-group col-6">
                            <label>Fecha Emisión <span class="small">( ¿Desde cuando necesita esta asignación?
                                    )</span></label>
                            <input type="date" name="fecha_emision_documento" id="default-datepicker" class="form-control" value="{{$value->fecha_emision_documento}}">
                        </div>

                        {{-- Fecha Límite documento --}}

                        <div class="form-group col-6">
                            <label>Fecha Límite <span class="small">( ¿Hasta cuando necesita esta asignación?
                                    )</span></label>
                            <input type="date" id="default-datepicker" class="form-control" name="fecha_limite_documento"value="{{$value->fecha_limite_documento}}">
                        </div>
                    </div>

                   {{-- Archivos --}}

                   <hr class="pb-2">

                   <div class="form-group mb-3">
                       
                           <label>Subir mi archivo <span class="small">Peso Max. 2MB | Formato: PDF</span></label>
                       
                           <input type="file" name="file_documento" disabled>
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
    $("#editarDocumento").modal()

</script>

@endif

@endif

@if (Session::has("ok-crear"))

<script>
    notie.alert({
        type: 1,
        text: '¡La documento ha sido creada correctamente!',
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
        text: '¡Error en el gestor de documentos!',
        time: 10
    })

</script>

@endif

@if (Session::has("ok-editar"))

<script>
    notie.alert({
        type: 1,
        text: '¡La documento ha sido actualizada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error al borrar la documento!',
        time: 10
    })

</script>

@endif

@endsection
