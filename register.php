<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>

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
            <h3 style="text-align: center;">Регистрация</h3>
            <label for="login">Логин:</label>
            <input type="text" name="login" id="login" required><br>
            <br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required><br>
            <br>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required><br>
            <br>
            <label for="surname">Фамилия:</label>
            <input type="text" name="surname" id="surname" required><br>
            <br>
            <label for="name">Имя:</label>
            <input type="text" name="name" id="name" required><br>
            <br>
            <label for="patronymic">Отчество:</label>
            <input type="text" name="patronymic" id="patronymic" required><br>
            <br>
            <input type="submit" value="Зарегистрироваться" class="button" name='OK'>
        </form>
    </div>

    <?php 
        if (isset($_POST['OK'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $registration_date = date("Y-m-d H:i:s");
            $surname = $_POST['surname'];
            $name = $_POST['name'];
            $patronymic = $_POST['patronymic'];

            $query = "INSERT INTO customer (login, password, email, date_of_register, surname, name, patronymic) 
                      VALUES ('$login', '$password', '$email', '$registration_date', '$surname', '$name', '$patronymic')";
            mysqli_query($link, $query);

            session_start();
            $_SESSION['login'] = $login;

            header("Location: main.php");
        }
    ?>
</body>
</html>
