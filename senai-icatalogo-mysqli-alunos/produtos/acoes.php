<?php 

session_start();

require ("../database/conexao.php");

function validarCampos(){

    //ARRAY DAS MENSAGENS DE ERRO 
    $erros = [];

    //VALIDAÇÃO DE DESCRIÇÃO

    if ($_POST["descricao"] == "" || !isset($_POST["descricao"])) {
        
        $erros[] = "O CAMPO DESCRIÇÃO É OBRIGATÓRIO";
    }

    //VALIDAÇÃO DE PESO

    if ($_POST["peso"] == "" || !isset($_POST["peso"])) {
        
        $erros[] = "O CAMPO PESO É OBRIGATÓRIO";
    
    }elseif (!is_numeric(str_replace(",", ".", $_POST["peso"]))) {
        
        $erros[]="O CAMPO PESO DEVE SER UM NÚMERO";
    }
 
    //VALIDAÇÃO DE QUANTIDADE
    
    if ($_POST["quantidade"] == "" || !isset($_POST["quantidade"])) {
        
        $erros[] = "O CAMPO QUANTIDADE É OBRIGATÓRIO";
    
    }elseif (!is_numeric(str_replace(",", ".", $_POST["quantidade"]))) {
        
        $erros[]="O CAMPO QUANTIDADE DEVE SER UM NÚMERO";
    }

    //VALIDAÇÃO DE COR

    if ($_POST["cor"] == "" || !isset($_POST["cor"])) {
        
        $erros[] = "O CAMPO COR É OBRIGATÓRIO";
    }

    
    //VALIDAÇÃO DE TAMANHO

    if ($_POST["tamanho"] == "" || !isset($_POST["tamanho"])) {
        
        $erros[] = "O CAMPO TAMANHO É OBRIGATÓRIO";
    }

    //VALIDAÇÃO DE VALOR

    if ($_POST["valor"] == "" || !isset($_POST["valor"])) {
        
        $erros[] = "O CAMPO VALOR É OBRIGATÓRIO";
    
    }elseif (!is_numeric(str_replace(",", ".", $_POST["valor"]))) {
        
        $erros[]="O CAMPO VALOR DEVE SER UM NÚMERO";
    }

    //VALIDAÇÃO DE DESCONTO

    if ($_POST["desconto"] == "" || !isset($_POST["desconto"])) {
        
        $erros[] = "O CAMPO DESCONTO É OBRIGATÓRIO";
    
    }elseif (!is_numeric(str_replace(",", ".", $_POST["desconto"]))) {
        
        $erros[]="O CAMPO  DESCONTO DEVE SER UM NÚMERO";
    }


    //VALIDAÇÃO DE CATEGORIA

    
    if ($_POST["categoria"] == "" || !isset($_POST["categoria"])) {
        
        $erros[] = "O CAMPO CATEGORIA É OBRIGATÓRIO";
    }

    //VALIDAÇÃO DA IMAGEM

    if ($_FILES["foto"]["error"] == UPLOAD_ERR_NO_FILE ) {
        
        $erros[] = "O ARQUIVO PRECISA SER UMA IMAGEM";
    }else {
        $imagemInfos = getimagesize($_FILES["foto"]["tmp"]);

        if ($_FILES["foto"]["size"] > 1024 * 1024 * 2) {

           $erros[] = "O ARQUIVO NÃO PODE SER MAIOR QUE 2MB";
        }

        $width = $imagemInfos[0];
        $height = $imagemInfos[1];

        if ($width != $height) {
          
            $erros[] = "A IMAGEM PRECISA SER QUADRADA";
        }
    }

    return $erros;
}

switch ($_POST["acao"]) {
    case 'inserir':

        $erros = validarCampos();

        // var_dump($erros);exit;

        if (count($erros) > 0 ) {
            
          $_SESSION["erros"] = $erros;
          
          header("location: novo/index.php");

          exit;

        }
        
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