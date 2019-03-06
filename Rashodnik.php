<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.11.2018
 * Time: 1:24
 */
class Rashodnik
{
    function __construct()
    {

    }

    public function getRashodnik($mysqli, $dateFrom, $dateTo, $filial, $d_num){
        $sql = "SELECT plata_id, plata_sum, plata_spopl, plata_name, plata_sum_zakaz, d_num, date_format(plata_date, '%d.%m.%y') plata_date2, d_id, s_vitrvyst, s_credit_org, s_credit_sum, d_client_family, s_cena_skidka 
        from plata left join dogovor on plata_d_id=d_id 
        inner join spopl on plata_spopl=spopl_id 
        inner join filial on plata_filial=filial_id where plata_id is not null ";
        if ($dateFrom!=="" && $dateTo!==""){
            $sql .= " and (plata_date >=str_to_date('" . $dateFrom . "', '%d.%m.%Y %H:%i:%s') and plata_date <=str_to_date('" . $dateTo . " 23:59:59', '%d.%m.%Y %H:%i:%s')) ";
        }
        if ($filial!==""){
            $sql .= " and plata_filial = '" . $filial . "'";
        }
        if ($d_num!==""){
            $sql .= " and upper(d_num) like '%" . $d_num. "%'";
        }
        $sql.= " order by plata_date desc";
        if (!$result = $mysqli->query($sql)) {
            // О нет! запрос не удался.
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
        $table = array();
        while ($row = $result->fetch_assoc()) {
           /*добавление остатка в кассе по итогам каждого дня*/
            if (!isset($currDate)){
                $currDate = iconv( 'cp1251', 'utf-8',$row["plata_date2"]);
                array_push($table, $this->getKassaSum($mysqli, $currDate, $filial));

            }
            if (date_parse_from_format("d.m.y", $currDate) > date_parse_from_format("d.m.y", iconv( 'cp1251', 'utf-8',$row["plata_date2"]))) {
                array_push($table, $this->getKassaSum($mysqli, iconv( 'cp1251', 'utf-8',$row["plata_date2"]), $filial));
            }
            $currDate = iconv( 'cp1251', 'utf-8',$row["plata_date2"]);

           /*Добавление наименований товара по договору*/
            $tovar_list="";
            $sqlTovar = "select tovar_name, tovar_kolvo from tovar where tovar_d_id='".$row["d_id"]."'";
            if (!$getTovar = $mysqli->query($sqlTovar)){
                echo "Ошибка при заполнении договора товарами" . $mysqli->error . "\n";
            } else{
                while ($tovar = $getTovar->fetch_assoc()){
                    $tovar_list .= $tovar["tovar_name"]."(".$tovar["tovar_kolvo"]."), ";
                }
                $tovar_list = rtrim($tovar_list, ", ");
            }

            /*колонка Наименование товара*/
            $plata_name = iconv( 'cp1251', 'utf-8',$row["plata_name"].' '.$tovar_list);
                if (iconv( 'cp1251', 'utf-8',$row["s_vitrvyst"])==163)
                    $plata_name.="<b>(Витрина)</b>";
                if (iconv( 'cp1251', 'utf-8',$row["s_credit_sum"]) > 0)
                    $plata_name.=" <b>(Кредит ".iconv( 'cp1251', 'utf-8',$row["d_client_family"])." ".iconv( 'cp1251', 'utf-8',$row["s_credit_org"])." ".iconv( 'cp1251', 'utf-8',$row["s_credit_sum"])."р.)</b>";
                if (iconv( 'cp1251', 'utf-8',$row["s_cena_skidka"]) > 0)
                    $plata_name.=" <b>(Скидка ".iconv( 'cp1251', 'utf-8',$row["s_cena_skidka"])."р.)</b>";

            /*колонка Предоплата*/
            $plata_sum="-";
            if (iconv( 'cp1251', 'utf-8',$row["plata_spopl"])==80) {
                $plata_sum = iconv('cp1251', 'utf-8', $row["plata_sum"]) . "<br />(терминал)";
                $plata_name .= " ".iconv('cp1251', 'utf-8', $row["d_client_family"]);
            }
            else
            {
                if (iconv( 'cp1251', 'utf-8',$row["plata_spopl"])==79)
                    $plata_sum=iconv( 'cp1251', 'utf-8',$row["plata_sum"]);
                else $plata_sum="-";
            }

            $temp = array(
                "plata_id" => iconv( 'cp1251', 'utf-8',$row["plata_id"]),
                "plata_sum" => $plata_sum,
                "plata_spopl" => iconv( 'cp1251', 'utf-8',$row["plata_spopl"]),
                "plata_name" => $plata_name,
                "plata_date" => iconv( 'cp1251', 'utf-8',$row["plata_date2"]),
                "plata_sum_zakaz" => iconv( 'cp1251', 'utf-8',$row["plata_sum_zakaz"]),
                "d_num" => iconv( 'cp1251', 'utf-8',$row["d_num"])
            );
            array_push($table, $temp);
        }
        //$kassaSummTable = $this->getKassaSum($mysqli, $dateTo, $filial);
        //echo var_dump($kassaSummTable);
        return array("rashodnik" => $table);
    }

    public function addPlata($mysqli, $plata_sum, $plata_name, $plata_spopl,$plata_filial){
        $sql = "INSERT INTO plata(plata_sum, plata_name, plata_spopl, plata_filial) VALUES('".$plata_sum."','".$plata_name."', '".$plata_spopl."', '".$plata_filial."');";
        if (!$result = $mysqli->query($sql)) {
            echo "Ошибка: " . $mysqli->error . "\n";
        }
    }

    public function setPlataDescr($mysqli, $plata_id, $plata_name){
        $sql = "UPDATE plata set plata_name = concat(plata_name, ' ".$plata_name."') where plata_id=".$plata_id.";";
        if (!$result = $mysqli->query($sql)) {
            echo "Ошибка: " . $mysqli->error . "\n";
        }
    }

    private function getKassaSum($mysqli, $dateTo, $filial){
        $sql = "SELECT sum(plata_sum) plata_sum
        from plata left join dogovor on plata_d_id=d_id 
        inner join spopl on plata_spopl=spopl_id 
        inner join filial on plata_filial=filial_id where plata_spopl=79 ";
        if ($dateTo!==""){
            $sql .= " and ( plata_date <=str_to_date('" . $dateTo . " 23:59:59', '%d.%m.%Y %H:%i:%s')) ";
        }
        //else echo "Произошла ошибка!";
        if ($filial!==""){
            $sql .= " and plata_filial = '" . $filial . "'";
        }
        $sql.= "order by plata_date desc";
        if (!$result = $mysqli->query($sql)) {
            // О нет! запрос не удался.
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
        $table = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array(
                "plata_id" => "0",
                "plata_sum" => "<b><i>".iconv( 'cp1251', 'utf-8',$row["plata_sum"])."</b></i>",
                "plata_spopl" => "-",
                "plata_name" => "<b><i>"."В Кассе"."</b></i>",
                "plata_date" => "<b><i>".$dateTo."</b></i>",
                "plata_sum_zakaz" => "-",
                "d_num" => "-"
            );
            array_push($table, $temp);
        }
        return $temp;
    }
}
?>