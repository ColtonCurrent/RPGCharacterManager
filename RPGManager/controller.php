<?php
    include("header.php");

    session_start();
    $action = $_GET["action"] ?? -1;

    if(isset($_SESSION['user_loggin_in'])){
        if($_SESSION['user_loggin_in'] == TRUE){
            include("userIn.php");

            if($action == "createChar"){
                echo $_SESSION['user_id_in'];
                include("characterCreate.php");
                if(isset($_POST['charName'])){
                    $charName = $_POST['charName'];
                    $charLevel = $_POST['charLevel'];
                    $charClass = $_POST['charClass'];
                    $userId = $_SESSION['user_id_in'];
                    require("model.php");
                    createRecord($charName, $charLevel, $charClass, $userId);
                }
            } elseif($action == "updateChar"){
                echo $_SESSION['user_id_in'];
                require("model.php");
                updateRecord();
                if(isset($_POST['charName'])){
                    $charName = $_POST['charName'];
                    $charLevel = $_POST['charLevel'];
                    $charClass = $_POST['charClass'];
                    $userId = $_SESSION['user_id_in'];
                    update($charName, $charLevel, $charClass, $userId);
                }
            } elseif($action == "deleteChar"){
                require("model.php");
                deleteRecord();
            } elseif($action == "logout"){
                $_SESSION['user_loggin_in'] = FALSE;
                $_SESSION['user_id_in'] = 0;
                session_destroy();
                header('Location: controller.php');
            } else{
                include("read.php");
            }

        } else{
            include("userOut.php");
            
            if($action == "createUser"){
                include("createUser.php");
                if(isset($_POST['user'])){
                    $user = $_POST['user'];
                    $pass = $_POST['pass'];
                    require("model.php");
                    createUser($user, $pass);
                }
            } elseif($action == "login"){
                include("login.php");
                if(isset($_POST['userlog'])){
                    $userlog = $_POST['userlog'];
                    $passlog = $_POST['passlog'];
                    require("model.php");
                    $check = checkLog($userlog, $passlog);
                    if($check[0] == 1){
                        $_SESSION['user_loggin_in'] = TRUE;
                        $_SESSION['user_id_in'] = $check[1];
                        header('Location: controller.php');
                    } else{
                        echo "Bad Credientials: The username or password you entered is incorrect!";
                    }
                } 
            } else{
                
            }
        }
    } else{
        $_SESSION['user_loggin_in'] = FALSE;
    }
    include("footer.php");
?>