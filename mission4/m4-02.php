<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-02</title>
</head>
<body>
    <?php
        $dsn = 'mysql:dbname=tb230786db;host=localhost';
        $user = 'tb-230786';
        $password = 'wmsr2BVm3H';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE IF NOT EXISTS tbtest2"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT"
            .");";
        $stmt = $pdo->query($sql);
     ?>

</body>
</html>
