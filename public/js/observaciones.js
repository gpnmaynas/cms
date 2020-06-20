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

var tablaObs = $("#tablaObs").DataTable({
	
	processing: true,
  	serverSide: true,

  	ajax:{
  		url: ruta+"/observaciones"		
  	},

  	"columnDefs":[{
  		"searchable": true,
  		"orderable": true,
  		"targets": 0
  	}],

  	"order":[[0, "desc"]],

  	columns: [
	  	{
	    	data: 'id_obs',
	    	name: 'id_obs'
		},
	  	
		  {
			data: 'titulo_doc_obs',
			name: 'titulo_doc_obs'
		  },
		  {
			data: 'detalle_obs',
			name: 'detalle_obs'
		  },
		  {
			data: 'fecha_doc_obs',
			name: 'fecha_doc_obs'
		  },
		  {
			data: 'doc_obs',
			name: 'doc_obs'
		},
		{
			data: 'documento_id',
		  name: 'documento_id'
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

tablaObs.on('order.dt search.dt', function(){

	tablaObs.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i){ cell.innerHTML = i+1})


}).draw();