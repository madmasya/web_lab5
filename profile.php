<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
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
        p {
            font-size: 1.2rem;
            margin-bottom: 10px;
            margin-left: 10px;
        }
    </style>
    <?php 
        require ("authorization.php");
        require ("setup.php");
    ?>
</head>

<body>
    <?php if (!$logged_in) { ?>
        <div class="button-container-top">
            <a href="login.php" class="button-left">Войти</a><br>
            <a href="register.php" class="button-left">Зарегистрироваться</a>
        </div>
    <?php } else { ?>
        <div class="button-container-top">
            <a href="profile.php" class="button-left">Личный кабинет</a><br>
            <form method="post" action="logout.php">
                <input type="submit" value="Выйти" class="button-left">
            </form>
        </div>
    <?php } ?>
    

    <br><br><br><br><br>

    <h1 style="text-align: center;">Audiomania</h1>
    
    <div class="button-container">
        <a href="main.php" class="button">Главная</a>
        <a href="music_shop.php" class="button">Покупка пластинок</a>
        <a href="news.php" class="button">Новости</a>
        <a href="contacts.php" class="button">Контакты</a>
    </div>

    <h2 style="margin-left: 10px; text-align: center;">Профиль пользователя</h2> 

    <?php
        $login = $_SESSION['login'];
        $query = "SELECT * FROM customer WHERE login = '$login'";
        $result = mysqli_query($link, $query);

        if (!$result) {
            echo "Ошибка: " . mysqli_error($link);
        } else {
            $user = mysqli_fetch_assoc($result);
        }
    ?>

    <?php if ($user) { ?>
        <div style="text-align: center;">
            <p><strong>Логин:</strong> <?php echo $user['login']; ?></p>
            <p><strong>Фамилия:</strong> <?php echo $user['surname']; ?></p>
            <p><strong>Имя:</strong> <?php echo $user['name']; ?></p>
            <p><strong>Отчество:</strong> <?php echo $user['patronymic']; ?></p>
            <p><strong>Дата регистрации:</strong> <?php echo $user['date_of_register']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        </div>
    <?php } else { ?>
        <p>Пользователь не найден.</p>
    <?php } ?>
    <div style="text-align: center;">
        <a href="cart.php" class="button">Корзина</a> 
        <a href="purchases.php" class="button">Просмотреть покупки</a> 
    </div>
</body>
</html>
