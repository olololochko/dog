<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE>Отработка</TITLE>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/4-col-portfolio.css" rel="stylesheet">
    <link href="css/datepicker.min.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY LANG="ru-RU" DIR="LTR">
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="img/logo.gif">Отработка</a>
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
                <label for="dateBegin">Период отработки</label>
                <input type="text" class="datepicker-here custom-select small" id="dateFrom" style="width: 110px;" name="dateFrom" value="<? echo $_POST["dateFrom"]; ?>">
                -
                <input type="text" class="datepicker-here custom-select small" id="dateTo" style="width: 110px;" name="dateTo" value="<? echo $_POST["dateTo"]; ?>">
            </div>
            <div class="form-inline" style="float: right;">
                <button class="btn btn-secondary" type="submit">Поиск!</button>
            </div>
        </form>
    </div>
    <div class="form-group" style="display: inline-block; width: calc(100% - 251px); vertical-align: top; margin-left: 20px;">
        <div id="captionOtrabotka">
        <h3 class="h3"><?echo $filial_fullname; ?> <br />
            <?echo $dateFrom." - ".$dateTo; ?> <br />
            ОТРАБОТКА</h3>
        </div>
        <div class="btn-group">
            <button id="btnExport" class="btn btn-dark btn-sm" onclick="fnExcelReport();">Экспрот в Excel </button>
        </div>
        <TABLE ID="tblOtrabotka" WIDTH=1065 CELLPADDING=7 CELLSPACING=0 STYLE="table-layout: fixed; white-space: normal; border-collapse: collapse;">
            <COL WIDTH=51>
            <COL WIDTH=62>
            <COL WIDTH=209>
            <COL WIDTH=99>
            <COL WIDTH=90>
            <COL WIDTH=76>
            <COL WIDTH=145>
            <COL WIDTH=87>
            <COL WIDTH=118>
            <thead>
            <TR VALIGN=TOP>
                <TH WIDTH=51 HEIGHT=42 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER>№ <FONT SIZE=2><B>дог.</B></FONT></P>
                </TH>
                <TH WIDTH=62 STYLE="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
                    <P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT SIZE=2><B>Дата
                    </B></FONT><FONT SIZE=2><B>договора</B></FONT></P>
                </TH>
                <TH WIDTH=209 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Наименование товара</B></FONT></P>
                </TH>
                <TH WIDTH=99 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Производитель</B></FONT></P>
                </TH>
                <TH WIDTH=90 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Общая сумма</B></FONT></P>
                </TH>
                <TH WIDTH=76 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Остаток суммы</B></FONT></P>
                </TH>
                <TH WIDTH=145 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Наименование банка</B></FONT></P>
                </TH>
                <TH WIDTH=87 STYLE="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
                    <P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT SIZE=2><B>Причина неотработки</B></FONT></P>
                </TH>
                <TH WIDTH=118 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Место нахождения
                    товара</B></FONT></P>
                </TH>
            </TR>
            </thead>
            <? foreach ($table["otrabotka"] as $row) { ?>
            <TR VALIGN=TOP>
                <TD WIDTH=51 HEIGHT=42 STYLE="border: 1px solid #000001;">
                    <? echo $row["d_num"]; ?>
                </TD>
                <TD WIDTH=62 STYLE="border: 1px solid #000001; ">
                    <? echo $row["d_date_add"]; ?>
                </TD>
                <TD colspan="2" class="parentTovar" style="border: 1px solid #000001; padding: 0px;">
                    <table width="100%" class="childTovar" style="border-style: hidden; table-layout: fixed; height: auto; margin: 0px;">
                        <?
                        $tovar=""; $proizv="";
                        $tovars = $Data->getTovar($mysqli, $row["d_id"]);
                        foreach ($tovars["tovar"] as $tovar_row) { ?>
                            <tr><td WIDTH="210" STYLE="border: 1px solid #000001;"><? echo $tovar_row["tovar_name"]; ?></td>
                            <td WIDTH="99" STYLE="border: 1px solid #000001; word-wrap:break-word;"><? echo $tovar_row["proizv_name"]; ?></td>
                            </tr><? //echo $tovar; ?>

                        <? } ?>
                    </table>
                </TD>
                <TD WIDTH=90 STYLE="border: 1px solid #000001;">
                    <? echo $row["s_summa"]; ?>
                </TD>
                <TD WIDTH=76 STYLE="border: 1px solid #000001;">
                    <? echo $row["s_ostatok"]; ?>
                </TD>
                <TD WIDTH=145 STYLE="border: 1px solid #000001;">
                    <? echo $row["s_credit"]; ?>
                </TD>
                <TD WIDTH=87 STYLE="border: 1px solid #000001; word-wrap:break-word;">
                    <? echo $row["d_primech_m"]; ?>
                </TD>
                <TD WIDTH=118 STYLE="border: 1px solid #000001;">
                    <? echo $row["status_name"]; ?>
                </TD>
            </TR>
            <? } ?>
        </TABLE>
        <div id="captionNeotrab"><h3 class="h3">НЕОТРАБОТКА</h3></div>
        <TABLE ID="tblNeotrab" WIDTH=1065 CELLPADDING=7 CELLSPACING=0 STYLE="table-layout: fixed; white-space: normal; border-collapse: collapse;">
            <COL WIDTH=51>
            <COL WIDTH=62>
            <COL WIDTH=209>
            <COL WIDTH=99>
            <COL WIDTH=90>
            <COL WIDTH=76>
            <COL WIDTH=145>
            <COL WIDTH=87>
            <COL WIDTH=118>
            <thead>
            <TR VALIGN=TOP>
                <TH WIDTH=51 HEIGHT=42 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER>№ <FONT SIZE=2><B>дог.</B></FONT></P>
                </TH>
                <TH WIDTH=62 STYLE="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
                    <P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT SIZE=2><B>Дата договора</B></FONT></P>
                </TH>
                <TH WIDTH=209 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Наименование товара</B></FONT></P>
                </TH>
                <TH WIDTH=99 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Производитель</B></FONT></P>
                </TH>
                <TH WIDTH=90 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Общая сумма</B></FONT></P>
                </TH>
                <TH WIDTH=76 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Остаток суммы</B></FONT></P>
                </TH>
                <TH WIDTH=145 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Наименование банка</B></FONT></P>
                </TH>
                <TH WIDTH=87 STYLE="border: 1px solid #000001; padding-top: 0in; padding-bottom: 0in; padding-left: 0.08in; padding-right: 0.08in">
                    <P ALIGN=CENTER STYLE="margin-bottom: 0in"><FONT SIZE=2><B>Причина неотработки</B></FONT></P>
                </TH>
                <TH WIDTH=118 STYLE="border: 1px solid #000001;">
                    <P ALIGN=CENTER><FONT SIZE=2><B>Место нахождения
                                товара</B></FONT></P>
                </TH>
            </TR>
            </thead>
            <? foreach ($tableNeotrab["neotrabotka"] as $row) { ?>
                <TR VALIGN=TOP>
                    <TD WIDTH=51 HEIGHT=42 STYLE="border: 1px solid #000001;">
                        <? echo $row["d_num"]; ?>
                    </TD>
                    <TD WIDTH=62 STYLE="border: 1px solid #000001; ">
                        <? echo $row["d_date_add"]; ?>
                    </TD>
                    <TD colspan="2" class="parentTovar" style="border: 1px solid #000001; padding: 0px;">
                        <table width="100%" class="childTovar" style="border-style: hidden; table-layout: fixed; height: auto; margin: 0px;">
                            <?
                            $tovars = $Data->getTovar($mysqli, $row["d_id"]);
                            foreach ($tovars["tovar"] as $tovar_row) { ?>
                                <tr><td WIDTH="210" STYLE="border: 1px solid #000001;"><? echo $tovar_row["tovar_name"]; ?></td>
                                <td WIDTH="99" STYLE="border: 1px solid #000001; word-wrap:break-word;"><? echo $tovar_row["proizv_name"]; ?></td>
                                </tr><? //echo $tovar; ?>

                            <? } ?>
                        </table>
                    </TD>

                    <TD WIDTH=90 STYLE="border: 1px solid #000001;">
                        <? echo $row["s_summa"]; ?>
                    </TD>
                    <TD WIDTH=76 STYLE="border: 1px solid #000001;">
                        <? echo $row["s_ostatok"]; ?>
                    </TD>
                    <TD WIDTH=145 STYLE="border: 1px solid #000001;">
                        <? echo $row["s_credit"]; ?>
                    </TD>
                    <TD WIDTH=87 STYLE="border: 1px solid #000001; word-wrap:break-word;">
                        <? echo $row["d_primech_m"]; ?>
                    </TD>
                    <TD WIDTH=118 STYLE="border: 1px solid #000001;">
                        <? echo $row["status_name"]; ?>
                    </TD>
                </TR>
            <? } ?>
        </TABLE>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/datepicker.min.js"></script>

    <script>
        //var table = document.getElementById('childTovar');
        //var parent = div.parentElement;
        //var posTable = table.getBoundingClientRect();
        //var posParent = parent.getBoundingClientRect();
        //if (posTable.height < posParent.height) {
            //table.style.height = posParent.height;
        //    $('.childTovar').css('height',posParent.height);
        //}
        $('.childTovar').each(function (i, elem) {
           if ($(this).height() < $(this).parent('.parentTovar').height())
           {
               $(this).height($(this).parent('.parentTovar').height());
           }
            //alert($(this).parent('#parentTovar').height());
        });
    </script>
    <script>
        var role = '<? echo $u_role; ?>';
        if (role == '*') {
            document.getElementById("blockFilialSearch").className = "d-block";
        } else
        {
            document.getElementById("blockFilialSearch").className="d-none";
        }
    </script>
    <? //для кспорта таблицы ?>
    <script>
        function fnExcelReport()
        {
            var caption = document.getElementById('captionOtrabotka');
            var tab_text = caption.innerHTML;
            tab_text=tab_text+"<table border='2px'><tr bgcolor='#87AFC6'>";
            var textRange; var j=0;
            tab = document.getElementById('tblOtrabotka'); // id of table
            for(j = 0 ; j < tab.rows.length ; j++)
            {
                tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
                //tab_text=tab_text+"</tr>";
            }
            tab_text=tab_text+"</table>";
            var captionNeotr = document.getElementById('captionNeotrab');
            tab_text = tab_text+captionNeotr.innerHTML;
            tab_text=tab_text+"<table border='2px'><tr bgcolor='#87AFC6'>";
            tabNeotr = document.getElementById('tblNeotrab'); // id of table
            for(j2 = 0 ; j2 < tabNeotr.rows.length ; j2++)
            {
                tab_text=tab_text+tabNeotr.rows[j2].innerHTML+"</tr>";
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

</BODY>
</HTML>