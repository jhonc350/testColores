<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>.: PRUEBA TÉCNICA :.</title>
<!-- Favicon-->
<link rel="icon" type="image/x-icon" href="./logos/favicon.ico" />
<!-- Core theme CSS (includes Bootstrap)-->
<link href="css/datos.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> 

<!-- SweetAlert--> 
<script src="scripts/sweetalert.min.js"></script> 

<!-- Loading Overlay--> 
<script src="scripts/loadingoverlay.min.js"></script>
</head>

<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-black">
<div class="container">
<a class="navbar-brand" href="#!">PRUEBA TÉCNICA</a>
</nav>
<header class="py-5 bg-image-full" style="background-image: url('logos/logo_header.jpg')"> </header>
<br>
<div class="card" style="width:700px;">
    <div class="card-body">
        <h5 class="card-title"><B>PRUEBA TÉCNICA FINCA RAIZ</B></h5>
        <br>
        <div class="letter">
            <spam> Por favor ingrese la información de los Colores...</spam>
            <br>
        </div>
        <br>
        <div class="panel-body">
            <form class="form-validate form-horizontal" name="colorForm" id="colorForm" role="form" method="post">
                <br>
                <div class="row">
                    <label for="color1" class="col-sm-3 col-form-label">Color 1</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control colorInput" id="color1" name="color1" placeholder="#000000" onKeyUp="this.value=this.value.toUpperCase()" maxlength="7" autofocus>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <label for="color2" class="col-sm-3 col-form-label">Color 2</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control colorInput" id="color2" name="color2" placeholder="#000000" onKeyUp="this.value=this.value.toUpperCase()" maxlength="7">
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div lass="col-lg-8">
                        <div id="mensajeError" class="alert alert-danger" role="alert"> </div>
                    </div>
                </div>
                <br />
                <button type="button" name="btCurso" id="btCurso" class="btn btn-primary" onclick="Guardar()">Calcular Combinación</button>
                <br />
            </form>
        </div>
    </div>
</div>

<!-- Footer-->
<footer class="py-4 bg-black">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-left">
                <p class="m-0 text-left text-white" style="font-size:32px"><b>Contáctenos</b></p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 text-left">
                <p class="m-0 text-left text-white" style="font-size:16px">Jhonc350@hotmail.com</p>
                <a href="https://wa.me/+573042110868" target="_blank"><i class="fab fa-whatsapp whatsapp-icon"></i> 310 3211949</a>
                <p class="m-0 text-left text-white" style="font-size:16px">Celular 310 3211949</p>
            </div>
            <div class="col-md-4 text-left">
                <p class="m-0 text-center text-white" style="color:#FFF"></p>
            </div>
            <div class="col-md-4 text-left">
                <p class="m-12 text-center text-white"><b></b></p>
            </div>
        </div>
        <br>
    </div>
</footer>
<!-- Bootstrap core JS--> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> 
</script>
</body>
</html>
<script>
$(document).ready(function() {
    $("#mensajeError").hide();

    // Función para actualizar el color del input
        function updateColorInput(input) {
            var color = $(input).val();
            $(input).css("background-color", color);
        }

        // Evento para detectar cambios en los inputs
        $(".colorInput").on("input", function () {
            updateColorInput(this);
        });
    // Método de validación para verificar que los input tengan el formato hexadecimal
    $.validator.addMethod("hexColor", function (value, element) {
            return /^#[0-9A-Fa-f]{6}$/i.test(value);
        }, "Por favor, introduce un color hexadecimal válido (ej. #RRGGBB)");
    
	$("#colorForm").validate({
            rules: {
                color1: {
                    required: true,
                    hexColor: true
                },
                color2: {
                    required: true,
                    hexColor: true
                }
            },
            messages: {
                color1: {
                    required: "Por favor, introduce el Color 1 hexadecimal.",
                    hexColor: "Por favor, introduce el Color 1 hexadecimal válido (ej. #RRGGBB)"
                },
                color2: {
                    required: "Por favor, introduce el Color 2 hexadecimal.",
                    hexColor: "Por favor, introduce el Color 2 hexadecimal válido (ej. #RRGGBB)"
                }
            },
			errorElement: "div",
        	errorLabelContainer: ".alert-danger"
        });
});
	

function Guardar() {

    if (!$('#colorForm').valid())
    {
        return;
    }		
    var Colores = {
                    color1: $("#color1").val(),
                    color2: $("#color2").val()
                }

    $.ajax({
            type:'POST',
            url: './CapaNegocio/CN_Color.php',
            data: Colores,
            dataType: 'json',
            async: true,
            beforeSend: function() {
                        $(".card-body").LoadingOverlay("show", {
                                background      : "rgba(0, 0, 0, 0.4)",
                                image           : "./img/listar.svg",
                                imageAnimation  : "1.5s fadein",
                                imageColor      : "#ffffff",
                                textColor       : "#ffffff",
                                text			: "Reportando...",
                                imageResizeFactor: 6,
                                size: 14
                            });
                    },
        })
        .done(function ajaxDone(res){
           if(res.resultado == 1)
               {
                   //swal("Buen Trabajo!", res.mensaje, "success");
                   swal({
                      title: "Buen Trabajo!",
                      content: {
                        element: "div",
                        attributes: {
                          innerHTML: res.mensaje
                        },
                      },
                      icon: "success"
                    });
                   //limpiamos los campos
                   /*$("#color1").val("");
                   $("#color2").val("");*/
                   return false;
               }
               else
               {
                   swal("Revise los datos ingresados", res.mensaje, "warning")
                   $("#mensajeError").text("Problemas para calcular la combinación" + res.resultado).show();
               }
        })
        .fail(function ajaxError(e){
            console.log(e);
        })
        .always(function ajaxSiempre(){
            $(".card-body").LoadingOverlay("hide")
            console.log('Final de la llamada ajax.');
        })
        return false;
}
</script>