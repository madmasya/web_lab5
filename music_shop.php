<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <title>Сеть магазинов с пластинками</title>
    <link rel="stylesheet" type="text/css" href="/style/styles.css">

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
    </style>

    <?php 
        require ("setup.php");
        require ("authorization.php");
        if (!$logged_in) {
            echo "<script>window.location.href = 'login.php';</script>";
        }
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

    <h2 style="text-align: center;">Онлайн покупка пластинок</h2>

    <b>Сортировка по цене:</b>
    <form method='GET'>
        <div>
            Минимальная цена: <input type="number" name="min_price" value="<?php echo $_GET['min_price']; ?>">
        </div>
        <br>
        <div>
            Максимальная цена: <input type="number" name="max_price" value="<?php echo $_GET['max_price']; ?>">
        </div>
        <br>
        <button type='submit' name='OK3' value='ok'>OK</button>
    </form><br>

    <b>Сортировка по жанру: </b>
    <form class="styledForm" method='GET'>
        <select name='genre' size='1'>
            <option value='' <?php if ($_GET['genre'] == '') echo "selected"; ?>>
                Без сортировки
            </option>
            <?php 
                $query = "select DISTINCT(genre) from music_record";
                $result = mysqli_query($link, $query);
                foreach ($result as $row) {
                    foreach ($row as $key => $value) {
                        echo "<option value='$value'";
                        if ($_GET['genre'] == $value) { 
                            echo "selected";
                        }
                        echo ">".$value."</option>";
                    }
                }
            ?>
        </select>
        <button type='submit' name='OK1' value='ok'>OK</button>
    </form> <br>
    
    <b>Сортировка по автору: </b>
    <form class="styledForm" method='GET'>
        <select name='author' size='1'>
            <option value='' <?php if ($_GET['author'] == '') echo "selected"; ?>>
                Без сортировки
            </option>
            <?php 
                $query = "select DISTINCT(author) from music_record";
                $result = mysqli_query($link, $query);
                foreach ($result as $row) {
                    foreach ($row as $key => $value) {
                        echo "<option value='$value'";
                        if ($_GET['author'] == $value) { 
                            echo "selected";
                        }
                        echo ">".$value."</option>";
                    }
                }
            ?>
        </select>
        <button type='submit' name='OK2' value='ok'>OK</button>
    </form> <br>

    <form method="POST"> 
    <table border=2 align=center> <tr>
        <th> Выбрать </th> 
        <th> Название </th>
        <th> Автор </th>
        <th> Количество треков </th>
        <th> Страна выпуска </th>
        <th> Цена </th>
        <th> Жанр </th> 
        <th> Магазины </th> 
        <th> Изображение </th>
        </tr>
    
    <?php 

        $action = !empty($_GET['genre']) ? $_GET['genre'] : '';

        $query = "SELECT mr.id, mr.name, mr.author, mr.number_of_tracks, mr.country, mr.price, mr.genre, GROUP_CONCAT(DISTINCT ms.address SEPARATOR ',<br>') AS stores, mr.image
                FROM music_record mr 
                JOIN music_records_storage mrstr ON mrstr.id_of_music_record = mr.id
                JOIN music_store ms ON mrstr.id_of_music_store = ms.id
                GROUP BY mr.id";

        if ($action != '') {
            $query .= " HAVING mr.genre LIKE '%$action'";
        }

        $action = !empty($_GET['author']) ? $_GET['author'] : '';
        if ($action != '') {
            $query .= " HAVING mr.author LIKE '%$action%'";
        }

        $action = !empty($_GET['min_price']) ? $_GET['min_price'] : '';
        if ($action != '') {
            $query .= " HAVING mr.price >= $action";
        }

        $action = !empty($_GET['max_price']) ? $_GET['max_price'] : '';
        if ($action != '') {
            $query .= " AND mr.price <= $action";
        }
                
        $result = mysqli_query($link, $query);

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='selected_records[]' value='$row[id]'></td>";
            foreach ($row as $key => $value) {
                if ($key == 'id') continue;
                if ($key == 'image') {
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($value) . "' width='100'></td>"; 
                } else {
                    echo "<td>$value</td>";
                }
            }
            echo "</tr>";
        }
    ?>

    </table>
    <br>
    <div style="text-align: right; margin-right: 180px;">
        <button type='submit' name='add_to_cart_all' class="button">Добавить все в корзину</button><br>
        <a href="cart.php" class="button">Перейти в корзину</a>
    </div>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart_all'])) {
            if (isset($_POST['selected_records']) && is_array($_POST['selected_records'])) {
                session_start();
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }

                foreach ($_POST['selected_records'] as $record_id) {
                    if (array_key_exists($record_id, $_SESSION['cart'])) {
                        $_SESSION['cart'][$record_id] += 1;
                    } else {
                        $_SESSION['cart'][$record_id] = 1;
                    }
                }
                echo "<script>alert('Пластинки добавлены в корзину!');</script>";
            } else {
                echo "<script>alert('Добавить пластинки в корзину!');</script>";
            }
        }
    ?>

</body>


</html>