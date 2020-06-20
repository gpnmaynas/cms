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

var tablaAvance = $("#tablaAvance").DataTable({
	
	processing: true,
  	serverSide: true,

  	ajax:{
  		url: ruta+"/avances"		
  	},

  	"columnDefs":[{
  		"searchable": true,
  		"orderable": true,
  		"targets": 0
  	}],

  	"order":[[0, "desc"]],

  	columns: [
	  	{
	    	data: 'id_avance',
	    	name: 'id_avance'
        },
        {
			data: 'asunto_avance',
			name: 'asunto_avance'
		  },
	  	{
	  		data: 'detalle_avance',
	    	name: 'detalle_avance'
		  },
		  {
			data: 'fecha_avance',
			name: 'fecha_avance'
		  },
        {
			data: 'asignacion_id',
			name: 'asignacion_id'
		  },
		  {
			data: 'file_avance',
			name: 'file_avance'
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

tablaAvance.on('order.dt search.dt', function(){

	tablaAvance.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i){ cell.innerHTML = i+1})


}).draw();