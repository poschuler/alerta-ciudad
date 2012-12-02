<?php

require("validar_sesion.php");

?>

<!DOCTYPE html>

<html>
<head runat="server">
    	<title>My GeoSocial</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/site.css" />

    <script type="text/javascript">
        $(document).ready(function () {
            $(".imgAcciones").mouseenter(function () {
                $(this).css("box-shadow", "3px 3px 5px 6px #ccc");
            });
            $(".imgAcciones").mouseleave(function () {
                $(this).css("box-shadow", "none");
            });
        });
	</script>
</head>
<body> 

<div data-role="page" data-theme="b" id="page1" style="background: url('http://m.opentable.com/content/images/springboard-bg-sm.png') repeat">
	<div data-role="header" data-theme="b">
		<h1>GeoSocial</h1>
		<a href="index.php" data-role="button" data-icon="delete" data-inline="true" data-theme="b">Salir</a>
	</div><!-- /header -->

	<div data-role="content">	
				
				<div id="logo"><img alt="" src="images/logo.png" border="0" class="homeLogo"></div>
				<div style="display:block;height:20px"></div>
				
				<div class="ui-grid-a">
					<div class="ui-block-a tileDiv tileBorderRight" >			
						<img alt="" src="images/myGeoSocial.png" alt="myGeoSocial" class="imgAcciones"/>
						<div id="lblMyGeoSocial" class="acciones">MyGeoSocial</div>

					</div>
					<div class="ui-block-b tileDiv">
						<img alt="" src="images/Entorno.png" alt="myGeoSocial" class="imgAcciones"/>
						<div id="lblEntorno" class="acciones">Entorno</div>
					</div>
				</div>
				<div style="ui-grid-a; height:50px;width;100%">
					
				</div>
				<div class="ui-grid-a">
					<div class="ui-block-a tileDiv tileBorderRight tileBorderTop">
						<a href="#"><img alt="" id="localizacion" src="images/localizacion.png" alt="myGeoSocial" class="imgAcciones" /></a>
						<div id="lblLocalizacion" class="acciones">Localizacion</div>
					</div>
					<div class="ui-block-b tileDiv tileBorderTop">
						<a href="amigos.aspx"><img alt="" src="images/buscarAmigos.png" alt="myGeoSocial" class="imgAcciones"/></a>
						<div id="lblBuscarAmigos" class="acciones">Buscar Amigos</div>
					</div>
				</div>

	</div><!-- /content -->

	<div data-role="footer" data-theme="b" data-position="fixed">
		<h4>YS</h4>
	</div><!-- /footer -->
</div>
</div><!-- /page -->

</body>
</html>


