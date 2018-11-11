<?php
class Main
{
    function __construct()
    {

    }
    public function getData($mysqli, $page, $perpage)
    {
        $u_role=$this->getUserRole($mysqli);
        $start= ($page-1)*$perpage;
        $sql = "SELECT d_id, tovar_id, status_name, d_num, date_format(d_date_add, '%d.%m.%y') d_date_add, tovar_name, tovar_cost, tovar_kolvo, proizv_name, tovar_primech_ruk, tovar_primech_magaz 
                FROM dogovor 
                inner join filial on dogovor.d_filial=filial.filial_id 
                inner join user on dogovor.d_user_id=user.user_id 
                inner join spopl on dogovor.s_spopl=spopl.spopl_id 
                inner join vitrvyst on dogovor.s_vitrvyst=vitrvyst.vv_id 
                inner join tovar on dogovor.d_id=tovar.tovar_d_id
                inner join proizv on tovar.tovar_proizv=proizv.proizv_id 
                left join status on tovar.tovar_status=status.status_id 
                WHERE d_id is not null";
        if($_POST["d_num"]!=""){
            $sql.= " and d_num like '%".iconv('utf-8','cp1251',$_POST["d_num"])."%'";
        }
        if($_POST["status_id"]!="") {
            $sql .= " and status_id = '" . $_POST["status_id"] . "'";
        }
        if ($u_role =='*') {
            if ($_POST["filial_id"] != "") {
                $sql .= " and filial_id = '" . $_POST["filial_id"] . "'";
            }
        } else {
            $sql .= " and filial_id = '" . $u_role . "'";
        }
        if($_POST["spopl_id"]!="") {
            $sql .= " and spopl_id = '" . $_POST["spopl_id"] . "'";
        }
        if($_POST["proizv_id"]!="") {
            $sql .= " and proizv_id = '" . $_POST["proizv_id"] . "'";
        }
        if($_POST["dateBegin"]!="" && $_POST["dateEnd"]!="") {
            $sql .= " and (d_date_add >=str_to_date('" . $_POST["dateBegin"] . "', '%d.%m.%Y %H:%i:%s') and d_date_add <=str_to_date('" . $_POST["dateEnd"] . " 23:59:59', '%d.%m.%Y %H:%i:%s')) ";
        }
        $result_count = $mysqli->query($sql);
        $count_rows = $result_count->num_rows;
        $sql.= " ORDER BY dogovor.d_date_add desc, dogovor.d_num desc, dogovor.d_id desc LIMIT ".$start.", ".$perpage." ";
        if (!$result = $mysqli->query($sql)) {
            // О нет! запрос не удался.
            echo "Извините, возникла проблема в работе сайта.";

            // И снова: не делайте этого на реальном сайте, но в этом примере мы покажем,
            // как получить информацию об ошибке:
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Запрос: " . $sql . "\n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            echo "Ошибка: " . $mysqli->error . "\n";
        }


        if ($result->num_rows === 0) {
            echo "Мы не смогли найти совпадение. Пожалуйста, попробуйте еще раз.";
        }
        $table = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array(
                "d_id" => iconv( 'cp1251', 'utf-8',$row["d_id"]),
                "tovar_id" => iconv( 'cp1251', 'utf-8',$row["tovar_id"]),
                "status_name" => iconv( 'cp1251', 'utf-8',$row["status_name"]),
                "d_num" => iconv( 'cp1251', 'utf-8',$row["d_num"]),
                "d_date_add" => iconv( 'cp1251', 'utf-8',$row["d_date_add"]),
                "tovar_name" => iconv( 'cp1251', 'utf-8',$row["tovar_name"]),
                "tovar_cost" => iconv( 'cp1251', 'utf-8',$row["tovar_cost"]),
                "tovar_kolvo" => iconv( 'cp1251', 'utf-8',$row["tovar_kolvo"]),
                "tovar_proizv" => iconv( 'cp1251', 'utf-8', $row["proizv_name"]),
                "tovar_primech_ruk" => iconv( 'cp1251', 'utf-8', $row["tovar_primech_ruk"]),
                "tovar_primech_magaz" => iconv( 'cp1251', 'utf-8', $row["tovar_primech_magaz"])
            );
            array_push($table, $temp);
        }
        /*$row = $result->fetch_assoc();
        foreach ($row as $rows)
        {
            echo $rows["d_num"];
        }*/
        return array("data" => $table, "count_rows" => $count_rows);
    }

    public function getStatus($mysqli)
    {
        $sql = "SELECT status_id, status_name from status;";
        if (!$result = $mysqli->query($sql)) {
            echo "Извините, возникла проблема в работе сайта.";
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Запрос: " . $sql . "\n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            echo "Ошибка: " . $mysqli->error . "\n";
            exit;
        }
        if ($result->num_rows === 0) {
            echo "Мы не смогли найти совпадение. Пожалуйста, попробуйте еще раз.";
            exit;
        }
        $status = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array(
                "status_id" => iconv( 'cp1251', 'utf-8',$row["status_id"]),
                "status_name" => iconv( 'cp1251', 'utf-8',$row["status_name"])
            );
            array_push($status, $temp);
            echo $status[""];
        }
        return $status;
    }

    public function getFilial($mysqli)
    {
        $sql = "SELECT filial_id, filial_name from filial;";
        if (!$result = $mysqli->query($sql)) {
            echo "Извините, возникла проблема в работе сайта.";
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Запрос: " . $sql . "\n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            echo "Ошибка: " . $mysqli->error . "\n";
            exit;
        }
        if ($result->num_rows === 0) {
            echo "Мы не смогли найти совпадение. Пожалуйста, попробуйте еще раз.";
            exit;
        }
        $filial = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array(
                "filial_id" => iconv( 'cp1251', 'utf-8',$row["filial_id"]),
                "filial_name" => iconv( 'cp1251', 'utf-8',$row["filial_name"])
            );
            array_push($filial, $temp);
            echo $filial[""];
        }
        return $filial;
    }

    public function getProizv($mysqli)
    {
        $sql = "SELECT proizv_id, proizv_name from proizv;";
        if (!$result = $mysqli->query($sql)) {
            echo "Извините, возникла проблема в работе сайта.";
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Запрос: " . $sql . "\n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            echo "Ошибка: " . $mysqli->error . "\n";
            exit;
        }
        if ($result->num_rows === 0) {
            echo "Мы не смогли найти совпадение. Пожалуйста, попробуйте еще раз.";
            exit;
        }
        $proizv = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array(
                "proizv_id" => iconv( 'cp1251', 'utf-8',$row["proizv_id"]),
                "proizv_name" => iconv( 'cp1251', 'utf-8',$row["proizv_name"])
            );
            array_push($proizv, $temp);
            echo $proizv[""];
        }
        return $proizv;
    }

    public function getSpopl($mysqli)
    {
        $sql = "SELECT spopl_id, spopl_name from spopl;";
        if (!$result = $mysqli->query($sql)) {
            echo "Извините, возникла проблема в работе сайта.";
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Запрос: " . $sql . "\n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            echo "Ошибка: " . $mysqli->error . "\n";
            exit;
        }
        if ($result->num_rows === 0) {
            echo "Мы не смогли найти совпадение. Пожалуйста, попробуйте еще раз.";
            exit;
        }
        $spopl = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array(
                "spopl_id" => iconv( 'cp1251', 'utf-8',$row["spopl_id"]),
                "spopl_name" => iconv( 'cp1251', 'utf-8',$row["spopl_name"])
            );
            array_push($spopl, $temp);
            echo $spopl[""];
        }
        return $spopl;
    }

    public function updateStatus($mysqli, $tovar_ids, $status_id)
    {
        foreach ($tovar_ids as $tovar_id) {
            $sql = "UPDATE tovar set tovar_status=".$status_id." where tovar_id=".$tovar_id.";";
            if (!$result = $mysqli->query($sql)) {
                echo "Извините, возникла проблема в работе сайта.";
                echo "Ошибка: Наш запрос не удался и вот почему: \n";
                echo "Запрос: " . $sql . "\n";
                echo "Номер_ошибки: " . $mysqli->errno . "\n";
                echo "Ошибка: " . $mysqli->error . "\n";
                exit;
            }
        }
    }

    public function updatePrimM($mysqli, $tovar_ids, $tovar_primech_magaz)
    {
        foreach ($tovar_ids as $tovar_id) {
            $sql = "UPDATE tovar set tovar_primech_magaz='".$tovar_primech_magaz."' where tovar_id=".$tovar_id.";";
            if (!$result = $mysqli->query($sql)) {
                echo "Извините, возникла проблема в работе сайта.";
                echo "Ошибка: Наш запрос не удался и вот почему: \n";
                echo "Запрос: " . $sql . "\n";
                echo "Номер_ошибки: " . $mysqli->errno . "\n";
                echo "Ошибка: " . $mysqli->error . "\n";
                exit;
            }
        }
    }

    public function updatePrimU($mysqli, $tovar_ids, $tovar_primech_ruk)
    {
        foreach ($tovar_ids as $tovar_id) {
            //echo $tovar_primech_ruk.$tovar_id;exit;
            $sql = "UPDATE tovar set tovar_primech_ruk='".$tovar_primech_ruk."' where tovar_id=".$tovar_id.";";
            if (!$result = $mysqli->query($sql)) {
                echo "Извините, возникла проблема в работе сайта.";
                echo "Ошибка: Наш запрос не удался и вот почему: \n";
                echo "Запрос: " . $sql . "\n";
                echo "Номер_ошибки: " . $mysqli->errno . "\n";
                echo "Ошибка: " . $mysqli->error . "\n";
                exit;
            }
        }
    }

    public function addUser($mysqli, $l_name, $l_role, $l_pass)
    {
            //echo $tovar_primech_ruk.$tovar_id;exit;
            $sql = "INSERT INTO l_in(l_name,l_pass,l_role) VALUES('".$l_name."', '".crypt($l_pass)."', '".$l_role."');";
            if (!$result = $mysqli->query($sql)) {
                echo "Извините, возникла проблема в работе сайта.";
                echo "Ошибка: Наш запрос не удался и вот почему: \n";
                echo "Запрос: " . $sql . "\n";
                echo "Номер_ошибки: " . $mysqli->errno . "\n";
                echo "Ошибка: " . $mysqli->error . "\n";
                exit;
            }
    }

    public function updatePassword($mysqli, $l_pass, $l_newpass, $l_newpass2)
    {
        $sql1="SELECT l_pass from l_in where l_name='".$_SESSION["u_id"]."'";
        $queryPass = $mysqli->query($sql1);
        $resultPass = $queryPass->fetch_assoc();
        if (password_verify($l_pass, $resultPass["l_pass"])) {
            if ($l_newpass === $l_newpass2) {
                //echo $tovar_primech_ruk.$tovar_id;exit;
                $sql2 = "UPDATE l_in set l_pass='".crypt($l_newpass)."' where l_name='" . $_SESSION["u_id"] . "';";
                if (!$result = $mysqli->query($sql2)) {
                    echo "Номер_ошибки: " . $mysqli->errno . "\n";
                    echo "Ошибка: " . $mysqli->error . "\n";
                    exit;
                }
                else
                {
                    header("Location: http://".$_SERVER['HTTP_HOST']."/");
                }
            }
            else echo "Пароль не был изменен, так как введеные пароли не совпадают";
        }
        else echo "Пароль не был изменен, так как был введен неверно текущий пароль";
    }

    public function getUserRole($mysqli)
    {
        $sql="SELECT l_role from l_in where l_name='".$_SESSION["u_id"]."'";
                if (!$result = $mysqli->query($sql)) {
                    echo "Номер_ошибки: " . $mysqli->errno . "\n";
                    echo "Ошибка: " . $mysqli->error . "\n";
                    exit;
                }
                else
                {
                    $resultRole = $result->fetch_assoc();
                    return $resultRole["l_role"];
                }
    }
}
?>