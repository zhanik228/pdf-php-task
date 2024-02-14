<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF PHP</title>
</head>

<body>
    <h1>Загрузка и отправка PDF</h1>

    <!-- Форма для загрузки PDF -->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Выберите PDF для загрузки:
        <input type="file" name="pdf_file" id="pdf_file">
        <input type="submit" value="Загрузить PDF" name="submit">
    </form>

    <br>

    <!-- Кнопка для перехода на страницу редактирования -->
    <button onclick="location.href='list.php';">Редактировать список адресатов</button>
</body>

</html>