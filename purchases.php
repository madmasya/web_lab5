<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Покупки</title>
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

    <h2 style="margin-left: 10px;text-align: center;">Соврешенные покупки</h2> 

    <?php
        $login = $_SESSION['login'];
        $query = "SELECT id FROM customer WHERE login = '$login'";
        $result = mysqli_query($link, $query);

        $user_id = 0;
        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $user_id = $row['id'];
            } else {
                echo "Пользователь с логином '$login' не найден.";
            }
        } else {
            echo "Ошибка при выполнении запроса: " . mysqli_error($link);
        }

        $query = "SELECT * FROM purchase WHERE id_of_customer = '$user_id'";
        $result = mysqli_query($link, $query);


        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<div style='text-align: center;>'<ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a href='purchase_details.php?id={$row['id']}' class='button'>Подробнее</a> - Дата: " . $row['date_of_purchase'] . ", Время: " . $row['time_of_purchase'] . "</li>";
                }
                echo "</ul></div>";
            } else {
                echo "<p>У вас пока нет совершенных покупок.</p>";
            }
        } else {
            echo "Ошибка: " . mysqli_error($link);
        }

        mysqli_close($link);
    ?>
</body>
</html>
