<?php
try{
	$pdo = new PDO('mysql:host=localhost;dbname=bd_gado',"root","");
	$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$consulta = $pdo -> query("DELETE FROM ".$_GET["table"]." WHERE ".$_GET["cod"]." = ".$_GET['delete']);
	header("location:".$_GET["table"].".php");
	}
catch(PDOException $e){
	echo "ERRO: Verifique as dependências antes de apagar. \n Voltando...";
}
?>

<script type="text/javascript">
	setTimeout(function(){window.location.href = window.location.pathname.replace('deleteRow.php','') + '<?php echo $_GET["table"]; ?>.php'}, 5000);
</script>
