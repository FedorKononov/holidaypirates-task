<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?= !empty($head_title) ? e($head_title) : '' ?> / HolidayPirates</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <?= view($content_template)->render(); ?>

        <!-- JQuery -->
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>