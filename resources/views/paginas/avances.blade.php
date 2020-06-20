@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Avances</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="{{url('/')}}">Inicio</a></li>

                        <li class="breadcrumb-item active">Avances</li>

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
                                data-target="#crearAvance">Crear nuevo avance</button>

                        </div>

                        <div class="card-body">

                            {{--   @foreach ($avance as $element)
                  {{ $element }}
                            @endforeach --}}

                            <table class="table table-bordered table-striped dt-responsive" id="tablaAvance" width="100%">

                                <thead>

                                    <tr>

                                        <th width="10px">#</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Fecha</th>
                                        <th>Asignación</th>
                                        <th>Adjunto</th>
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
Crear Avance
======================================-->
<div class="modal" id="crearAvance">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{url('/')}}/avances" method="post" enctype="multipart/form-data">

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Registrar Avance</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <div class="form-group mb-3">

                        <label>Mi Asunto <span class="small"></span></label>

                        <input type="text" class="form-control" name="asunto_avance"
                            placeholder="Especificar mi avance" value="{{old("asunto_avance")}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Detalles <span class="small"></span></label>

                        

                            <textarea name="detalle_avance" type="text" id="detalle_avance" class="form-control" cols="30" rows="10" value="{{old("detalle_avance")}}" required></textarea>
                    </div>
                    <div class="form-group mb-3">

                        <label>Fecha<span class="small"></span></label>

                            <input type="date" name="fecha_avance" class="form-control" placeholder="dd/mm/aaaa" id="" required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Mi asignación<span class="small"> ¿A qué asignacion pertenece mi avance?</span></label>

                        <select name="asignacion_id" id="asignacion_id" required class="form-control" >
                            @foreach ($asignaciones as $key => $value)
                            <option value="{{$value->id_asignacion}}">{{$value->titulo_asignacion}}</option>
                            @endforeach
                          </select>
                    </div>
   
                    
                    {{-- Archivos --}}

                    <hr class="pb-2">

                    <div class="form-group mb-3">
                        
                            <label>Subir mi archivo <span class="small">Peso Max. 2MB | Formato: PDF</span></label>
                        
                            <input type="file" name="file_avance" required>
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
Editar Avance
======================================-->

@if (isset($status))

@if ($status == 200)

@foreach ($avance as $key => $value)

<div class="modal" id="editarAvance">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{url('/')}}/avances/{{$value->id_avance}}" method="post"
                enctype="multipart/form-data">

                @method('PUT')

                @csrf

                <div class="modal-header bg-info">

                    <h4 class="modal-title">Editar Avance</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">


                    <div class="form-group mb-3">

                        <label>Asunto <span class="small"></span></label>

                        <input type="text" class="form-control" name="asunto_avance"
                            placeholder="Especifica tu avance" value="{{$value->asunto_avance}}"
                            required>
                    </div>
                    <div class="form-group mb-3">

                        <label>Detalle <span class="small"></span></label>
                            <textarea name="detalle_avance" type="text" id="detalle_avance" class="form-control" cols="30" rows="10"  required>{{$value->detalle_avance}}</textarea>
                    </div>
                    <div class="form-group mb-3">

                        <label>Fecha<span class="small"></span></label>

                            <input type="date" name="fecha_avance" class="form-control" placeholder="dd/mm/aaaa" id="" value="{{$value->fecha_avance}}" required>
                    </div>

                
                    
                    <div class="form-group mb-3">

                        <label>Mi asignación<span class="small"></span></label>
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
    $("#editarAvance").modal()

</script>

@endif

@endif

@if (Session::has("ok-crear"))

<script>
    notie.alert({
        type: 1,
        text: '¡El avance ha sido creada correctamente!',
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

@if (Session::has("no-validacion-pdf"))

<script>
    notie.alert({
        type: 2,
        text: '¡No se está validando el documento!',
        time: 7
    })

</script>

@endif
@if (Session::has("no-validacion-pdf-2"))

<script>
    notie.alert({
        type: 2,
        text: '¡Valida pero nada mas!',
        time: 7
    })

</script>

@endif
@if (Session::has("no-validacion-pdf-3"))

<script>
    notie.alert({
        type: 2,
        text: '¡Error PDF-3',
        time: 7
    })

</script>

@endif

@if (Session::has("error"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error en el gestor de avances!',
        time: 10
    })

</script>

@endif

@if (Session::has("ok-editar"))

<script>
    notie.alert({
        type: 1,
        text: '¡El avance ha sido actualizada correctamente!',
        time: 10
    })

</script>

@endif

@if (Session::has("no-borrar"))

<script>
    notie.alert({
        type: 3,
        text: '¡Error al borrar el avance!',
        time: 10
    })

</script>

@endif

@endsection
