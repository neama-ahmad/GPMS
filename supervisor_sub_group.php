<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
    if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
    }

    $Group_id = $_GET["link"]; 
?>
<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.0.0/css/all.css">
        
        <title>نظام إدارة مشاريع التخرج | مجموعتي</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <style>
        .mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 95%;
            padding-top:10px;
            height:650px;
            background: none;
            box-shadow:none;
            margin: 30px;
            padding: 20px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            
        }

        h3{
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
        }

        .Bigrow{
            display: flex;
            flex-direction: row;
 
            justify-content: flex-start;
            width:100%;
            height:600px;
        

        }
        
        .Bigrow .column1 ,.Bigrow .column2{
            display: flex;
            flex-direction: column;
            align-Items:right;
            justify-content: flex-start;
            padding: 20px;
            margin: 12px;
            height:400px;
            border: 2px solid #ddd;
            text-align:right;
            position: relative;
          
        }

        .Bigrow .column1{
            width:30%;
        }

        .Bigrow .column2{
            width:57%;
            padding:12px;
        }
        
        .column1 h4 {
         padding: 0px;
         margin:0px;
         margin-top:12px;
         color: #038C85;
         font-size:15px;
        }
        .column1 p {
            word-wrap: break-word;
            font-size: 14px;
            padding: 2px;
            margin:0px;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
            width:22%;
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


        .column1 .button , .column2 .button {
            width:36%;
            margin: 9px;
            display: inline;
        }

        .edit-btn{
            background-color: #F5B041;
            width: 60%;
        }

        .edit-btn:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;

        }

        .column2 .members{
            display: flex;
            flex-direction: row;
            align-Items:right;
            justify-content: flex-start;
            width:100%;
            height:250px;
            /*border: 2px solid #ddd;*/
            text-align:right;
            flex-wrap: wrap;

        }

        .column2 .sub_members{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content:flex-start;
            width:20%;
            height:200px;
            padding-top:12px;
            /*border: 2px solid #ddd;*/
            text-align:right;
            flex-wrap: wrap;
            

        }

        .super_members{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content:center;
            width:100%;
            height:180px;
            border: 2px solid #ddd;
            text-align:right;
            flex-wrap: wrap;

        }

        .column2 .member{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content: center;
            width: 60px;
            height: 60px;
            margin: 5px;
            border-radius:50%;
            border: 2px solid #666;

        }

        .super_members .member{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content: center;
            width: 90px;
            height: 90px;
            margin: 5px;
            border-radius:50%;
            border: 2px solid #666;

        }

        .column2 p{
            font-size: 15px;
            text-align:center;
            text-wrap:wrap;
            word-break:break-word;
            padding:0;
            margin:0;
        }


        .forminput{
            padding: 8px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 8px;
            width: 60%;
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

    
        
        .Buttonrow{
            width: 100%;
            height:auto;
            padding: 20px 0px;
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
            position: absolute;
            bottom:0;
            left:0;

        }

        .buttons2{
            padding: 20px;
            bottom: 80px;
        }

        .buttons2 .button{
            width: 20%;
            margin: 10px;
        }
        
        .buttons2 .del-btn{
           background-color: indianred;
        }

        .buttons2 .del-btn:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

    
        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        .mother h3{
            font-size: 20px;
        }
        
       
        .row{
            width:100%;
        
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

    

    }



    </style>
    </haed> 
    <body>
        
            <?php
            $email = $_SESSION['email'];
            $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row = mysqli_fetch_array($query1)){
               $userID = $row['ID'];

                $hasGroup = mysqli_query($db, "SELECT * FROM group_supervisor WHERE user_id = '$userID' ");
                $count3 = mysqli_num_rows($hasGroup);
                if($count3 < 1 ){
                 echo '<p style="text-align:center;">لست مشرفا على مجموعة حتى الآن</p>';
                }

                else{
                 
                    $query3 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                    while($row3 = mysqli_fetch_array($query3)){
                    $Group_Name = $row3['Group_Name'];
                    $Group_Description = $row3['Group_Description'];
                    $part = $row3['part'];

                    $query6 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$userID' ");
                    while($row6 = mysqli_fetch_array($query6)){
                    $supervisor_Name = $row6['fullName'];
                    $super_email = $row6['email'];
                         
                
                
                
                ?>
            <div class="mother">  
            <?php
              echo'
              <a href="supervisor_group.php" class="Toback">&#8594;</a>';
            ?>
        
            <div class="Bigrow">
                <div class ="column1">
                    <h4>اسم المجموعة</h4>
                    <p><?php echo $Group_Name; ?></p>

                    <h4>وصف المجموعة</h4>
                    <p><?php echo $Group_Description; ?></p>

                    <h4>القسم</h4>
                    <p><?php echo $part; ?></p>

                    <h4>المشرف</h4>
                    <?php 
                     
                     echo '<p>'.$supervisor_Name.'</p>';
                        
                
                   ?>

                </div>

                <div class="column2">
                    <div class="members">
                        <?php
                          
                        
                        echo '<div class="super_members">
                        <div class="member">
                            <img src=https://th.bing.com/th/id/OIP.etPyP55EobSmSvAewS7uggHaHa?pid=ImgDet&w=474&h=474&rs=1" height = 35px width = 35px; >
                            
                        </div>
                        <p>'.$supervisor_Name.'</p>
                        <h4 style="color:green;adding:2; margin:0;">المشرف</h4>
                        
                        </div>';
                    
                        $query4 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = ' $Group_id' ");
                        while($row4 = mysqli_fetch_array($query4)){
                            $group_id = $row4['group_id'];
                            $student_id = $row4['user_id'];
                            $query5 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$student_id' ");
                            while($row5 = mysqli_fetch_array($query5)){
                                $member_email = $row5['email'];
                                $fullName = $row5['fullName'];
                                $leadership = $row4['leadership'];
                                echo 
                                '<div class="sub_members">
                                    <div class="member">
                                    <img src=https://th.bing.com/th/id/OIP.etPyP55EobSmSvAewS7uggHaHa?pid=ImgDet&w=474&h=474&rs=1" height = 30px width = 30px; >
                                    </div>';
                                    if($member_email == $email){
                                        echo '<p>أنا</p>';
                                    }
                                    else{
                                        echo'
                                        <p>'.$fullName.'</p>';
                                  
                                    }

                                    if($leadership == 1){
                                        echo '<h5 style="color:green;adding:2; margin:0;">قائد المجموعة</h5>';
                                    }

                                   
                                echo '
                            
                                </div>';
                            }
                        }

                    }

                }
                
            
                ?>
             
                        
                </div>

           </div>
           <div class="Buttonrow buttons2">
           <?php
           echo'
              <a href="supervisor_files.php?link='.$group_id.'" class="button base"><i class="fa fa-file"></i>    الملفات</a>
              <a  href="supervisor_chat.php?link='.$group_id.'" class="button base"> <i class="fa fa-message"></i>  الرسائل</a>';
           ?>
           </div>
            
        </div>
    </div>
    <?php }}?>
        
    </body>
</html>