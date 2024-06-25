<?php 
    require_once "config.php";
    require_once "session.php";
 
    //to stop showing this page if not login in
    if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
    }
?>


<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>نظام إدارة مشاريع التخرج | جدول المناقشة النهائية</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">

        <style>
    
        #mother{
            display:flex;
            flex-direction:column;
            align-Items:center;
            justify-content: center;
            height: auto;
            width: 100%;
            padding-top:30px;
        }

        h3{
            font-size: 20px;
            color: #f16465;
            margin: 2px;
            padding-top:30px;
            padding-bottom:16px;
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
            padding-bottom: 20px;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
            width:20%;
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
            padding: 7px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 8px;
            width: 45%;
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
            display:flex;
            flex-direction:row;
            padding-top:12px;
            align-Items:center;
            justify-content: center;
            width:100%;
            height:auto;
            flex-wrap:wrap;
        }
        .column2{
            width:50%;
            padding:8px;
            height:400px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px 0px;
            display: flex;
            flex-direction: column;
            align-Items: center;
            margin: 12px 20px;
            

        }

        h4{
            font-size:14px;
            padding:0;
            margin:0;
            color: #555;
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
      margin: 6px 20px;
    }

    td{
      text-align: right;
      color:#333;
      padding: 12px;
      font-size:14px;
      word-wrap:break-word;
      border-bottom:1px solid #ccc;
    }

    .bold{
      color:#038C85;
    }


        #del-btn{
            width:60px;
            background-color: indianred;
            margin:0;
            margin-top: 12px;
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
         <h3 >جدول المناقشة النهائية</h3>
         <div class="row2">
        
            <?php
                $email = $_SESSION['email'];
                $query= mysqli_query($db, "SELECT * FROM user where email = '$email' ");
                while($row = mysqli_fetch_array($query)){
                $userID = $row['ID'];

                $query1 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
                while($row1 = mysqli_fetch_array($query1)){
                $Group_id = $row1['group_id'];

                $query2 = mysqli_query($db,"SELECT * FROM final_discussion WHERE group_id = '$Group_id' ");
                while($row2 = mysqli_fetch_array($query2)){
                $final_discussion_ID = $row2['ID'];
                $appointment_ID = $row2['appointment_ID'];
                
                
               
            ?>

           <div class="column2">

              <table>
                <?php
                    $query4 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                    while($row4 = mysqli_fetch_array($query4)){
                    $group_Name = $row4['Group_Name'];
                ?>
                <tr><td class="bold">اسم المجموعة</td><td><?php echo $group_Name;?></tr>
                
                <tr><td class="bold">المختبرين</td>
                <td>
                <?php
                  $query5 = mysqli_query($db,"SELECT * FROM discussion_user WHERE final_discussion_ID = '$final_discussion_ID' ");
                  while($row5 = mysqli_fetch_array($query5)){
                  $examiner_ID = $row5['user_id'];

                  $query6 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$examiner_ID' ");
                  while($row6 = mysqli_fetch_array($query6)){
                  $full_name = $row6['fullName']; 
                  
                ?>
                <?php echo $full_name; echo'<br/>'; }}?>
                </td>
                </tr>
                <?php
                $query3 = mysqli_query($db,"SELECT * FROM discussion_appointment WHERE ID = '$appointment_ID' ");
                while($row3 = mysqli_fetch_array($query3)){

                ?>
                <tr><td class="bold">اليوم</td><td><?php echo $row3['discussion_day'];?></tr>
                <tr><td class="bold">التاريخ</td><td><?php echo $row3['discussion_date'];?></td></tr>
                <tr><td class="bold">الوقت</td><td><?php echo $row3['discussion_time'];?></td></tr>
                <tr><td class="bold">المكان</td><td><?php echo $row3['discussion_place'];?></tr>
                
              </table>
            </div>
             
        <?php
        }}}}}
        ?>
        </div>

      </div>

  
   </body>
   </html>
