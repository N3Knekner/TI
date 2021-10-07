<!DOCTYPE html>
<html>
<head>
	<title>GADO dms</title>
	<style type="text/css">
		div{
			width: 100vw;
			display: flex;
			align-items: center;
			padding-top: 50px;
		}
		button{
			display: flex;
			width: 100%;
			height: 100px;
			justify-content: center;
			font-size: 20px;
		}
		body{
			padding: 0px;
			margin: 0px;
		}
	</style>
</head>
<body>

	<div>
		<button onclick="window.location.href = window.location.pathname+'veterinario.php'">Veterinario</button>
		<button onclick="window.location.href = window.location.pathname+'gado.php'">Gado</button>
		<button onclick="window.location.href = window.location.pathname+'raca.php'">Raca</button>
		<button onclick="window.location.href = window.location.pathname+'criador.php'">Criador</button>
		<button onclick="window.location.href = window.location.pathname+'Gado_has_Veterinario.php'">Consultas</button>
	</div>

</body>
</html>