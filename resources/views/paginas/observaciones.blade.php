@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Observaciones</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

                        <li class="breadcrumb-item active">Observaciones</li>

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
                                data-target="#crearObservacion">Crear nueva observacion</button>

                        </div>

                        <div class="card-body">

                            {{--   @foreach ($observacion as $element)
                  {{ $element }}
                            @endforeach --}}

                            <table class="table table-bordered table-striped dt-responsive" id="tablaObs" width="100%">

                                <thead>

                                    <tr>

                                        <th width="10px">#</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Fecha</th>
                                        <th>Doc. Observación</th>
                                        <th>Doc. Observado</th>
                                        
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
Crear Observacion
======================================-->
<div class="modal" id="crearObservacion">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{url('/')}}/observaciones" method="post" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Crear Observacion</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                  

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control" name="titulo_doc_obs"
                            placeholder="Ingrese el título de la observacion" value="{{old("titulo_doc_obs")}}"
                            required>

                    </div>

                    {{-- Descripción documento --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-pencil-alt"></i>
                        </div>

                        <input type="text" class="form-control" name="detalle_obs"
                            placeholder="Ingrese la descripción de la observacion"
                            value="{{old("detalle_obs")}}" maxlength="30" required>

                    </div>
                    

                   
                    <label>Documento de observación<span class="small"> ( Selecciona el documento que observa )</span></label>
                    <select name="doc_obs" id="" class="form-control">
                        
                        @foreach ($documentos as $key => $value)
                        <option value="{{$value->id_documento}}">{{$value->titulo_documento}}</option>
                        @endforeach
                    </select>    
                    <label>Documento<span class="small"> ( Selecciona el documento observado )</span></label>
                    <select name="documento_id" id="" class="form-control">
                        
                        @foreach ($documentos as $key => $value)
                        <option value="{{$value->id_documento}}">{{$value->titulo_documento}}</option>
                        @endforeach
                    </select>    

                    <div class="row">
                        {{-- Fecha Emisión documento --}}
                        <div class="form-group col-6">
                            <label>Fecha <span class="small">( ¿Cuando se dió esta observacion?
                                    )</span></label>
                            <input type="date" name="fecha_doc_obs" id="default-datepicker" class="form-control">
                        </div>

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
Editar Observacion
======================================-->

@if (isset($status))

@if ($status == 200)

@foreach ($observacion as $key => $value)

<div class="modal" id="editarObservacion">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/observaciones/{{$value->id_obs}}" method="post"
                enctype="multipart/form-data">

                @method('PUT')

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Observación</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-list-ul"></i>
                        </div>

                        <input type="text" class="form-control" name="titulo_doc_obs"
                            placeholder="Ingrese el título de la observacion" value="{{$value->titulo_doc_obs}}"
                            required>

                    </div>

                    {{-- Descripción documento --}}

                    <div class="input-group mb-3">

                        <div class="input-group-append input-group-text">
                            <i class="fas fa-pencil-alt"></i>
                        </div>

                        <input type="text" class="form-control" name="detalle_obs"
                            placeholder="Ingrese la descripción de la observacion"
                            value="{{$value->detalle_obs}}" maxlength="30" required>

                    </div>
                    

                   
                    <label>Documento de observación<span class="small"> ( Selecciona el documento que observa )</span></label>
                    <select name="doc_obs" id="" class="form-control">
                        
                        @foreach ($documentos as $key => $value2)
                        @if($value2->id_documento == $value->doc_obs)
                        <option value="{{$value2->id_documento}}" selected>{{$value2->titulo_documento}}</option>
                        @endif
                        @endforeach
                        @foreach ($documentos as $key => $value2)
                        @if($value2->id_documento != $value->doc_obs)
                        <option value="{{$value2->id_documento}}">{{$value2->titulo_documento}}</option>
                        @endif
                        @endforeach
                    </select>    
                    <label>Documento<span class="small"> ( Selecciona el documento observado )</span></label>
                    <select name="documento_id" id="" class="form-control">
                        
                        @foreach ($documentos as $key => $value2)
                        @if($value2->id_documento == $value->documento_id)
                        <option value="{{$value2->id_documento}}" selected>{{$value2->titulo_documento}}</option>
                        @endif
                        @endforeach
                        @foreach ($documentos as $key => $value2)
                        @if($value2->id_documento != $value->documento_id)
                        <option value="{{$value2->id_documento}}">{{$value2->titulo_documento}}</option>
                        @endif
                        @endforeach
                    </select>    

                    <div class="row">
                        {{-- Fecha Emisión documento --}}
                        <div class="form-group col-6">
                            <label>Fecha <span class="small">( ¿Cuando se dió esta observacion?)</span></label>
                            <input type="date" name="fecha_doc_obs" class="form-control" value="{{$value->fecha_doc_obs}}">
                        </div>

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
    $("#editarObservacion").modal()

</script>

@endif

@endif

@if (Session::has("ok-crear"))

<script>
    notie.alert({
        type: 1,
        text: '¡La observacion ha sido creada correctamente!',
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
        text: '¡Error en el gestor de observaciones!',
        time: 10
    })

</script>

@endif

@if (Session::has("ok-editar"))

<script>
    notie.alert({
        type: 1,
        text: '¡La observacion ha sido actualizada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error al borrar la observacion!',
        time: 10
    })

</script>

@endif

@endsection
