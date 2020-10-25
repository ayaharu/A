<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    <?php

	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//テーブルを表示
	$sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";
	
	//編集機能
        if (isset($_POST["ednum"]) and isset($_POST["edipass"])){
        if (strlen($_POST["ednum"])!=0 and strlen($_POST["edipass"])!=0) {
            $sql = 'SELECT * FROM mission5_1';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
                if ($row['id']== $_POST["ednum"] ){
                    if($row['dpass'] == $_POST["edipass"] ) {
                    $name1=$row['name'];
                    $come=$row['comment'];
                    $hen=$row['id'];
                    $pass0=$row['dpass'];
                }
        }
        }
        }
        }
?>
	
    <form action="" method="post">
        <input type="text" size="20" name="name1" style="width:200px;" placeholder="名前"  value="<?php if(isset($name1)) {echo $name1;} ?>">
        <input type="text" size="20" name="come" style="width:200px;" placeholder="コメント" value="<?php if(isset($come)) {echo $come;} ?>">
        <input type="hidden" size="20" name="hen" placeholder="編集対象番号表示" value="<?php if(isset($hen)) {echo $hen;} ?>">
        <input type="text" size="20" name="pass" placeholder="パスワード" value="<?php if(isset($pass)) {echo $pass;} ?>">
        <input type="hidden" size="20" name="pass0" style="width:200px; "placeholder="編集対象パスワード表示" value="<?php if(isset($pass0)) {echo $pass0;} ?>">
        <input type="submit" size="20" name="submit" value="送信">
        <br>
    <form action="" method="post">
        <input type="number" size="20" name="dele" style="width:200px;" placeholder="削除したい投稿の番号を入力">
        <input type="text" size="20" name="delpass" style="width:200px;" placeholder="削除したい投稿のパスワード">
        <input type="submit" name="delete" value="削除">
        <br>
    <form action="" method="post">
        <input type="number" size="20" name="ednum" style="width:200px;" placeholder="編集したい投稿の番号を入力">
        <input type="text" size="20" name="edipass" style="width:200px;" placeholder="編集したい投稿のパスワード">
        <input type="submit" name="edit" value="編集">
    </form>
    
	<?php
	//データを入力
	$date = date("Y/m/d H:i:s");
    if(isset($_POST["name1"]) and isset($_POST["come"])) {
       if(strlen($_POST["name1"])!=0 and strlen($_POST["come"])!=0 and strlen($_POST["pass"])!=0 ){
            $name1 = $_POST["name1"];
            $come = $_POST["come"];
            $str=$name1.$come;
            $pass = $_POST["pass"];
            if(strlen($_POST["hen"]==0)){
                $hen = $_POST["hen"];
	            $sql = $pdo -> prepare("INSERT INTO mission5_1 (time, name, comment, dpass) VALUES (:time, :name, :comment, :dpass)");
	            $sql -> bindParam(':time', $time, PDO::PARAM_STR);
            	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
            	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            	$sql -> bindParam(':dpass', $dpass, PDO::PARAM_STR);
            	$time=$date;
            	$name=$name1;
            	$comment=$come;
            	$dpass=$pass;
            	$sql -> execute();
                echo"新しい投稿を送信しました。<br>";
            }
    else{
        $id=$_POST["hen"];
        $name1 = $_POST["name1"];
        $comment = $_POST["come"];
	    $time = $date;
	    $dpass = $_POST["pass0"];
	    $sql = 'UPDATE mission5_1 SET name=:name,comment=:comment,time=:time,dpass=:dpass WHERE id=:id';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
	    $stmt->bindParam(':name', $name1, PDO::PARAM_STR);
	    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $stmt->bindParam(':dpass', $dpass, PDO::PARAM_STR);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->execute();
	    echo"投稿を編集しました。<br>";
      }
     }
    }

	//入力されているデータレコードを削除
	if (isset($_POST["dele"]) and isset($_POST["delpass"])) {
	    if(strlen($_POST["dele"])!=0 and strlen($_POST["delpass"])!=0){
	        $delpass=$_POST["delpass"];
	        $dele=$_POST["dele"];
	        $sql = 'SELECT * FROM mission5_1';
	        $stmt = $pdo->query($sql);
        	$results = $stmt->fetchAll();
        	foreach ($results as $row){
                if ($row['id'] ==  $_POST["dele"]) {
                    if ($row['dpass'] ==  $_POST["delpass"]) {
                        $id=$_POST["dele"];
	                    $sql = 'delete from mission5_1 where id=:id';
	         $stmt = $pdo->prepare($sql);
	         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	         $stmt->execute();
	        echo"投稿を削除しました。<br>" ;
            } 
            else{
                echo" ";
                }
             }
          }
       }
	}
       else{
           echo" ";
       }
        	

	//表示4-6
    //テーブルに登録されたデータを表示
    $sql = 'SELECT * FROM mission5_1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['time'].',';
	echo $row['name'].',';
	echo $row['comment'].'<br>';
	echo "<hr>";
	}	
	?>