<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>GPN Asistencias | CMS</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="{{$blog[0]['icono']}}">
	
	<!--=====================================
	PLUGINS DE CSS
	======================================-->

	{{-- BOOTSTRAP 4 --}}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	{{-- OverlayScrollbars.min.css --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/OverlayScrollbars.min.css">

	{{-- TAGS INPUT --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/tagsinput.css">

	{{-- FILE INPUT --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/fileinput.min.css">
	
	{{-- SUMMERNOTE --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/summernote.css">

	{{-- NOTIE --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/notie.css">

	<!-- DataTables -->
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/dataTables.bootstrap4.min.css">	
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/responsive.bootstrap.min.css">

	{{-- CSS AdminLTE --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/adminlte.min.css">

	{{-- google fonts --}}
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	{{-- google icons --}}
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	{{-- SELECT 2 --}}
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/select2.min.css">
	<link rel="stylesheet" href="{{ url('/') }}/css/plugins/select2-bootstrap4.min.css">


	<style>
		.responsive-table li {
  border-radius: 3px;
  padding: 25px 30px;
  display: flex;
  justify-content: space-between;
  margin-bottom: 25px;
}
.responsive-table .table-header {

  color:white;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}
.responsive-table .table-row {
  background-color: #ffffff;
  box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
  color: navy;
}
.responsive-table .col-1 {
  flex-basis: 10%;
}
.responsive-table .col-2 {
  flex-basis: 40%;
}
.responsive-table .col-3 {
  flex-basis: 25%;
}
.responsive-table .col-4 {
  flex-basis: 25%;
}
@media all and (max-width: 767px) {
  .responsive-table .table-header {
    display: none;
  }
  .responsive-table li {
    display: block;
  }
  .responsive-table .col {
    flex-basis: 100%;
  }
  .responsive-table .col {
    display: flex;
    padding: 10px 0;
  }
  .responsive-table .col:before {
    color: #6C7A89;
    padding-right: 10px;
    content: attr(data-label);
    flex-basis: 50%;
    text-align: right;
  }
  
}
	</style>
	
	


	<!--=====================================
	PLUGINS DE JS
	======================================-->

	{{-- Fontawesome --}}
	<script src="https://kit.fontawesome.com/e632f1f723.js" crossorigin="anonymous"></script>

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	{{-- jquery.overlayScrollbars.min.js --}}
	<script src="{{ url('/') }}/js/plugins/jquery.overlayScrollbars.min.js"></script>

	{{-- TAGS INPUT --}}
	{{-- https://www.jqueryscript.net/form/Bootstrap-4-Tag-Input-Plugin-jQuery.html --}}
	<script src="{{ url('/') }}/js/plugins/tagsinput.js"></script>

	{{-- FILE INPUT --}}
	<script src="{{ url('/') }}/js/plugins/fileinput.min.js"></script>
	<script src="{{ url('/') }}/js/plugins/es.js"></script>
	<script src="{{ url('/') }}/js/plugins/theme.min.js"></script>

	{{-- SUMMERNOTE --}}
	{{-- https://summernote.org/ --}}
	<script src="{{ url('/') }}/js/plugins/summernote.js"></script>

	{{-- NOTIE --}}
	{{-- https://github.com/jaredreich/notie --}}
	<script src="{{ url('/') }}/js/plugins/notie.js"></script>

	{{-- SWEET ALERT --}}
	{{-- https://sweetalert2.github.io/ --}}
	<script src="{{ url('/') }}/js/plugins/sweetalert.js"></script>

	<!-- DataTables 
	https://datatables.net/-->
	<script src="{{ url('/') }}/js/plugins/jquery.dataTables.min.js"></script>
	<script src="{{ url('/') }}/js/plugins/dataTables.bootstrap4.min.js"></script> 
	<script src="{{ url('/') }}/js/plugins/dataTables.responsive.min.js"></script>
	<script src="{{ url('/') }}/js/plugins/responsive.bootstrap.min.js"></script>	

	{{-- JS AdminLTE --}}
	<script src="{{ url('/') }}/js/plugins/adminlte.js"></script>

	{{-- SELECT 2 --}}

	<script src="{{ url('/') }}/js/plugins/select2.full.min.js"></script>

</head>

@if (Route::has('login'))

@auth

<body class="hold-transition sidebar-mini layout-fixed">

	<div class="wrapper">

		@include('modulos.header')

		@include('modulos.sidebar')

		@yield('content')

		@include('modulos.footer')


	</div>

<input type="hidden" id="ruta" value="{{url('/')}}">

<script>

$(function () {
	$('#observaciones_respuesta').select2({
	placeholder: 'Selecciona una opción',
	multiple: true,
	tags: true,
	tokenSeparators: [',', '.'],
	})
	$('#observaciones_respuesta_selected').select2({
	multiple: true,
	tags: true,
	tokenSeparators: [',', '.'],
	})
	$('#involucrados_respuesta').select2({
	placeholder: 'Selecciona una opción',
	multiple: true,
	tags: true,
	tokenSeparators: [',', '.'],
	})
	$('#involucrados_documento').select2({
	placeholder: 'Selecciona una opción',
	multiple: true,
	tags: true,
	tokenSeparators: [',', '.'],
	})
	$('#involucrados_documento_selected').select2({
	placeholder: 'Selecciona una opción',
	multiple: true,
	tags: true,
	tokenSeparators: [',', '.'],
	})
	$('#involucrados_respuesta_selected').select2({
	placeholder: 'Selecciona una opción',
	multiple: true,
	tags: true,
	tokenSeparators: [',', '.'],
	})
	$('#usuario_id').select2({
	placeholder: 'Selecciona una opción'
	})
	$('#usuario_id_selected').select2({
	placeholder: 'Selecciona una opción'
	})
	$('#documento_id').select2({
	placeholder: 'Selecciona una opción'
	})
	$('#documento_id_selected').select2({
	placeholder: 'Selecciona una opción'
	})
	$('.select2bs4').select2({
		theme: 'bootstrap4'
	});
});
</script>

<script src="{{url('/')}}/js/codigo.js"></script>
<script src="{{url('/')}}/js/administradores.js"></script>
<script src="{{url('/')}}/js/asignaciones.js"></script>
<script src="{{url('/')}}/js/documentos.js"></script>
<script src="{{url('/')}}/js/observaciones.js"></script>
<script src="{{url('/')}}/js/referencias.js"></script>
<script src="{{url('/')}}/js/avances.js"></script>
<script src="{{url('/')}}/js/respuestas.js"></script>
<script src="{{url('/')}}/js/categorias.js"></script>
<script src="{{url('/')}}/js/articulos.js"></script>
<script src="{{url('/')}}/js/opiniones.js"></script>
<script src="{{url('/')}}/js/banner.js"></script>
<script src="{{url('/')}}/js/anuncios.js"></script>

</body>

@else

@include('paginas.login')

@endauth

@endif	

</html>