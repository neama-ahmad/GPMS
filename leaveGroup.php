<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
    if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
    }


    if($_SERVER["REQUEST_METHOD"] == "POST") {

        //
        if(isset($_POST['ok-btn'])){
            $ID = $_POST['ID'];
            $email = $_SESSION['email'];
            $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row = mysqli_fetch_array($query1)){
            $myID = $row['ID'];
            $query = mysqli_query($db, "UPDATE group_members SET leadership = 1 WHERE user_id =  '$ID' ");
            $query = mysqli_query($db, "UPDATE group_members SET leadership = 0 WHERE user_id =  '$myID' ");
            $msg = "تمت عملية تحويل القيادة";
            }
        }

        if(isset($_POST['leave-btn'])){
            $user_id = $_POST['user_id'];
            $query2 = mysqli_query($db, "SELECT * FROM  group_members WHERE user_id = '$user_id'");
            while($row4 = mysqli_fetch_array($query2)){
                $can_leave = $row4['can_laeve'];
                $leadership = $row4['leadership'];
                if($leadership == 1){
                   $msg = 'قم بتحويل القيادة أولا لعضو آخر';
                }
                else{
                    if($can_leave == 'no'){
                        $msg='لا يمكنك مغادرة المجموعة ..انتهت مهلة المغادرة';
                    }
                    else{
                        $query = mysqli_query($db, "DELETE FROM  group_members WHERE user_id =  '$user_id' ");
                        header("Location:mainGroup.php");
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

        <title>نظام إدارة مشاريع التخرج | مغادرة المجموعة</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <style>
        #mother{
            display:flex;
            flex-direction:column;
            align-Items:center;
            justify-content: center;
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
        }

        .Bigrow{
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
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
            width:90%;
            padding:12px;
        }
        
        .column1 h4 {
         padding: 2px;
         margin:0px;
         color: #038C85;
         margin-top:12px;
         font-size:14px;
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
            width:36%;
            margin: 9px;
            display: inline;
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
            width:18%;
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
            width: 74px;
            height: 74px;
            margin: 5px;
            border-radius:50%;
            border: 1px solid #888;

        }

        .column2 p{
            font-size:14px;
            text-align:center;
            text-wrap:wrap;
            word-break:break-word;
            padding:9px;
            margin:4px;
        }

        .column2 .ok-btn{
            font-size:12px;
            width: 100%;
        }

        .column2 .ok-btn:hover{
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
        
        .column2 .leave-btn{
           background-color: indianred;
           width:30%;
           float:left;
        }

        .column2 .leave-btn:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
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
          
            <div class="Bigrow">
                <div class="column2">
                  <?php 
                    //show error message
                    if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                    }  
                    ?>
                    <h3>قم بتحويل القيادة أولا لعضو آخر</h3><br/>
                    <div class="members">
                     <?php
                        $email = $_SESSION['email'];
                        $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
                        while($row = mysqli_fetch_array($query1)){
                        $userID = $row['ID'];
           
                        $query2 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
                        while($row2 = mysqli_fetch_array($query2)){
                        $Group_id = $row2['group_id'];
                           
                        $query4 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = ' $Group_id' ");
                        while($row4 = mysqli_fetch_array($query4)){
                        $user_id = $row4['user_id'];
                        $leadership = $row4['leadership'];

                        $query5 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$user_id' ");
                        while($row5 = mysqli_fetch_array($query5)){
                        $email = $_SESSION['email'];
                        $member_email = $row5['email'];
                        $fullName = $row5['fullName'];
                        $ID = $row5['ID'];
                              

                        echo 
                        '<div class="sub_members">
                            <div class="member">
                                <img src=https://th.bing.com/th/id/OIP.etPyP55EobSmSvAewS7uggHaHa?pid=ImgDet&w=474&h=474&rs=1" height = 30px width = 30px; >
                            </div>';
                            if($member_email == $email){
                                echo '<p style="font-size:14px">أنا</p>';
                            }
                            else{
                                echo'<p style="font-size:14px">'.$fullName.'</p>
                                <form method ="POST">
                                <input type="hidden"  name="ID" value= "'.$ID.'" readonly>
                                <input type="submit" name="ok-btn"  class="button ok-btn" value="تسليم القيادة">
                                </form>';       
                            }

                            if($leadership == 1){
                                echo '<h4 style="color:green;padding:2; margin:0; text-align:center;font-size:14px;">قائد المجموعة</h4>';
                            }

                                   
                        echo '
                            
                        </div>';
                        }
                    }
                            
                       ?>
                    </div>
    
                    <?php
                    echo'
                    <form method ="POST">
                    <input type="hidden"  name="ID" value= "'.$user_id.'" readonly>
                    <input type="submit" name="leave-btn"  class="button leave-btn" value="مغادرة المجموعة">
                    </form>';     
                    
                    ?>
                    
                    
                </div>

            </div>
           
            
        </div>
        
        

    <?php 
     }}
    ?>
    </body>
</html>