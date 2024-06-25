<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
      //insert topics added by supervisor to database
      if(isset($_POST["btn-add"])){

        $to = $_POST['to'];
        $message = $_POST['message'];


        $email = $_SESSION['email'];
        $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
        while($row1 = mysqli_fetch_array($query1)){
            $userID = $row1['ID'];
          
            $query = mysqli_query($db, "INSERT INTO notifications (sendFor, message, user_id) VALUES ('$to','$message', '$userID')");
                $msg = "تم رفع الإشعار";

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

        <title>نظام إدارة مشاريع التخرج |إرسال إشعارات</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/files.css">
        <style>
            .row2 .column2{
                height: auto;
                padding-bottom: 12px;
                padding-top:10px;
            }
        </style>



    </head>

    <body>

 

        <div id="mother">
         <div class="column">

            <!--form-->
            <form method="POST" action="">
               <h3 >إرسال إشعارات</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                     }  
                  ?>
                <h4>إرسال إشعار إلى</h4>
                <select name="to"  class="forminput" required>
                    <option value="">اختر...</option>
                        <?php
                        $partType = array("عام","أعضاء لجنة المشاريع","المختبرين","المشرفين","الطلاب");
                        foreach($partType as $item){
                           echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                        }
                        ?>
                </select>  
                <textarea  name="message" placeholder="محتوى الرسالة"   maxlength="400" cols="3" rows= "6" class="forminput area" required></textarea>
                
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال">
            </form>

            

         </div>
         <br/>
        
         <div class="row2">
         <h3>جميع الإشعارات التابعة لي</h3>
            <?php
            $email = $_SESSION['email'];
            $query3 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row3 = mysqli_fetch_array($query3)){
              $userID = $row3['ID'];
            
              $query2 = mysqli_query($db,"SELECT * FROM  notifications WHERE user_id = '$userID' ORDER BY Added_Time DESC ");
              while($row2 = mysqli_fetch_array($query2)){
            ?>

           <div class="column2">

              <table>
                <tr><td class="bold">إلى</td><td><?php echo $row2['sendFor'];?></td></tr>
                <tr><td class="bold">محتوى الرسالة</td><td><?php echo $row2['message'];?></td></tr>
                <tr><td class="bold">وقت الإرسال</td><td><?php $dt = new DateTime($row2['Added_Time']); echo $dt->format('H:i    d/m '); ?></td></tr>
               </table>
            </div>
             
        <?php
        }}
        ?>
        </div>

      </div>

     
  
   </body>
   </html>
