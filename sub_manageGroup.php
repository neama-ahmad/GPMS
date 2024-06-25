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

        <title>نظام إدارة مشاريع التخرج | مجموعتي</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <style>
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 95%;
            padding-top:30px;
            height:600px;
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
            text-align:center;
        }

        .Bigrow{
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            width:100%;
            height:100%;
        

        }
        
        .Bigrow .column1 ,.Bigrow .column2{
            display: flex;
            flex-direction: column;
            align-Items:right;
            justify-content: flex-start;
            padding: 12px;
            margin: 12px;
            height:80%;
            border: 2px solid #ddd;
            text-align:right;
            position: relative;
          
        }

        .Bigrow .column1{
            width:39%;
        }

        .Bigrow .column2{
            width:54%;
            padding:12px;
        }
        
        .column1 h4 {
         padding: 2px;
         margin:0px;
         color: #038C85;
         margin-top:12px;
         font-size: 14px;
        }
        .column1 p {
            word-wrap: break-word;
            font-size: 14px;
            padding: 0px;
            margin:0px;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
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
            width:40%;
            margin: 2px;
            display: inline;
        }

        .column1 .edit-btn{
            background-color: #F5B041;
            width: 50%;
        }

        .column1 .edit-btn:hover{
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
            height:100%;
            /*border: 2px solid #ddd;*/
            text-align:right;
            flex-wrap: wrap;

        }

        .column2 .sub_members{
            display: flex;
            flex-direction: column;
            align-Items:center;
            width:20%;
            height:280px;
            /*border: 2px solid #ddd;*/
            text-align:right;
            flex-wrap: wrap;

        }

        .column2 .member{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin: 5px;
            border-radius:50%;
            border: 1px solid #555;

        }

        .column2 p{
            font-size:14px;
            text-align:center;
            text-wrap:wrap;
            word-break:break-word;
            padding:0;
            margin:0;
        }

        .column2 h4{
            font-size:14px;
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
            padding: 10px 0px;
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
            bottom: 70px;
        }

        .buttons2 .button{
            width: 20%;
            margin: 10px;
        }
        
        .Buttonrow .del-btn{
           background-color: indianred;
           width:50%;
        }

        .Buttonrow .del-btn:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .buttons2 .back{
            width: 12%;
            margin:7px;
            background-color: orange;
        }

    
        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        #mother h3{
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
        <div id="mother">
        <?php
          echo'
          <a href="manageGroup.php?link='.$Group_id.'" class="Toback">&#8594;</a>';
        ?>
           <?php 
           //show error message
            if(!empty($msg)) {
                echo "<p id='error'>$msg</p>";
            }  
            ?>
            <?php
             $query1 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
             while($row = mysqli_fetch_array($query1)){
                $userID = $row['ID'];

                $query3 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                while($row3 = mysqli_fetch_array($query3)){
                    $Group_Name = $row3['Group_Name'];
                    $Group_Description = $row3['Group_Description'];
                    $part= $row3['part'];
            ?>
            <div class="Bigrow">
                <div class ="column1">
                    <h4>اسم المجموعة</h4>
                    <p><?php echo $Group_Name; ?></p>

                    <h4>وصف المجموعة</h4>
                    <p><?php echo $Group_Description; ?></p>

                    <h4>الشطر</h4>
                    <p><?php echo $part; ?></p>

                    <h4>المشرف</h4>
                    <p><?php 
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
                                
                            echo '<p>'.$supervisor_Name.'</p>';
                        }
                      }
                    }
                    }
                      ?>
                    <div class="Buttonrow">
                        <a  href="admin_editGroupinfo.php?link=<?php echo $Group_id;?>" class="button edit-btn">تعديل بيانات المجموعة</a>
                    </div>
                </div>

                <div class="column2">
                    <div class="members">
                    <?php
                        $query4 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = ' $Group_id' ");
                        while($row4 = mysqli_fetch_array($query4)){
                            $user_id = $row4['user_id'];
                            $leadership = $row4['leadership'];
                            $query5 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$user_id' ");
                            while($row5 = mysqli_fetch_array($query5)){
                                $email = $_SESSION['email'];
                                $member_email = $row5['email'];
                                $fullName = $row5['fullName'];
                              

                                echo 
                                '<div class="sub_members">
                                    <div class="member">
                                    <img src=https://th.bing.com/th/id/OIP.etPyP55EobSmSvAewS7uggHaHa?pid=ImgDet&w=474&h=474&rs=1" height = 30px width = 30px; >
                                    </div>';
                                        echo'
                                        <p>'.$fullName.'</p>';

                                    if($leadership == 1){
                                        echo '<h4 style="color:green;adding:2; margin:0;">قائد المجموعة</h4>';
                                    }

                                   
                                echo '
                            
                                </div>';
                            }
                        }
             
                    ?>
                    <div class="Buttonrow">
                        <?php
                         $enough_members = mysqli_query($db, "SELECT * FROM group_members where group_id = '$Group_id' ");
                         $count5 = mysqli_num_rows($enough_members);
                         if($count5 < 5) {
                            echo ' <a href="admin_AddMembers.php?link='.$Group_id.'" class="button">إضافة أعضاء</a>';
                         }
 
                        ?>
                        <a href="deleteMembers.php?link=<?php echo $Group_id;?>"  class="button">حذف أعضاء </a> 
                    </div>
                </div>

            </div>
          
            
        </div>
        
        

    <?php 
     }
    ?>
    </body>
</html>