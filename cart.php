<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сеть магазинов с пластинками</title>
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
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
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

    <?php
        $total_items = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

        $total_price = 0; 

        if ($total_items > 0) {
            foreach ($_SESSION['cart'] as $record_id => $quantity) {
                $query = "SELECT * FROM music_record WHERE id = $record_id";
                $result = mysqli_query($link, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $record = mysqli_fetch_assoc($result);
                    $total_price += $record['price'] * $quantity; 
                }
            }
        }
    ?>

    <h1>Корзина</h1>

    <?php if ($total_items > 0) { ?>
        <p style="margin-left: 10px;"><b>В корзине <?php echo $total_items; ?> товар(ов)</b></p>
        <p style="margin-left: 10px;"><b>Общая стоимость: <?php echo $total_price; ?> руб.<b></p>
    <?php } ?>
    
    <table>
    <thead>
        <tr>
            <th>Название</th>
            <th>Автор</th>
            <th>Треков на пластинке</th>
            <th>Страна выпуска</th>
            <th>Цена</th>
            <th>Жанр</th> 
            <th>Количество</th>
            <th>Действие</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $record_id => $quantity) {
                    $query = "SELECT * FROM music_record WHERE id = $record_id";
                    $result = mysqli_query($link, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $record = mysqli_fetch_assoc($result);
                        echo "<tr>";
                        echo "<td>" . $record['name'] . "</td>";
                        echo "<td>" . $record['author'] . "</td>";
                        echo "<td>" . $record['number_of_tracks'] . "</td>";
                        echo "<td>" . $record['country'] . "</td>";
                        echo "<td>" . $record['price'] . "</td>";
                        echo "<td>" . $record['genre'] . "</td>";
                        echo "<td>" . $quantity . "</td>"; 
                        echo "<td><form method='post' action='remove_from_cart.php'>";
                        echo "<input type='hidden' name='record_id' value='$record_id'>";
                        echo "<input type='submit' name='remove_from_cart' value='Удалить'>";
                        echo "</form></td>";
                        echo "</tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='8' style='text-align: center;'>Корзина пуста</td></tr>";
            }
        ?>
    </tbody>
    </table>
    <br>
    <div style="text-align: center;">
        <form method='post' action='buy_cart.php'>
            <button type='submit' name='buy_cart_all' class="button">Совершить покупку</button>
        </form>
    </div>

    
</body>
</html>
