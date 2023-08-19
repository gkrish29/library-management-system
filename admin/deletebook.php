<?php 
    
    include '../_dbconnect.php';

    $sql= "DELETE FROM books where book_id = $_GET[bn];";
    $result = $conn->query($sql);

    if(!$result){
        echo $conn->error;

    }


    else{
        header('Location:managebook.php');

    }
    
?>