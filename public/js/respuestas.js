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

var tablaRespuesta = $("#tablaRespuesta").DataTable({
	
	processing: true,
  	serverSide: true,

  	ajax:{
		  url: ruta+"/respuestas"	,
		  //type: "post",
		  error: function(xhr, ajaxOptions, thrownError){  // error handling code
			$("#tablaRespuesta").css("display","none");
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		   }
  	},

  	"columnDefs":[{
  		"searchable": true,
  		"orderable": true,
  		"targets": 0
  	}],

  	"order":[[0, "desc"]],

  	columns: [
	  	{
	    	data: 'id_respuesta',
	    	name: 'id_respuesta'
        },
        {
			data: 'asunto_respuesta',
			name: 'asunto_respuesta'
		  },
	  	{
	  		data: 'detalle_respuesta',
	    	name: 'detalle_respuesta'
		  },
		  {
			data: 'fecha_respuesta',
			name: 'fecha_respuesta'
		  },
        {
			data: 'documento_id',
			name: 'documento_id'
		  },
		  {
			data: 'involucrados_respuesta',
			name: 'involucrados_respuesta'
		  },
        {
			data: 'usuario_id',
			name: 'usuario_id'
		  },
		  {
			data: 'observaciones_respuesta',
			name: 'observaciones_respuesta'
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

tablaRespuesta.on('order.dt search.dt', function(){

	tablaRespuesta.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i){ cell.innerHTML = i+1})


}).draw();