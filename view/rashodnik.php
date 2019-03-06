<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Расходник</title>

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
        <a class="navbar-brand" href="#"><img src="img/logo.gif">Расходник</a>
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


            <div class="form-group" id="blockFilialSearch">
                <label for="filial_id">Филиал</label>
                <select class="form-control" id="filial_id" name="filial_id">
                    <option value=""></option>
                    <?php foreach ($filial as $filial_row) { ?>
                        <option value="<? echo $filial_row["filial_id"] ?>" <? if ($filial_row["filial_id"]==$_POST["filial_id"]) echo 'selected'; ?>><? echo $filial_row["filial_name"] ?></option>
                    <? } ?>
                </select>
            </div>

            <div class="form-row" style="margin-bottom: 5px;">
                <label for="dateBegin">Период добавления</label>
                <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateFrom" value="<? echo $_POST["dateFrom"]; ?>">
                -
                <input type="text" class="datepicker-here custom-select small" style="width: 110px;" name="dateTo" value="<? echo $_POST["dateTo"]; ?>">
            </div>
            <div class="form-inline" style="float: right;">
                <button class="btn btn-secondary" type="submit">Поиск!</button>
            </div>
        </form>
    </div>
    <!-- Page Content -->
    <div class="form-group" style="display: inline-block; width: calc(100% - 251px); vertical-align: top; margin-left: 20px;">
        <form name="gridForm" id="gridForm" action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"  onsubmit="return validate_check ( );">
            <div class="form-group" id="captionRashodnik">
                <h3 class="h3"><?echo $filial_fullname; ?></h3>
                <h3 class="h3"><?echo $dateFrom." - ".$dateTo; ?></h3>
                <h3 class="h3">РАСХОД-ПРИХОД</h3>
            </div>
            <div class="btn-group">
                <button type="button" id="btnAddSum" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddSum">Добавить приход\расход</button>
                <button id="btnExport" class="btn btn-dark btn-sm" onclick="fnExcelReport();">Экспрот в Excel </button>
            </div>
            <table border="1" id="tblRashodnik" style="width:768px; white-space: normal; border-collapse: collapse; border: 1px solid black;">
                <thead>
                <tr style="text-align: center;">
                    <th style="width: 85px;">ПРЕД ОПЛАТА</th>
                    <th style="width: 400px;">НАИМЕНОВАНИЕ</th>
                    <th style="width: 73px;">№ Договора</th>
                    <th style="width: 70px;">ДАТА</th>
                    <th style="width: 90px;">СУММА</th>
                    <th style="width: 50px;"></th>
                </tr>
                </thead>
                <?php foreach ($table["rashodnik"] as $curow) { ?>
                    <tr>
                        <td style="width: 85px; text-align: center;"><? echo $curow["plata_sum"]; ?></td>
                        <td style="width: 400px; white-space: normal;"><? echo $curow["plata_name"]; ?></td>
                        <td style="width: 73px;"><? echo $curow["d_num"]; ?></td>
                        <td style="width: 70px; text-align: center;"><? echo $curow["plata_date"]; ?></td>
                        <td style="width: 90px; text-align: center;"><? echo $curow["plata_sum_zakaz"]; ?></td>
                        <td style="width: 50px;"><button type="button" class="btn btn-primary btn-sm" name="btnAddDescr" data-toggle="modal" data-target="#modalAddDescr" onclick="setPlataId(<? echo $curow["plata_id"]; ?>);">+</button></td>
                    </tr>
                <? }?>
            </table>
            <!-- /.container -->
    </div>
</div>
<!-- /.row -->

<!-- /.modal windows -->
<div class="modal fade" id="modalAddSum" tabindex="-1" role="dialog" aria-labelledby="modalAddSum" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Введите приход\расход</h5>
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

<div class="modal fade" id="modalAddDescr" tabindex="-1" role="dialog" aria-labelledby="modalAddSum" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Введите информацию для поля "Наименование товара"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Информация</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Остаток\Взнос рассрочка\..." name="plata_name_descr">
                        <input type="text" class="form-control" id="plataId" name="plata_id" hidden>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="act" value="isUpdatePlataDescr">Добавить инф. к платежу</button>
            </div>
        </div>
    </div>
</div>

</form>
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
    var role = '<? echo $u_role; ?>';
    if (role == '*') {
        document.getElementById("blockFilialSearch").className = "d-block";
    } else
    {
        document.getElementById("blockFilialSearch").className="d-none";
    }
</script>

<script>
function setPlataId(id) {
var input= document.getElementById("plataId");
input.value = id;
}

function fnExcelReport()
{
    var caption = document.getElementById('captionRashodnik');
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    tab_text = tab_text+caption.innerHTML;
    var textRange; var j=0;
    tab = document.getElementById('tblRashodnik'); // id of table
    for(j = 0 ; j < tab.rows.length ; j++)
    {
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
    tab_text= tab_text.replace(/<button[^>]*>|<\/input>/gi, ""); // reomves button params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);
}
</script>

</body>

</html>