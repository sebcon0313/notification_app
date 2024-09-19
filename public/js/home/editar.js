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
