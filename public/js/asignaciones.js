/*=============================================
DataTable Servidor de administradores
=============================================*/

// $.ajax({

// 	url: ruta+"/categorias",
// 	success: function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	},
// 	error: function (jqXHR, textStatus, errorThrown) {
//         console.error(textStatus + " " + errorThrown);
//     }

// })

/*=============================================
DataTable de administradores
=============================================*/

var tablaAsignaciones = $("#tablaAsignaciones").DataTable({
	
	processing: true,
  	serverSide: true,

  	ajax:{
  		url: ruta+"/asignaciones"		
  	},

  	"columnDefs":[{
  		"searchable": true,
  		"orderable": true,
  		"targets": 0
  	}],

  	"order":[[0, "desc"]],

  	columns: [
	  	{
	    	data: 'id_asignacion',
	    	name: 'id_asignacion'
	  	},
	  	{
	  		data: 'titulo_asignacion',
	    	name: 'titulo_asignacion'
	  	},
	  	{
	  		data: 'descripcion_asignacion',
	    	name: 'descripcion_asignacion'
		},
		{
			data: 'p_claves_asignacion',
		  	name: 'p_claves_asignacion'
		},
	  	{
	  		data: 'fecha_emision_asignacion',
	    	name: 'fecha_emision_asignacion'
		},
		{
			data: 'fecha_limite_asignacion',
		  	name: 'fecha_limite_asignacion'
		},
		{
			data: 'id_adjuntos',
			name: 'id_adjuntos'
		},
		{
			data: 'name',
			name: 'name'
		},
		{
			data: 'titulo_etapa',
			name: 'titulo_etapa'
		},
		{
			data: 'titulo_estado',
			name: 'titulo_estado'
		},
		{
			data: 'respuestas_asignacion',
			name: 'respuestas_asignacion'
		},
		{
			data: 'avances_asignacion',
			name: 'avances_asignacion'
		},
		{
			data: 'referencias_asignacion',
			name: 'referencias_asignacion'
		},
		{
			data: 'observaciones_asignacion',
			name: 'observaciones_asignacion'
		},
	  	// {
	  	// 	data: 'fecha_limite_asignacion',
	    // 	name: 'fecha_limite_asignacion',
	    // 	render: function(data, type, full, meta){

	    // 		return '<p class="validarRuta">'+data+'</p>'
	    		
	    // 	}
	  	// },
	  	// {
	  	// 	data: 'img_categoria',
	    // 	name: 'img_categoria',
	    // 	render: function(data, type, full, meta){

	    // 		return '<img src="'+ruta+'/'+data+'" class="img-fluid">'
	    		
	    // 	},

	    // 	orderable: false
	  	// },
	  	{
	  		data: 'acciones',
	    	name: 'acciones'
	  	}

	],
 	"language": {

	    "sProcessing": "Procesando...",
	    "sLengthMenu": "Mostrar _MENU_ registros",
	    "sZeroRecords": "No se encontraron resultados",
	    "sEmptyTable": "Ningún dato disponible en esta tabla",
	    "sInfo": "Mostrando registros del _START_ al _END_",
	    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
	    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix": "",
	    "sSearch": "Buscar:",
	    "sUrl": "",
	    "sInfoThousands": ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	      "sFirst": "Primero",
	      "sLast": "Último",
	      "sNext": "Siguiente",
	      "sPrevious": "Anterior"
	    },
	    "oAria": {
	      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
	      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }

  	}

});

tablaAsignaciones.on('order.dt search.dt', function(){

	tablaAsignaciones.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i){ cell.innerHTML = i+1})


}).draw();