<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_4-07</title>
</head>
<body>
    <?php
        // DB接続設定

        //共通部分
        $dsn = 'mysql:dbname=tb230786db;host=localhost';
        $user = 'tb-230786';
        $password = 'wmsr2BVm3H';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        $id = 2; //変更する投稿番号
        $name = "そらぴよ";
        $comment = "変更されたコメント01"; //変更したい名前、変更したいコメントは自分で決めること
        $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        //表示部分
        $sql = 'SELECT * FROM tbtest';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }

     ?>

</body>
</html>
