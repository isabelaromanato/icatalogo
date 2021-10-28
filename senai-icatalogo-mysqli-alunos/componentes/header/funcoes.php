<?php

function lerArquivo($nomeArquivo)
{
    $arquivo = file_get_contents($nomeArquivo);
    $jsonArray = json_decode($arquivo);

    return $jsonArray;
}

function buscarFuncionario($funcionarios, $filtro)
{
    $funcionariosFiltro = [];
    foreach ($funcionarios as $funcionario) {
        if (
            strpos($funcionario->first_name, $filtro) !== false
            ||
            strpos($funcionario->last_name, $filtro) !== false
            ||
            strpos($funcionario->department, $filtro) !== false
        ) {
            $funcionariosFiltro[] = $funcionario;
        }
    }
    return $funcionariosFiltro;
}


function adicionarFuncionario($nomeArquivo, $novoFuncionario)
{
    $funcionarios = lerArquivo($nomeArquivo);

    $funcionarios[] = $novoFuncionario;
    // print_r($funcionarios);

    $json = json_encode($funcionarios);
    file_put_contents($nomeArquivo, $json);
}



function deletarFuncionario($nomeArquivo, $idFuncioanrio){
    $funcionarios = lerArquivo($nomeArquivo);

    foreach($funcionarios as $chave => $funcionario){
        if($funcionario-> id == $idFuncioanrio){
            unset($funcionarios[$chave]);
        }
    }

    $json = json_encode(array_values($funcionarios));
    file_put_contents($nomeArquivo, $json);

}

//Busca funcionario por id

function buscarFuncionarioPorId ($nomeArquivo, $idFuncionario){
    
    $funcionarios = lerArquivo ($nomeArquivo);
    
    foreach ($funcionarios as $funcionario) {
        
    if ($funcionario -> id == $idFuncionario) {
       
        return $funcionario;
    }
    }

    return false;
    
}

function editarFuncionario($nomeArquivo, $funcionarioEditado) {



    $funcionarios = lerArquivo($nomeArquivo);


    foreach ($funcionarios as $chave => $funcionario){
      
        if ($funcionario->id == $funcionarioEditado["id"]) {
            $funcionarios[$chave] = $funcionarioEditado;
        }
    }


    $json = json_encode(array_values($funcionarios));
    file_put_contents($nomeArquivo, $json);
    
}

//funções referentes ao sistema de login

function realizarLogin($usuario, $senha, $dados)
{

    foreach ($dados as  $dado) {
       
        if ($dado->usuario == $usuario && $dado->senha == $senha) {
      
            //VARIÁVEIS DE SESSÃO

            $_SESSION["usuario"] = $dado->usuario;
            $_SESSION["id"] = session_id();
            $_SESSION["data_hora"] = date('d/m/Y - h:i:s');

            header('location: empresaX.php');
            exit;

            
        } 
                    
    }

    header('location:index.php');
}

//FUNÇÃO DE VERIFICAÇÃO DE LOGIN:
// VERIFICA SE O USUARIO PASSOU PELO PROCESSO DE LOGIN

function verificarLogin (){
    
    if ($_SESSION["id"] != session_id() || (empty($_SESSION["id"])) ){

        header('location:index.php');

    }
    
}


//FUNÇÃO DE FINALIZAÇÃO DE LOGIN:
//EFETUA A AÇÃO DE SAIR DO USUÁRIO- DESTRUINDO A FUNÇÃO

function finalizarLogin() {
    
    session_unset(); //limpa todas as variaveis de sessão
    session_destroy(); //destroi a sessão ativa

    header('location:empresaX.php');
}

?>