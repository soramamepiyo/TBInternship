<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-04</title>
</head>
<body>
    <?php

      $devChar = "<>";
      $filename = "mission_3-4.txt";

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

          if (isset($_POST['submit'])) {

              $editTargetNum = $_POST["editTargetNum"];

              $userName = $_POST["userName"];
              $comment = $_POST["comment"];

              if($editTargetNum == "") {
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

                      $str = $n . $devChar . $userName . $devChar . $comment . $devChar . $date;

                      fwrite($fp, $str.PHP_EOL);
                      fclose($fp);
                  }

              } else {
                  //コメントを編集

                  //echo $editTargetNum . "を編集します。";

                  $fp = fopen($filename,"a");

                  if(file_exists($filename)){
                      $lines = file($filename,FILE_IGNORE_NEW_LINES);
                      $lineCount = 0;

                      foreach($lines as $line){

                          $lineCount = $lineCount + 1;

                          if ($lineCount == $editTargetNum) {

                                $parts = explode($devChar, $line);
                                $str = $lineCount . $devChar . $userName . $devChar . $comment . $devChar . $parts[3];
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

                  //最後にhiddenのvalue値を""に

              }


          } elseif (isset($_POST['delete'])) {

              $deleteNum = $_POST["deleteNum"];

              if ($deleteNum != "") {
                  deleteLine($deleteNum);
              } else {
                  $alert = "<script type='text/javascript'>alert('削除番号が入力されていません！');</script>";
                  echo $alert;
                  exit;
              }

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

            } elseif (isset($_POST['edit'])) {

                $editNum = $_POST["editNum"];

                if ($editNum == "") {
                  $alert = "<script type='text/javascript'>alert('編集番号が入力されていません！');</script>";
                  echo $alert;
                  exit;
                }

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

                        }

                    }
                }

                fclose($fp);

          } else {
              echo "エラーです。";
          }

      }


      function deleteLine($l) {
          $filename = "mission_3-4.txt";
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
        <input type="submit" name="submit">
        <br>
        <input type="number" name="deleteNum" placeholder="削除したい番号">
        <input type="submit" name="delete" value="削除" >
        <br>
        <input type="number" name="editNum" placeholder="編集したい番号">
        <input type="submit" name="edit" value="編集" >
        <input type="hidden" name="editTargetNum" value="<?php
            if ($editUserName != "") {
                echo $editNum;
            }
        ?>">

    </form>

    <?php


      echo "<br>";
      echo "- - - - - - - - - - - - コメント - - - - - - - - - - - -<br>";

      if(file_exists($filename)){
          $lines = file($filename,FILE_IGNORE_NEW_LINES);

          foreach($lines as $line){
              echo $line;
              echo "<br>";
          }
      }

    ?>

</body>
</html>
