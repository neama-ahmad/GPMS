<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      if(isset($_POST["btn-add"])){

        $supervisorID = $_GET["link"];


        $email = $_SESSION['email'];
        $query1 = mysqli_query($db, "SELECT * FROM user where email = '$email' ");
        while($row = mysqli_fetch_array($query1)){
            $userID = $row['ID'];

            //check student belong to group first
            $hasGroup = mysqli_query($db,"SELECT user_id FROM group_members WHERE user_id = '$userID' ");
            $count = mysqli_num_rows($hasGroup);
            if($count < 1){
               $msg = "لا يمكنك تنفيذ هذه العملية إلا بعد انضمامك لمجموعة";
            }

            else{
      
            $query2 = mysqli_query($db, "SELECT * FROM group_members where user_id = '$userID' ");
            while($row1 = mysqli_fetch_array($query2)){
            $Group_id = $row1['group_id'];

            //check if a student already has a group concteed with supervisor 
            $hasSupervisor = mysqli_query($db, "SELECT group_id FROM group_supervisor where user_id = '$supervisorID' ");
            $count2 = mysqli_num_rows($hasSupervisor);
            if($count2 == 1) {
                $msg = "يبدو أن لدى مجموعتك مشرف.. لا يمكنك اختيار مشرف آخر";
            }
            else{
                //check if student's group already sent offer to the same supervisor before
                $sendOfferBefore = mysqli_query($db, "SELECT supervisor_id FROM offer WHERE group_id = '$Group_id' AND supervisor_id = '$supervisorID'");
                $count3 = mysqli_num_rows($sendOfferBefore);
                if($count3 == 1) {
                    $msg = "يبدو أنه تم إرسال طلب إشراف دراسي لهذا المشرف من قبل مجموعتكم..لايمكنك الإرسال مرة أخرى";
                }
                        else{
                            //check if a group already send offer to three supervisor before
                            $sendOffer = mysqli_query($db, "SELECT * FROM offer where group_id = '$Group_id' ");
                            $count4 = mysqli_num_rows($sendOffer);
                            if($count4 == 3) {
                                $msg = "يبدو أنكم قمتم بإرسال طلبات إشراف دراسي لثلاث مشرفين..لا يمكنكم الإرسال مرة أخرى";
                            }

                            else{
                                //send_offer
                                $send_offer = mysqli_query($db, "INSERT INTO offer(group_id, student_id,supervisor_id) VALUES ('$Group_id','$userID','$supervisorID')");   
                                $msg = "تم إرسال طلبكم إلى المشرف وسوف يتم إشعاركم في حال قبول المشرف على طلبكم أو رفضه";
                            }  

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

        <title>نظام إدارة مشاريع التخرج | إرسال مقترح للمشرف</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">

        <style>
    
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:20px;
        }

        .Toback{
            font-size:25px;
            background-color:LightSlateGray;
            text-align:center;
            border: none;
            color: white;
            text-decoration: none;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            width:5%;
            height:1%;
            padding:0;
            border-radius:5px;
            font-style:bold;
            margin-right:50px;
        }

        .Toback:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }
        
        h3{
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
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
        <a href="searchForSupervisor.php" class="Toback">&#8594;</a>';
        ?>
         <div class="column">
         
               <h3 >إرسال طلب إشراف إلى المشرف</h3><br/>

                <?php 
                    //show error message
                    if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                    }  
                ?>

                    <table>
                    <tr>
                        <th>اسم المشرف</th>
                        <th>تخصص المشرف</th>
                        <th>يمكنه الإشراف على شطر</th>
                        <th>فكرة المشروع المقترح</th>
                    </tr>
                <?php
                $supervisorID = $_GET["link"];
                $Groupinfo = mysqli_query($db, "SELECT * FROM user where ID = '$supervisorID' "); 
                while($row = mysqli_fetch_array($Groupinfo)){
                ?>

                    <tr>
                        <td ><?php echo $row['fullName']; ?></td>
                        <?php
                        $noTopics = mysqli_query($db, "SELECT user_id FROM topics where user_id = '$supervisorID' ");
                        $count = mysqli_num_rows($noTopics);
                        if($count != 1){
                        echo'
                        <td>غير محدد</td>
                        <td>غير محدد</td>
                        <td>غير محدد</td>';
                        }
                        else{
                        $topics = mysqli_query($db, "SELECT * FROM topics where user_id = '$supervisorID' "); 
                        while($row1 = mysqli_fetch_array($topics)){
                        $major = $row1['major'];
                        $part = $row1['part'];
                        $topic = $row1['topic'];
                        echo'
                        <td>'.$major.'</td>
                        <td>'.$part.'</td>
                        <td>'.$topic.'</td>';

                        }
                      }}
                      ?>

                      </table>
                
            <form method="POST" action="">  
               
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال طلب الإشراف">
            </form>

            </div>
            </div>

  
    </body>
   </html>
