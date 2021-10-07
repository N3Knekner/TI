<?php
require_once('utils/utils.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    //Leva a pagina de perfil
    if (isset($_GET['perfilId'])) {
      require_once('utils/utils.php');
      $sql = 'SELECT * FROM veterinario WHERE id = '.$_GET['perfilId'];
      $comando = preparaComando($sql);
      $comando = executaComando($comando);
      $itens = '';
      while($linha = $comando->fetch(PDO::FETCH_ASSOC)){
        $item = file_get_contents('perfilVeterinario.html');
        $item = preencherFormulario($item,$linha);
        $itens .= $item;
      }
      $lista = file_get_contents('listaPerfilVeterinario.html');
      $lista = str_replace('{itens}',$itens,$lista);
      print($lista);
    }
    else{
    //Deleta
      if (isset($_GET['DelId'])) {
        $sql = 'delete from Veterinario where id = '.$_GET['DelId'];
        $comando = preparaComando($sql);
        executaComando($comando);
         echo '<script type="text/javascript">
                window.location.href = window.location.href.replace("veterinario.php"+window.location.href.substring((window.location.href).indexOf("?"),window.location.href.length),"listaVeterinario.php");
               </script>';
      }
      else{
        $formulario = file_get_contents('veterinario.html');
        if (isset($_GET['id'])){
          $sql = 'SELECT * FROM veterinario WHERE id = :id';
          $comando = preparaComando($sql);
          $comando->bindParam(':id',$_GET['id']);
          $veterinario = executaComando($comando)->fetch();
          $formulario = preencherFormulario($formulario,$veterinario);
        }else{
          $formulario = str_replace('{ibagens}','',$formulario);
          $formulario = str_replace('{nome}','',$formulario);
          $formulario = str_replace('{crmv}','',$formulario);
          $formulario = str_replace('{telefone}','',$formulario);
          $formulario = str_replace('{Descricao}','',$formulario);
          $formulario = str_replace('{id}','',$formulario);
        }
        print($formulario);
      }
    }
  }else if ($_SERVER['REQUEST_METHOD'] ==  'POST'){
    if (isset($_POST['nome'])){
      $nome = $_POST['nome'];
      $crmv = $_POST['crmv'];
      $telefone = $_POST['telefone'];
      $id = $_POST['id'];
      $descricao = $_POST['descricao'];
      $ibagens = $_FILES['ibagem']['name'] != ''?("img/".$_FILES["ibagem"]['name']):null;
      if($ibagens)move_uploaded_file($_FILES["ibagem"]['tmp_name'],$ibagens);

      if ($id > 0){
        if($ibagens)$sql = 'UPDATE veterinario SET nome = :nome, crmv = :crmv, telefone = :telefone, ibagens = :ibagens, Descricao = :descricao WHERE id = :id';
        else  $sql = 'UPDATE veterinario SET nome = :nome, crmv = :crmv, telefone = :telefone, Descricao = :descricao WHERE id = :id';
        $comando = preparaComando($sql);

        $comando->bindParam(':nome',$nome);
        $comando->bindParam(':crmv',$crmv);
        $comando->bindParam(':telefone',$telefone);
        if($ibagens)$comando->bindParam(':ibagens',$ibagens);
        $comando->bindParam(':descricao',$descricao);
        $comando->bindParam(':id',$id);

        executaComando($comando);
        $success = file_get_contents('success.html');
        $success = str_replace('{x}','Atualizado',$success);
        print($success);
      }else{
        if($ibagens)$sql = 'INSERT INTO veterinario (nome, crmv, telefone, ibagens, Descricao) VALUES (:nome,:crmv,:telefone,:ibagens,:descricao)';
        else $sql = 'INSERT INTO veterinario (nome, crmv, telefone, Descricao) VALUES (:nome,:crmv,:telefone,:descricao)';
        $comando = preparaComando($sql);

        $comando->bindParam(':nome',$nome);
        $comando->bindParam(':crmv',$crmv);
        $comando->bindParam(':telefone',$telefone);
        if($ibagens)$comando->bindParam(':ibagens',$ibagens);
        $comando->bindParam(':descricao',$descricao);

        executaComando($comando);
        $success = file_get_contents('success.html');
        $success = str_replace('{x}','Cadastrado',$success);
        print($success);
      }
      
    }else{
      echo "Preencha todos os campos do formulário";
    }

    echo '<script type="text/javascript">
   setTimeout(()=> {window.location.href = window.location.href.replace("veterinario.php", "listaVeterinario.php")}, 3000);
 </script>';
  }
 ?>

 
