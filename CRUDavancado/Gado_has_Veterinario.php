<!DOCTYPE html>
	<html>
	<head>
		<title>Consultas</title>
		
	</head>
	<body style="font-family: Segoe UI">
		<button style="background-color: lightblue;" onclick="window.location.href = window.location.href.replace('Gado_has_Veterinario.php','')">Voltar</button>
		<form method="GET" id="form">

		<?php 
		error_reporting(0);
			$dateORvarchar = [];
			$col = [];
			try{
				$pdo = new PDO('mysql:host=localhost;dbname=bd_gado',"root","");
				$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

				if (isset($_GET["Adicionar"])) {
					$fields = "";
					$values = "'";

					$y = "";
					$z = "";

					$coluna = $pdo -> query("select cod from gado where nome like '".$_GET["gado"]."'");
					while ($linha = $coluna->fetch(PDO::FETCH_ASSOC)) {
						$y=$linha["cod"];
					}

					$coluna = $pdo -> query("select cod from veterinario where nome like '".$_GET["veterinario"]."'");
					while ($linha = $coluna->fetch(PDO::FETCH_ASSOC)) {
						$z=$linha["cod"];
					}

					$coluna = $pdo -> query("insert into Gado_has_Veterinario(Gado_cod,Veterinario_cod,ultimaConsulta,tratamento) values(".$y." ,".$z." ,'".$_GET["data"]."','".$_GET["tratamento"]."');");
				}

				if (!isset($_GET["table"])) {
					$_GET["table"] = $a;
				}
				$_GET["table"] = "Gado_has_Veterinario";
				$coluna = $pdo -> query("DESCRIBE ".$_GET['table']);
				while ($linha = $coluna->fetch(PDO::FETCH_ASSOC)) {
					$col[count($col)] = utf8_encode($linha['Field']);
					$x = "-i";
					if(strstr($linha['Type'],'varchar')){$x="-d";}
					echo '<br><input type="radio" name="tipo"';if($_GET['tipo'] == $linha['Field'].$x)echo "checked = 'checked'"; echo ' value="'.$linha['Field'].$x.'">'.$linha['Field'];
				}	
					echo '<br><br><input type="text" name="search" value="'.$_GET['search'].'" placeholder="Buscar"><input type="submit" value="Pesquisar"><br><br>';

			    
				echo "<hr><h3>Adicionar</h3>";

				$gado = $pdo -> query("SELECT nome FROM gado");

				echo "Gado: <select name='gado'>";
				$a = false;
				while ($linha = $gado->fetch(PDO::FETCH_NUM)) {
					if ($a == false) $a = $linha[0];
					echo "<option value='".$linha[0]."'";
					if($_GET['table'] == $linha[0])echo "selected='selected'";
					echo ">".utf8_encode($linha[0])."</option>";
				}
				echo "</select><br>";

				$gado = $pdo -> query("SELECT nome FROM veterinario");

				echo "veterinario: <select name='veterinario'>";
				$a = false;
				while ($linha = $gado->fetch(PDO::FETCH_NUM)) {
					if ($a == false) $a = $linha[0];
					echo "<option value='".$linha[0]."'";
					if($_GET['table'] == $linha[0])echo "selected='selected'";
					echo ">".utf8_encode($linha[0])."</option>";
				}
				echo "</select><br>";

				echo 'Tratamento: <input type="text" name="tratamento"><br> Data:<input type="date" name="data"><br>';
				echo '<input type="submit" value="Adicionar" name="Adicionar"><hr><br><br><table><tr class="row">';

				if (!isset($_GET["search"]) || $_GET["search"] == undefined || $_GET["search"] == null) {
					$type = 'SELECT * FROM '.$_GET['table'];
				}
				for ($i=0; $i < count($col); $i++) { 
					if (explode("-", $_GET['tipo'])[0] == $col[$i]){
						if(explode("-", $_GET['tipo'])[1] == "d")$type = 'SELECT * FROM '.$_GET['table'].' WHERE '.$col[$i].' like "%'.$_GET['search'].'%"';
						else{
							if($i == 0)$type = "SELECT * FROM ".$_GET['table']." WHERE $col[$i] = ".$_GET['search'];
							else $type = "SELECT * FROM ".$_GET['table']." WHERE $col[$i] >= ".$_GET['search'];
							if(!intval($_GET['search']))$type = 'SELECT * FROM '.$_GET['table'].' WHERE '.$col[$i].' like "'.$_GET['search'].'%"';
						}
					}
					echo "<td class='colum' style='font-weight: bold;text-transform: uppercase;color: black'>$col[$i]</td>";
				}
				echo "<td style='font-weight: bold;'>DELETAR</td><td style='font-weight: bold;'>ALTERAR</td></tr>";
				$consulta = $pdo -> query($type);

				$c = 0;
				while ($linha = $consulta->fetch(PDO::FETCH_NUM)) {
					$color = "#fff";
					if ($c % 2 == 0) { $color = "grey";}
					echo "<tr style='background-color: $color'>";
					for ($i=0; $i < count($linha); $i++) {

					if ($i==0) {
						$coluna = $pdo -> query("select nome from gado where cod like ".$linha[$i]."");
						while ($l = $coluna->fetch(PDO::FETCH_ASSOC)) {
							$linha[$i]=$l["nome"];
						}
					}
					if ($i==1) {
						$coluna = $pdo -> query("select nome from veterinario where cod like ".$linha[$i]."");
						while ($l = $coluna->fetch(PDO::FETCH_ASSOC)) {
							$linha[$i]=$l["nome"];
						}
					}
						if ($i == 2) {
							echo "<td>".date_format(date_create(utf8_encode($linha[$i])),"d/m/Y")."</td>";
						}else echo "<td>".utf8_encode($linha[$i])."</td>";
					}
					echo "<td><input type='submit' class='delete' name='delete' value='".utf8_encode($linha[0])."'></td>";
					echo "<td><input type='submit' class='delete' name='alterar' value='".utf8_encode($linha[0])."'></td></tr>";
					$c++;
				}
			}
			catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
			if (isset($_GET['delete'])){
					echo "<script>
					if(confirm('deseja realmente excluir'))window.location.href = 'deleteRow.php?delete=".$_GET['delete']."&table=".$_GET["table"]."&cod=".$col[0]."&tipo=".$_GET["tipo"]."'
					</script>";
			}
			if (isset($_GET['alterar'])){
				echo "<script>
					if(confirm('deseja realmente alterar?'))window.location.href = 'alterarConsultas.php?delete=".$_GET['alterar']."&table=".$_GET["table"]."&cod=".$col[0]."&tipo=".$_GET["tipo"]."'
					</script>";
			}

		 ?>
		 </table>
		 <script type="text/javascript">
		 	function submiting(){
		 		document.getElementById("form").submit();
		 	}
		 </script>
	</body>
</html>