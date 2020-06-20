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

var tablaDocumentos = $("#tablaDocumentos").DataTable({
	
	processing: true,
  	serverSide: true,

  	ajax:{
  		url: ruta+"/documentos"		
  	},

  	"columnDefs":[{
  		"searchable": true,
  		"orderable": true,
  		"targets": 0
  	}],

  	"order":[[0, "desc"]],

  	columns: [
	  	{
	    	data: 'id_documento',
	    	name: 'id_documento'
		},
		{
	    	data: 'name',
	    	name: 'name'
	  	},
	  	{
	  		data: 'titulo_documento',
	    	name: 'titulo_documento'
		  },
		  {
			data: 'detalle_documento',
			name: 'detalle_documento'
		},
		  {
			data: 'file_documento',
			name: 'file_documento'
		},
		// {
		// 	data: 'p_claves_documento',
		//   	name: 'p_claves_documento'
		// },
	  	{
	  		data: 'fecha_emision_documento',
	    	name: 'fecha_emision_documento'
		},
		{
			data: 'fecha_limite_documento',
		  	name: 'fecha_limite_documento'
		},
		
		{
			data: 'involucrados_documento',
			name: 'involucrados_documento'
		},
		
		{
			data: 'observaciones_documento',
			name: 'observaciones_documento'
		},
		
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

tablaDocumentos.on('order.dt search.dt', function(){

	tablaDocumentos.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i){ cell.innerHTML = i+1})


}).draw();