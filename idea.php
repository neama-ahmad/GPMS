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

        $major = $_POST['major'];
        $part = $_POST['part'];
        $topic = $_POST['topic'];


        $email = $_SESSION['email'];
        $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
        while($row1 = mysqli_fetch_array($query1)){
          $userID = $row1['ID'];
          
          $sendTopicsBefor = mysqli_query($db, "SELECT user_id FROM topics where user_id = '$userID' ");
            $count2 = mysqli_num_rows($sendTopicsBefor);
            if($count2 == 1) {
                $msg = "يبدو أنك قمت برفع أفكار المشاريع المقترحة من قبل..لا يمكنك إرسال آخرى حتى تقوم بحذفها أولا";
            }
            else{
                $query = mysqli_query($db, "INSERT INTO topics (major, topic,part, user_id) VALUES ('$major','$topic', '$part','$userID')");
                $msg = "تم رفع المقترح";

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

        <title>نظام إدارة مشاريع التخرج |إقتراح أفكار</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/files.css">
        <style>
            .row2{
                padding-top: 30px;
            }
            .row2 .column2{
                height:auto;
                padding: 12px;
            }
        </style>

    </head>

    <body>

 

        <div id="mother">
         <div class="column">

            <!--form-->
            <form method="POST" action="">
               <h3 >مقترح فكرة مشروع تخرج</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                     }  
                  ?>
                <input type="text"  name="major" class="forminput" placeholder="تخصصك كمشرف"  required>
                <h4>يمكنك الإشراف على أي شطر؟</h4>
                <select name="part"  class="forminput" required>
                    <option value="">اختر...</option>
                        <?php
                        $partType = array("طلاب وطالبات","طالبات","طلاب");
                        foreach($partType as $item){
                           echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                        }
                        ?>
                </select>  
                <textarea  name="topic" placeholder="أسرد كل أفكار المشاريع المقترحة ما لايزيد عن 300 حرف"   maxlength="300" cols="3" rows= "6" class="forminput area" required></textarea>
                
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال">
            </form>

            

         </div>
         <br/>
         <div class="row2">
        
            <?php
            $email = $_SESSION['email'];
            $query3 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row3 = mysqli_fetch_array($query3)){
              $userID = $row3['ID'];
            
              $query2 = mysqli_query($db,"SELECT * FROM topics WHERE user_id = '$userID' ");
              while($row2 = mysqli_fetch_array($query2)){
            ?>

           <div class="column2">

              <table>
                <tr><td class="bold">تخصص المشرف</td><td><?php echo $row2['major'];?></td></tr>
                <tr><td class="bold">يمكنك الإشراف على شطر</td><td><?php echo $row2['part'];?></td></tr>
                <tr><td class="bold">المشاريع المقترحة</td><td><?php echo $row2['topic'];?></tr>
              </table>
               <form method ="POST">
                   <input type="hidden"  name="ID" value= "<?php echo $row2['ID'];?>" readonly>
                   <input type="submit" id="del-btn" name="del-btn"  class="button" value="حذف">
               </form>
            </div>
             
        <?php
        }}
        ?>
        </div>

      </div>

      <?php
       //delete topic when supervisor click on delete button
        if(isset($_POST["del-btn"])&& isset($_POST["ID"])) { 
            $query = mysqli_query($db,"DELETE FROM topics WHERE ID = '".$_POST["ID"]."' ");
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>
  
   </body>
   </html>
