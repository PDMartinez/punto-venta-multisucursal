

$(document).on("click", "#botonFlotante", function() {

    $('#cabecera').removeClass("col-xs-12 d-none d-lg-block d-xl-none d-none d-xl-block");

    var divProductos = document.getElementById("divProductos");

    var divClientes = document.getElementById("divcabecera");

    //console.log(divProductos);

    if (divProductos.style.display === "none") {

        divProductos.style.display = "block";
        divClientes.style.display = "none";

    } else {

        divProductos.style.display = "none";
        divClientes.style.display = "block";

    }

  });