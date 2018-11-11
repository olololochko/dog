<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Просмотр договора № <? echo $info["d_num"]; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/4-col-portfolio.css" rel="stylesheet">

    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border:none;border-color:#ccc;align-self:center}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:4px 20px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:4px 20px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
        .tg .tg-6uvz{background-color:#ffffff;color:#000000;border-color:#ffffff;text-align:center;vertical-align:top}
        .tg .tg-up7l{background-color:#ffffff;color:#000000;border-color:#ffffff;vertical-align:top}
        .tg .tg-baqh{text-align:center;vertical-align:top}
        .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
        .tg .tg-us36{border-color:inherit;vertical-align:top}
        .tg .tg-yw4l{vertical-align:top}
    </style>

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
            </ul>
        </div>
    </div>
</nav>


<table class="tg" align="center">
    <tr>
        <th class="tg-6uvz" colspan="6"><br />К договору №<? echo $info["d_num"].' '. date("d.m.Y", strtotime($info["d_date_add"])); ?><br></th>
    </tr>
    <tr>
        <td class="tg-up7l">Модель<br></td>
        <td class="tg-up7l" colspan="5"><? echo $info["tovar_name"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l">Основа</td>
        <td class="tg-up7l" colspan="5"><? echo $info["s_osnova"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l">Подбор</td>
        <td class="tg-up7l" colspan="5"><? echo $info["s_podbor"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l">3-я ткань</td>
        <td class="tg-up7l" colspan="5"><? echo $info["s_3tkan"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l">Примечание</td>
        <td class="tg-up7l" colspan="5"><? echo $info["s_primech"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l" colspan="2"><br />Цена (только за мебель)</td>
        <td class="tg-6uvz"><br /><? echo $info["s_cena_meb"]; ?></td>
        <td class="tg-us36" colspan="2"><br />Не стандарт ткани</td>
        <td class="tg-c3ow"><br /><? echo $info["s_cena_tkan"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l" colspan="2">Не стандарт каркас</td>
        <td class="tg-6uvz"><? echo $info["s_cena_karkas"]; ?></td>
        <td class="tg-us36" colspan="2">Скидка</td>
        <td class="tg-c3ow"><? echo $info["s_skidka"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l"><br /></td>
        <td class="tg-up7l" colspan="2"><br />Общая сумма</td>
        <td class="tg-c3ow" colspan="2"><br /><? echo $info["s_summa"]; ?></td>
        <td class="tg-us36"></td>
    </tr>
    <tr>
        <td class="tg-up7l"></td>
        <td class="tg-up7l" colspan="2">Предоплата</td>
        <td class="tg-c3ow" colspan="2"><? echo $info["s_sum_predopl"]; ?></td>
        <td class="tg-us36"></td>
    </tr>
    <tr>
        <td class="tg-up7l"></td>
        <td class="tg-up7l" colspan="2">Остаток суммы</td>
        <td class="tg-baqh" colspan="2"><? echo ($info["s_summa"]-$info["s_sum_predopl"]); ?></td>
        <td class="tg-yw4l"></td>
    </tr>
    <tr>
        <td class="tg-up7l" colspan="2"><br />Доставка в течении</td>
        <td class="tg-up7l"><br /><? echo $info["s_dost_date"]; ?></td>
        <td class="tg-yw4l" colspan="2"><br />Стоимость доставки</td>
        <td class="tg-yw4l"><br /><? echo $info["s_dost_stoim"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l" colspan="2">Стоимость подъема на эт.</td>
        <td class="tg-up7l"><? echo $info["s_dost_cost_etaj"]; ?></td>
        <td class="tg-yw4l" colspan="2">Стоимость сборки</td>
        <td class="tg-yw4l"><? echo $info["s_stoim_sborki"]; ?></td>
    </tr>
    <tr>
        <td class="tg-up7l" colspan="2">Контактные телефоны</td>
        <td class="tg-up7l" colspan="4"><? echo $info["d_phone"]; ?></td>
    </tr>
</table>
<br />

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

</body>

</html>
