<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-03</title>
</head>
<body>
    <?php
        // DB接続設定
        $dsn = 'mysql:dbname=tb230786db;host=localhost';
        $user = 'tb-230786';
        $password = 'wmsr2BVm3H';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql ='SHOW TABLES';
        $result = $pdo -> query($sql);
        foreach ($result as $row){
            echo $row[0];
            echo '<br>';
        }
        echo "<hr>";
     ?>

</body>
</html>
