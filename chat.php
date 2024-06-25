<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(isset($_POST["btn-add"])){

        $message = $_POST['message'];


        $email = $_SESSION['email'];
        $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
        while($row1 = mysqli_fetch_array($query1)){
            $userID = $row1['ID'];

            $query2 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
            while($row2 = mysqli_fetch_array($query2)){

            $Group_id = $row2["group_id"];
            
            //send message for chating
            $send_message = mysqli_query($db, "INSERT INTO chat (message, user_id , group_id) VALUES ('$message', '$userID' , '$Group_id')");

        }

          
    }  
        
     }
    }
    
?>


<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>نظام إدارة مشاريع التخرج |إرسال رسالة</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/chat.css">



    </head>

    <body>

       <?php
        $email = $_SESSION['email'];
        $query = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
        while($row = mysqli_fetch_array($query)){
          $userID = $row['ID'];

          
        $query2 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
        while($row2 = mysqli_fetch_array($query2)){

        $Group_id = $row2["group_id"];
        $leadership = $row2['leadership'];
    
    ?>
    <div id="mother">

    <?php
    if($leadership == 1){
        echo'
        <a href="myGroup.php" class="Toback">&#8594;</a>';
    }
    else{
        echo'
        <a href="mainGroup.php" class="Toback">&#8594;</a>';
    }
    ?>

     
        <div class="row2">
         <h3>رسائل المجموعة</h3>
            <?php
            
              $query3 = mysqli_query($db,"SELECT * FROM chat WHERE group_id = '$Group_id'  ORDER BY Added_Time ASC  ");
              while($row3 = mysqli_fetch_array($query3)){
                $writer_id = $row3['user_id'];
                $message = $row3['message'];
                $Added_Time = $row3['Added_Time'];
                $supervisor = $row3['supervisor'];
                $dt = new DateTime($Added_Time);
                
            ?>
            <?php
               $query4 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$writer_id' ");
                 while($row4 = mysqli_fetch_array($query4)){
                    $writer_name = $row4['fullName'];
               
                    if($writer_id == $userID){
                     echo '
                     <div class="contianer1">
                     <div class="column2" id="col1">

                     <table>
                         <tr><td>'.$message.'</td></tr>
                     </table>
                     <span class="how">أنا</span> 
                     <span class="time">'.$dt->format("H:i    d/m ").' </span>
                     </div>
                     </div>
                     
                     ';
                    }
                    else{
                      echo '
                      <div class="contianer2">
                      <div class="column2" id="col2">

                       <table>
                          <tr><td>'.$message.'</td></tr>
                       </table>';
                       if($supervisor == 1){
                         echo '<span class="how">المشرف</span>';
                        }
                       else{
                        echo '<span class="how">'.$writer_name.'</span>';
                       }
                       echo '
                       <span class="time">'.$dt->format("H:i    d/m ").' </span>
                       </div>
                       </div>
                     
                     ';
                    }
                }}}}
            ?>

        <div class="column">

            <!--form-->
            <form method="POST" action="">
                <textarea  name="message" placeholder="اكتب شيئا.."   maxlength="400" cols="3" rows= "3" class="forminput area" required></textarea>
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال">
            </form>


        </div>
       
      </div>

    </div>

      

  
   </body>
   </html>
