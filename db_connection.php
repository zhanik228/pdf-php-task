<?php
$servername = "localhost"; // Хост базы данных (обычно localhost)
$username = "root"; // Ваше имя пользователя для доступа к MySQL
$password = ""; // Ваш пароль для доступа к MySQL
$dbname = "php-pdf-task"; // Имя вашей базы данных

// Подключение к базе данных
$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
