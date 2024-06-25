<?php
    require_once "config.php";
    require_once "session.php";
 
    //to stop showing this page if not login in
    if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST"){

       //Create new group
       if(isset($_POST["btn-add"])){

        $Group_Name = $_POST['Group_Name'];
        $Group_Description = $_POST['Group_Description'];
        $part = $_POST['part'];
        $user1_email = $_POST['user1_email'];
        $user2_email = $_POST['user2_email'];


       
        $query= mysqli_query($db, "SELECT * FROM user where email = '$user1_email' ");
        while($row = mysqli_fetch_array($query)){
            $user1_ID = $row['ID'];
            $gender1 = $row['gender'];
            $Active1 = $row['Active'];
            $role1 = $row['role'];

        $query_user2 = mysqli_query($db,"SELECT * FROM user WHERE email = '$user2_email' ");
        while($row1 = mysqli_fetch_array($query_user2)){
            $member_userID = $row1['ID'];
            $member_Active = $row1['Active'];
            $member_gender = $row1['gender'];
            $member_role = $row1['role'];


            $check_user1_email = mysqli_query($db,"SELECT email FROM user WHERE email = '$user1_email' ");
            $count1 = mysqli_num_rows($check_user1_email);

            $check_user2_email = mysqli_query($db,"SELECT email FROM user WHERE email = '$user2_email' ");
            $count2 = mysqli_num_rows($check_user2_email);

            //verify the first member is not the same second member
            if($user1_email == $user2_email){
                $msg = "تأكد من صحة مدخلاتك..قمت بتكرار البريد الالكتروني لكلا العضوين";

            }
            //check two members accounts are exist
            elseif($count1 < 1 || $count2 < 1){
                $msg = "تأكد من صحة البريد الالكتروني أعضاء المجموعة";
            }

            elseif($count1 == 1 || $count2 == 1){
               //check two members accounts are active
                if($Active1 == 0 || $member_Active == 0 ){
                    $msg = "يبدو أن العضو الثاني في المجموعة لديه حساب غير مفعل..يمكنه الانتظار حتى يتم تفعيل حسابه";
                }

                else{
                    if($role1 != 'طالب' || $member_role != 'طالب' ){
                        $msg = "تأكد من صحة البريد الالكتروني للأعضاء**" ;
                    }
                    else{
                        //check if a member already has a group before
                        $user1_hasGroup = mysqli_query($db, "SELECT user_id FROM group_members where user_id = '$user1_email' ");
                        $count3 = mysqli_num_rows($user1_hasGroup);

                        $member_hasGroup = mysqli_query($db, "SELECT user_id FROM group_members where user_id = '$member_userID' ");
                        $count4 = mysqli_num_rows($member_hasGroup);
                        
                        //verify two members have not group
                        if($count3 == 1 || $count4 == 1) {
                            $msg = "يبدو أن أحدى الأعضاء سبق له الانضمام إلى مجموعة.. لا يمكنك إضافته إلى مجموعة أخرى";
                        }

                        else{
                           //check member gender
                           if($gender1 == 'أنثى' && $member_gender == 'ذكر'){
                                $msg="يجب أن يكون الأعضاء من نفس الشطر إما طلاب أو طالبات";
                            }
        
                            elseif($gender1 == 'ذكر' && $member_gender == 'أنثى'){
                                $msg="يجب أن يكون الأعضاء من نفس الشطر إما طلاب أو طالبات";
                            }

                            else{
                                //check group name is uniqe
                                $queryGroupName = mysqli_query($db, "SELECT Group_Name FROM groups WHERE Group_Name = '$Group_Name' ");
                                $count3 = mysqli_num_rows($queryGroupName);
                                if($count3 > 0 ){
                                    $msg = "اسم المجموعة محجوز قم بتغير الاسم إلى اسم آخر";

                                }
                                else{

                                //insert group data to DB
                                $query1 = mysqli_query($db, "INSERT INTO groups (Group_Name, Group_Description, part) VALUES ('$Group_Name','$Group_Description','$part')");
                            
                               //get Group_id from last insert and insert group_members data into DB
                               $Group_id = mysqli_insert_id($db);
                                if($Group_id){
                                    $query2 = mysqli_query($db, "INSERT INTO group_members (group_id, user_id, leadership) VALUES ('$Group_id','$user1_ID', 1)");
                                    $query3 = mysqli_query($db, "INSERT INTO group_members (group_id, user_id) VALUES ('$Group_id','$member_userID')");
                                }
                                header('Location:manageGroup.php');

                            }
                        }

                    }

                    
                }

                }
                
               
            }

            else {
                echo '';
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

        <title>نظام إدارة مشاريع التخرج | إنشاء مجموعة جديدة</title>

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
            text-align:center;
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


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
            width:24%;
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

        .column2 .r1{
           font-size: 14px;
           color:#038C85;
           padding:4px;
           margin:2px;
        }

        .column2 .r2{
           font-size: 14px;
           color:#555;
           padding:0px;
           margin:2px;
           margin-bottom:14px;
        }

        #del-btn{
            width:60px;
            background-color: indianred;
            margin:0;
        }

        #del-btn:hover{
            background:#999;
        }

        h4{
            padding:2px;
            padding-top:16px;
            margin:2px;
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
          <a href="manageGroup.php" class="Toback">&#8594;</a>';
        ?>
         <div class="column">

            <!--form-->
            <form method="POST" action="">
               <h3 >إنشاء مجموعة جديدة</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                     }  
                  ?>

               <input type="text"  name="Group_Name" class="forminput" placeholder="اختر اسم للمجموعة"  required>
               <textarea  name="Group_Description" placeholder="  قم بكتابة مالا يزيد عن 100 حرف بوصف المشاريع التي تهتم بها المجموعة"  cols="3" rows= "6" class="forminput area" maxlength="100" required></textarea>
                <h4>حدد الشطر التي تتبع لها المجموعة</h4>
               <select name="part"  class="forminput" required>
               <option value="">اختر...</option>
                  <?php
                     $part = array("طالبات" , "طلاب");
                     foreach($part as $item){
                        echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                     }
                  ?>
               </select>  
               <h4>قم بإضافة العضو الأول للمجموعة (القائد)</h4>
               <input type="email"  name="user1_email" class="forminput" placeholder=" أدخل البريد الالكتروني الخاص به"  required>
               <h4>قم بإضافة العضو الثاني للمجموعة</h4>
                <input type="email"  name="user2_email" class="forminput" placeholder=" أدخل البريد الالكتروني الخاص به"  required>
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إنشاء">
            </form>

            

         </div>
        

        </div>

     
  
   </body>
   </html>
