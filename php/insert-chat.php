<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        include_once "encryption.php"; // Include encryption functions
        
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        
        if(!empty($message)){
            // Encrypt the message before storing
            $encrypted_message = encryptMessage($message);
            
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$encrypted_message}')") or die();
        }
    }else{
        header("location: ../login.php");
    }
?>
