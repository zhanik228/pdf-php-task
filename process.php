<?php
require_once('db_connection.php');

// Подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Обработка данных из формы и сохранение в базе данных
    if (empty($_POST['recipient_name']) || empty($_POST['recipient_email_or_telegram'])) {
        echo "Ошибка: пожалуйста, заполните все поля.";
    } else {
        $name = $_POST['recipient_name'];
        $recipient_contact = $_POST['recipient_email_or_telegram'];

        if (preg_match('/^\d+$/', $recipient_contact)) {
            // Это ID Telegram
            $query = "INSERT INTO users (name, telegram_id)
            VALUES ('$name', '$recipient_contact')";

            if ($conn->query($query) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error:" . $query . "<br />" . $conn->error;
            }
        } else {
            $query = "INSERT INTO users (name, email)
            VALUES ('$name', '$recipient_contact')";

            if ($conn->query($query) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error:" . $query . "<br />" . $conn->error;
            }
        }

        // Теперь вы можете использовать эти данные для сохранения в базе данных или отправки по электронной почте/Telegram
    }

    // Отправка на email или телеграм, если указано
} else {
    echo "Извините, была отправлена некорректная форма.";
}
