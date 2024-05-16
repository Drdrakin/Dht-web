<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "esp32";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $success_message = "";
    $error_message = "";

    if ($conn->connect_error) {
        $error_message = "Ola! A conexao falhou: " . $conn->connect_error;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {

        $temp = isset($_POST['temperature']) ? $_POST['temperature'] : null;
        $umid = isset($_POST['humidity']) ? $_POST['humidity'] : null;

        if ($temp !== null && $umid !== null) {

            $sql = "INSERT INTO dht_data (temperatura, umidade) VALUES ('$temp', '$umid')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "Otimo! O registro da leitura do sensor DHT11 foi salvo com sucesso.";
            } else {
                $error_message = "Ops! Algo deu errado: " . $conn->error;
            }
        } else {
            $error_message = "Oops! Parece que os valores de temperatura e umidade nao foram recebidos corretamente.";
        }
    } else {
        $error_message = "Nenhum dado recebido para atualizacao.";
    }
    
    $sql = "SELECT * FROM dth_data ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $temp = $row["temperatura"];
        $umid = $row["umidade"];

        $sql = "SELECT temperatura, data_hora FROM dht_data WHERE temperatura =
        (SELECT min(temperatura) as temperatura FROM dth_data WHERE temperatura <> 0) LIMIT 1";
        
        $resultMenor = $conn->query($sql);

        if ($resultMenor->num_rows > 0) {

            $row = $resultMenor->fetch_assoc();
            $menorTemp = $row["temperatura"];
            $menorDataHora = date('d/m/Y H:i:s', strtotime($row["data_hora"]));
        }else{
            $menorTemp = "--";
            $menorDataHora = "--";
        } /*line 72*/
    }
}