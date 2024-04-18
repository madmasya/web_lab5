<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>

    <link rel="stylesheet" href="style/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #c0effa;  
            color: #333;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
    <?php 
        require ("setup.php");
    ?>
</head>
<body>
    <div class="button-container-top">
        <a href="login.php" class="button-left">Войти</a><br>
        <a href="register.php" class="button-left">Зарегистрироваться</a>
    </div>
    <br><br><br><br><br>
    <h1 style="text-align: center;">Audiomania</h1>
    <div class="button-container">
        <a href="main.php" class="button">Главная</a>
        <a href="music_shop.php" class="button">Покупка пластинок</a>
        <a href="news.php" class="button">Новости</a>
        <a href="contacts.php" class="button">Контакты</a>
    </div>

    <br><br>
    
    <div class="container">
        <form method="post" >
            <h3 style="text-align: center;">Вход</h3>
            <label for="login">Логин:</label>
            <input type="text" name="login" id="login" required><br>
            <br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required><br>
            <br>
            <input type="submit" value="Войти" class="button" name='OK'>
        </form>
        <a href="register.php" class="button">Зарегистрироваться</a>
    </div>

    <?php 
        if (isset($_POST['OK'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $query = "SELECT * FROM customer WHERE login='$login' AND password='$password'";
            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) == 1) {    
                session_start();
                $_SESSION['login'] = $login; 
                header("Location: main.php"); 
            } else {
                echo "<br><div style='text-align: center; color: red;'>Неправильный логин или пароль. Пожалуйста, попробуйте снова.</div>";
            }
        }
    ?>
</body>
</html>
