<?php
session_start();
$id = $_GET["id"];
$isLogged=0;
if ($_GET["exit"] == 1) {
    $u_log=null;
    $u_pass=null;
    $_SESSION["u_id"]="";
    $_SESSION["u_pass"]="";
}
if (isset($_POST["uid"]) && isset($_POST["upass"]))
{
    $u_log=$_POST["uid"];
    $u_pass=$_POST["upass"];
}
require_once 'data.php';
include 'login.php';

if ($isLogged === 1) {
    if (isset($id) or $_GET["goto"]=="rashodnik" or $_GET["goto"]=="printOtrab") {
        if (isset($id)){
            require_once 'viewid.php';
            $ViewId = new ViewId();
            $info = $ViewId->getSpecif($id, $mysqli);
            include 'view/viewId.php';
        }
        if ($_GET["goto"]=="rashodnik"){
            require_once 'Rashodnik.php';
            if (isset($_POST["dateFrom"]) && $_POST["dateFrom"]!=="") {
                $dateFrom = $_POST["dateFrom"];
            } else {
                $dateFrom = "";
            }
            if (isset($_POST["dateTo"]) && $_POST["dateTo"]!=="") {
                $dateTo = $_POST["dateTo"];
            } else {
                $dateTo = "";
            }
            if (isset($_POST["filial_id"]) && $_POST["filial_id"]!=="") {
                $filial_id = $_POST["filial_id"];
            } else {
                $filial_id = "";
            }
            if (isset($_POST["spopl_id"]) && $_POST["spopl_id"]!=="") {
                $spopl_id = $_POST["spopl_id"];
            } else {
                $spopl_id = "";
            }
            if (isset($_POST["d_num"]) && $_POST["d_num"]!=="") {
                $d_num = iconv('utf-8','cp1251',strtoupper($_POST["d_num"]));
            } else {
                $d_num = "";
            }
            $Rashodnik = new Rashodnik();
            require_once 'main.php';
            $Data = new Main();
            $filial = $Data->getFilial($mysqli);
            $spopl = $Data->getSpopl($mysqli);
            $u_role = $Data->getUserRole($mysqli);

            $filial_fullname = "";
            if ($u_role == "*") {
                if ($_POST["filial_id"] != "") {
                    $filial_fullname = $Data->getFilialFullName($mysqli, $_POST["filial_id"]);
                }
                else  $filial_fullname = "ВСЕ ФИЛИАЛЫ";
            }
            else $filial_fullname=$Data->getFilialFullName($mysqli, $u_role);

            if ($_POST["act"]=="isInsertPlata") {
                if ($_POST["spopl_id_upd"]!=="" && $_POST["plata_name"]!=="" && $_POST["plata_sum"]!==""){
                    $filial = $Data->getUserRole($mysqli);
                    if ($filial=='*') $filial=4;
                    $plata_name = iconv('utf-8','cp1251',$_POST["plata_name"]);
                    $plata_sum=$_POST["plata_sum"];
                    $plata_sum = str_replace("-", "'-'",$plata_sum);
                    $Rashodnik->addPlata($mysqli, $plata_sum, $plata_name, $_POST["spopl_id_upd"],$filial);
                } else echo 'Расход\приход не добавлен. Не были заполнены все поля';
            }

            if ($_POST["act"]=="isUpdatePlataDescr") {
                if ($_POST["plata_name_descr"]!=="" && $_POST["plata_id"]!=="" && isset($_POST["plata_id"])){
                    $plata_name = iconv('utf-8','cp1251',$_POST["plata_name_descr"]);
                    $Rashodnik->setPlataDescr($mysqli, $_POST["plata_id"], $plata_name);
                } else echo 'Информация не добавлена. Не было заполнено поле описания платежа';
            }
            $table=$Rashodnik->getRashodnik($mysqli, $dateFrom, $dateTo, $filial_id, $d_num);
            include 'view/rashodnik.php';
        } else if ($_GET["goto"]=="printOtrab") {
            require_once 'main.php';
            $Data = new Main();
            $filial = $Data->getFilial($mysqli);
            $u_role = $Data->getUserRole($mysqli);

            $filial_fullname = "";
            if ($u_role == "*") {
                if ($_POST["filial_id"] != "") {
                    $filial_fullname = $Data->getFilialFullName($mysqli, $_POST["filial_id"]);
                }
                else  $filial_fullname = "ВСЕ ФИЛИАЛЫ";
            }
            else $filial_fullname=$Data->getFilialFullName($mysqli, $u_role);

            if (isset($_POST["dateFrom"]) && $_POST["dateFrom"]!=="") {
                $dateFrom = $_POST["dateFrom"];
            } else {
                $dateFrom = "";
            }
            if (isset($_POST["dateTo"]) && $_POST["dateTo"]!=="") {
                $dateTo = $_POST["dateTo"];
            } else {
                $dateTo = "";
            }
            if (isset($_POST["filial_id"]) && $_POST["filial_id"]!=="") {
                $filial_id = $_POST["filial_id"];
            } else {
                $filial_id = "";
            }
            require_once 'printOtrab.php';
            $printOtrab = new printOtrab();
            $table = $printOtrab->getOtrab($mysqli, $dateFrom, $dateTo, $u_role);
            $tableNeotrab = $printOtrab->getNeotrab($mysqli, $dateFrom, $dateTo, $u_role);
            include "view/printOtrab.php";
        }
    } else {
        require_once 'main.php';
        $Data = new Main();
        $role = $Data->getUserRole($mysqli);
        if (isset($_POST["act"])) {
            if ($_POST["act"] == "isUpdStatus") {
                if (isset($_POST["d_ids"])) {
                    $Data->updateStatus($mysqli, $_POST["d_ids"], $_POST["status_id_upd"]);
                }
            }
            if ($_POST["act"] == "isUpdPrimM") {
                if (isset($_POST["d_ids"])) {
                    $primech_magaz = iconv('utf-8', 'cp1251', $_POST["tovar_primech_magaz"]);
                    $Data->updatePrimM($mysqli, $_POST["d_ids"], $primech_magaz);
                }
            }

            if ($_POST["act"] == "isUpdPrimU") {
                if (isset($_POST["d_ids"])) {
                    $primech_ruk = iconv('utf-8', 'cp1251', $_POST["tovar_primech_ruk"]);
                    $Data->updatePrimU($mysqli, $_POST["d_ids"], $primech_ruk);
                }
            }

            if ($_POST["act"] == "isAddUser") {
                if (isset($_POST["l_name"]) && isset($_POST["l_role"]) && isset($_POST["l_pass"])) {
                    $primech_ruk = iconv('utf-8', 'cp1251', $_POST["tovar_primech_ruk"]);
                    $Data->addUser($mysqli, $_POST["l_name"], $_POST["l_role"], $_POST["l_pass"]);
                } else echo "Не все поля были заполнены!";
            }

            if ($_POST["act"] == "isUpdPassword") {
                if (isset($_POST["l_pass"]) && isset($_POST["l_newpass"]) && isset($_POST["l_newpass2"])) {
                    $primech_ruk = iconv('utf-8', 'cp1251', $_POST["tovar_primech_ruk"]);
                    $Data->updatePassword($mysqli, $_POST["l_pass"], $_POST["l_newpass"], $_POST["l_newpass2"]);
                } else echo "Не все поля были заполнены!";
            }

            if ($_POST["act"] == "isInsertPlata" && count($_POST["d_ids"])== 1) {
                if (isset($_POST["d_ids"]) && isset($_POST["spopl_id_upd"]) && isset($_POST["plata_name"]) && isset($_POST["plata_sum"])) {
                    $plata_name = iconv('utf-8', 'cp1251', $_POST["plata_name"]);
                    $d_id= $_POST["d_ids"][0];
                    $Data->addPlata($mysqli, $d_id, $_POST["spopl_id_upd"], $plata_name, $_POST["plata_sum"], $role);
                } else {
                    echo 'Произошла ошибка';
                    exit;
                }
            }

            if ($_POST["act"] == "isInsertNeotrabotka" && count($_POST["d_ids"]) > 0) {
                if (isset($_POST["d_ids"])) {
                    $d_id= $_POST["d_ids"];
                    $Data->addNeotrabotka($mysqli, $d_id);
                } else {
                    echo 'Произошла ошибка';
                    exit;
                }
            }
        }

        /*if (isset($_POST["print"]) && $_POST["print"]=="isPrintOtr") {

            if ($_POST["dateCloseBegin"] != "" && $_POST["dateCloseEnd"] != "") {
                if ($u_role == '*') {
                    if ($_POST["filial_id"] != "") {
                        icl
                    } else echo "<script type=\"text/javascript\">alert(\"Для вывода отработки необходимо выбрать филиал\");</script>";
                }
                else
                    echo "<script type=\"text/javascript\">alert(\"хуясе\");</script>";
                } else echo "<script type=\"text/javascript\">alert(\"Для вывода отработки необходимо выбрать даты отработки\");</script>";
        }*/

        if (isset($_POST["page"]) && ($_POST["page"]!=="")){
            $page=$_POST["page"];
        }
        else {
            $page=1;
        }
        $table = $Data->getData($mysqli, $page, $perpage);
        $page_count = ceil($table["count_rows"]/$perpage);
        $status = $Data->getStatus($mysqli);
        $filial = $Data->getFilial($mysqli);
        $proizv = $Data->getProizv($mysqli);
        $spopl = $Data->getSpopl($mysqli);
        $summa=0;
        include 'view/main.php';
    }
}
else
{
    //require_once 'main.php';
    //$Data = new Main();
    //$table = $Data->getData($mysqli);
    include 'view/auth.php';
}
?>