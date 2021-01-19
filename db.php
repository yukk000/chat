<?php 
foreach (select() as $message) {
 echo $message['time'],"：　",$message['name'],"：",$message['message'];
 echo nl2br("\n");
}
         // 投稿内容を登録
 if(isset($_POST["send"])) {
      insert(); //内容表示
      $stmt = select_new();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
        echo $message['time'],"：　",$message['name'],"：",$message['message'];
            echo nl2br("\n");
        }
}
 
  // DB接続
function connectDB() {
    static $dbh = null;
    if (null === $dbh) {
        try {
              $dbh = new PDO('mysql:host=localhost;dbname=chat','root','');
        } catch () {
        }  
    }
        return $dbh;
}
 
            // DBから投稿内容を取得
function select() {
     $dbh = connectDB();
     $sql = "SELECT * FROM message ORDER BY time";
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     return $stmt;
}
 
            // DBから投稿内容を取得(最新の1件)
function select_new() {
     $dbh = connectDB();
     $sql = "SELECT * FROM message ORDER BY time desc limit 1";
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     return $stmt;
}
 
            // DBから投稿内容を登録
function insert() {
     $dbh = connectDB();
     $sql = "INSERT INTO message (name, message, time) VALUES (:name, :message, now())";
     $stmt = $dbh->prepare($sql);
     $params = array(':name'=>$_POST['name'], ':message'=>$_POST['message']);
     $stmt->execute($params);
}

?>
