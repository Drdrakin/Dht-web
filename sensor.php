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

        
    }