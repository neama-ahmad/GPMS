<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['ok-btn'])){
        $user_id = $_POST['user_id'];
        $Group_id = $_POST['group_id'];
        $ID = $_POST['ID'];

        //accept to be a member in this group 
        $query = mysqli_query($db, "INSERT INTO group_members(group_id, user_id) VALUES ('$Group_id','$user_id')");
        $query = mysqli_query($db, "UPDATE member_ask SET status = 'accept' WHERE ID =  '$ID' ");
        header("Location:mainGroup.php");
    }

    
    if(isset($_POST['deny-btn'])){
        $ID = $_POST['ID'];
        //deny to be a member in this group
        $query = mysqli_query($db, "UPDATE member_ask SET status = 'deny' WHERE ID =  '$ID' ");
        header("Location:groups.php");
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

        <title>نظام إدارة مشاريع التخرج |إشعار بإضافتك لمجموعة</title>

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
            font-size: 22px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding:20px;
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


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px ;
            font-size:14px;
            text-align: center;
            text-decoration: none;
            background-color: #038C85;
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            width:50%;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 7px;
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
            align-Items:center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width:100%;
            flex-wrap:wrap;
            height:auto;
        }
        .column2{
            width:60%;
            padding:20px;
            height:450px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px 0px;
            display: flex;
            flex-direction: column;
            align-Items: center;
            margin: 12px 20px;
            position: relative;
            border-radius: 50px 50px 0px 50px;

            

        }

        h4{
            font-size:15px;
            color: #553965;
            padding-top: 20px;
        }

        .column2 .r1{
           font-size: 16px;
           color:#038C85;
           padding:4px;
           margin:2px;
        }

        .column2 .r2{
           font-size: 15px;
           color:#555;
           padding:0px;
           margin:2px;
           margin-bottom:14px;
        }

        
        table {
      width:90%;
      direction:rtl;
      margin: 9px;
      padding: 8px;
    }

    td{
      text-align: right;
      color:#333;
      padding: 9px;
      font-size:14px;
      word-wrap:break-word;
      /*border-bottom:1px solid #ccc;*/
    }

    .bold{
      color:#038C85;
    }

    .time{
        font-size:13px;
        color: #777;
        position:absolute;
        bottom:20px;
        left: 20px;
    }

    .buttons{
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
            width:100%;
            padding: 12px;
        }



        .del{
            background-color: indianred;
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
            width:90%;
            height:450px;
            margin:20px 12px;
            padding:20px;
        }


        .button{
           width: 70%;
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
         <h3>إشعار بإضافتك لمجموعة</h3>
         <div class="row2">
        
            <?php
            $email = $_SESSION['email'];
            $query3 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row3 = mysqli_fetch_array($query3)){
              $userID = $row3['ID'];

                $query2 = mysqli_query($db,"SELECT * FROM member_ask WHERE user_id = '$userID' ");
                while($row2 = mysqli_fetch_array($query2)){
                $ID = $row2['ID'];
                $group_id = $row2['group_id'];

                $query = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$group_id' ");
                while($row = mysqli_fetch_array($query)){
                    
                ?>
                    <div class="column2">
                   <h4>تريد هذه المجموعة إضافتك لمجموعتها يمكن القبول أو الرفض</h4>
                    <table>
                    <tr><td class="bold">اسم المجموعة</td><td><?php echo $row['Group_Name'];?></td></tr>
                    <tr><td class="bold">وصف المجموعة</td><td><?php echo $row['Group_Description'];?></td></tr>
                    <tr><td class="bold">أعضاء المجموعة</td> 
                    <td>
                        <?php
                        
                        $query6 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = '$group_id' ");
                        while($row6 = mysqli_fetch_array($query6)){
                        $member_id = $row6['user_id'];

                        $query7 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$member_id' ");
                        while($row7 = mysqli_fetch_array($query7)){

                            $full_name = $row7['fullName'];
                            echo $full_name;
                            echo'<br/>';
                        }}
                        ?>
                        </td>
                        <tr>
                        <?php 
                        echo '<td>
                        <form method ="POST">
                        <input type="hidden"  name="ID" value= "'.$ID.'" readonly>
                        <input type="hidden"  name="user_id" value= "'.$userID.'" readonly>
                        <input type="hidden"  name="group_id" value= "'.$group_id.'" readonly>
                        <div class="buttons">
                        <input type="submit" name="ok-btn"  class="button" value="قبول">
                        <input type="submit" name="deny-btn" class="button del" value="رفض">
                        </div>
                        </form>
                        </td>';
                        ?>
                        </tr>
                    </table>
                  </div>
              <?php }}} ?>
        </div>

      </div>

     

   </body>
   </html>
