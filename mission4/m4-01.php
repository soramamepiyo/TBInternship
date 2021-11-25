<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-01</title>
</head>
<body>
    <?php
        $dsn = 'mysql:dbname=tb230786db;host=localhost';
        $user = 'tb-230786';
        $password = 'wmsr2BVm3H';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     ?>

</body>
</html>
