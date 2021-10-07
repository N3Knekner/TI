<form method="GET" id="form">
	<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='cod' value=".$_GET['delete'].">"; ?>
		<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='delete' value=".$_GET['delete'].">"; ?>	



		<h3>Adicionar</h3>

		nome: <input type="text" name="nome"><br>
		<input type="submit" value="SALVAR" name="Adicionar">

</form>




<?php
	if (isset($_GET['Adicionar'])) {
		$pdo = new PDO('mysql:host=localhost;dbname=bd_gado',"root","");
		$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$pdo -> query("UPDATE Raca SET nome = '".$_GET["nome"]."' WHERE cod =".$_GET['cod']);
		header("location:raca.php");
	}
?>
