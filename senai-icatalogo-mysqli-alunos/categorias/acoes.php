<?php

session_start();

/*CONEXÃO COM BANCO DE DADOS*/

require("../database/conexao.php");


/*Função de validação*/ 
function validaCampos(){

$erros = [];

if(!isset ($_POST ['descricao']) || $_POST['descricao'] == ""){


    $erros [] = "O campo descrição é de preenchimento obrigatório";

}

return $erros;
}

/*
TRATAMENTO DE DADOS VINDO DO FORMULÁRIO

-Tipo da ação
-Execação dos processos da ação solicitada

*/ 

switch ($_POST ['acao']) {
    case 'inserir':

        //CHAMADA DA FUNÇÃO DE VALIDAÇÃO DE ERROS:
        $erros = validaCampos();

        //VERIFCAR SE EMITE ERROS 

        if (count($erros) > 0 ){

            $_SESSION['erros'] = $erros;

            header('location: index.php');

            exit();

        }

        // echo "INSERIR"; exit;

        $descricao = $_POST ['descricao'];

        /*MONTAGEM DA INTRUÇÃO SQL DE INSERÇÃO DE DADOS:*/

        $sql = "INSERT INTO tbl_categoria(descricao) VALUES ('$descricao')";

        // echo $sql; exit;


        /*mysqli_query() parâmetros 
        1- Uma construção aberta e válida
        2-Uma instrução sql válida
        */ 

        $resultado = mysqli_query($conexao, $sql);


        header ('location: index.php');

        //  echo "<pre>";
        //  var_dump($resultado);
        //  echo "</pre>";
        // exit;

        break;

        case 'deletar':

            $categoriaID = $_POST['categoriaId']; 

            $sql = "DELETE FROM tbl_categoria WHERE id = $categoriaID";

            $resultado = mysqli_query($conexao, $sql);

            header('location: index.php');

            break;

            case 'editar':

                $id = $_POST["id"];
                $descricao = $_POST ["descricao"];

                $sql = "UPDATE tbl_categoria SET descricao = '$descricao'  WHERE id = $id";
                // echo $sql;exit;
                //comando em sql cercado com aspas duplas

                $resultado = mysqli_query($conexao, $sql);

                header('location: index.php');

                break;


        default;
        # code...
        break;
}

?>