<?php
class printOtrab
{
    public function getOtrab($mysqli, $dateFrom, $dateTo, $u_role)
    {
        //$u_role=$this->getUserRole($mysqli);
        $sql = "SELECT d_id, status_name, d_num, date_format(d_date_add, '%d.%m.%y') d_date_add, d_date_close, d_neotr, user_fio, d_primech_r, d_primech_m, s_sum_predopl, s_summa, vv_name, spopl_name, sum(plata_sum)+s_credit_sum plata_sum, s_credit_org, s_credit_sum 
                FROM dogovor 
                inner join filial on dogovor.d_filial=filial.filial_id 
                inner join plata on dogovor.d_id=plata.plata_d_id 
                inner join user on dogovor.d_user_id=user.user_id 
                inner join spopl on dogovor.s_spopl=spopl.spopl_id 
                inner join vitrvyst on dogovor.s_vitrvyst=vitrvyst.vv_id 
                left join status on dogovor.d_status=status.status_id  
                WHERE d_date_close is not null ";//d_date_close is not null
        if ($u_role =='*') {
            if ($_POST["filial_id"] != "") {
                $sql .= " and filial_id = '" . $_POST["filial_id"] . "'";
            }
        } else {
            $sql .= " and filial_id = '" . $u_role . "'";
        }
        if($dateFrom!="" && $dateTo!="") {
            $sql .= " and (d_date_close >=str_to_date('" . $dateFrom . "', '%d.%m.%Y %H:%i:%s') and d_date_close <=str_to_date('" . $dateTo . " 23:59:59', '%d.%m.%Y %H:%i:%s')) ";
        }
        /*if($_POST["neotr"]=="1") {
            $sql .= " and d_neotr = '" . $_POST["neotr"] . "'";
        }*/
        $sql.=" group by d_id ";
        $sql.= " ORDER BY dogovor.d_date_close desc ";

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
            if (iconv( 'cp1251', 'utf-8', $row["s_credit_sum"]) > 0)
                $s_credit=iconv( 'cp1251', 'utf-8', $row["s_credit_org"])."(".iconv( 'cp1251', 'utf-8', $row["s_credit_sum"])."р.)";
            else
                $s_credit = "";

            $ostatok = iconv( 'cp1251', 'utf-8',$row["s_summa"])-iconv( 'cp1251', 'utf-8',$row["plata_sum"]);

            $temp = array(
                "d_id" => iconv( 'cp1251', 'utf-8',$row["d_id"]),
                "d_num" => iconv( 'cp1251', 'utf-8',$row["d_num"]),
                "d_date_add" => iconv( 'cp1251', 'utf-8',$row["d_date_add"]),
                "status_name" => iconv( 'cp1251', 'utf-8',$row["status_name"]),
                "d_date_close" => iconv( 'cp1251', 'utf-8',$row["d_date_close"]),
                "plata_sum" => iconv( 'cp1251', 'utf-8',$row["plata_sum"]),
                "s_summa" => iconv( 'cp1251', 'utf-8',$row["s_summa"]),
                "spopl_name" => iconv( 'cp1251' , 'utf-8', $row["spopl_name"]),
                "user_fio" => iconv( 'cp1251', 'utf-8',$row["user_fio"]),
                "d_neotr" => iconv( 'cp1251', 'utf-8', $row["d_neotr"]),
                "d_primech_r" => iconv( 'cp1251' , 'utf-8', $row["d_primech_r"]),
                "d_primech_m" => iconv( 'cp1251', 'utf-8', $row["d_primech_m"]),
                "s_credit" => $s_credit,
                "s_ostatok" => $ostatok
            );
            array_push($table, $temp);
        }
        return array("otrabotka" => $table);
    }

    public function getNeotrab($mysqli, $dateFrom, $dateTo, $u_role)
    {
        //$u_role=$this->getUserRole($mysqli);
        $sql = "SELECT d_id, status_name, d_num, date_format(d_date_add, '%d.%m.%y') d_date_add, d_date_close, d_neotr, user_fio, d_primech_r, d_primech_m, s_sum_predopl, s_summa, vv_name, spopl_name, sum(plata_sum)+s_credit_sum plata_sum, s_credit_org, s_credit_sum 
                FROM dogovor 
                inner join filial on dogovor.d_filial=filial.filial_id 
                inner join plata on dogovor.d_id=plata.plata_d_id 
                inner join user on dogovor.d_user_id=user.user_id 
                inner join spopl on dogovor.s_spopl=spopl.spopl_id 
                inner join vitrvyst on dogovor.s_vitrvyst=vitrvyst.vv_id 
                left join status on dogovor.d_status=status.status_id  
                WHERE d_neotr=1 ";//d_date_close is not null
        if ($u_role =='*') {
            if ($_POST["filial_id"] != "") {
                $sql .= " and filial_id = '" . $_POST["filial_id"] . "'";
            }
        } else {
            $sql .= " and filial_id = '" . $u_role . "'";
        }
        $sql.=" group by d_id ";
        $sql.= " ORDER BY dogovor.d_date_close desc ";

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
            if (iconv( 'cp1251', 'utf-8', $row["s_credit_sum"]) > 0)
                $s_credit=iconv( 'cp1251', 'utf-8', $row["s_credit_org"])."(".iconv( 'cp1251', 'utf-8', $row["s_credit_sum"])."р.)";
            else
                $s_credit = "";

            $ostatok = iconv( 'cp1251', 'utf-8',$row["s_summa"])-iconv( 'cp1251', 'utf-8',$row["plata_sum"]);

            $temp = array(
                "d_id" => iconv( 'cp1251', 'utf-8',$row["d_id"]),
                "d_num" => iconv( 'cp1251', 'utf-8',$row["d_num"]),
                "d_date_add" => iconv( 'cp1251', 'utf-8',$row["d_date_add"]),
                "status_name" => iconv( 'cp1251', 'utf-8',$row["status_name"]),
                "d_date_close" => iconv( 'cp1251', 'utf-8',$row["d_date_close"]),
                "plata_sum" => iconv( 'cp1251', 'utf-8',$row["plata_sum"]),
                "s_summa" => iconv( 'cp1251', 'utf-8',$row["s_summa"]),
                "spopl_name" => iconv( 'cp1251' , 'utf-8', $row["spopl_name"]),
                "user_fio" => iconv( 'cp1251', 'utf-8',$row["user_fio"]),
                "d_neotr" => iconv( 'cp1251', 'utf-8', $row["d_neotr"]),
                "d_primech_r" => iconv( 'cp1251' , 'utf-8', $row["d_primech_r"]),
                "d_primech_m" => iconv( 'cp1251', 'utf-8', $row["d_primech_m"]),
                "s_credit" => $s_credit,
                "s_ostatok" => $ostatok
            );
            array_push($table, $temp);
        }
        return array("neotrabotka" => $table);
    }
}