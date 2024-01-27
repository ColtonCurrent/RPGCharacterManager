<?php
    $dsn = 'mysql:host=localhost:3308;dbname=cs_350';
    $username = 'student';
    $password = 'CS350';
    $db = new PDO($dsn, $username, $password);
    

    function deleteRecord(){
        global $db;
        $id = $_GET["id"];

        $query = "DELETE FROM characters WHERE characters.id = $id";
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
        header('Location: controller.php');
    }

    function updateRecord(){
        global $db;
        $id = $_GET["id"];

        $query = "SELECT * FROM characters WHERE characters.id = $id";
        $statement = $db->prepare($query);
        $statement->execute();
        $products = $statement->fetch();

        $charName = $products['charName'];
        $charLevel = $products['charLevel'];
        $charClass = $products['charClass'];
        include("update.php");
    }

    function update($characterName, $characterLevel, $characterClass, $userId){
        global $db;

        $id = $_GET["id"];
        try {
            $insert = "UPDATE characters SET characters.charName = :charName, characters.charLevel = :charLevel, characters.charClass = :charClass, characters.user_id = :user_id WHERE id = $id";
            $statement = $db->prepare($insert);
            $statement->bindValue(':charName', $characterName);
            $statement->bindValue(':charLevel', $characterLevel);
            $statement->bindValue(':charClass', $characterClass);
            $statement->bindValue(':user_id', $userId);
            $statement->execute();
        } catch(PDOException $e){
            $msg = $e->getMessage();
            echo "<p>ERROR: $msg</p>";
        }
        $statement->closeCursor();
        header('Location: controller.php');
    }

    function readRecord($userId){
        global $db;

        $query = "SELECT * FROM characters WHERE characters.user_id = $userId";
        $statement = $db->prepare($query);
        $statement->execute();
        $products = $statement->fetchAll();
        
        foreach($products as $product){
            echo "<tr>";
            echo "<td>" . $product['charName'] . "</td>";
            echo "<td>" . $product['charLevel'] . "</td>";
            echo "<td>" . $product['charClass'] . "</td>";
            echo "<td> <a href='controller.php?action=updateChar&id=" . $product['id'] . "'>Update</a> </td>";
            echo "<td> <a href='controller.php?action=deleteChar&id=" . $product['id'] . "'>Delete</a> </td>";
            echo "</tr>";
        }
        $statement->closeCursor();
    }

    function createRecord($characterName, $characterLevel, $characterClass, $userId){
        global $db;
        try {
            $insert = "INSERT INTO characters (charName, charLevel, charClass, user_id) VALUES (:charName, :charLevel, :charClass, :user_id)";
            $statement = $db->prepare($insert);
            $statement->bindValue(':charName', $characterName);
            $statement->bindValue(':charLevel', $characterLevel);
            $statement->bindValue(':charClass', $characterClass);
            $statement->bindValue(':user_id', $userId);
            
            $statement->execute();
        } catch(PDOException $e){
            $msg = $e->getMessage();
            echo "<p>ERROR: $msg</p>";
        }
        $statement->closeCursor();
        header('Location: controller.php');
    }

    function createUser($user, $pass){
        global $db;

        $query = "SELECT * FROM users where users.username = '$user'";
        $statement = $db->prepare($query);
        $statement->execute();
        $products = $statement->fetch();

        if($products){
            echo "Username Already Exists";
        } else{
            $pass1 = password_hash($pass, PASSWORD_DEFAULT);
            echo $pass1;
            try {
                $insert = "INSERT INTO users (username, userpassword) VALUES (:username, :userpassword)";
                $statement = $db->prepare($insert);
                $statement->bindValue(':username', $user);
                $statement->bindValue(':userpassword', $pass1);
                $statement->execute();
            } catch(PDOException $e){
                $msg = $e->getMessage();
                echo "<p>ERROR: $msg</p>";
            }
            $statement->closeCursor();
            header('Location: controller.php');
        }   
    }

    function checklog($userlog, $passlog){
        global $db;

        $query = "SELECT * FROM users where users.username = '$userlog'";
        $statement = $db->prepare($query);
        $statement->execute();
        $products = $statement->fetch();
        $tempId = $products['id'];
        $sender = array();

        if($products){
            if(password_verify($passlog, $products['userpassword'])){
                array_push($sender, 1);
                array_push($sender, $tempId);
                return $sender;
            } else{
                array_push($sender, 0);
                return $sender;
            }
        } else{
            array_push($sender, 0);
            return $sender;
        }
    }
?>