<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }

   //get appointment_ID from last page using get method
   $appointment_ID = $_GET["link"];

   //using post method
   if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["btn-add"])){

       $Group_id = $_POST['group_Name'];
       $first_examiner_id = $_POST['first_examiner'];
       $second_examiner_id = $_POST['second_examiner'];
       $discussion_Name = $_POST['discussion_Name'];


      //check if group has discussion before
      $has_discussion = mysqli_query($db, "SELECT group_id FROM final_discussion WHERE group_id = '$Group_id' ");
      $count = mysqli_num_rows($has_discussion);
      if($count > 0){
          $msg = "يبدو أنه تم تحديد موعد مناقشة لهذه المجموعة ";
      }

      else{
          //check the first examiner is not the same group's supervisor
          $check_first_examiner = mysqli_query($db, "SELECT user_id FROM group_supervisor WHERE user_id = '$first_examiner_id' AND group_id = '$Group_id' ");
          $count1 = mysqli_num_rows($check_first_examiner); 
          if($count1 > 0){
             $msg = "لا يمكن تحديد مشرف المجموعة مختبرا لمجموعته.. قم بتغيير المختبر الأول ";
          }

          else{
              //check the second examiner is not the same group's supervisor
              $check_second_examiner = mysqli_query($db, "SELECT user_id FROM group_supervisor WHERE user_id = '$second_examiner_id' AND group_id = '$Group_id' ");
              $count2 = mysqli_num_rows($check_second_examiner) ;
              if($count2 > 0){
                 $msg = "لا يمكن تحديد مشرف المجموعة مختبرا لمجموعته.. قم بتغيير المختبر الثاني ";
              }

              else{
                  //verify the two examiners selected is not the same examiners
                  if($first_examiner_id == $second_examiner_id){
                      $msg ="لا تقوم بتكرار المختبر..حدد مختبرين مختلفين";

                  }

                  else{
                      //verify the discussion name is uniqe
                      $check_discussion_Name = mysqli_query($db, "SELECT discussion_Name FROM final_discussion WHERE discussion_Name = '$discussion_Name' ");
                      $count3 = mysqli_num_rows($check_discussion_Name);
                      if($count3 > 0 ){
                          $msg = "قم بتسمية المناقشة بإسم غير مكرر..تم التسمية بهذا الاسم من قبل";
                      }

                      else{
                          //craete new discussion
                          $Create_discussion = mysqli_query($db, "INSERT INTO final_discussion (discussion_Name, group_id, appointment_ID) VALUES ('$discussion_Name', '$Group_id', '$appointment_ID')");
                          
                          //get final_discussion_id from last insert and insert examiners data into DB
                          $final_discussion_id = mysqli_insert_id($db);
                          if($final_discussion_id){
                            $add_examiner1 = mysqli_query($db, "INSERT INTO discussion_user (user_id, rank, final_discussion_ID) VALUES ('$first_examiner_id', 1 , '$final_discussion_id')");
                            $add_examiner2 = mysqli_query($db, "INSERT INTO discussion_user (user_id, rank, final_discussion_ID) VALUES ('$second_examiner_id', 2 , '$final_discussion_id')");
                          }
                          $book_appintment = mysqli_query($db, "UPDATE discussion_appointment SET booked = 1 WHERE ID = '$appointment_ID' ");
                             
                          header('Location:discussions.php');
                      }
                  
                  }

              }
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

        <title>نظام إدارة مشاريع التخرج | حجز موعد المناقشة النهائية</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">

        <style>
    
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:30px;
        }

        h3{
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            text-align:center;
        }
        
        .column{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content: center;
            width:100%;
            height:auto;
            background: none;
            box-shadow:none;
        }

        .column form{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content: center;
            width:100%;
            height:auto;
            background: none;
            box-shadow:none;
            padding-bottom: 40px;
        }

        .buttons{
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
            width:100%;
            padding: 12px;
        }

        .buttons .back{
            width: 12%;
            background-color: orange;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
            width:18%;
            margin: 9px;
            font-size:14px;
            text-align: center;
            text-decoration: none;
            background-color: #038C85;
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 8px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 8px;
            width: 50%;
            border: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            font-family: 'JF Flat Regular', sans-serif;
            background-color: transparent;
            border-radius: 10px;
        }

        #error{
            display:inline-block;
            font-size:15px;
            text-align: center;
            width: 50%;
            padding:9px;
            padding-right:20px;
            background-color: Gainsboro;
            color:#666;
            border-radius:5px;
                
        }
        *:focus{
            outline:none;
        }

        table {
           width:80%;
           direction:rtl;
           padding-bottom: 20px;
        }

        td{
            text-align: center;
            color:#333;
            padding: 9px;
            font-size:14px;
            word-wrap:break-word;
            border-bottom:1px solid #ccc;
        }

        th{
            font-size:15px;
            border-bottom:1px solid #ccc;
            color:#038C85;
        }

        .row2{
            display:flex;
            flex-direction:row;
            padding-top:12px;
            align-Items:right;
            justify-content: flex-start;
            width:100%;
            height:auto;
            flex-wrap:wrap;
        }
        .column2{
            width:30%;
            padding:8px;
            height:450px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px 0px;
            display: flex;
            flex-direction: column;
            align-Items: center;
            margin: 12px 20px;
            

        }

        .column2 table {
      width:90%;
      direction:rtl;
      margin: 6px 20px;
      word-wrap:break-word;
    }

    .column2 td{
      text-align: right;
      color:#333;
      padding: 9px;
      font-size:14px;
      word-wrap:break-word;
      border-bottom:1px solid #ccc;
    }

    .column2 .bold{
      color:#038C85;
    }

   


        h3{
            padding-top: 40px;
            padding-bottom:0px;
        }

        h4{
            padding:4px;
            margin:4px;
            padding-top: 20px;
        }

        #del-btn{
            width:30%;
            background-color: indianred;
            margin:0;
        }

        #del-btn:hover{
            background:#999;
        }
        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        #mother h3{
            font-size: 20px;
        }
        
        .row2{
            padding-top:12px;
            align-Items:center;
            justify-content: center;
            width:100%;
        }
        .column2{
            width:100%;
            height:350px;
            margin:20px 12px;
            padding:10px;
        }


        .button{
            padding: 6px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 8px;
            margin: 8px;
            width: 80%;

        }

        #error{
            width: 90%
                
        }

        #del-btn{
            padding: 12px;
            width:100px;
        }

    

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
         
               <h3 >حجز موعد المناقشة النهائية</h3>

                    <table>
                    <tr>
                        <th>اليوم</th>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th>المكان</th>                        
                    </tr>
                <?php

                $query = mysqli_query($db, "SELECT * FROM discussion_appointment WHERE ID = '$appointment_ID' "); 
                while($row = mysqli_fetch_array($query)){
                ?>

                <tr>
                    <td><?php echo $row['discussion_day']; ?></td>
                    <td><?php echo $row['discussion_date']; ?></td>
                    <td><?php echo $row['discussion_time']; ?></td>
                    <td><?php echo $row['discussion_place']; ?></td>
                </tr>
                <?php } ?>

            </table>
                
            <form method="POST" action="">
            <?php 
                    //show error message
                    if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                    }  
                ?>
                  
            <h4>حدد المجموعة</h4>
                <select name="group_Name"  class="forminput" required>
                <option value="">اختر...</option>
                  <?php
                    $query1 = mysqli_query($db,"SELECT * FROM groups");
                    while($row1 = mysqli_fetch_array($query1)){
                        echo "<option value=". $row1['ID']. ">" .$row1['Group_Name']."</option>";
                    }
                  ?>
                </select>

                <h4>حدد المختبر الأول</h4>
                <select name="first_examiner"  class="forminput" required>
                <option value="">اختر...</option>
                  <?php
                    $query2 = mysqli_query($db,"SELECT * FROM user WHERE role = 'مختبر' AND Active = 1 ");
                    while($row2 = mysqli_fetch_array($query2)){
                        echo "<option value=". $row2['ID']. ">" .$row2['fullName']."</option>";
                    }
                  ?>
               </select>  

               <h4>حدد المختبر الثاني</h4>
                <select name="second_examiner"  class="forminput" required>
                <option value="">اختر...</option>
                  <?php
                    $query3 = mysqli_query($db,"SELECT * FROM user WHERE role = 'مختبر' AND Active = 1 ");
                    while($row3 = mysqli_fetch_array($query3)){
                        echo "<option value=". $row3['ID']. ">" .$row3['fullName']."</option>";
                    }
                  ?>
               </select> 
               <input type="text" name="discussion_Name" class="forminput" minlength="4" placeholder="قم بتسمية هذه المناقشة"  required >
               
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="تأكيد">
            </form>

            </div>
            </div>

        
     
  
    </body>
   </html>
