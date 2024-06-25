<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if($_SERVER["REQUEST_METHOD"] == "POST") {
      //add new member
      if(isset($_POST["btn-add"])){

        $Group_id = $_GET["link"];
       
        $user_email = $_POST['user_email'];

        $email = $_SESSION['email'];
        $query1= mysqli_query($db, "SELECT * FROM user where email = '$email' ");
        while($row = mysqli_fetch_array($query1)){
            $userID = $row['ID'];
            $gender = $row['gender'];


        $query_user = mysqli_query($db,"SELECT * FROM user WHERE email = '$user_email' ");
        while($row1 = mysqli_fetch_array($query_user)){
            $member_userID = $row1['ID'];
            $member_Active = $row1['Active'];
            $member_gender = $row1['gender'];
            $member_role = $row1['role'];
    

        //check first member email if exists in the system or not
        $check_user_email = mysqli_query($db,"SELECT email FROM user WHERE email = '$user_email' ");
        $count = mysqli_num_rows($check_user_email);
       
        if($count > 0){
            if($member_role != 'طالب'){
                $msg = "تأكد من صحة البريد الالكتروني لهذا العضو**" ;
            }
            else{
                if($member_Active == 0 ){
                    $msg = "يبدو أن هذا العضو لديه حساب غير مفعل..يمكنه الانتظار حتى يتم تفعيل حسابه";
                }
               
                else{

                    //check if a member already has a group before
                    $member_hasGroup = mysqli_query($db, "SELECT user_id FROM group_members where user_id = '$member_userID' ");
                    $count2 = mysqli_num_rows($member_hasGroup);
                    if($count2 == 1) {
                        $msg = "يبدو أن هذا العضو سبق له الانضمام إلى مجموعة.. لا يمكنك إضافته إلى مجموعة أخرى";
                    }

                    else{
                        //check member gender
                        if($gender == 'أنثى' && $member_gender == 'ذكر'){
                            $msg="لا يمكن إضافة طالب إلى مجموعتك";
                        }
        
                        elseif($gender == 'ذكر' && $member_gender == 'أنثى'){
                            $msg="لا يمكن إضافة طالبة إلى مجموعتك";
                        }
                    
                        else{
                            $member_ask_before = mysqli_query($db, "SELECT user_id FROM member_ask where user_id = '$member_userID' ");
                            $count3 = mysqli_num_rows($member_ask_before);
                            if($count3 == 1) {
                                $msg = "تم إشعار هذا الطالب من قبل..انتظر حتى يقوم بالموافقة";
                            }
                            else{

                                $query = mysqli_query($db, "INSERT INTO member_ask(group_id, user_id) VALUES ('$Group_id','$member_userID')");
                                $msg = "تم إشعار الطالب..وسوف يتم إضافته للمجموعة بعد موافقة الطالب";

                            }
                            
                        }
                    }
                }

            }

        }

        else{
            $msg = "تأكد من صحة البريد الالكتروني لهذا العضو";
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

        <title>نظام إدارة مشاريع التخرج | إضافة أعضاء للمجموعة</title>

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
            margin-right:10px;
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

        .row2{
            padding-top:12px;
            align-Items:right;
            justify-content: flex-start;
            width:100%;
        }
        .column2{
            width:30%;
            padding:8px;
            height:300px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px 0px;
            display: flex;
            flex-direction: column;
            align-Items: center;
            margin: 12px 20px;
            

        }

        h3{
            padding-top: 40px;
            padding-bottom:0px;
        }

        h4{
            padding:4px;
            margin:4px;
            padding-top: 20px;
            font-size:15px;
        }

        #del-btn{
            width:60px;
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
        <a href="myGroup.php" class="Toback">&#8594;</a>';
        ?>
          <div class="column">

            <form method="POST" action="">
               <h3 >إضافة أعضاء للمجموعة</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                     }  
                  ?>
                <h4>إضافة عضو جديد</h4>
                <input type = "email"  name="user_email" class="forminput" placeholder="البريد الالكتروني" required>
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إضافة">
            </form>

            

         </div>
        

        </div>

     
  
   </body>
   </html>
