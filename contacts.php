<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Связь</title>
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
        require ("authorization.php");
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
    <br>
    <div class="container">
        <form method="post" >
        <h2 style="text-align: center;">Связь с нами</h2>
            <label for="name">Ваше имя:</label>
            <input type="text" name="name" id="name" required><br>
            <br>
            <label for="email">Ваш email:</label>
            <input type="email" name="email" id="email" required><br>
            <br>
            <label for="message">Сообщение:</label>
            <textarea id="message" name="message" required></textarea><br><br>
            <input type="submit" value="Отправить" class="button" name='OK'>
        </form>
    </div>

    <?php
        if (isset($_POST['OK'])) {
            mail('audiomania@gmail.com', 'Сообщение с сайта', $_POST['message'], 'From:' . $_POST['email']);
            $_SESSION['message_sent'] = true;
        }

        if (isset($_SESSION['message_sent']) && $_SESSION['message_sent']) {
            echo "<p style='text-align: center; color: green;'>Сообщение успешно отправлено!</p>";
            $lastEmail = scandir("C:/OSPanel/userdata/temp/email", SCANDIR_SORT_DESCENDING)[0];
            $emailContent = file_get_contents("C:/OSPanel/userdata/temp/email/{$lastEmail}");
            $emailContent = nl2br($emailContent);
            echo "<div class='container'>";
            echo "<h2 style='text-align: center;'>Последнее отправленное сообщение:</h2>";
            echo "<p>{$emailContent}</p>";
            echo "</div>";
            unset($_SESSION['message_sent']);
        }
    ?>
</body>
</html>
