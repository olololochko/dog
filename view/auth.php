<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Доброго времени суток</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href ="../vendor/bootstrap/css/login.css" rel="stylesheet">
    <style type="text/css">
    .form form {
    width: 300px;
    margin: 0 auto;
    padding-top: 20px;
    }
    </style>

</head>
<body id="LoginForm">

<div class="login-form container">
    <div class="main-div">
        <div class="panel">
            <h2>Вход в систему</h2>
            Введите имя пользователя и пароль
        </div>
        <form id="Login" action="index.php" role="form" method="POST">
                <div class="form-group">
                        <input type="text" class="form-control" placeholder="Логин" name="uid">
                </div>
                <div class="form-group">
                        <input type="password" class="form-control" placeholder="Пароль" name="upass">
                </div>
                        <button type="submit" class="btn btn-labeled btn-success">Войти</button>

        </form>
    </div>
    <p class="bottom-text"> (C)2018</p>
</div><!-- form  -->
</body>

</html>