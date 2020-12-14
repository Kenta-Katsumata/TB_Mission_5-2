<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>Mission_5-1</title>
    </head>
    <body>
        <?php 
        /*Noticeを非表示にする*/
        error_reporting(E_ALL & ~E_NOTICE);
        
         /*データベースと接続*/
        $dsn = 'データベース';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE
        => PDO::ERRMODE_WARNING));
        
        /*データテーブルを作成*/
        $sql = 'CREATE TABLE IF NOT EXISTS mission5'."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."date DATETIME,"
        ."password char(32)"
        .");";
        $stmt = $pdo->query($sql);
        
        /*データテーブルの最後のコメント番号を取得*/
        $sql = 'SELECT * FROM mission5 ORDER BY id DESC LIMIT 1';
        $stmt = $pdo -> query($sql);
        $result = $stmt -> fetchAll();
        foreach($result as $row){
            $cuurent_id = $row['id'];
            $next_id = $cuurent_id + 1;
        }
        
        /*編集機能*/
        if($_POST["edit_number"] == true  && $_POST["edit_submit"] == true){
            $edit_number = $_POST["edit_number"];
            $sql = 'SELECT * FROM mission5 WHERE id=:id';
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':id', $edit_number, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();    
            foreach($result as $row){
                $edit_password = $row["password"];
            }
            if($_POST["edit_password"] == true && $edit_password 
            == $_POST["edit_password"]){
                foreach($result as $row){
                $edit_id = $row['id'];
                $edit_name = $row['name'];
                $edit_comment = $row['comment'];
                $mode = $edit_id;
            }
            }
            
        }
            
                
        ?>
        <form action = "" method = post>
        <dl>
            <dt>名前</dt>
            <dd><input type = "text" name = "name" 
            value = "<?php echo $edit_name ?>"></dd>
            <dt>コメント</dt>
            <dd><input type = "text" name = "comment" 
            value = "<?php echo $edit_comment ?>"></dd>
            <dt>パスワード</dt>
            <dd><input type = "text" name = "password" ></dd>
            <input type = "submit" name = "submit">
            <hr>
            <dt>削除するコメント</dt>
            <dd><input type = "number" name = "del_number"></dd>
            <dt>パスワード</dt>
            <dd><input type = "text" name = "del_password" ></dd>
            <input type = "submit" name = "del_submit" value = "削除">
            <hr>
            <dt>編集するコメント</dt>
            <dd><input type = "number" name = "edit_number"></dd>
            <dt>パスワード</dt>
            <dd><input type = "text" name = "edit_password" ></dd>
            <input type = "submit" name = "edit_submit" value = "編集">
            <hr>
            </dl>
            <input type = "hidden" name = "mode" value = "<?php echo $mode?>">
        </form>
        <?php
        
        /*書き込みが有効であった場合、データテーブルに追加*/
        if($_POST["name"] == true && $_POST["comment"] == true && 
        $_POST["submit"] == true && $_POST["mode"] == false){
            if($_POST["password"] == true){
                $date = date("Y/m/d H:i:s");
                $sql = $pdo -> prepare("INSERT INTO mission5 (id, name, comment,
                date, password) VALUES(:id, :name, :comment,:date, :password)");
                $sql -> bindParam(':id', $next_id, PDO::PARAM_STR);
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $sql -> bindParam(':password', $password, PDO::PARAM_STR);
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                $password = $_POST["password"];
                $sql -> execute();
                /*データテーブルの表示*/
                $sql = "SELECT * FROM mission5";
                $stmt = $pdo -> query($sql);
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo $row['comment']." ";
                    echo $row['date']." "."<br>";
                }
            }else{
                /*データテーブルの表示*/
                $sql = "SELECT * FROM mission5";
                $stmt = $pdo -> query($sql);
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo $row['comment']." ";
                    echo $row['date']." "."<br>";
                }
                echo "パスワードを入力してください";
            }
            
        }
        /*データの削除機能が実行されたとき*/
        elseif($_POST["del_number"] == true  && $_POST["del_submit"] == true){
            $id = $_POST["del_number"];
            $sql = 'SELECT * FROM mission5 WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> execute();
            $result = $stmt -> fetchAll();
            foreach ($result as $row){
        		$del_password = $row['password'];
            	}
            
            if($_POST["del_password"] == false){
                /*表示*/
                $sql = "SELECT * FROM mission5";
                $stmt = $pdo -> query($sql);
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo $row['comment']." ";
                    echo $row['date']." "."<br>";
                }
                echo "パスワードを入力してください";
            }elseif($_POST["del_password"] == true && $_POST["del_password"] 
            != $del_password){
                /*表示*/
                $sql = "SELECT * FROM mission5";
                $stmt = $pdo -> query($sql);
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo $row['comment']." ";
                    echo $row['date']." "."<br>";
                }
                echo "パスワードが間違っています";
            }elseif($_POST["del_password"] == true && $_POST["del_password"] 
            == $del_password){
                $del_id = $_POST["del_number"];
                $sql = "DELETE FROM mission5 WHERE id = :id";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(":id", $del_id,PDO::PARAM_INT);
                $stmt -> execute();
                
                /*表示*/
                $sql = "SELECT * FROM mission5";
                $stmt = $pdo -> query($sql);
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo $row['comment']." ";
                    echo $row['date']." "."<br>";
                }
            }else{
                /*データテーブルの表示*/
                $sql = "SELECT * FROM mission5";
                $stmt = $pdo -> query($sql);
                $result = $stmt -> fetchAll();
                foreach($result as $row){
                    echo $row['id']." ";
                    echo $row['name']." ";
                    echo $row['comment']." ";
                    echo $row['date']." "."<br>";
                }
            }
            
            }
        /*編集機能が実行されたとき*/
        elseif($_POST["mode"] == false && $_POST["edit_number"] == true && 
        $_POST["edit_password"] == false){
            /*データテーブルの表示*/
            $sql = "SELECT * FROM mission5";
            $stmt = $pdo -> query($sql);
            $result = $stmt -> fetchAll();
            foreach($result as $row){
                echo $row['id']." ";
                echo $row['name']." ";
                echo $row['comment']." ";
                echo $row['date']." "."<br>";
            }
            echo "パスワードを入力してください";
        }
        elseif($_POST["mode"] == false && $_POST["edit_number"] == true && 
        $_POST["edit_password"] == true && $_POST["edit_password"] 
        != $edit_password){
            /*データテーブルの表示*/
            $sql = "SELECT * FROM mission5";
            $stmt = $pdo -> query($sql);
            $result = $stmt -> fetchAll();
            foreach($result as $row){
                echo $row['id']." ";
                echo $row['name']." ";
                echo $row['comment']." ";
                echo $row['date']." "."<br>";
            }
            echo "パスワードが間違っています";
        }
        elseif($_POST["mode"] == true && $_POST["name"] == true && 
        $_POST["comment"] == true && $_POST["submit"] == true ) {
            $date = date("Y/m/d H:i:s");
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $id = $_POST["mode"];
            $sql = 'UPDATE mission5 SET name=:name,comment=:comment,date=:date 
            WHERE id=:id';
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':name',$name,PDO::PARAM_STR);
            $stmt -> bindParam(':comment',$comment,PDO::PARAM_STR);
            $stmt -> bindParam(':id',$id,PDO::PARAM_STR);
            $stmt -> bindParam(':date',$date,PDO::PARAM_STR);
            $stmt -> execute();
            
            /*データテーブルの表示*/
            $sql = "SELECT * FROM mission5";
            $stmt = $pdo -> query($sql);
            $result = $stmt -> fetchAll();
            foreach($result as $row){
                echo $row['id']." ";
                echo $row['name']." ";
                echo $row['comment']." ";
                echo $row['date']." "."<br>";
                
            }
        }
            else{
            /*データテーブルの表示*/
            $sql = "SELECT * FROM mission5";
            $stmt = $pdo -> query($sql);
            $result = $stmt -> fetchAll();
            foreach($result as $row){
                echo $row['id']." ";
                echo $row['name']." ";
                echo $row['comment']." ";
                echo $row['date']." "."<br>";
            }
        }
       
            
        ?>
        
    </body>
</html>