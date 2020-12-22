 <?php
 
 $stmt = select(); foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                echo $message['time'],"：　",$message['name'],"：",$message['message'];
                echo nl2br("\n");
            }

            if(isset($_POST["send"])) {
                insert();
                $stmt = select_new();
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                    echo $message['time'],"：　",$message['name'],"：",$message['message'];
                    echo nl2br("\n");
                }
            }

            function connectDB() {
                $dbh = new PDO('mysql:host=localhost;dbname=chat','root','');
                return $dbh;
            }

            function select() {
                $dbh = connectDB();
                $sql = "SELECT * FROM message ORDER BY time";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                return $stmt;
            }

            function select_new() {
                $dbh = connectDB();
                $sql = "SELECT * FROM message ORDER BY time desc limit 1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                return $stmt;
            }
   
            function insert() {
                $dbh = connectDB();
                $sql = "INSERT INTO message (name, message, time) VALUES (:name, :message, now())";
                $stmt = $dbh->prepare($sql);
                $params = array(':name'=>$_POST['name'], ':message'=>$_POST['message']);
                $stmt->execute($params);
            }
        ?>
