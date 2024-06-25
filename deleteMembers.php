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

        <title>نظام إدارة مشاريع التخرج | حذف أعضاء</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <style>
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: 700px;
            width: 100%;
            padding-top:20px;
            height:auto;
            background: red;
            box-shadow:none;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            
        }


        h3{
            font-size: 20px;
            color:#038C85;
            padding: 2px;
            margin: 2px;
        }
        .leader{
            color: #038C85;
            font-size: 14px;
            padding: 20px;
            font-style: bold;
        }

        .Bigrow{
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
            width:100%;
            height:450px;
        

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
            width:40%;
        }

        .Bigrow .column2{
            width:100%;
            padding:12px;
        }
        
        .column1 h4 {
         padding: 2px;
         margin:2px;
         color: #038C85;
        }
        .column1 p {
            word-wrap: break-word;
            font-size: 14px;
            padding: 2px;
            margin:2px;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
            width:60%;
            padding:8px 20px;
            margin: 12px;
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
            height:450px;
            /*border: 2px solid #ddd;*/
            text-align:right;
            flex-wrap: wrap;

        }

        .column2 .sub_members{
            display: flex;
            flex-direction: column;
            align-Items:center;
            justify-content:flex-start;
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
            width: 80px;
            height: 80px;
            margin: 5px;
            border-radius:50%;
            border: 2px solid #666;

        }

        .column2 p{
            text-align:center;
            text-wrap:wrap;
            word-break:break-word;
            padding:0;
            margin:0;
            font-size:14px;
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
            bottom: 70px;
        }

        .buttons2 .button{
            width: 20%;
            margin: 10px;
        }

        .buttons2 .back{
            width: 12%;
            margin:7px;
            background-color: orange;
        }

        
        #del-btn{
           background-color: indianred;
           width: 100%;
        }

        #del-btn:hover{
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
</head>
<body>
    <div  id="mother">
        <?php
          echo'
          <a href="sub_manageGroup.php?link='.$Group_id.'" class="Toback">&#8594;</a>';
        ?>   
        <div class="Bigrow">
        <div class="column2">
        
            <div class="members">
                <?php
                $query4 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = ' $Group_id' ");
                while($row4 = mysqli_fetch_array($query4)){
                    $user_id = $row4['user_id'];
                    $leadership = $row4['leadership'];
                    $query5 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$user_id' ");
                    while($row5 = mysqli_fetch_array($query5)){
                        $member_email = $row5['email'];
                        $fullName = $row5['fullName'];
                        echo 
                        '<div class="sub_members">
                        <div class="member">
                        <img src=https://th.bing.com/th/id/OIP.etPyP55EobSmSvAewS7uggHaHa?pid=ImgDet&w=474&h=474&rs=1" height = 32px width = 32px; >
                        </div>
                        <p>'.$fullName.'</p>
                        <p>'.$member_email.'</p>';
                        if($leadership == 0){
                            $query6 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$user_id' ");
                            while($row6 = mysqli_fetch_array($query6)){
                                $ID = $row6['ID'];
                            echo'
                            <form method ="POST">
                                <input type="hidden"  name="ID" value= "'.$ID.'" readonly>
                                <input type="submit" id="del-btn" name="del-btn"  class="button" value="حذف">
                            </form>';
                        }
                     }
                        else{
                            echo '<p class="leader"> قائد المجموعة</p>';
                        }
                        
                        echo '</div>';
                    }
                }
             
                ?>

           
            </div>

            </div>
        </div>

        <?php
        //delete members
        if(isset($_POST["del-btn"])&& isset($_POST["ID"])) { 
            $query = mysqli_query($db,"DELETE FROM group_members WHERE ID = '".$_POST["ID"]."' ");
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>
    </body>
</html>