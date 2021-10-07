<form method="GET" id="form">
	<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='cod' value=".$_GET['delete'].">"; ?>
		<?php echo "<input type='checkbox' checked='checked' hidden='hidded' name='delete' value=".$_GET['delete'].">"; ?>	



		<h3>Alterar</h3>

		Nome: <input type="text" name="nome">
		<br>Nome da Propriedade:  <input type="text"  name="CRMV"><br>
		<input type="submit" value="SALVAR" name="Adicionar">

</form>




<?php
	if (isset($_GET['Adicionar'])) {
		$pdo = new PDO('mysql:host=localhost;dbname=bd_gado',"root","");
		$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$pdo -> query("UPDATE Criador SET nome = '".$_GET["nome"]."' WHERE cod =".$_GET['cod']);
		$pdo -> query("UPDATE Criador SET nome_Propriedade = '".$_GET["CRMV"]."' WHERE cod =".$_GET['cod']);
		header("location:criador.php");
	}
?>
