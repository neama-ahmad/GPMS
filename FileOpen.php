<?php

require_once "config.php";
require_once "session.php";

if (!isset($_SESSION['loggedin'])) {
	header('Location:login.php');
	exit;
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>نظام إدارة مشاريع التخرج | الملفات</title>

    <!-- CSS here -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/boxes.css">

    </head>
    <body>
      
        <?php
            $ID = $_GET["ID"];
            $query = mysqli_query($db,"SELECT * FROM files WHERE ID = $ID");
            while($row = mysqli_fetch_array($query)){
                $file_Name = $row['file_Name'];
             
                $file = 'Files/'.$row['docs'];

                $filename =  $row['docs'];
                
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

                readfile($file);
                
        
            }
        
         
        ?>

    </body>
</html>