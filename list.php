<!DOCTYPE html>
<html>

<head>
    <title>Редактирование списка адресатов</title>
</head>

<body>
    <h1>Редактирование списка адресатов</h1>

    <!-- Форма для редактирования базы данных -->
    <form action="sendPDF.php" method="post">
        <!-- Поля для редактирования -->
        <!-- Например: -->
        <input type="submit" value="Отправить всем файл" name="submit">
    </form>
    <br>
    <form action="process.php" method="post">
        <!-- Поля для редактирования -->
        <!-- Например: -->
        <input type="text" name="recipient_name" placeholder="ФИО получателя">
        <input type="text" name="recipient_email_or_telegram" placeholder="Email/ID Telegram получателя">
        <input type="submit" value="Создать" name="submit">
    </form>
    <br>
    <?php
    require_once('db_connection.php');

    if (isset($_REQUEST['delete'])) {
        $sql = "DELETE FROM users WHERE id = {$_REQUEST['id']}";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Unable to delete data";
        }
    }

    $users = $conn->query('SELECT * FROM users');
    if ($users->num_rows > 0) {
        echo '<table class="table">';
        echo "<thead>";
        echo "<tr>";
        echo "<th>Имя</th>";
        echo "<th>Email</th>";
        echo "<th>Telegram ID</th>";
        echo "<th>Действие</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $users->fetch_assoc()) {
            $emailNotNull = $row['email'];
            $telegramIdNotNull = $row['telegram_id'];

            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['telegram_id'] . "</td>";
            echo '<td><form action="" method="POST">
                    <input
                        type="hidden"
                        name="id"
                        value=' . $row['id'] . '
                    >
                    <button
                        type="submit"
                        name="delete"
                        value="Delete"
                    >
                        Delete
                    </button>
                </form>
                <form action="edit.php">
                    <input
                        type="hidden"
                        name="id"
                        value=' . $row['id'] . '
                    >
                    <button
                        type="submit"
                        name="edit"
                        value="Edit"
                    >
                        Edit
                    </button>
                </form>
                </td>';
        }
        echo "</tbody>";
        echo "</table>";
    }
    ?>
</body>

</html>