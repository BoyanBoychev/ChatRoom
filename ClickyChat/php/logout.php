<?php
    session_start();
    if(isset($_SESSION['unique_id'])){ //if user is logged in then come to this page, otherwise go to login page
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){ //if logout id set
            $status = "Offline now";
            //once user logout, update his status to offline and go to login form
            //and update the status to active if user logged in succssesfully
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>