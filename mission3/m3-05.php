<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>今日の晩御飯何食べた？？</title>
</head>
<body>
    <?php

        $devChar = "<>";
        $devPWChar = "|¥|";
        $filename = "mission_3-5_2.txt";

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

                        $fp = fopen($filename,"a");

                        if(file_exists($filename)){
                            $lines = file($filename,FILE_IGNORE_NEW_LINES);

                            foreach($lines as $line){

                                if ($line != "") {
                                    $parts = explode($devChar, $line);
                                    $n = $parts[0] + 1;
                                }
                            }
                        }

                        if(!isset($n)) {
                            $n = 1;
                        }

                        $str = $n . $devChar . $userName . $devChar . $comment . $devChar . $date . $devPWChar . $commentPassword;

                        fwrite($fp, $str.PHP_EOL);
                        fclose($fp);

                    } else {
                        $alert = "<script type='text/javascript'>alert('名前かコメントが空白です！');</script>";
                        echo $alert;
                        exit;
                    }

                } else {
                    //コメントを編集

                    $fp = fopen($filename,"a");

                    if(file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        $lineCount = 0;

                        foreach($lines as $line){

                            $lineCount = $lineCount + 1;

                            if ($lineCount == $editTargetNum) {

                                $parts = explode($devChar, $line);
                                $dateParts = explode($devPWChar, $parts[3]);

                                $str = $lineCount . $devChar . $userName . $devChar . $comment . $devChar . $dateParts[0] . $devPWChar . $commentPassword;
                                fwrite($fp, $str.PHP_EOL);
                                deleteLine($editTargetNum);
                            } else if ($lineCount > $editTargetNum) {
                                $str = $line;
                                fwrite($fp, $str.PHP_EOL);
                                deleteLine($editTargetNum);
                            }
                        }
                    }

                    fclose($fp);

                        $editTargetNum = "";

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
                $fp = fopen($filename,"r");

                if(file_exists($filename)){
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    $lineCount = 0;

                    foreach($lines as $line){

                        $lineCount = $lineCount + 1;

                        if ($lineCount == $deleteNum) {

                            $PWParts = explode($devPWChar, $line);
                            $password = $PWParts[1];

                            if($password != $deleteCommentPassword) {
                                $alert = "<script type='text/javascript'>alert('パスワードが間違っています！');</script>";
                                echo $alert;

                                //echo "パスワードが間違っています！";
                                break;
                            } else {

                                $PWIsCorrect = true;

                                if ($deleteNum != "") {
                                    deleteLine($deleteNum);
                                } else {
                                    $alert = "<script type='text/javascript'>alert('削除番号が入力されていません！');</script>";
                                    echo $alert;
                                    exit;
                                }
                            }

                        }
                    }
                }

                if ($PWIsCorrect == true) {

                    $fp = fopen($filename,"a");

                    if(file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        $lineCount = 0;

                        foreach($lines as $line){

                            $lineCount = $lineCount + 1;

                            if ($lineCount >= $deleteNum) {
                                if ($line != "") {

                                    $parts = explode($devChar, $line);
                                    $str = $lineCount . $devChar . $parts[1] . $devChar . $parts[2] . $devChar . $parts[3];
                                    fwrite($fp, $str.PHP_EOL);
                                    deleteLine($deleteNum);
                                }
                            }
                        }
                    }

                    fclose($fp);
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
                $fp = fopen($filename,"r");

                if(file_exists($filename)){
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    $lineCount = 0;

                    foreach($lines as $line){

                        $lineCount = $lineCount + 1;

                        if ($lineCount == $editNum) {

                            $PWParts = explode($devPWChar, $line);
                            $password = $PWParts[1];

                            if($password != $editCommentPassword) {
                                $alert = "<script type='text/javascript'>alert('パスワードが間違っています！');</script>";
                                echo $alert;

                                //echo "パスワードが間違っています！";
                                break;
                            } else {

                                $PWIsCorrect = true;
                            }

                        }
                    }
                }

                if ($PWIsCorrect == true) {

                    $fp = fopen($filename,"a");

                    if(file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        $lineCount = 0;

                        foreach($lines as $line){

                            $lineCount = $lineCount + 1;

                            if ($lineCount == $editNum) {

                                $parts = explode($devChar, $line);

                                $editUserName = $parts[1];
                                $editComment = $parts[2];

                                $PWParts = explode($devPWChar, $line);
                                $editPassword = $PWParts[1];

                            }
                        }
                    }
                    fclose($fp);
                }

            } else {
                echo "エラーです。";
            }
        }

        function deleteLine($l) {
            $filename = "mission_3-5_2.txt";
            $myFile = file($filename);

            unset($myFile[$l - 1]);

            file_put_contents($filename, $myFile);

            return;
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

    <h1>今日の晩御飯何食べた？？</h1>

    <?php

        echo "<br>";
        echo "- - - - - - - - - - - - コメント - - - - - - - - - - - -<br>";

        if(file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);

            foreach($lines as $line){

                $parts = explode($devPWChar, $line);
                echo $parts[0];
                echo "<br>";
            }
        }

    ?>

</body>
</html>
