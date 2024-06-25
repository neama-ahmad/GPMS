<?php

session_start();

$role = isset($_SESSION["role"]);
if(isset($_SESSION["id"]) && $_SESSION["id"]==true){
    
     
  if($row["role"]=="طالب"){
    header("location:student.php");
    exit;
  }

  else if($row["role"]=="مشرف"){
    header("location:supervisor.php");
    exit;
  }

  else if($row["role"]=="مختبر"){
    header("location:examiner.php");
    exit;
  }

  else if($row["role"]=="عضو لجنة المشاريع"){
    header("location:GP_committee.php");
    exit;
  }

  else{
    header("location:login.php");
        
  }

}    



?>