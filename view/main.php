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
            <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateBegin">
            -
            <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateEnd">
        </div>
        <div class="form-inline" style="float: right;">
            <button class="btn btn-secondary" type="submit">Поиск!</button>
        </div>
    </form>
</div>
<!-- Page Content -->
<div class="form-group" style="display: inline-block; width: calc(100% - 251px); vertical-align: top; margin-left: 20px;">
    <form name="gridForm" id="gridForm" action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"  onsubmit="return validate_check ( );">
        <div class="btn-group">
                <button type="button" id="btnPrimechU" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalPrimU">Изм. примеч. Р</button>
                <button type="button" id="btnPrimechM" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalPrimM">Изм. примеч. М</button>
                <button type="button" id="btnStatus" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalStat">Изм. статус</button>
                <button type="button" id="btnDelete" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDel">Удалить</button>
        </div>
    <table class="table table-hover" style="width: calc(100% - 251px);">
    <thead>
    <tr>
        <th>  </th>
        <th><input type="checkbox" class="form-check-input" id="checkAll">№</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Наименование товара</th>
        <th>Производитель</th>
        <th>Прим. рук-ва</th>
        <th>Прим. магаз.</th>
        <th>Цена(шт.)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($table["data"] as $curow) { ?>
    <tr>
        <td>  </td>
        <td><input type="checkbox" class="form-check-input" name="tovar_ids[]" id="<? echo $curow["tovar_id"]; ?>" value="<? echo $curow["tovar_id"]; ?>"><a href="index.php?id=<? echo $curow["d_id"]; ?>"> <? echo $curow["d_num"]; ?> </a></td>
        <td><? echo $curow["status_name"]; ?></td>
        <td><? echo $curow["d_date_add"]; ?></td>
        <td><? echo $curow["tovar_name"]; ?></td>
        <td><? echo $curow["tovar_proizv"]; ?></td>
        <td><? echo $curow["tovar_primech_ruk"]; ?></td>
        <td><? echo $curow["tovar_primech_magaz"]; ?></td>
        <td><? echo $curow["tovar_cost"].'('.$curow["tovar_kolvo"].')'; ?></td>
        <? $summa = $summa+($curow["tovar_cost"]*$curow["tovar_kolvo"]) ?>
    </tr>
    <?}?>
    </tbody>
</table>
        <div class="text-xl-right">
            Сумма: <? echo $summa ?>
        </div>

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