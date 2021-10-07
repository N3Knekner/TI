<!DOCTYPE html>
<html>
<head>
	<title>teste usuario</title>
	<link rel="stylesheet" type="text/css" href="css/css.css">
</head>
<body>
		

			<menu id="Tag_Menu" style="display: block;">
				<form method="POST">
					<input type="submit" name="Contacts" value="Meus Contatos"><input type="button" value="Adicionar Contato" onclick="Add_Contact()" id="Add_Button">
					<input type="text" name="Search_Bar" id="Search_Bar" placeholder="Buscar"><input type="submit" name="Search" value="Buscar"><input type="button" onclick="Filter_Hover()" id="Filter_Hover_Css" value="▼">

					<div id="filter" style="display: none;">
						Mês<input type="checkbox" name="Filter_Mounth" value="mounth">
						Nome <select name="Name_Select" value="NotSelected">
							    <option selected="selected" value="NotSelected"></option>
								<option value="name">Primeiro Nome</option>
								<option value="lastname">Sobrenome</option>
								<option value="complete">Nome Completo</option>
							</select>
						mail <select name="Email_Select" value="NotSelected">
								<option selected="selected" value="NotSelected"></option>
								<option value="domain">Dominio</option>
								<option value="complete">Email Completo</option>
							</select>
					</div>
	

				</form>

				<form method="POST" id="Data_Form" style="display:none;">
					<br><br>
					Nome <input type="text" name="Add_Nome" id="Add_Nome"><br>
					Fone <input type="number" name="Add_Fone" id="Add_Fone"><br>
					Data.Nasc <input type="date" name="Add_DataNasc" id="Add_DataNasc"><br>
					Email <input type="Email" name="Add_Email" id="Add_Email"><br>
					<input type="submit" value="Adicionar" name="Add_Save" id="Add_Save">
					<input type="submit" value="Salvar Edicao" name="Edit_Save" id="Edit_Save">
				</form>
			</menu>

			<script>

				var Adding = true;
				var Hovered = false;

				function Add_Contact(){
					if (Adding) {
						document.getElementById('Add_Button').style.display = "none";
						document.getElementById('Data_Form').style.display = "block";
						document.getElementById('Edit_Save').style.display = 'none';
 						document.getElementById('Add_Save').style.display = 'block';
						Adding = false;
					}
					else {
						document.getElementById('Add_Button').style.display = "block";
						document.getElementById('Data_Form').style.display = "none";
						Adding = true;
					}
				}

				function Filter_Hover(){
					x=document.getElementById('filter');
					if (x.style.display == 'block')x.style.display = 'none';
					else x.style.display = 'block';
				}

				function Option_Hover(){
					window.captureEvents(Event.MOUSEMOVE);
					window.onmousemove = function (){	
											if (!Hovered){
												document.getElementById('Options').style.display = "block";
												document.getElementById('Options').style.Botton = event.clientY;
												document.getElementById('Options').style.Left = event.clientX;
												Hovered = true;
											}
											else{
												document.getElementById('Options').style.display = "none";
												Hovered = false;
											}
										}
				}

			</script>
<form method="POST">
<report id="Tag_Report_BD">

<?php
session_start();
$User = $_SESSION['User'];

BD_Report($User);

	if(isset($_POST['Edit_Button'])){
		$_POST['Edit_Button'] = null;
		BD_Edit($User,"fill");
	}
	if(isset($_POST['Edit_Save'])){
		$_POST['Edit_Save'] = null;
		BD_Edit($User,"save");
	}

	if(isset($_POST['Add_Save'])){
		$_POST['Add_Save'] = null;
		BD_ADD($User);
	}

	if(isset($_POST['Search_Bar'])){
		if($_POST['Name_Select'] != "NotSelected") BD_Name_Search($_POST['Search_Bar'],$_POST['Name_Select'],$User);
		if($_POST['Filter_Mounth'] == "mounth") BD_Calendar_Search($_POST['Search_Bar'],$User);
		if($_POST['Email_Select'] != "NotSelected") BD_Email_Search($_POST['Search_Bar'],$_POST['Email_Select'],$User);
	}

	if(isset($_POST['Contacts'])){
		$_POST['Contacts'] = null;
		BD_Report($User);
	}

 	if(isset($_POST['Delete_Button'])){
 		$_POST['Delete_Button'] = null;
 		Delete_BD($User);
 	}

 	if(isset($_POST['Favorite_Button'])){
		$_POST['Favorite_Button'] = null;
		BD_Favorite($User);
	}

  //if(!$reload && $Edit)Data_Verify($User);


	function BD_Report($User){
		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
		echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Contatos:<br>';</script>";
		foreach ($BD as $key => $value) {
			echo "<br>",$key+1,")  ";
			for($c = 0; $c < count($BD[$key]); $c++){
				echo $BD[$key][$c]," | ";
			}
		}	
	}

 	function BD_ADD($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$verify = false;
		$Nome = $_POST['Add_Nome'];
		foreach ($BD as $key => $value) {
			if($BD[$key][0] == $Nome){
				echo "<script>alert('Esta pessoa ja existe em sua agenda');Add_Contact()</script>";
				$verify = true;
				break;
			}
		}
		if (!$verify) {
 			$case = count($BD);
 			$BD[$case][0] = $Nome;
			$BD[$case][1] = $_POST['Add_Fone'];
 			$BD[$case][2] = $_POST['Add_DataNasc'];
 			$BD[$case][3] = $_POST['Add_Email'];
 			$BD[$case][4] = "<input type='checkbox' name='key' value='".$case."' id='delete' onclick='Option_Hover()'>";
 			$BD[$case][5] = "";
			fclose(fwrite(fopen("../../Users/".$User.".json", "w"),json_encode($BD))); 
			BD_Report($User);
		}
 	}

 	function Delete_BD($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$BD_AUX=[];
 		$count = count($BD);
 		$case = $_POST['key'];
 		for ($i=$case; $i < $count; $i++) { 
 			$BD[$i] = $BD[$i+1];
 			$BD[$i][4] = "<input type='checkbox' name='key' value='".$i."' id='delete'>";
 		}

 		for ($i=0; $i < $count-1; $i++) { 
 			$BD_AUX[$i] = $BD[$i];
 		}

 		fclose(fwrite(fopen("../../Users/".$User.".json", "w"),json_encode($BD_AUX))); 
		BD_Report($User);
 	}

 	function Data_Verify($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Aniversariantes:<br>';</script>";
 		$Names = "";
 		$QTD = 0;
 		foreach ($BD as $key => $value) {
 			if(strstr("".$BD[$key][2],date("m"))){
 				if(strstr("".$BD[$key][2],date("d"))){
 					$QTD++;
 					if ($QTD > 1)$Names = $Names." e ";
 					$Names = $Names." ".$BD[$key][0];
 				}
 			}
 		}
 		echo "<script>alert('".$Names." está de aniversario hoje ! ')</script>";
 	}

	function BD_Name_Search($Search,$type,$User){
		$QTD = strlen($Search);
 		$Return = "";
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		if ($type == "complete") {
 			echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Sua Pesquisa de Nome:<br>';</script>";
 			foreach ($BD as $key => $value) {
 				if(strstr($BD[$key][0],$Search)){
 					$Quest = str_split($BD[$key][0]);
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD+$i); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<mark>".$aux."</mark>";
 							$i += $QTD-1;
 						}
 						else $Return = $Return.$Quest[$i];
 					}
 					$Return = $Return." | ".$BD[$key][1]." | ".$BD[$key][2]." | ".$BD[$key][3]." | ".$BD[$key][4]."<br>";
 				}
 			}
 			echo $Return;
 		}

 		else if ($type == "name") {
 			echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Sua Pesquisa de Primeiro Nome:<br>';</script>";
 			foreach ($BD as $key => $value) {
 				if (strpos($BD[$key][0]," "))$Aux_BD_Name = substr($BD[$key][0],0,strpos($BD[$key][0]," "));
 				else $Aux_BD_Name = $BD[$key][0];
 				if(strstr($Aux_BD_Name,$Search)){
 					$Quest = str_split($Aux_BD_Name);
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD+$i); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<mark>".$aux."</mark>";
 							$i += $QTD-1;
 						}
 						else $Return = $Return.$Quest[$i];
 					}
 					$Return = $Return.substr($BD[$key][0],strpos($BD[$key][0]," "),strlen($BD[$key][0]))." | ".$BD[$key][1]." | ".$BD[$key][2]." | ".$BD[$key][3]." | ".$BD[$key][4].$BD[$key][5]."<br>"; 
 				}
 			}
 			echo $Return;
 		}
 		else {
 			echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Sua Pesquisa de Sobrenomeome:<br>';</script>";
 			foreach ($BD as $key => $value) {
 				if (strpos($BD[$key][0]," "))$Aux_BD_Name = substr($BD[$key][0],strpos($BD[$key][0]," "),strlen($BD[$key][0]));
 				if(strstr($Aux_BD_Name,$Search)){
 					$Return = $Return.substr($BD[$key][0],0,strpos($BD[$key][0]," "));
 					$Quest = str_split($Aux_BD_Name);
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD+$i); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<mark>".$aux."</mark>";
 							$i += $QTD-1;
 						}
 						else $Return = $Return.$Quest[$i];
 					}
 					$Return = $Return." | ".$BD[$key][1]." | ".$BD[$key][2]." | ".$BD[$key][3]." | ".$BD[$key][4].$BD[$key][5]."<br>"; 
 				}
 			}
 			echo $Return;
	 	}
 	}

 	function BD_Calendar_Search($Mounth,$User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Sua pesquisa de Aniversariantes do Mês:<br>';</script>";
 		foreach ($BD as $key => $value) {
 			if(strstr(substr($BD[$key][2], -5, -3),"".$Mounth)){
 				echo $BD[$key][2]." | ".$BD[$key][0]." | ".$BD[$key][1]." | ".$BD[$key][2]." | ".$BD[$key][3].$BD[$key][4]." | "." | ".$BD[$key][5]."<br>";
 			}
 		}
 	}

 	function BD_Email_Search($Search,$type,$User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		echo "<script>document.getElementById('Tag_Report_BD').innerHTML = 'Sua pesquisa de Email:<br>';</script>";
 		$QTD = strlen($Search);
 		$Return = "";

 		if($type == "domain"){ 
 			foreach ($BD as $key => $value) {
 				if(strstr(strstr($BD[$key][3], '@'),$Search)){
 					$Quest = str_split(strstr($BD[$key][3], '@'));
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD+$i); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<mark>".$aux."</mark>";
 							$i += $QTD-1;
 						}
 						else $Return = $Return.$Quest[$i];
 					}
 					$Return = substr($BD[$key][3],0,strpos($BD[$key][3],"@")).$Return." | ".$BD[$key][0]." | ".$BD[$key][1]." | ".$BD[$key][2]." | ".$BD[$key][4].$BD[$key][5]."<br>"; 
 				}
 			}
 			echo $Return;
 		}

 		else{
 			foreach ($BD as $key => $value) {
 				if(strstr($BD[$key][3],$Search)){
 					$Quest = str_split($BD[$key][3]);
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD+$i); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<mark>".$aux."</mark>";
 							$i += $QTD-1;
 						}
 						else $Return = $Return.$Quest[$i];
 					}
 					$Return = $Return." | ".$BD[$key][0]." | ".$BD[$key][1]." | ".$BD[$key][2]." | ".$BD[$key][4].$BD[$key][5]."<br>"; 				
 				}
 			}
 			echo $Return;
 		}
 	}

 	function BD_Edit($User,$Parameter){
 		$case = 4; //-----------------------------------------------------------------------------------a case deve ser enviada pelo ajax
 		$Nome = $_POST['Add_Nome'];
 		$verify = false;
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		if ($Parameter == "fill"){
 			echo "<script>document.getElementById('Edit_Save').style.display = 'block';
 			document.getElementById('Add_Save').style.display = 'none';
 			document.getElementById('Data_Form').style.display = 'block';
 			document.getElementById('Add_Nome').value = '".$BD[$case][0]."';
			document.getElementById('Add_Fone').value = '".$BD[$case][1]."';
			document.getElementById('Add_DataNasc').value = '".$BD[$case][2]."';
			document.getElementById('Add_Email').value = '".$BD[$case][3]."'</script><br>";
 		}

 		else{//$Parameter == "save"
 		echo "<br>case2:".$case;
 		echo "<br>Nome1:".$BD[$case][0];
 		echo "<br>Nome2:".$Nome;
 		echo "<script>document.getElementById('Data_Form').style.display = 'none';</script>";//arrumar que ele
			if ($Nome != $BD[$case][0]) {
				foreach ($BD as $key => $value) {
					if($BD[$key][0] === $Nome){
						$verify = true;
						BD_Edit($User,"fill");
						break;
					}
				}
			}
			if (!$verify) {
				$BD[$case][0] = $Nome;
 				$BD[$case][1] = $_POST['Add_Fone'];
 				$BD[$case][2] = $_POST['Add_DataNasc'];
 				$BD[$case][3] = $_POST['Add_Email'];
 				echo "<br>Nome3:".$BD[$case][0];
				fclose(fwrite(fopen("../../Users/".$User.".json", "w"),json_encode($BD)));
				BD_Report($User);
			}
 		}
 	}

 	function BD_Favorite($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$case = $_POST['key'];
 		if (!$BD[$case][5]) {
 			$BD[$case][5] = "★";
			echo "<script>alert('".$BD[$case][0]." foi adicionado aos Favoritos!')</script>";
		}

		else{
 			$BD[$case][5] = "";
			echo "<script>alert('".$BD[$case][0]." foi removido dos Favoritos!')</script>";
		}

		fclose(fwrite(fopen("../../Users/".$User.".json", "w"),json_encode($BD)));
		BD_Report($User);
	}


?>

</report>
	<br><br>
	<optons id="Options" style="display: none;">
		<input type='submit' value='Excluir' name='Delete_Button'> <input type='submit' value='Editar' name='Edit_Button'> <input type='submit' value='Favoritos' name='Favorite_Button'>
	</optons>
</form>

</body>
</html>