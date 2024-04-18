<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {

        if (isset($_POST['record_id'])) {

            $record_id_to_remove = $_POST['record_id'];

            if (isset($_SESSION['cart'][$record_id_to_remove])) {
                if ($_SESSION['cart'][$record_id_to_remove] == 1) {
                    unset($_SESSION['cart'][$record_id_to_remove]);
                } else {
                    $_SESSION['cart'][$record_id_to_remove] -= 1;
                }

                header("Location: cart.php");
                exit(); 
            } else {
                echo "Пластинка не найдена в корзине.";
            }
        } else {
            echo "Не удалось получить ID пластинки для удаления.";
        }
    } else {
        echo "Неверный запрос.";
    }
?>