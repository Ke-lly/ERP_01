
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "config.php";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $nome_equip = $_POST["nome_equip"];
        $problema = $_POST["problema"];
        $data_inicio = $_POST["data_inicio"];
        $data_termino = $_POST["data_termino"];
        $tecnico_resp = $_POST["tecnico_resp"];
        $status = $_POST["status"];

        $sql_id = "SELECT nome FROM funcionarios WHERE funcionario_id = '$tecnico_resp'";
    $func_nome_result = $conn->query($sql_id);

    // Check if the query was successful and a result was returned
        // Fetch the name
        $func_nome_row = $func_nome_result->fetch();
        $func_nome = $func_nome_row['nome'];

        // Now we can safely insert it into the manutencoes table
        $query = "INSERT INTO manutencoes (equipamento, descricao_problema, data_inicio, data_termino, tecnico_responsavel, status, responsavel_id) VALUES ('$nome_equip', '$problema', '$data_inicio', '$data_termino', '$func_nome', '$status', '$tecnico_resp')";

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $conn->query($query);
            header('Location: manutencao.php');
            exit();
        }
        catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erro ao cadastrar manutenção: " . $e->getMessage() . "</div>";
        }
    }
?>