<?php 


require ("../database/conexao.php");

switch ($_POST["acao"]) {
    case 'inserir':
        
        //TRATAMENTO DA IMAGEM PARA UPLOAD:

        // echo '<pre>';
        // var_dump($_FILES);
        // echo '</pre>';

        //RECUPERA O NOME DO ARQUIVO

        $nomeArquivo = $_FILES["foto"]["name"];

        //RECUPERAR A EXTENÇÃO DO ARQUIVO -> pathinfo
        
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

        //DEFINIR UM NOVO NOME PARA O ARQUIVO DE IMAGEM 
        //md5 - eu faço e não desfaço
        //microtime - converte uma data para microsegundos

        $novoNome = md5(microtime()) . "." . $extensao;


        echo $nomeArquivo;
        echo "<br.</br>";
        echo $novoNome;

        break;
    
    default:
        # code...
        break;
}
?> 