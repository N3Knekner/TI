<?php
session_start();
$User = isset($_SESSION['User'])?$_SESSION['User']:"indefinido";

error_reporting(0);

	if(isset($_POST['Request_User'])){
		$_POST['Request_User'] = null;
		if (isset($_SESSION['User'])) {echo $User;}else{echo "false";}
	}
	if (isset($_POST['logoff'])) {
		$_POST['logoff'] = null;
		unset($_SESSION['User']);
		echo "sucefull";
	}

	if(isset($_POST['Edit_Button'])){
		$_POST['Edit_Button'] = null;
		BD_Edit($User);
	}
	if(isset($_POST['Edit_Save'])){
		$_POST['Edit_Save'] = null;
		BD_Edit($User,"save");
	}
	

	if(isset($_POST['birthday'])){
		$_POST['birthday'] = null;
		Data_Verify($User);
	}

	if(isset($_POST['Add_Save'])){
		$_POST['Add_Save'] = null;
		BD_ADD($User);
	}

	if(isset($_POST['totalValue'])){
		$_POST['totalValue'] = null;
		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
		echo count($BD);
	}

	if(isset($_POST['Search'])){
		if($_POST['Class_Filter']=="2") BD_Name_Search($_POST['Search'],$_POST['Type_Filter'],$User);
		if($_POST['Class_Filter']=="1") BD_Calendar_Search($_POST['Search'],$User);
		if($_POST['Class_Filter']=="3") BD_Email_Search($_POST['Search'],$_POST['Type_Filter'],$User);
	}

	if(isset($_POST['Contacts'])){
		$_POST['Contacts'] = null;
		if (isset($_POST['Stage'])) {
			BD_Report($User,$_POST['Stage'],$_POST['Vision']);
		}else{
			BD_Report($User,0,0);
		}
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


	function BD_Report($User, $Stage, $Vision){
		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
		$responseText = [];
		$multiply = $Vision == 1 ? 20 : 15;

		if ($Stage != 0) { // Sistema de otimazacao para big data
			for($i = $Stage * $multiply - $multiply;   $i < (($Stage * $multiply) >= count($BD)-1 ? count($BD) : ($Stage+1) * $multiply);   $i++){

				$responseText[$i]  = [];

				for($c = 0; $c < count($BD[$i]); $c++){
					$responseText[$i][$c] = $BD[$i][$c];
				}
			}
		}else{$responseText = $BD;}
		echo json_encode($responseText);	
	}

 	function BD_ADD($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$verify = false;
		$Nome = $_POST['Add_Nome'];
		foreach ($BD as $key => $value) {
			if($BD[$key][0] == $Nome){
				echo "Nome ja existente";
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
 			$BD[$case][4] = $case."";
 			$BD[$case][5] = "";
			$x = fopen("../../Users/".$User.".json", "w");
			fwrite($x,json_encode($BD));
			fclose($x);
			echo "Alteracoes concluidas";
		}
 	}

 	function Delete_BD($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$BD_AUX=[];
 		$count = count($BD);
 		$case = $_POST['case'];
 		for ($i=$case; $i < $count-1; $i++) { 
 			$BD[$i] = $BD[$i+1];
 			$BD[$i][4] = $i."";
 		}

 		for ($i=0; $i < $count-1; $i++) { 
 			$BD_AUX[$i] = $BD[$i];
 		}

 		$x = fopen("../../Users/".$User.".json", "w");
			fwrite($x,json_encode($BD_AUX));
			fclose($x);
		echo "Excluido com sucesso";
 	}

 	function Data_Verify($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$Names = "nothing";
 		$aux="";
 		$QTD = 0;
 		foreach ($BD as $key => $value) {
			if(explode("-", $BD[$key][2])[2] == date("d")){
				if(explode("-", $BD[$key][2])[1] == date("m")){
					$QTD++;
					if ($QTD > 1)$aux .= " e ";
					$aux .= " ".$BD[$key][0];
				}
 			}
 		}
 		if ($aux != "") {
 			$Names = $aux;
 		}
 		echo $Names;
 	}

	function BD_Name_Search($Search,$type,$User){
		$QTD = strlen($Search);
 		$Return = "";
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		if ($type == "Nome Completo") {
 			foreach ($BD as $key => $value) {
 				if(strstr($BD[$key][0],$Search)){
 					$Quest = str_split($BD[$key][0]);
 					$Return.="<div class='search_results' onclick=".'"moveToPage(this);"'.">"; 

 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD + $i); $c++) $aux = $aux.$Quest[$c];
 						try{
	 						if (strstr($aux,$Search)){
	 							$Return = $Return."<b>".$aux."</b>";
	 							$i += $QTD-1;
	 						}
	 						else $Return = $Return.$Quest[$i];
 						}catch(String $e){}
 					}
 					$Return .="<br><div> Tel.: ".$BD[$key][1]." | Data: <input type='date' style='border: 0px solid black; color: black; background: #f8f9fa;' disabled='disabled' value='".$BD[$key][2]."'></input> | Email: ".$BD[$key][3]." | Nº: <div id='search_case' class='search_case'>".$BD[$key][4]."</div></div></div><hr>";
 				}
 			}
 			echo $Return;
 		}

 		else if ($type == "Primeiro Nome") {
 			foreach ($BD as $key => $value) {
 				if (strpos($BD[$key][0]," "))$Aux_BD_Name = substr($BD[$key][0],0,strpos($BD[$key][0]," "));
 				else $Aux_BD_Name = $BD[$key][0];
 				if(strstr($Aux_BD_Name,$Search)){
 					$Quest = str_split($Aux_BD_Name);
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<b>".$aux."</b>";
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
 			foreach ($BD as $key => $value) {
 				if (strpos($BD[$key][0]," "))$Aux_BD_Name = substr($BD[$key][0],strpos($BD[$key][0]," "),strlen($BD[$key][0]));
 				if(strstr($Aux_BD_Name,$Search)){
 					$Return = $Return.substr($BD[$key][0],0,strpos($BD[$key][0]," "));
 					$Quest = str_split($Aux_BD_Name);
 					for ($i=0; $i < count($Quest); $i++){ 
 						$aux = "";
 						for ($c=$i; $c < ($QTD+1); $c++) $aux = $aux.$Quest[$c];
 						if (strstr($aux,$Search)){
 							$Return = $Return."<b>".$aux."</b>";
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

 	function BD_Edit($User){
 		$Nome = $_POST['Add_Nome'];
 		$case = $_POST["case"];
 		$verify = false;
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		
		if ($Nome != $BD[$case][0]) {
			foreach ($BD as $key => $value) {
				if($BD[$key][0] === $Nome){
					$verify = true;
					echo "Nome ja existente";
					break;
				}
			}
		}
		if (!$verify) {
			$BD[$case][0] = $Nome;
			$BD[$case][1] = $_POST['Add_Fone'];
			$BD[$case][2] = $_POST['Add_DataNasc'];
			$BD[$case][3] = $_POST['Add_Email'];

			$x = fopen("../../Users/".$User.".json", "w");
			fwrite($x,json_encode($BD));
			fclose($x);
			echo "Alteracoes concluidas";
		}
		
 	}

 	function BD_Favorite($User){
 		$BD = json_decode(file_get_contents("../../Users/".$User.".json"));
 		$case = $_POST['case'];
 		if (!$BD[$case][5]) {
 			$BD[$case][5] = "★";
 			echo "true";
		}

		else{
 			$BD[$case][5] = "";
 			echo "false";
		}

		$x = fopen("../../Users/".$User.".json", "w");
		fwrite($x,json_encode($BD));
		fclose($x);
		echo "Sucesso";
	}
?>