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
    if (isset($id)) {
        require_once 'viewid.php';
        $ViewId = new ViewId();
        $info = $ViewId->getSpecif($id, $mysqli);
        include 'view/viewId.php';
    } else {
        require_once 'main.php';
        $Data = new Main();
        $role = $Data->getUserRole($mysqli);
        if (isset($_POST["act"])) {
            if ($_POST["act"] == "isUpdStatus") {
                if (isset($_POST["tovar_ids"])) {
                    $Data->updateStatus($mysqli, $_POST["tovar_ids"], $_POST["status_id_upd"]);
                }
            }
            if ($_POST["act"] == "isUpdPrimM") {
                if (isset($_POST["tovar_ids"])) {
                    $primech_magaz = iconv('utf-8', 'cp1251', $_POST["tovar_primech_magaz"]);
                    $Data->updatePrimM($mysqli, $_POST["tovar_ids"], $primech_magaz);
                }
            }

            if ($_POST["act"] == "isUpdPrimU") {
                if (isset($_POST["tovar_ids"])) {
                    $primech_ruk = iconv('utf-8', 'cp1251', $_POST["tovar_primech_ruk"]);
                    $Data->updatePrimU($mysqli, $_POST["tovar_ids"], $primech_ruk);
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
        }

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