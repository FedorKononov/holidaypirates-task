<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?= !empty($head_title) ? e($head_title) : '' ?> / HolidayPirates</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style type="text/css">
            .footer_panel{
                bottom: 0;
                position: absolute;
                height: 30px;
                width: 100%;
                border-top: 2px solid #ddd;
            }
        </style>
    </head>
    <body>
        <?= view($content_template)->render(); ?>

        <div class="footer_panel">
            <?if ($auth_user):?>
                <b>User</b>: <?=$auth_user->email;?>
            <?endif;?>
            <b>Links</b>: <a href="/login">Login</a> <a href="/logout">Logout</a> <a href="/register">Register</a> &nbsp;&nbsp;| &nbsp;&nbsp; <a href="/job">Jobs</a>  &nbsp;&nbsp;| &nbsp;&nbsp; <a href="/moderator/job">Moderator Jobs</a> &nbsp;&nbsp;| &nbsp;&nbsp; <a href="/moderator/user">Users</a> <a href="/moderator/group">Groups</a> <a href="/moderator/permission">Permissions</a>
        </div>

        <!-- JQuery -->
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>