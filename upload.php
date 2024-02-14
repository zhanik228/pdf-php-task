<?php
require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf_file"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename('uploaded_file.pdf');
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка на PDF
    if ($pdfFileType != "pdf") {
        echo "Извините, только файлы PDF разрешены.";
        $uploadOk = 0;
    }

    // Попытка загрузки файла
    if ($uploadOk == 0) {
        echo "Извините, ваш файл не был загружен.";
    } else {
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            echo "Файл " . basename($_FILES["pdf_file"]["name"]) . " успешно загружен.";
        } else {
            echo "Извините, возникла ошибка при загрузке файла.";
        }
    }
} else {
    echo "Извините, была отправлена некорректная форма.";
}

unset($_POST);
