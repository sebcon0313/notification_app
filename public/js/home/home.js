$(document).ready(function () {
    $("#documentosTable").DataTable({
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
                "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            oAria: {
                sSortAscending:
                    ": Activar para ordenar la columna de manera ascendente",
                sSortDescending:
                    ": Activar para ordenar la columna de manera descendente",
            },
        },
        columnDefs: [
            { 
                "targets": [ 4 ], // Índice de la columna que deseas ocultar
                "visible": false, // Ocultar la columna
                "searchable": true // Asegurar que siga siendo buscable
            }
        ]
    });
});

// Selecionamos el elemento div que abre el modal
const openModal = document.getElementById('open-modal');

// Agregamos un evento click al elemento div
openModal.addEventListener('click', () => {
    // Selecionamos el elemento del modal
    const myModal = document.getElementById('myModal');

    // Creamos una instancia del modal
    const modal = new bootstrap.Modal(myModal, {
        // Opciones del modal
        backdrop: true,
        keyboard: true
    });

    // Mostramos el modal
    modal.show();
});

(function () {
    'use strict';
    window.addEventListener('load', function () {
        let forms = document.getElementsByClassName('needs-validation');
        let validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

document.getElementById("tipo_id").addEventListener("change", function () {
    let select = this.value;
    let divNuevoProyecto = document.getElementById("div-doc");

    if (select === "nuevo") {
        divNuevoProyecto.classList.remove("ocultar");
        document.getElementById("nombre_doc").setAttribute("required", true);
    } else {
        divNuevoProyecto.classList.add("ocultar");
        document.getElementById("nombre_doc").removeAttribute("required");
    }
});

document.getElementById("proyecto_id").addEventListener("change", function () {
    let select = this.value;
    let divNuevoProyecto = document.getElementById("div-proyecto");

    if (select === "nuevo") {
        divNuevoProyecto.classList.remove("ocultar");
        document.getElementById("nombre_proyecto").setAttribute("required", true);
    } else {
        divNuevoProyecto.classList.add("ocultar");
        document.getElementById("nombre_proyecto").removeAttribute("required");
    }
});


function deleteDoc(e, id) {
    e.preventDefault();
    Swal.fire({
        title: "¿Eliminar el documento?",
        text: "Una vez eliminado no se pueden revertir lo cambios",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          /* Swal.fire({
            title: "Eliminado",
            text: "El documento se elimino correctamente",
            icon: "success"
          }); */

          window.location.href = '/destroyDocumento?id='+id;
        }
      });
}


$(document).ready(function () {
    $('#pdfModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var pdfUrl = button.data('url'); // Extraer la URL del atributo data-url

        var modal = $(this);
        modal.find('#pdfViewer').attr('src', pdfUrl); // Asignar el src del iframe
    });

    // Limpiar el src del iframe al cerrar el modal para optimizar memoria
    $('#pdfModal').on('hidden.bs.modal', function () {
        $(this).find('#pdfViewer').attr('src', '');
    });
});
