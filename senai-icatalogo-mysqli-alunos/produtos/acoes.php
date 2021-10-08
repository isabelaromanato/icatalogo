<?php 


require ("../database/conexao.php");

switch ($_POST["acao"]) {
    case 'inserir':
        
        //TRATAMENTO DA IMAGEM PARA UPLOAD:

        //RECUPERA O NOME DO ARQUIVO

        $nomeArquivo = $_FILES["foto"]["name"];

        //RECUPERAR A EXTENÇÃO DO ARQUIVO -> pathinfo
        
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        //DEFINIR UM NOVO NOME PARA O ARQUIVO DE IMAGEM 
        //md5 - eu faço e não desfaço
        //microtime - converte uma data para microsegundos

        $novoNome = md5(microtime()) . "." . $extensao;


        //UPLOADED
        move_uploaded_file($_FILES["foto"]["tmp_name"], "fotos/$novoNome");

        //INSERÇÃO DE DADOS DA BASE DE DADOS DO MYSQL
        
        $descricao = $_POST["descricao"];
        $peso = $_POST["peso"];
        $quantidade = $_POST["quantidade"];
        $cor = $_POST["cor"];
        $tamanho = $_POST["tamanho"];
        $valor = $_POST["valor"];
        $desconto = $_POST["desconto"];
        $categoriaId = $_POST["categoria"];

        //CRIAÇÃO DA INSTRUÇÃO SQL DE INSERÇÃO

        $sql  = "INSERT  INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id)
        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto, '$novoNome', $categoriaId)";

        echo $sql;

        //EXECUSÃO DO SQL DE INSERÇÃO

        $resultado = mysqli_query($conexao, $sql);

        //REDIRECIONAR PARA INDEX

        header('location: index.php');

        break;
    
    default:
        # code...
        break;
}
?> 