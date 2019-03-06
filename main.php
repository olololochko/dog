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
        $sql = "SELECT d_id, status_name, d_num, date_format(d_date_add, '%d.%m.%y') d_date_add, d_date_close, d_neotr, user_fio, d_primech_r, d_primech_m, s_sum_predopl, s_summa, vv_name, spopl_name, sum(plata_sum)+s_credit_sum plata_sum
                FROM dogovor 
                inner join filial on dogovor.d_filial=filial.filial_id 
                inner join plata on dogovor.d_id=plata.plata_d_id 
                inner join user on dogovor.d_user_id=user.user_id 
                inner join spopl on dogovor.s_spopl=spopl.spopl_id 
                inner join vitrvyst on dogovor.s_vitrvyst=vitrvyst.vv_id 
                left join status on dogovor.d_status=status.status_id 
                WHERE d_id is not null";
        if($_POST["d_num"]!=""){
            $sql.= " and d_num like '%".iconv('utf-8','cp1251',$_POST["d_num"])."%'";
        }
        if($_POST["tovar_name"]!=""){
            $sql.= " and d_id in (select tovar_d_id from tovar where upper(tovar_name) like '%".iconv('utf-8','cp1251',strtoupper($_POST["tovar_name"]))."%')";
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
            $sql .= " and d_id in (select tovar_d_id from tovar where tovar_proizv = '" . $_POST["proizv_id"] . "')";
        }
        if($_POST["dateBegin"]!="" && $_POST["dateEnd"]!="") {
            $sql .= " and (d_date_add >=str_to_date('" . $_POST["dateBegin"] . "', '%d.%m.%Y %H:%i:%s') and d_date_add <=str_to_date('" . $_POST["dateEnd"] . " 23:59:59', '%d.%m.%Y %H:%i:%s')) ";
        }
        if($_POST["dateCloseBegin"]!="" && $_POST["dateCloseEnd"]!="") {
            $sql .= " and (d_date_close >=str_to_date('" . $_POST["dateCloseBegin"] . "', '%d.%m.%Y %H:%i:%s') and d_date_close <=str_to_date('" . $_POST["dateCloseEnd"] . " 23:59:59', '%d.%m.%Y %H:%i:%s')) ";
        }
        if($_POST["neotr"]=="1") {
            $sql .= " and d_neotr = '" . $_POST["neotr"] . "'";
        }
        $sql.=" group by d_id ";
        $result_count = $mysqli->query($sql);
        $count_rows = $result_count->num_rows;
        $sql.= " ORDER BY dogovor.d_date_add desc, dogovor.d_num desc, dogovor.d_id desc LIMIT ".$start.", ".$perpage."";
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
                "status_name" => iconv( 'cp1251', 'utf-8',$row["status_name"]),
                "d_num" => iconv( 'cp1251', 'utf-8',$row["d_num"]),
                "d_date_add" => iconv( 'cp1251', 'utf-8',$row["d_date_add"]),
                "d_date_close" => iconv( 'cp1251', 'utf-8',$row["d_date_close"]),
                "plata_sum" => iconv( 'cp1251', 'utf-8',$row["plata_sum"]),
                "s_summa" => iconv( 'cp1251', 'utf-8',$row["s_summa"]),
                "spopl_name" => iconv( 'cp1251' , 'utf-8', $row["spopl_name"]),
                "user_fio" => iconv( 'cp1251', 'utf-8',$row["user_fio"]),
                "d_neotr" => iconv( 'cp1251', 'utf-8', $row["d_neotr"]),
                "d_primech_r" => iconv( 'cp1251' , 'utf-8', $row["d_primech_r"]),
                "d_primech_m" => iconv( 'cp1251', 'utf-8', $row["d_primech_m"])
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

    public function getTovar($mysqli, $d_id)
    {
                $sql = "SELECT tovar_d_id, tovar_name, tovar_kolvo, tovar_cost, proizv_name
                FROM tovar
                inner join proizv on tovar.tovar_proizv=proizv.proizv_id 
                WHERE tovar_id is not null and tovar_d_id='".$d_id."' ";
        $sql.= " ORDER BY tovar_cost desc; ";
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
                "tovar_d_id" => iconv( 'cp1251', 'utf-8',$row["tovar_d_id"]),
                "tovar_name" => iconv( 'cp1251', 'utf-8',$row["tovar_name"]),
                "tovar_kolvo" => iconv( 'cp1251', 'utf-8',$row["tovar_kolvo"]),
                "tovar_cost" => iconv( 'cp1251', 'utf-8',$row["tovar_cost"]),
                "proizv_name" => iconv( 'cp1251', 'utf-8',$row["proizv_name"])
            );
            array_push($table, $temp);
        }
        /*$row = $result->fetch_assoc();
        foreach ($row as $rows)
        {
            echo $rows["d_num"];
        }*/
        return array("tovar" => $table);
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
        $sql = "SELECT filial_id, filial_name from filial order by filial_name;";
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
        $sql = "SELECT proizv_id, proizv_name from proizv order by proizv_name;";
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

    public function updateStatus($mysqli, $d_ids, $status_id)
    {
        foreach ($d_ids as $d_id) {
            $sql = "UPDATE dogovor set d_status=".$status_id." where d_id=".$d_id.";";
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

    public function updatePrimM($mysqli, $d_ids, $tovar_primech_magaz)
    {
        foreach ($d_ids as $d_id) {
            $sql = "UPDATE dogovor set d_primech_m='".$tovar_primech_magaz."' where d_id=".$d_id.";";
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

    public function updatePrimU($mysqli, $d_ids, $tovar_primech_ruk)
    {
        foreach ($d_ids as $d_id) {
            //echo $tovar_primech_ruk.$tovar_id;exit;
            $sql = "UPDATE dogovor set d_primech_r='".$tovar_primech_ruk."' where d_id=".$d_id.";";
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

    public function addPlata($mysqli, $d_id, $plata_spopl, $plata_name, $plata_sum, $role)
    {
        $sql = "INSERT INTO plata(plata_d_id, plata_spopl, plata_name, plata_sum, plata_filial) VALUES('".$d_id."', '".$plata_spopl."', '".$plata_name."', '".$plata_sum."', '".$role."');";
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

    public function addNeotrabotka($mysqli, $d_ids){
        foreach ($d_ids as $d_id)
        {
            $sql = "update dogovor set d_neotr=1 where d_id=".$d_id.";";
            if (!$result = $mysqli->query($sql)) {
                echo "Номер_ошибки: " . $mysqli->errno . "\n";
                echo "Ошибка: " . $mysqli->error . "\n";
                exit;
            }
        }
    }
    public function getFilialFullName($mysqli, $filial_id){
        $sql="SELECT filial_fullname from filial where filial_id='".$filial_id."'";
        if (!$result = $mysqli->query($sql)) {
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            echo "Ошибка: " . $mysqli->error . "\n";
            exit;
        }
        else
        {
            $resultFilialname = $result->fetch_assoc();
            return iconv( 'cp1251', 'utf-8',$resultFilialname["filial_fullname"]);
        }
    }
}
?>