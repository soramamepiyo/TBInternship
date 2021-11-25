<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>しりとり掲示板</title>
</head>
<body>
    <?php

        //データベースを準備する
        $dsn = 'mysql:dbname=tb230786db;host=localhost';
        $user = 'tb-******';
        $password = '******';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


        $sql = "CREATE TABLE IF NOT EXISTS db_m501_7"
            ." ("
            . "id INT PRIMARY KEY,"
            . "name char(32),"
            . "comment TEXT,"
            . "postDate TEXT,"
            . "password TEXT"
            .");";
        $stmt = $pdo->query($sql);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['submit'])) {

                $editTargetNum = $_POST["editTargetNum"];

                $userName = $_POST["userName"];
                $comment = $_POST["comment"];
                $commentPassword = $_POST["commentPassword"];

                if($editTargetNum == "") {

                    if ($commentPassword == "") {
                        $alert = "<script type='text/javascript'>alert('パスワードが入力されていません！');</script>";
                        echo $alert;
                        exit;
                    }

                    //コメントを新規追加

                    if ($userName != "" && $comment != "") {

                        $date = date("Y/m/d H:i:s");

                        //idを取得

                        $sql = 'SELECT * FROM db_m501_7';
                        $stmt = $pdo->query($sql);
                        $results = $stmt->fetchAll();

                        $id = count($results) + 1;

                        $sql = 'SELECT * FROM db_m501_7';
                        $stmt = $pdo->query($sql);
                        $results = $stmt->fetchAll();

                        $sql = $pdo -> prepare("INSERT INTO db_m501_7 (id, name, comment, postDate, password) VALUES (:id, :name, :comment, :postDate, :password)");
                        $sql -> bindParam(':id', $id, PDO::PARAM_INT);
                        $sql -> bindParam(':name', $userName, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                        $sql -> bindParam(':postDate', $date, PDO::PARAM_STR);
                        $sql -> bindParam(':password', $commentPassword, PDO::PARAM_STR);
                        $sql -> execute();

                    } else {
                        $alert = "<script type='text/javascript'>alert('名前かコメントが空白です！');</script>";
                        echo $alert;
                        exit;
                    }

                } else {
                    //コメントを編集

                    $sql = 'UPDATE db_m501_7 SET name=:name,comment=:comment,password=:password WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $userName, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $commentPassword, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $editTargetNum, PDO::PARAM_INT);
                    $stmt->execute();

                }

            } elseif (isset($_POST['delete'])) {

                $deleteNum = $_POST["deleteNum"];
                $PWIsCorrect = false;

                $deleteCommentPassword = $_POST["deleteCommentPassword"];

                if ($deleteCommentPassword == "") {
                    $alert = "<script type='text/javascript'>alert('パスワードが入力されていません！');</script>";
                    echo $alert;
                    exit;
                }

                //パスワードの正誤判定

                $sql = 'SELECT * FROM db_m501_7';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    //$rowの中にはテーブルのカラム名が入る

                    if ($row['id'] == $deleteNum) {
                      $password = $row['password'];
                    }
                }

                if ($password == "") {
                    echo "その番号のデータが見つかりませんでした。". "<br>";
                    exit;
                } else if($password == $deleteCommentPassword) {
                    $PWIsCorrect = true;
                } else {
                    echo "パスワードが間違っています！". "<br>";
                }

                if ($PWIsCorrect == true) {

                    $sql = 'delete from db_m501_7 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $deleteNum, PDO::PARAM_INT);
                    $stmt->execute();

                    //番号の降り直し

                      //全体の件数の探索

                    $sql = 'SELECT * FROM db_m501_7';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();

                    $numData = count($results) + 1;

                    //echo "データの件数: " . $numData . "<br>";

                    for($j = 1; $j <= $numData; $j++) {
                        if ($j > $deleteNum) {
                            //echo $j . "番目のidを1減らします。<br>";

                            $re_id = $j - 1;

                            $sql = 'UPDATE db_m501_7 SET id=:re_id WHERE id=:id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $j, PDO::PARAM_INT);
                            $stmt->bindParam(':re_id', $re_id, PDO::PARAM_INT);
                            $stmt->execute();

                        }

                    }

                    $re_id = 0;

                    foreach ($results as $row){
                        //$rowの中にはテーブルのカラム名が入る

                        $re_id += 1;

                        if($row['id'] > $deleteNum) {
                          $sql = 'UPDATE db_m501_7 SET id=:id WHERE id=:id';
                          $stmt = $pdo->prepare($sql);
                          $stmt->bindParam(':id', $re_id, PDO::PARAM_INT);
                          $stmt->execute();

                        }
                    }
                }

            } elseif (isset($_POST['edit'])) {

                //編集作業

                $editNum = $_POST["editNum"];
                $PWIsCorrect = false;

                $editCommentPassword = $_POST["editCommentPassword"];

                if ($editCommentPassword == "") {
                    $alert = "<script type='text/javascript'>alert('パスワードが入力されていません！');</script>";
                    echo $alert;
                    exit;
                }

                if ($editNum == "") {
                    $alert = "<script type='text/javascript'>alert('編集番号が入力されていません！');</script>";
                    echo $alert;
                    exit;
                }

                //パスワードの正誤判定

                $sql = 'SELECT * FROM db_m501_7';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    //$rowの中にはテーブルのカラム名が入る
                    if ($row['id'] == $editNum) {
                      $password = $row['password'];
                    }
                }

                if ($password == "") {
                  echo "その番号のデータが見つかりませんでした。". "<br>";
                  exit;
                } else if($password == $editCommentPassword) {
                  $PWIsCorrect = true;
                } else {
                  echo "パスワードが間違っています！". "<br>";
                  exit;
                }

                if ($PWIsCorrect == true) {

                    $sql = 'SELECT * FROM db_m501_7';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row){
                        //$rowの中にはテーブルのカラム名が入る

                        if ($row['id'] == $editNum) {
                            $editUserName = $row['name'];
                            $editComment = $row['comment'];
                            $editPassword = $row['password'];
                        }
                    }
                }

            } else {
                echo "エラーです。";
            }
        }
    ?>

    <form action="" method="post">
        <input type="text" name="userName" placeholder="名前" value="<?php
            error_reporting(0);
            if ($editUserName != "") {
                echo $editUserName;
            }
        ?>">
        <input type="text" name="comment" placeholder="コメント" value="<?php
            error_reporting(0);
            if ($editUserName != "") {
                echo $editComment;
            }
        ?>">
        <input type="password" name="commentPassword" placeholder="パスワード(登録)" value="<?php
            error_reporting(0);
            if ($editPassword != "") {
                echo $editPassword;
            }
        ?>">
        <input type="submit" name="submit">
        <br>
        <input type="number" name="deleteNum" placeholder="削除したい番号" >
        <input type="password" name="deleteCommentPassword" placeholder="パスワード(確認)">

        <input type="submit" name="delete" value="削除" >
        <br>
        <input type="number" name="editNum" placeholder="編集したい番号">
        <input type="password" name="editCommentPassword" placeholder="パスワード(確認)">

        <input type="submit" name="edit" value="編集" >
        <input type="hidden" name="editTargetNum" value="<?php
            if ($editUserName != "") {
                echo $editNum;
            }
        ?>">

    </form>

    <h1>しりとりしましょう</h1>
    <h3>一人何回でも投稿してください！</h3>

    <?php

        echo "<hr>";

        $sql = 'SELECT * FROM db_m501_7';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo "<br>ID:  " . $row['id']. "<br>";
            echo "名前: " . $row['name'] . "　　　日時: " . $row['postDate'] . "<br>";
            echo "コメント: " . $row['comment']. "<br><br>";
            echo "<hr>";
        }

    ?>

</body>
</html>
