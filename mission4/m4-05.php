<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-05</title>
</head>
<body>
    <?php
        // DB接続設定

        //共通部分
        $dsn = 'mysql:dbname=tb230786db;host=localhost';
        $user = 'tb-230786';
        $password = 'wmsr2BVm3H';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


        $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $name = 'そら';
        $comment = 'テストコメント03'; //好きな名前、好きな言葉は自分で決めること
        $sql -> execute();
     ?>

</body>
</html>
