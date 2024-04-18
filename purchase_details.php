<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали покупки</title>
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

    <h2 style="text-align: center;">Информация о покупке:</h2> 

    <?php

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $purchase_id = $_GET['id'];

            $query = "SELECT * FROM purchase WHERE id = '$purchase_id'";
            $result = mysqli_query($link, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $purchase_info = mysqli_fetch_assoc($result);
                    echo "<div style='text-align: center;'>";
                    echo "<p>Дата покупки: " . $purchase_info['date_of_purchase'] . "</p>";
                    echo "<p>Время покупки: " . $purchase_info['time_of_purchase'] . "</p>";

                    $records_query = "SELECT music_record.*, COUNT(*) AS total_quantity, SUM(music_record.price) AS total_price
                                    FROM music_record 
                                    JOIN music_records_in_purchase ON music_record.id = music_records_in_purchase.id_of_music_record
                                    WHERE music_records_in_purchase.id_of_purchase = '$purchase_id'
                                    GROUP BY music_record.id";
                    $records_result = mysqli_query($link, $records_query);

                    if ($records_result) {
                        echo "<h2 style='margin-left: 10px;'>Список пластинок в этой покупке:</h2>";
                        $total_purchase_price = 0;
                        while ($record_row = mysqli_fetch_assoc($records_result)) {
                            $total_purchase_price += $record_row['total_price'];
                            echo "<p><b>Название пластинки:</b> " . $record_row['name'] . 
                            "<br><b>Автор: </b>" . $record_row['author'] . 
                            "<br><b> Цена за 1 копию: </b>" . $record_row['price'] 
                            . "руб.<br><b> Количество: </b>" . $record_row['total_quantity'] . 
                            "<br><b> Общая цена: </b>" . $record_row['total_price'] . " руб.</p>";
                        }
                        echo "<p><b>Итоговая стоимость покупки:</b> " . $total_purchase_price . " руб.</p>";
                    } else {
                        echo "Ошибка при получении списка пластинок: " . mysqli_error($link);
                    }
                } else {
                    echo "<p>Покупка с указанным id не найдена.</p>";
                }
            } else {
                echo "Ошибка: " . mysqli_error($link);
            }
        } else {
            echo "<p>Параметр id не был передан.</p>";
        }

        mysqli_close($link);
    ?>
    <a href="purchases.php" class="button">Вернуться к покупкам</a>
    </div>
    <br>
</body>
</html>
