<?php
  $x = "";
  if(isset($_POST['btnSubmit']) )
  {
		if ($_POST['txtUserName'] != "" and $_POST['txtContrasenia'] != "")
		{
			require("conexion.php");
			$query = mysql_query("SELECT username,password,id,surname,firstname,name FROM user WHERE username = '{$_POST['txtUserName']}' LIMIT 1");
			$info = mysql_fetch_assoc($query);
			
			if ($info)
			{			
				if(md5($_POST['txtContrasenia']) == $info['password'])
				{
				  // esta logueado
				  session_start();
				  $_SESSION['logueado'] = true;
				  $_SESSION['uid'] = $info['id'];
				  $_SESSION['uname'] = $info['surname'].' '.$info['firstname'].', '.$info['name'];
				  header("Location: index_other.php");
				}else{
				  $x =  "El usuario o contrase&ntilde;a son incorrectos";
				}
			}
			else
			{
				$query = mysql_query("SELECT username,password,id,name FROM authority WHERE username = '{$_POST['txtUserName']}' LIMIT 1");
				$info = mysql_fetch_assoc($query);
				
				if(md5($_POST['txtContrasenia']) == $info['password'])
				{
				  // esta logueado
				  session_start();
				  $_SESSION['logueado'] = true;
				  $_SESSION['uid'] = $info['id'];
				  $_SESSION['uname'] = $info['name'];
				  header("Location: index_authority.php");
				}else
				{
				  $x =  "El usuario o contrase&ntilde;a son incorrectos";
				}
			}
	    }
		else
		{
		 $x = "Ingrese Usuario y Pass";
		}
		
  }
?>

<!DOCTYPE html> 

<html>
<head runat="server">
    	<title>Alerta Ciudad</title> 
	
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/site.css" />
</head>

<body> 

<div data-role="page" data-theme="b" id="page1" style="background: url('http://m.opentable.com/content/images/springboard-bg-sm.png') repeat">
	<div data-role="header" data-theme="b">
		<h1>Alerta Ciudad</h1>
	</div><!-- /header -->

	<div data-role="content">	
				
				<div id="logo"><img alt="" src="images/logo.png" border="0" class="homeLogo"/></div>
				<div style="display:block;height:20px;align: center;"></div>
				<form id="loginForm"  data-ajax="false" method="post">
					<label for="username">Usuario:</label>
					<input type="text" name="txtUserName" placeholder="Usuario"/>
					
					</br>
					
					<label for="username">Contrasenia:</label>
					<input type="password" name="txtContrasenia" placeholder="Contrasenia"/>
					</br>
					</br>
					</br>
					
					<fieldset class="ui-grid-a">
						<div class="ui-block-a"><button type="submit" name="btnSubmit" data-theme="b" data-mini="true">Ingresar</button></div>
						<div class="ui-block-b"><a href="registrar.php" type="button" name="btnNuevoUsuario" data-theme="c" data-mini="true">Nuevo Usuario</a></div>	   
					</fieldset>	
				</form>
				
				<div align="center" style="margin-top: 1%;">
					<label name="lblError" style="text-align:center; color: red; "><?php echo(($x!="") ? $x : ""); ?></label>
				</div>
				
				

	</div><!-- /content -->

	<div data-role="footer" data-theme="b" data-position="fixed">
		<h1>YS</h1>
	</div><!-- /footer -->
</div>
</div><!-- /page -->

</body>
</html>