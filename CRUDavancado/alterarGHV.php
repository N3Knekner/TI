<form method="GET" id="form">
	<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='cod' value=".$_GET['delete'].">"; ?>
	<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='delete' value=".$_GET['delete'].">"; ?>	



		<h3>Adicionar</h3>

		nome: <input type="text" name="nome">
		<br>CRMV:  <input type="text"  name="CRMV">
		<br>telefone:  <input type="text" name="telefone"><br>
		<input type="submit" value="Adicionar" name="Adicionar">

</form>




<?php
	if (isset($_GET['Adicionar'])) {
		$pdo = new PDO('mysql:host=localhost;dbname=bd_gado',"root","");
		$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$pdo -> query("UPDATE Veterinario SET nome = '".$_GET["nome"]."' WHERE cod =".$_GET['cod']);
		$pdo -> query("UPDATE Veterinario SET CRMV = '".$_GET["CRMV"]."' WHERE cod =".$_GET['cod']);
		$pdo -> query("UPDATE Veterinario SET telefone = '".$_GET["telefone"]."' WHERE cod =".$_GET['cod']);
		header("location:veterinario.php");
	}
?>
