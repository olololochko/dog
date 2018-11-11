<?php
if(isset($_SESSION["u_id"]) && isset($_SESSION["u_pass"]))
{
    if ($_SESSION["u_id"] !=="" && $_SESSION["u_pass"]!=="") {
        $u_log = $_SESSION["u_id"];
        $u_pass = $_SESSION["u_pass"];
    }
}
if (isset($u_log) && isset($u_pass))
{

    if (!$result = $mysqli->query("select l_pass, l_role from l_in where l_name='".$u_log."'")){
        echo "Извините, возникла проблема в работе сайта.";
        echo "Ошибка: Наш запрос не удался и вот почему: \n";
        echo "Номер_ошибки: " . $mysqli->errno .$mysqli->error. "\n";
        exit;
    }

    if (!$result->num_rows === 0){
        echo "Фуфло гонишь не по теме";
        exit;
    }

    if ($result->num_rows === 1)
    {
        $data = $result->fetch_assoc();

        if (password_verify($u_pass, $data["l_pass"])) {
            $_SESSION["u_id"] = $u_log;
            $_SESSION["u_pass"] = $u_pass;
            $isLogged = 1;
            $u_role = $data["l_role"];
        } else {
            $isLogged = 0;
            $_SESSION["u_id"] = null;
            $_SESSION["u_pass"] = null;
        }
    }
    else {
        $isLogged = 0;
        $_SESSION["u_id"] = null;
        $_SESSION["u_pass"] = null;
    }
} else {
    $isLogged = 0;
    $_SESSION["u_id"] = null;
    $_SESSION["u_pass"] = null;
}