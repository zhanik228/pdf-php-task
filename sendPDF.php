<?php
require_once('db_connection.php');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Получаем данные из формы

$token = '6839877085:AAH4cpIU3t7l2Glj-y5RXU0Z5CJvzwhJ2bE';
$bot = new \TelegramBot\Api\Client($token);
$pdfPath = 'uploads/uploaded_file.pdf';
$pdfContent = file_get_contents($pdfPath);

$sql = "SELECT * FROM users";
$users = $conn->query($sql);
if ($users->num_rows > 0) {
    while ($row = $users->fetch_assoc()) {
        $telegram_id = $row['telegram_id'];
        $recipient_name = $row['name'];
        if (!empty($telegram_id)) {
            try {
                $bot->sendDocument($telegram_id, $pdfContent, 'uploaded_file.pdf');
                echo "Telegram Успешно отправлен к пользователю $recipient_name <br>";
            } catch (\TelegramBot\Api\Exception $e) {
                echo "Ошибка при отправке файла: " . $e->getMessage() . "<br>";
            }
        } else {
            $mail = new PHPMailer(true);
            $recipient_contact = $row['email'];

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'zhan142004@gmail.com';
                $mail->Password = 'rrvpmrmdwdlumlge';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->addAddress($recipient_contact, $recipient_name);

                // Устанавливаем тему письма
                $mail->Subject = 'PDF file';
                $mail->Body = 'Ваш загруженный файл';

                if (!file_exists('uploads/uploaded_file.pdf')) {
                    echo "Отправляемый файл не найден. Пожалуйста, загрузите PDF файл <br />";
                    return;
                }

                // Устанавливаем текст сообщения
                $mail->addAttachment('uploads/uploaded_file.pdf');

                // Отправляем сообщение
                $mail->send();

                echo "Email Успешно отправлен к пользователю $recipient_contact <br>";
            } catch (Exception $e) {
                echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
            }
        }
    }
    $bot->run();
    header("Refresh: 15; url=list.php");
    unlink('uploads/uploaded_file.pdf');
}
