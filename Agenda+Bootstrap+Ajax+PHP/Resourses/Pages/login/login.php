<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Debok</title>
	<link rel="stylesheet" type="text/css" href="css/css.css">
</head>
<body onload="Menu();verify_login()">
	<center>
		<img id="Logo" src="../ImgShared/logo.png"><h1 id="h1" style="display:none;">Cadastro</h1>
		<login id="login">
			<form method="POST">
				<div><p class="formLabel">Usuário</p><input type="text" id="User" name="User" autocomplete="off" onkeyup="verify_login()"></div><br>
				<div><p class="formLabel">Senha</p> <input type="password" id="Password" name="Password" autocomplete="off"></div><br>
				<div id="checkbox"><c id="label_checkbox">Modo Lite</c><input type="checkbox" name="" id="Mode"></div>
				<input type="submit" id="Login_Button" name="LOGIN" value="LOGIN">
			</form>
			<div id="label_Sign">Não possui uma conta?<br>Crie uma Gratuitamente!<div></div>
			<input type="button" id="Sign_Button" value="SIGN IN" onclick="SIGN()"></div>
		</login>
		<sign id="sign" style="display:none;">
			<form method="POST">
				<div><p class="formLabel">Nome</p><input type="text" id="User_Sign" name="User" autocomplete="off"></div><br>
				<div><p class="formLabel">Email</p><input type="email" id="Email" name="Email" autocomplete="off"></div><br>
				<div><p class="formLabel">Data de Nascimento</p><br><input type="date" id="Data_Nasc" name="Data_Nasc"></div><br>
				<div><p class="formLabel">Senha</p><input type="password" class="Password_Sign" name="Password" autocomplete="off"></div><br>
				<div><p class="formLabel">Confirme a Senha</p> <input type="password" class="Password_Sign" onkeyup ="Password_Confirm()" name="Password_confirm" autocomplete="off"></div>
				<asd id="terms_div"><input type="checkbox" id="terms_checkbox"><t id="Terms">Eu li e concordo com os termos de uso e a política de privacidade</t></asd>
				<input type="submit" id="sign_confirm" name="SIGN" value="OK">
			</form>
	</center>
	<hr id="hr">
	<p id="copyright">COPYRIGHT <sup>©</sup><br></p> <a id="evandro" href="https://www.facebook.com/profile.php?id=100011410677894">Evandro Socrepa</a> <a id="andre" href="https://www.facebook.com/andreluis.felberrenken">André Luís Felber Renken</a>
		
	</sign>
	<script>
		function verify_login(){
			if (document.getElementById('User').value == "") {
				document.getElementById('Login_Button').setAttribute("disabled","disabled");
				document.getElementById('Login_Button').style.boxShadow= "none"
			}else{
				console.log("asd");
				document.getElementById('Login_Button').removeAttribute("disabled");
				document.getElementById('Login_Button').style.boxShadow= " 0px 5px 10px black"
			}

		}
		function SIGN(){
			document.getElementById('login').style.display = "none";
			document.getElementById('copyright').style.display = "none";
			document.getElementById('hr').style.display = "none";
			document.getElementById('evandro').style.display = "none";
			document.getElementById('andre').style.display = "none";
			document.getElementById('h1').style.display = "block";
			document.getElementById('sign').style.display = "block";
		}

		function Menu(){
			if(location.search != ""){
			document.getElementById('login').style.display = "none";
			document.getElementById('Tag_Menu').style.display = "block";
			}
		}

		function Add_Contact(){
			var Adding = true;
			if (Adding) {
				document.getElementById('Add_Button').style.display = "none";
				document.getElementById('Add_Form').style.display = "block";
				Adding = false
			}
			else {
				document.getElementById('Add_Button').style.display = "block";
				document.getElementById('Add_Form').style.display = "none";
				Adding = true;
			}
		}

		function Password_Confirm(){
			x=document.getElementsByClassName('Password_Sign');
			if (x[0].value != x[1].value) {
				x[1].style.border = "3px solid red";
				x[1].style.boxShadow = "10px red";
			}
			else{
				x[1].style.border = "3px solid rgb(30,30,40)";
				x[1].style.boxShadow = "none";
			}
		}

	</script>
	<report id="Tag_Report_BD">
		<?php

		if (isset($_SESSION['User'])) {
			echo "<script> window.location='../schedule_page/schedule_page.html';</script>";
		}else{
			$User_Keys = json_decode(file_get_contents('../../User_Keys.json'));
			$Password = "";
			$User = "";
			
			if(isset($_POST['SIGN'])){
				$verify = null;
				$_POST['SIGN'] = 0;
				$User = $_POST['User'];
				foreach ($User_Keys as $key => $value) {
					if($User_Keys[$key][0]==$User){
						echo "<script>alert('Nome de usuario já existente');SIGN()</script>";
						$verify = true;
						break;
					}
				}
				if (!$verify) {
					$Password = $_POST['Password'];
					SIGN($User_Keys,$User,$Password);
				}
			}
				
			if(isset($_POST['LOGIN'])){
				$verify = true;
				$_POST['LOGIN'] = null;
				$User = $_POST['User'];
				$Password = $_POST['Password'];
				foreach ($User_Keys as $key => $value) {
					if($User_Keys[$key][0]==$User && $User_Keys[$key][1]==$Password){
						$verify = false;
						$User_Keys = null;
						$_SESSION['User'] = $User;
						echo "<script> window.location='../schedule_page/schedule_page.html';</script>";
						break;
					}
				}
				if ($verify) {
					echo "<script>alert('Usuario/Senha Incorretos')</script>";
				}
			}
		}
			function SIGN($User_Keys,$User,$Password){ 
					$case = count($User_Keys);
					$Data_Nasc = $_POST['Data_Nasc'];
					$Email = $_POST['Email'];
					$User_Keys[$case][0] = $User;
					$User_Keys[$case][1] = $Password;
					$User_Keys[$case][2] = $Data_Nasc;
					$User_Keys[$case][3] = $Email;
					fclose(fwrite(fopen("../../User_Keys.json", "w"),json_encode($User_Keys))); 
					fclose(fwrite(fopen("../../Users/".$User.".json", "w"),'[["'.$User.'","12345678","'.$Data_Nasc.'","'.$Email.'","0",""]]'));
					$_SESSION['User'] = $User;
					echo "<script> window.location='../schedule_page/schedule_page.html'; </script>";
			}
		?>

	</report>

</body>
</html>