<?php 
  require_once "config.php";
  require_once "session.php";
 
  //to stop showing this page if not login in
  if(!isset($_SESSION['loggedin'])) {
    header('Location:login.php');
    exit;
  }


  if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Set appointments for discussions
    if(isset($_POST["btn-add"])){

      $discussion_date = $_POST['discussion_date'];
      $discussion_time = $_POST['discussion_time'];
      $discussion_place = $_POST['discussion_place'];

      //set name of day according by date
      $days = array('يوم الأحد' , 'يوم الآثنين' , 'يوم الثلاثاء' , 'يوم الأربعاء' , 'يوم الخميس' , 'يوم الجمعة' , 'يوم السبت');
      $day = date ('w', strtotime($discussion_date));
      $discussion_day = $days[$day];

      
      $appointment_found = mysqli_query($db,"SELECT * FROM discussion_appointment WHERE discussion_date = '$discussion_date' AND discussion_time = '$discussion_time'");
      $count = mysqli_num_rows($appointment_found);
      if($count > 0){
      while($row = mysqli_fetch_array($appointment_found)){
        $discussion_found_place = $row['discussion_place'];

        if($discussion_place == $discussion_found_place ){
          $msg = 'عذرا..الموعد يتعارض مع مواعيد سابقة..جرب إضافة موعد مختلف';
        }
        else{
          $Set_Appointment = mysqli_query($db, "INSERT INTO discussion_appointment (discussion_date, discussion_time, discussion_day, discussion_place) VALUES ('$discussion_date','$discussion_time', '$discussion_day','$discussion_place')");
          $msg = "تم رفع الموعد";

        }
       }

      }

      else{
        $Set_Appointment = mysqli_query($db, "INSERT INTO discussion_appointment (discussion_date, discussion_time, discussion_day, discussion_place) VALUES ('$discussion_date','$discussion_time', '$discussion_day','$discussion_place')");
        $msg = "تم رفع الموعد";
      }


    }

          
         
        
  }


//pagination
if(isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
  }
      
  else {
    $page_no = 1;
  }
      
  //each page show only 20 records
  $total_records_per_page = 20;
      
  $offset = ($page_no-1) * $total_records_per_page;

   //count records in DB table
   $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM discussion_appointment ");
   $total_records = mysqli_fetch_array($result_count);
   $total_records = $total_records['total_records'];
   
   //number of pages
   $total_no_of_pages = ceil($total_records / $total_records_per_page);
   $second_last = $total_no_of_pages - 1; // total pages minus 1
   
   //fectch records data from DB table
   $sql = "SELECT * FROM discussion_appointment ORDER BY ID DESC LIMIT $offset, $total_records_per_page";
   $result = $db->query($sql);
   $arr_rows = [];
 
  
    if ($result->num_rows > 0) {
       $arr_rows = $result->fetch_all(MYSQLI_ASSOC);
   }
      

?>


<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>نظام إدارة مشاريع التخرج | إضافة مواعيد المناقشات</title>

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
          .error{
            display:inline-block;
            font-size:14px;
            text-align: center;
            width: 90%;
            padding:9px;
            padding-right:20px;
            background-color: Gainsboro;
            color:#666;
            border-radius:5px;
        
          }
        </style>

    </head>

    <body>

 

        <div id="mother">
        <?php
        echo'
        <a href="discussions.php" class="Toback">&#8594;</a>';
        ?>
          <div class="column">

            <!--form-->
            <form method="POST" action="">
               <h3>إضافة مواعيد المناقشات</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p class='error'>$msg</p>";
                     }  
                  ?>
                <h4>حدد التاريخ</h4>
                <input type="date" name="discussion_date" class="forminput" placeholder="حدد  التاريخ"  required >
                <h4>حدد الوقت</h4>
                <input type="time" name="discussion_time" class="forminput"  placeholder="حدد الوقت"  required >
                <h4>حدد المكان</h4>
                <input type="number" name="discussion_place" class="forminput"  placeholder="أدخل رقم القاعة"  required >
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إضافة">
            </form>

            

         </div>
         <br/>
         
         <div class="row2">
         <h3 >جميع المواعيد</h3>
            <?php 
            //show error message
            if(!empty($msg2)) {
              echo "<p class='error'>$msg2</p>";
              }  
            ?>
        
            <?php
               foreach($arr_rows as $row) { 
            ?>


           <div class="column2">

              <table>
                <tr><td class="bold">التاريخ</td><td><?php echo $row['discussion_date'];?></td></tr>
                <tr><td class="bold">الوقت</td><td><?php echo $row['discussion_time'];?></td></tr>
                <tr><td class="bold">اليوم</td><td><?php echo $row['discussion_day'];?></tr>
                <tr><td class="bold">المكان</td><td><?php echo 'قاعة' . ' '. $row['discussion_place'] . ' '.'مبنى الجزيرة';?></tr>
              </table>
               <form method ="POST">
                   <input type="hidden"  name="ID" value= "<?php echo $row['ID'];?>" readonly>
                   <input type="submit" id="del-btn" name="del-btn"  class="button" value="حذف">
               </form>
            </div>
             
        <?php
        }
        ?>
        </div>

        <!--pagination-->
        <div class="pagination">
        <?php
        $page_link = "";
        if($page_no >= 2){
          echo "<a href='discussion_appointment.php?page_no=".($page_no - 1)."'>السابق</a>";
        }

        for($i=1; $i<=$total_no_of_pages; $i++){
          if($i == $page_no){
            if($page_no == 1 && $total_no_of_pages == 1){
              $page_link .="";
            }
            else{
              $page_link .="<a class='active' href='discussion_appointment.php?page_no=".$i."'>".$i."</a>";
            }
          }
          else{
            $page_link .="<a href='discussion_appointment.php?page_no=".$i."'>".$i."</a>";
          }
        }
        echo $page_link;
          if($page_no < $total_no_of_pages){
            echo "<a href='discussion_appointment.php?page_no=".($page_no + 1)."'>التالي</a>";
          }

        ?>
      </div>

      </div>

      <?php
       //delete topic when supervisor click on delete button
        if(isset($_POST["del-btn"])) { 
          $appointment_ID = $_POST['ID'];
          $query3 = mysqli_query($db,"SELECT * FROM discussion_appointment WHERE ID = '$appointment_ID' ");
          while($row3 = mysqli_fetch_array($query3)){
          $booked = $row3['booked'];
          if($booked == 1){
           $msg2 ="لا يمكنك حذف موعد محجوز";
          }
          else{
            
            $query = mysqli_query($db,"DELETE FROM discussion_appointment WHERE ID = '".$_POST["ID"]."' ");
            echo "<meta http-equiv='refresh' content='0'>";

          }
        }

        }
        ?>

        <script>
            function closePopup(){
               document.getElementById("pop-up").style.display ="none";
            }
        </script>
  
   </body>
   </html>
