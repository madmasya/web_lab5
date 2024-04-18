<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сеть магазинов с пластинками</title>
    <link rel="stylesheet" href="/style/styles.css">
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

    <div class="container">
        <h2>О нас</h2>
        <p>Мы являемся уютным и дружелюбным местом для всех ценителей музыкальных пластинок.</p>
        <p>Наш магазин предлагает широкий ассортимент виниловых записей на любой вкус и эпоху. Здесь вы найдете как классические альбомы легендарных исполнителей, так и редкие экземпляры коллекционных изданий.</p>
        <p>Помимо продажи пластинок, мы также организуем различные музыкальные события, прослушивания новых релизов, встречи с музыкантами, а также виниловые вечера и многое другое.</p>
    </div>
</body>
</html>
