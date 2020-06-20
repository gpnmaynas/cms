@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Asignaciones</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

                        <li class="breadcrumb-item active">Asignaciones</li>

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
                                data-target="#crearAsignacion">Crear nueva asignacion</button>

                        </div>

                        <div class="card-body">

                            {{--   @foreach ($asignacion as $element)
                  {{ $element }}
                            @endforeach --}}

                            <table class="table table-bordered table-striped dt-responsive" id="tablaAsignaciones"
                                width="100%">

                                <thead>

                                    <tr>

                                        <th width="10px">#</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Palabras claves</th>
                                        <th>Emitido el</th>
                                        <th>Hasta el</th>
                                        <th>Adjuntos</th>
                                        <th>Asignado a</th>
                                        <th>Etapa</th>
                                        <th>Estado</th>
                                        <th>Respuestas</th>
                                        <th>Avances</th>
                                        <th>Referencias</th>
                                        <th>Observaciones</th>
                                        <!-- <th>Ruta</th> -->
                                        <!-- <th width="200px">Imagen</th> -->
                                        <th>Acciones</th>

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
Crear Asignacion
======================================-->
<div class="modal" id="crearAsignacion">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{url('/')}}/asignaciones" method="post" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Crear Asignacion</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    {{-- Usuario asignacion --}}

                    <div class="form-group">

                      <label>Asignar a: <span class="small">( ¿A quién quiere asignar? )</span></label>
                        <select name="id_user" id="" required class="form-control" >
                          <option value="">Seleccione usuario</option>
                          @foreach ($administradores as $key => $value)
                          <option value="{{$value->id}}">{{$value->name}}</option>
                          @endforeach
                        </select>

                    </div>

                    {{-- Título asignacion --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control" name="titulo_asignacion"
                            placeholder="Ingrese el título de la asignacion" value="{{old("titulo_asignacion")}}"
                            required>

                    </div>

                    {{-- Descripción asignacion --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-pencil-alt"></i>
                        </div>

                        <input type="text" class="form-control" name="descripcion_asignacion"
                            placeholder="Ingrese la descripción de la asignacion"
                            value="{{old("descripcion_asignacion")}}" maxlength="30" required>

                    </div>

                    {{-- Ruta asignacion --}}

                    {{-- <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-link"></i>
                        </div>

                        <input type="text" class="form-control inputRuta" name="ruta_asignacion"
                            placeholder="Ingrese la ruta de la asignacion" value="{{old("ruta_asignacion")}}" required>

                    </div>

                    <hr class="pb-2"> --}}

                    {{-- Palabras claves asignacion --}}

                    <div class="form-group mb-3">

                        <label>Palabras Claves <span class="small">(Separar por comas)</span></label>

                        <input type="text" class="form-control" value="asignacion" name="p_claves_asignacion"
                            data-role="tagsinput" required>

                    </div>

                    
                    <div class="row">
                      {{-- Fecha Emisión asignacion --}}
                      <div class="form-group col-6">
                        <label>Fecha Emisión <span class="small">( ¿Desde cuando necesita esta asignación? )</span></label>
                        <input type="date" name="fecha_emision_asignacion" id="default-datepicker" class="form-control">
                      </div>
  
                      {{-- Fecha Límite asignacion --}}
  
                      <div class="form-group col-6">
                        <label>Fecha Límite <span class="small">( ¿Hasta cuando necesita esta asignación? )</span></label>
                        <input type="date" id="default-datepicker" class="form-control" name="fecha_limite_asignacion">
                      </div>
                    </div>

                    <div class="row">
                      {{-- Etapa asignacion --}}
                    <div class="form-group col-6">
                      <label>Etapa <span class="small">( ¿En qué etapa se encuentra? )</span></label>
                      <select name="etapa_id" id="" required class="form-control" >   
                        <option value="">Elije Etapa</option>                     
                        @foreach ($etapa as $key => $value)                       
                          <option value="{{$value->id_etapa}}">{{$value->titulo_etapa}}</option>                        
                        @endforeach
                        
                      </select>
                    </div>

                    {{-- Estado asignacion --}}
                    <div class="form-group col-6">
                      <label>Estado <span class="small">( ¿En qué estado se encuentra? )</span></label>
                      <select name="estado_id" class="form-control" id="">
                        <option value="">Elije Estado</option>                     
                        @foreach ($estado as $key => $value)                       
                          <option value="{{$value->id_estado}}">{{$value->titulo_estado}}</option>                        
                        @endforeach
                      </select>
                    </div>
                  </div>
                    

                    {{-- Imagen de portada --}}

                    {{-- <hr class="pb-2">

                    <div class="form-group my-2 text-center">

                        <div class="btn btn-default btn-file">

                            <i class="fas fa-paperclip"></i> Adjuntar Imagen de la Asignacion

                            <input type="file" name="img_asignacion" required>

                        </div>

                        <img class="previsualizarImg_img_asignacion img-fluid py-2">

                        <p class="help-block small">Dimensiones: 1024px * 250px | Peso Max. 2MB | Formato: JPG o PNG</p>
                    </div> --}}

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
Editar Asignacion
======================================-->

@if (isset($status))

@if ($status == 200)

@foreach ($asignacion as $key => $value)

<div class="modal" id="editarAsignacion">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/asignaciones/{{$value->id_asignacion}}" method="post"
                enctype="multipart/form-data">

                @method('PUT')

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Asignación</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                  {{-- Usuario asignacion --}}

                  <div class="form-group">

                    <label>Asignar a: <span class="small">( ¿A quién quiere asignar? )</span></label>
                      <select name="id_user" id="" required class="form-control" >
                        
                        @foreach ($administradores as $key => $value2)
                        @if ($value2->id == $value->id_user)
                          <option value="{{$value->id_user}}">{{$value2->name}}</option>
                        @endif
                        @endforeach
                        @foreach ($administradores as $key => $value2)
                        @if($value2->id != $value->id_user)
                          <option value="{{$value2->id}}">{{$value2->name}}</option>
                        @endif
                        @endforeach
                      </select>

                  </div>

                  {{-- Título asignacion --}}

                  <div class="input-group mb-3">

                      <div class="input-group-append input-group-text">
                          <i class="fas fa-list-ul"></i>
                      </div>

                      <input type="text" class="form-control" name="titulo_asignacion"
                          placeholder="Ingrese el título de la asignacion" value="{{$value->titulo_asignacion}}"
                          required>

                  </div>

                  {{-- Descripción asignacion --}}

                  <div class="input-group mb-3">

                      <div class="input-group-append input-group-text">
                          <i class="fas fa-pencil-alt"></i>
                      </div>

                      <input type="text" class="form-control" name="descripcion_asignacion"
                          placeholder="Ingrese la descripción de la asignacion"
                          value="{{$value->descripcion_asignacion}}" maxlength="30" required>

                  </div>

                  {{-- Ruta asignacion --}}

                  {{-- <div class="input-group mb-3">

                      <div class="input-group-append input-group-text">
                          <i class="fas fa-link"></i>
                      </div>

                      <input type="text" class="form-control inputRuta" name="ruta_asignacion"
                          placeholder="Ingrese la ruta de la asignacion" value="{{old("ruta_asignacion")}}" required>

                  </div>

                  <hr class="pb-2"> --}}

                  {{-- Palabras claves asignacion --}}

                  <div class="form-group mb-3">

                      <label>Palabras Claves <span class="small">(Separar por comas)</span></label>
                      @php
                    
                      $tags = json_decode($value->p_claves_asignacion, true);
  
                      $p_claves = "";
                      
                      foreach ($tags as $element){
  
                         $p_claves .= $element.",";
  
                      }
  
                    @endphp
                      <input type="text" class="form-control" name="p_claves_asignacion" data-role="tagsinput" value="{{$p_claves}}" required>

                  </div>

                  
                  <div class="row">
                    {{-- Fecha Emisión asignacion --}}
                    <div class="form-group col-6">
                      <label>Fecha Emisión <span class="small">( ¿Desde cuando necesita esta asignación? )</span></label>
                    <input type="date" name="fecha_emision_asignacion" class="form-control" value="{{$value->fecha_emision_asignacion}}">
                    </div>

                    {{-- Fecha Límite asignacion --}}

                    <div class="form-group col-6">
                      <label>Fecha Límite <span class="small">( ¿Hasta cuando necesita esta asignación? )</span></label>
                      <input type="date"  class="form-control" name="fecha_limite_asignacion" value="{{$value->fecha_limite_asignacion}}">
                    </div>
                  </div>

                  <div class="row">
                    {{-- Etapa asignacion --}}
                    <div class="form-group col-6">
                      <label>Etapa <span class="small">( ¿En qué etapa se encuentra? )</span></label>
                      <select name="etapa_id" id="etapa_id" required class="form-control" >                        
                        @foreach ($etapa as $key => $value2)
                        @if ($value2->id_etapa == $value->etapa_id)
                          <option value="{{$value->etapa_id}}">{{$value2->titulo_etapa}}</option>
                        @endif
                        @endforeach
                        @foreach ($etapa as $key => $value2)
                        @if($value2->id_etapa != $value->etapa_id)
                          <option value="{{$value2->id_etapa}}">{{$value2->titulo_etapa}}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>

                    {{-- Estado asignacion --}}
                    <div class="form-group col-6">
                      <label>Estado <span class="small">( ¿En qué estado se encuentra? )</span></label>
                      <select name="estado_id" id="estado_id" class="form-control" id="">
                        @foreach ($estado as $key => $value4)
                        @if ($value4->id_estado == $value->estado_id)
                          <option value="{{$value->estado_id}}">{{$value4->titulo_estado}}</option>
                        @endif
                        @endforeach
                        @foreach ($estado as $key => $value4)
                        @if($value4->id_estado != $value->estado_id)
                          <option value="{{$value4->id_estado}}">{{$value4->titulo_estado}}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  

                  {{-- Imagen de portada --}}

                  {{-- <hr class="pb-2">

                  <div class="form-group my-2 text-center">

                      <div class="btn btn-default btn-file">

                          <i class="fas fa-paperclip"></i> Adjuntar Imagen de la Asignacion

                          <input type="file" name="img_asignacion" required>

                      </div>

                      <img class="previsualizarImg_img_asignacion img-fluid py-2">

                      <p class="help-block small">Dimensiones: 1024px * 250px | Peso Max. 2MB | Formato: JPG o PNG</p>
                  </div> --}}

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
    $("#editarAsignacion").modal()
</script>

@endif

@endif

@if (Session::has("ok-crear"))

<script>
    notie.alert({
        type: 1,
        text: '¡La asignacion ha sido creada correctamente!',
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
        text: '¡Error en el gestor de asignaciones!',
        time: 10
    })

</script>

@endif

@if (Session::has("ok-editar"))

<script>
    notie.alert({
        type: 1,
        text: '¡La asignacion ha sido actualizada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error al borrar la asignacion!',
        time: 10
    })

</script>

@endif

@endsection
