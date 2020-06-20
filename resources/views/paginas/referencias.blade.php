@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Referencias</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

                        <li class="breadcrumb-item active">Referencias</li>

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
                                data-target="#crearReferencia">Crear nueva referencia</button>

                        </div>

                        <div class="card-body">

                            {{--   @foreach ($referencia as $element)
                  {{ $element }}
                            @endforeach --}}

                            <table class="table table-bordered table-striped dt-responsive" id="tablaRef" width="100%">

                                <thead>

                                    <tr>

                                        <th width="10px">#</th>
                                        <th>Tema</th>
                                        <th>Detalle</th>
                                        <th>Asignación</th>
                                        <th>Documento referencia</th>
                                        
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
Crear Referencia
======================================-->
<div class="modal" id="crearReferencia">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{url('/')}}/referencias" method="post" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Crear Referencia</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <div class="form-group mb-3">

                        <label>Tema <span class="small"></span></label>

                        <input type="text" class="form-control" name="titulo_ref"
                            placeholder="Ingrese el tema de la referencia" value="{{old("titulo_ref")}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Detalle <span class="small"></span></label>

                        <input type="text" class="form-control" name="detalle_ref"
                            placeholder="Ingrese el tema de la referencia" value="{{old("detalle_ref")}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Documento<span class="small"></span></label>

                            <select name="documento_id" id="" required class="form-control" >
                            <option value="">Seleccione documento</option>
                            @foreach ($documentos as $key => $value)
                            <option value="{{$value->id_documento}}">{{$value->titulo_documento}}</option>
                            @endforeach
                            </select>
                    </div>
                    <div class="form-group mb-3">

                        <label>Asignación que referencia <span class="small"></span></label>

                        <select name="asignacion_id" id="" required class="form-control" >
                            <option value="">Seleccione documento</option>
                            @foreach ($asignaciones as $key => $value)
                            <option value="{{$value->id_asignacion}}">{{$value->titulo_asignacion}}</option>
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
Editar Referencia
======================================-->

@if (isset($status))

@if ($status == 200)

@foreach ($referencia as $key => $value)

<div class="modal" id="editarReferencia">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/referencias/{{$value->id_ref}}" method="post"
                enctype="multipart/form-data">

                @method('PUT')

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Asignación</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">
                
                    <div class="form-group mb-3">

                        <label>Titulo <span class="small"></span></label>

                        <input type="text" class="form-control" name="titulo_ref"
                            placeholder="Ingrese el tema de la referencia" value="{{$value->titulo_ref}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Detalle <span class="small"></span></label>

                        <input type="text" class="form-control" name="detalle_ref"
                            placeholder="Ingrese el detalle de la referencia" value="{{$value->detalle_ref}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Documento<span class="small"></span></label>

                        <select name="documento_id" id="documento_id" required class="form-control" >
                            
                            @foreach ($documentos as $key => $value3)
                            @if ($value3->id_documento == $value->documento_id)
                            <option value="{{$value->documento_id}}">{{$value3->titulo_documento}}</option>
                            @endif
                            @endforeach
                            @foreach ($documentos as $key => $value3)
                            @if($value3->id_documento != $value->documento_id)
                            <option value="{{$value3->id_documento}}">{{$value3->titulo_documento}}</option>
                            @endif
                            @endforeach  

                        </select>
                    </div>
                    <div class="form-group mb-3">

                        <label>Asignación que referencia <span class="small"></span></label>
                        <select name="asignacion_id" id="asignacion_id" required class="form-control">
                            @foreach ($asignaciones as $key => $value4)
                            @if ($value4->id_asignacion == $value->asignacion_id)
                            <option value="{{$value->asignacion_id}}">{{$value4->titulo_asignacion}}</option>
                            @endif
                            @endforeach
                            @foreach ($asignaciones as $key => $value4)
                            @if($value4->id_asignacion != $value->asignacion_id)
                            <option value="{{$value4->id_asignacion}}">{{$value4->titulo_asignacion}}</option>
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
    $("#editarReferencia").modal()

</script>

@endif

@endif

@if (Session::has("ok-crear"))

<script>
    notie.alert({
        type: 1,
        text: '¡La referencia ha sido creada correctamente!',
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
        text: '¡Error en el gestor de referencias!',
        time: 10
    })

</script>

@endif

@if (Session::has("ok-editar"))

<script>
    notie.alert({
        type: 1,
        text: '¡La referencia ha sido actualizada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error al borrar la referencia!',
        time: 10
    })

</script>

@endif

@endsection
