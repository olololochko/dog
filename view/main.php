<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Управление заказами</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/4-col-portfolio.css" rel="stylesheet">
    <link href="css/datepicker.min.css" rel="stylesheet" type="text/css">

</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="img/logo.gif">Управление заказами</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Главная страница
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?goto=rashodnik" >Расходник</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?goto=printOtrab" >Отработка</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/" data-toggle="modal" data-target="#modalChangePass">Изменить пароль</a>
                </li>
                <li class="nav-item" id="btnCreateUser">
                    <a class="nav-link" href="/" data-toggle="modal" data-target="#modalAddUser">Создать уч.запись</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?exit=1">Выход</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div style="white-space: nowrap; margin-top: 10px;">
<div class="form-control" style="width: 250px; margin-left: 10px; display: inline-block; white-space: normal; vertical-align: top;">
    <form name="searchForm" id="searchForm" action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return validate_search ( );">

        <div class="form-group">
            <label for="d_num">№ договора</label>
            <input id="d_num" class="form-control" name="d_num" placeholder="№ договора" value="<? echo $_POST["d_num"]; ?>">
        </div>

        <div class="form-group">
            <label for="d_num">Наименование товара</label>
            <input id="d_num" class="form-control" name="tovar_name" placeholder="Товар" value="<? echo $_POST["tovar_name"]; ?>">
        </div>

        <div class="form-group">
            <label for="status_id">Статус</label>
            <select class="form-control" id="status_id" name="status_id">
                <option value=""></option>
                <?php foreach ($status as $status_row) { ?>
                <option value="<? echo $status_row["status_id"] ?>" <? if ($status_row["status_id"]==$_POST["status_id"]) echo 'selected'; ?>> <? echo $status_row["status_name"] ?> </option>
                <? } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="spopl_id">Оплата</label>
            <select class="form-control" id="spopl_id" name="spopl_id">
                <option value=""></option>
                <?php foreach ($spopl as $spopl_row) { ?>
                    <option value="<? echo $spopl_row["spopl_id"] ?>" <? if ($spopl_row["spopl_id"]==$_POST["spopl_id"]) echo 'selected'; ?>><? echo $spopl_row["spopl_name"] ?></option>
                <? } ?>
            </select>
        </div>

        <div class="form-group" id="blockFilialSearch">
            <label for="filial_id">Филиал</label>
            <select class="form-control" id="filial_id" name="filial_id">
                <option value=""></option>
                <?php foreach ($filial as $filial_row) { ?>
                    <option value="<? echo $filial_row["filial_id"] ?>" <? if ($filial_row["filial_id"]==$_POST["filial_id"]) echo 'selected'; ?>><? echo $filial_row["filial_name"] ?></option>
                <? } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="proizv_id">Произодитель</label>
            <select class="form-control" id="proizv_id" name="proizv_id">
                <option value=""></option>
                <?php foreach ($proizv as $proizv_row) { ?>
                    <option value="<? echo $proizv_row["proizv_id"] ?>" <? if ($proizv_row["proizv_id"]==$_POST["proizv_id"]) echo 'selected'; ?>><? echo $proizv_row["proizv_name"] ?></option>
                <? } ?>
            </select>
        </div>
        <div class="form-row" style="margin-bottom: 5px;">
            <label for="dateBegin">Период оформления</label>
            <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateBegin" value="<? echo $_POST["dateBegin"]; ?>">
            -
            <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateEnd" value="<? echo $_POST["dateEnd"]; ?>">
        </div>
        <div class="form-row" style="margin-bottom: 5px;">
            <label for="dateCloseBegin">Дата отработки (завершения)</label>
            <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateCloseBegin" value="<? echo $_POST["dateCloseBegin"]; ?>">
            -
            <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateCloseEnd" value="<? echo $_POST["dateCloseEnd"]; ?>">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="neotr" name="neotr" value="1" <? if($_POST["neotr"]=="1") echo "checked"; ?>>
            <label class="form-check-label" for="neotr">
                Только неотработка
            </label>
        </div>
        <div class="form-inline" style="float: right;">
            <button class="btn btn-secondary" type="submit">Поиск!</button>
        </div>
    </form>
</div>
<!-- Page Content -->
<div class="form-group" style="display: inline-block; width: calc(100% - 251px); vertical-align: top; margin-left: 20px;">
    <form name="gridForm" id="gridForm" action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"  onsubmit="return validate_check ( );">
        <input id="page" name="page" value="<? echo $_POST["page"] ?>" hidden>
        <div class="btn-group">
                <button type="button" id="btnPrimechU" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalPrimU">Изм. примеч. Р</button>
                <button type="button" id="btnPrimechM" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalPrimM">Изм. примеч. М</button>
                <button type="button" id="btnStatus" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalStat">Изм. статус</button>
                <button type="button" id="btnNeotr" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalNeotr" onclick="getDogToNeotr()">В неотработку</button>
        </div>
    <table class="table-sm table-hover" style="width: calc(100% - 251px);">
    <thead>
    <tr>
        <th>  </th>
        <th><input type="checkbox" class="form-check-input" id="checkAll">№</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Оформил</th>
        <th>Прим. рук-ва</th>
        <th>Прим. магаз.</th>
        <th>Сп.Оплаты</th>
        <th>Оплачено</th>
        <th>Сумма</th>
        <th>Взнос</th>
    </tr>
    </thead>
    <?php foreach ($table["data"] as $curow) { ?>
        <tbody class="<? if ($curow["d_neotr"] == 1) echo 'table-danger'; else if ($curow["d_date_close"] !== "") echo 'table-success'; else echo 'table-default'; ?>">
    <tr>
        <td> * </td>
        <td><input type="checkbox" class="form-check-input" name="d_ids[]" id="<? echo $curow["d_id"]; ?>" value="<? echo $curow["d_id"]; ?>" title="<? echo $curow["d_num"]; ?>"><a href="index.php?id=<? echo $curow["d_id"]; ?>"> <? echo $curow["d_num"]; ?> </a></td>
        <td><? echo $curow["status_name"]; ?></td>
        <td><? echo $curow["d_date_add"]; ?></td>
        <td><? echo $curow["user_fio"]; ?></td>
        <td><? echo $curow["d_primech_r"]; ?></td>
        <td><? echo $curow["d_primech_m"]; ?></td>
        <td><? echo $curow["spopl_name"]; ?></td>
        <td><? echo $curow["plata_sum"]; ?></td>
        <td><? echo $curow["s_summa"]; ?></td>
        <td><button type="button" class="btn btn-primary btn-sm" name="insertPlata" data-toggle="modal" data-target="#modalPlata" id="btnPlata" onclick="selectCurr(<? echo $curow["d_id"]; ?>);" <? if ($role=='*') echo 'disabled'; ?>>+</button></td>
    </tr>
    <?
    $tovars = $Data->getTovar($mysqli, $curow["d_id"]);
    foreach ($tovars["tovar"] as $tovar) { ?>
    <tr>
        <td></td><td></td>
        <td colspan="9"><? echo $tovar["tovar_name"].'('.$tovar["proizv_name"].') = '.$tovar["tovar_cost"].'р.('.$tovar["tovar_kolvo"].')'; ?></td>
    </tr>
    <? } ?>
    </tbody>
        <? }?>
</table>

    <!-- Pagination -->
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <? for ($i=1; $i<=$page_count; $i++) { ?>
            <li class="page-item">
                <button class="page-link" name="page" value="<? echo $i; ?>" form="searchForm" onclick="document.getElementById('searchForm').submit()"><? echo $i; ?></button>
            </li>
        <? } ?>
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
    <!-- /.container -->
</div>
</div>
<!-- /.row -->

<!-- /.modal windows -->
<div class="modal fade" id="modalStat" tabindex="-1" role="dialog" aria-labelledby="modalStat" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Выберите статус</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="status_id">Статус</label>
                    <select class="form-control" id="status_id_upd" name="status_id_upd">
                        <?php foreach ($status as $status_row) { ?>
                            <option value="<? echo $status_row["status_id"] ?>"><? echo $status_row["status_name"] ?></option>
                        <? } ?>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isUpdStatus">Изменить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPrimM" tabindex="-1" role="dialog" aria-labelledby="modalPrimM" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Введите примечание</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tovar_primech_magaz">Примечание магазина</label>
                    <input id="tovar_primech_magaz" class="form-control" name="tovar_primech_magaz" placeholder="Введите значение">
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isUpdPrimM">Изменить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPrimU" tabindex="-1" role="dialog" aria-labelledby="modalPrimU" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Введите примечание</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tovar_primech_ruk">Примечание управляющего</label>
                    <input id="tovar_primech_ruk" class="form-control" name="tovar_primech_ruk" placeholder="Введите значение">
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isUpdPrimU">Изменить</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPlata" tabindex="-1" role="dialog" aria-labelledby="modalPlata" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Введите оплату</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="status_id">Способ оплаты</label>
                    <select class="form-control" id="spopl_id_upd" name="spopl_id_upd">
                        <?php foreach ($spopl as $spopl_row) { ?>
                            <option value="<? echo $spopl_row["spopl_id"] ?>"><? echo $spopl_row["spopl_name"] ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Наименование платы</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Остаток\Взнос рассрочка\..." name="plata_name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Сумма</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="руб." name="plata_sum">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isInsertPlata">Добавить плату</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNeotr" tabindex="-1" role="dialog" aria-labelledby="modalNeotr" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить выбранные договора в неотработку?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Наименование платы</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Не выбраны договора для добавления в неотработку!" name="neotrDog" id="neotrDog" disabled>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isInsertNeotrabotka">Добавить в неотработку</button>
            </div>
        </div>
    </div>
</div>

</form>

<!-- modal change pass and create user -->

<div class="modal fade" id="modalChangePass" tabindex="-1" role="dialog" aria-labelledby="modalChangePass" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Изменение пароля</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<? echo $_SERVER['REQUEST_URI']; ?>" role="form" method="POST">
                <div class="form-group">
                    <label for="inputPassword3" class="control-label">Старый пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Пароль" name="l_pass" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="control-label">Новый пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Пароль" name="l_newpass" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="control-label">Повторите новый пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Повторите ароль" name="l_newpass2" required>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isUpdPassword">Изменить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="modalAddUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление нового пользователя</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<? echo $_SERVER['REQUEST_URI']; ?>" role="form" method="POST">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Имя пользователя</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Введите логин" name="l_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <label for="filial_id">Филиал</label>
                                <select class="form-control" id="l_role" name="l_role" required>
                                    <option value="*">Управляющий</option>
                                    <?php foreach ($filial as $filial_row) { ?>
                                        <option value="<? echo $filial_row["filial_id"] ?>"><? echo $filial_row["filial_name"] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="Пароль" name="l_pass" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary" type="submit" name="act" value="isAddUser">Добавить!</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
    </div>
    <!-- /.container -->
</footer>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/datepicker.min.js"></script>
<script>
    $("#checkAll").click(function () {
        $(".form-check-input").prop('checked', $(this).prop('checked'));
    });

    $('#modalPlata').on('hidden.bs.modal', function () {
        $(".form-check-input").prop('checked', false);
    });

</script>
<script type="text/javascript">
    function validate_search ( )
    {
        valid = true;
        if ( (document.searchForm.dateBegin.value !== "" && document.searchForm.dateEnd.value == "") || (document.searchForm.dateBegin.value == "" && document.searchForm.dateEnd.value !== "") )
        {
            alert ( "Не могли бы вы соизволить заполнить оба поля периода дат?" );
            valid = false;
        }
        return valid;
    }
</script>
<script type="text/javascript">
    function validate_check ( ) {
        valid = true;
        if ($('#gridForm :checkbox:checked').length > 0) {
            valid = true;
        }
        else {
            alert ( "Уважаемый(ая)! Пожалуйста, выберите позиции, по отношению к которым вы хотите произвести изменения" );
            valid = false;
        }
        return valid;
    }

    function selectCurr(d_id){
        $(".form-check-input").prop('checked', false);
        $(".form-check-input#"+d_id+"").prop('checked', true);
    }

    function getDogToNeotr() {
        var checkboxes = document.getElementsByClassName('form-check-input');
        var selectedCheckboxes ="В неотработку ";
        var count=0;
        for (var index = 0; index < checkboxes.length; index++) {
            if (checkboxes[index].checked) {
                selectedCheckboxes += checkboxes[index].title+", "; // положим в массив выбранный
                count++;
            }
        }
        if (count > 0) {
            $("#neotrDog").prop('value', selectedCheckboxes.substr(0, selectedCheckboxes.length - 2) + "?");
        } else {
            $("#neotrDog").prop('value', "Не выбраны договора!");
        }
    }
</script>

<script>
    var role = '<? echo $role; ?>';
    if (role == '*') {
        //document.getElementById("blockFilialSearch").className = "d-block";
        document.getElementById("btnPrimechM").className = "d-none";
        //document.getElementById("btnPrimechU").className = "d-block";
        //document.getElementById("btnCreateUser").className = "d-block";
        //document.getElementById("btnDelete").className = "d-block";
    } else
    {
        document.getElementById("blockFilialSearch").className="d-none";
        //document.getElementById("btnPrimechM").className = "d-block";
        document.getElementById("btnPrimechU").className = "d-none";
        document.getElementById("btnCreateUser").className = "d-none";
        document.getElementById("btnDelete").className = "d-none";
    }
</script>

</body>

</html>