<form method="GET" id="form">
	<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='cod' value=".$_GET['delete'].">"; ?>
		<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='delete' value=".$_GET['delete'].">"; ?>	



		<h3>Alterar</h3>

				Tratamento: <input type="text" name="tratamento"><br> Data:<input type="date" name="data"><br>


		<input type="submit" value="SALVAR" name="Adicionar">

</form>




<?php
	if (isset($_GET['Adicionar'])) {
		$pdo = new PDO('mysql:host=localhost;dbname=bd_gado',"root","");
		$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$pdo -> query("UPDATE Gado_has_Veterinario SET tratamento = '".$_GET["tratamento"]."' WHERE Gado_cod =".$_GET['cod']);
		
		/*$pdo -> query("UPDATE Gado SET Raca_cod = '".$_GET["gado"]."' WHERE cod =".$_GET['cod']);
		$pdo -> query("UPDATE Gado SET Criador_cod = '".$_GET["veterinario"]."' WHERE cod =".$_GET['cod']);*/
		header("location:consultas.php");
	}
?>
