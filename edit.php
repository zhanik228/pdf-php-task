<!DOCTYPE html>
<html>

<head>
    <title>Редактирование списка адресатов</title>
</head>

<body>
    <h1>Редактирование списка адресатов</h1>

    <!-- Форма для редактирования базы данных -->
    <?php
    require_once('db_connection.php');

    if (isset($_REQUEST['edit'])) {
        $sql = "SELECT * FROM users WHERE id = {$_REQUEST['id']}";

        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
    }

    if (isset($_REQUEST['update'])) {
        $recipient_contact = $_REQUEST['recipient_email_or_telegram'];
        if (preg_match('/^\d+$/', $recipient_contact)) {
            // Это ID Telegram
            $sql = "UPDATE users SET name = ?, telegram_id = ?, email = NULL WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssi", $recipient_name, $recipient_email_or_telegram, $id);

                $recipient_name = $_POST['recipient_name'];
                $recipient_email_or_telegram = $_POST['recipient_email_or_telegram'];
                $id = $_POST['id'];

                if ($stmt->execute()) {
                    echo "Данные успешно обновлены";
                    header("Location: list.php");
                } else {
                    echo "Ошибка при выполнении запроса: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Ошибка подготовки запроса: " . $conn->error;
            }
        } else {
            // Подготовленный запрос на обновление данных пользователя
            $sql = "UPDATE users SET name = ?, email = ?, telegram_id = NULL WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssi", $recipient_name, $recipient_email_or_telegram, $id);

                $recipient_name = $_POST['recipient_name'];
                $recipient_email_or_telegram = $_POST['recipient_email_or_telegram'];
                $id = $_POST['id'];

                if ($stmt->execute()) {
                    echo "Данные успешно обновлены";
                    header("Location: list.php");
                } else {
                    echo "Ошибка при выполнении запроса: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Ошибка подготовки запроса: " . $conn->error;
            }
        }
    }

    echo "<form method='post'>";
    echo "<input type='hidden' name='id' value='{$_REQUEST['id']}'>";
    echo "<input type='text' value={$user['name']} name='recipient_name' placeholder='ФИО получателя'>";
    echo '<input type="text" name="recipient_email_or_telegram" placeholder="Email/ID Telegram получателя" value=' . ($user['email'] ?? $user['telegram_id']) . '>';
    echo "<button name='update' value='Update' type='submit'>Сохранить</button>";
    echo "</form>";
    ?>
</body>

</html>