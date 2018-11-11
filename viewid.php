<?php
Class ViewId
{
    public function getSpecif($id, $mysqli)
    {
        $sql = "SELECT * FROM dogovor where dogovor.d_id=".$id;
        $sql2 = "SELECT * from tovar where tovar_d_id=".$id;
        if (!$result = $mysqli->query($sql)) {
            // О нет! запрос не удался.
            echo "Извините, возникла проблема в работе сайта.";

            // И снова: не делайте этого на реальном сайте, но в этом примере мы покажем,
            // как получить информацию об ошибке:
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            exit;
        }

        if (!$result2 = $mysqli->query($sql2)){
            echo "Извините, возникла проблема в работе сайта.";
            echo "Ошибка: Наш запрос не удался и вот почему: \n";
            echo "Номер_ошибки: " . $mysqli->errno . "\n";
            exit;
        }

        if (!$result2->num_rows === 0){
            echo "Извините, возникла проблема в работе сайта. Не найден товар для данной позиции";
            exit;
        }

        if ($result->num_rows === 1) {
            $tovar="";
            while ($row2 = $result2->fetch_assoc()) {
                $tovar .= $row2["tovar_name"].'('.$row2["tovar_cost"].'*'.$row2["tovar_kolvo"].'), ';
            }
            while ($row = $result->fetch_assoc()) {
                $info = array(
                    "d_num" => iconv( 'cp1251', 'utf-8',$row["d_num"]),
                    "d_date_add" => iconv( 'cp1251', 'utf-8',$row["d_date_add"]),
                    "tovar_name" => iconv( 'cp1251', 'utf-8',rtrim($tovar,", ")),
                    "s_osnova" => iconv( 'cp1251', 'utf-8',$row["s_osnova"]),
                    "s_podbor" => iconv( 'cp1251', 'utf-8',$row["s_podbor"]),
                    "s_3tkan" => iconv( 'cp1251', 'utf-8',$row["s_3tkan"]),
                    "s_primech" => iconv( 'cp1251', 'utf-8',$row["s_primech"]),
                    "s_cena_meb" => iconv( 'cp1251', 'utf-8',$row["s_cena_meb"]),
                    "s_cena_tkan" => iconv( 'cp1251', 'utf-8',$row["s_cena_tkan"]),
                    "s_cena_karkas" => iconv( 'cp1251', 'utf-8',$row["s_cena_karkas"]),
                    "s_cena_skidka" => iconv( 'cp1251', 'utf-8',$row["s_cena_skidka"]),
                    "s_sum_predopl" => iconv( 'cp1251', 'utf-8',$row["s_sum_predopl"]),
                    "s_dost_date" => iconv( 'cp1251', 'utf-8',$row["s_dost_date"]),
                    "s_dost_stoim" => iconv( 'cp1251', 'utf-8',$row["s_dost_stoim"]),
                    "s_dost_cost_etaj" => iconv( 'cp1251', 'utf-8',$row["s_dost_cost_etaj"]),
                    "s_summa" => iconv( 'cp1251', 'utf-8',$row["s_summa"]),
                    "s_spopl" => iconv( 'cp1251', 'utf-8',$row["s_spopl"]),
                    "s_vitrvyst" => iconv( 'cp1251', 'utf-8',$row["s_vitrvyst"])//,
                    //"d_phone" => iconv( 'cp1251', 'utf-8',$row["d_phone"], ENT_QUOTES, "cp1251")
                );
                //array_push($info, $temp);
                //echo $info["d_num"];
            }
        } else {
            echo "Мы не смогли найти совпадение. Пожалуйста, попробуйте еще раз.";
            exit;
        }
        //$info = array();
        return $info;
    }
}