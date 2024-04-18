<?php
    require("setup.php"); 
    session_start();

    if (empty($_SESSION['cart'])) {
        echo "<script>alert('Для начала нужно добавить пластинки в корзину!'); window.location.href = 'music_shop.php';</script>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy_cart_all'])) {
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

        $time_of_purchase = date('H:i:s');
        $date_of_purchase = date('Y-m-d');
        $query = "INSERT INTO purchase (id_of_customer, time_of_purchase, date_of_purchase) 
        VALUES ('$user_id', '$time_of_purchase', '$date_of_purchase')";
        mysqli_query($link, $query);
        $purchase_id = mysqli_insert_id($link);

        $query = "INSERT INTO music_records_in_purchase (id_of_music_record, id_of_purchase) VALUES (?, ?)";
        $stmt = mysqli_prepare($link, $query);

        if ($stmt) {
            foreach ($_SESSION['cart'] as $record_id => $quantity) {
                for ($i = 0; $i < $quantity; $i++) {
                    mysqli_stmt_bind_param($stmt, "is", $record_id, $purchase_id);
                    mysqli_stmt_execute($stmt);
                }
            }

            $_SESSION['cart'] = array();
            echo "<script>alert('Покупка успешно совершена!'); window.location.href = 'purchase_details.php?id=" . $purchase_id . "';</script>";
            exit();

        } else {
            echo "Ошибка при подготовке запроса: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
    }
?>
