<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости</title>
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
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .news-item {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .news-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .news-content {
            color: #666;
        }
        .news-date {
            color: #999;
            font-size: 14px;
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
    
    <div class="container">
        <h2>Последние новости</h2>
        <?php
            $random_query = "SELECT * FROM news ORDER BY RAND() LIMIT 1";
            $random_result = mysqli_query($link, $random_query);
            $random_row = mysqli_fetch_assoc($random_result);
        
            echo '<div class="news-item">';
            echo '<h2 class="news-title">' . $random_row['title'] . '</h2>';
            echo '<p class="news-content">' . $random_row['content'] . '</p>';
            echo '<p class="news-date">Дата публикации: ' . date('d.m.Y', strtotime($random_row['date'])) . '</p>';
            echo '</div>';
        
            $query = "SELECT * FROM news WHERE id != {$random_row['id']} ORDER BY date DESC LIMIT 1";
            $result = mysqli_query($link, $query);
        
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="news-item">';
                    echo '<h2 class="news-title">' . $row['title'] . '</h2>';
                    echo '<p class="news-content">' . $row['content'] . '</p>';
                    echo '<p class="news-date">Дата публикации: ' . date('d.m.Y', strtotime($row['date'])) . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>Новостей пока нет.</p>";
            }

            mysqli_close($link);
        ?>
    </div>
</body>
</html>
