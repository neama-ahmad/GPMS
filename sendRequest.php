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

        $Group_id = $_GET["link"];
       
        $request_content = $_POST['request_content'];

        $email = $_SESSION['email'];
        $query1= mysqli_query($db, "SELECT * FROM user where email = '$email' ");
        while($row = mysqli_fetch_array($query1)){
            $userID = $row['ID'];
            $gender = $row['gender'];

            //1)check if a student already has a group before
            $hasGroup = mysqli_query($db, "SELECT user_id FROM group_members where user_id = '$userID' ");
            $count2 = mysqli_num_rows($hasGroup);
            if($count2 == 1) {
                $msg = "يبدو أن لديك مجموعة..لا يمكنك الانضمام إلى مجموعة أخرى";
            }
            else{
                //2)verify the student gender is the same group members gender 
                $query2 = mysqli_query($db, "SELECT * FROM groups where ID = '$Group_id' ");
                while($row3 = mysqli_fetch_array($query2)){
                    $part = $row3['part'];
                  
                    if($gender == 'أنثى' && $part == 'طلاب'){
                        $msg="لايمكنك الانضمام إلى قروب طلاب";
                    }
        
                    elseif($gender == "ذكر" && $part == "طالبات"){
                        $msg="لايمكنك الانضمام إلى قروب طالبات";
                    }
                    
                    else{
                        //3)check if a student already send request to the same group before
                        $sameRequest = mysqli_query($db, "SELECT group_id FROM requests where group_id = '$Group_id' ");
                        $count3 = mysqli_num_rows($sameRequest);
                        if($count3 == 1) {
                            $msg = "يبدو أنك قمت بإرسال طلب انضمام لهذه المجموعة..لا يمكنك إرسال طلب آخر ";
                        }
                        else{
                            //4)verify the student not send more than three requests within 24 hours
                            $sendRequest = mysqli_query($db, "SELECT * FROM requests where user_id = '$userID' ");
                            $count4 = mysqli_num_rows($sendRequest);
                            if($count4 == 3) {
                                $msg = "يبدو أنك قمت بإرسال ثلاث طلبات انضمام لمجموعات أخرى..لا يمكنك إرسال طلب آخر ";
                            }

                            else{
                                //send request
                                $send_request = mysqli_query($db, "INSERT INTO requests(request_content,group_id, user_id) VALUES ('$request_content','$Group_id','$userID')");   
                                $msg = "تم إرسال طلبك وسوف يتم إضافتك للمجموعة في حال قبول مشرف المجموعة طلبك ويتم إشعارك أيضا في حال تم رفضك";
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

        <title>نظام إدارة مشاريع التخرج | إرسال طلب انضمام</title>

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
           word-wrap:break-word;
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
            font-size:14px;
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
            height:340px;
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
            margin-top: 12px;
        }

        #del-btn:hover{
            background:#999;
        }
        @media (max-width: 1000px){
       
        body{
            font-size: 14px;
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
            width: 60%;

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
        <a href="groups.php" class="Toback">&#8594;</a>';
        ?>
            <div class="column">

               <h3 >إرسال طلب انضمام إلى مجموعة</h3><br/>

                <?php 
                    //show error message
                    if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                    }  
                ?>
                <?php
                //show group info in table
                $Group_id = $_GET["link"];
                $Groupinfo = mysqli_query($db, "SELECT * FROM groups where ID = '$Group_id' "); 
                while($row = mysqli_fetch_array($Groupinfo)){
                    $Group_Name = $row['Group_Name'];
                    $Group_Description = $row['Group_Description'];
                    $part = $row['part'];
                 
                    echo' 
                    <table>
                    <tr>
                        <th>اسم المجموعة</th>
                        <th>وصف المجموعة</th>
                        <th>الشطر</th>
                        <th>اسم المشرف</th>
                        <th>أعضاء المجموعة</th>
                    </tr>
                    <tr>
                        <td>'.$Group_Name.'</td>
                        <td>'.$Group_Description.'</td>
                        <td>'.$part.'</td>
                        <td>';
                        $hasSupervisor = mysqli_query($db,"SELECT * FROM group_supervisor WHERE group_id = '$Group_id' ");
                        $count2 = mysqli_num_rows($hasSupervisor);
                        if($count2 < 1){
                            echo '<p>لايوجد مشرف</p>';
                        }
                        else{
                             while($row = mysqli_fetch_array($hasSupervisor)){
                                $supervisor_id = $row['user_id'];
                            $query6 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$supervisor_id' ");
                            while($row6 = mysqli_fetch_array($query6)){
                                $supervisor_Name = $row6['fullName'];
                                
                            echo $supervisor_Name;
                        }
                      }
                     
                      }
                    }
                      echo '
                      </td>
                      <td>';
                        
                        $query6 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = '$Group_id' ");
                        while($row6 = mysqli_fetch_array($query6)){
                        $user_id = $row6['user_id'];

                        $query7 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$user_id' ");
                        while($row7 = mysqli_fetch_array($query7)){

                            $full_name = $row7['fullName'];
                            echo $full_name;
                            echo'<br/>';
                        }}

                        echo '</td>';
                        ?>
                    </tr>
                    </table>
                    <br/>
                        
            <form method="POST">
                <textarea  name="request_content"  maxlength="200" placeholder="تكلم عن نفسك بشكل مختصر وعن اهتماماتك مالايزيد عن 200 حرف"  cols="3" rows= "6" class="forminput area" required></textarea>
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال طلب انضمام">
            </form>

            

         </div>
        

        </div>
        
        
      
  
    </body>
   </html>
