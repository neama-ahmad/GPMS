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

        <title>نظام إدارة مشاريع التخرج |إشعارات</title>

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
            font-size: 22px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding:20px
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
            width:40%;
            padding:8px;
            height:auto;
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
            padding-bottom:0;
            margin-bottom:0;
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
      padding: 12px;
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
         <h3>تنبيهات لجنة المشاريع</h3>
         <div class="row2">
        
            <?php
            $email = $_SESSION['email'];
            $query3 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row3 = mysqli_fetch_array($query3)){
              $role = $row3['role'];
              //show notifications sent to students only or general notifications
              if($role == 'طالب'){
                $query2 = mysqli_query($db,"SELECT * FROM  notifications WHERE sendFor = 'الطلاب' OR sendFor = 'عام' ORDER BY Added_Time DESC ");
                while($row2 = mysqli_fetch_array($query2)){
                ?>
                    <div class="column2">

                    <table>
                      <tr><td><?php echo $row2['message'];?></td></tr>
                    </table>
                    <span class="time"><?php $dt = new DateTime($row2['Added_Time']); echo $dt->format('H:i    d/m '); ?></span>
                  </div>
              <?php }} 
              //show notifications sent to supervisors only or general notifications
              elseif($role == 'مشرف'){
                $query4 = mysqli_query($db,"SELECT * FROM  notifications WHERE sendFor = 'المشرفين' OR sendFor = 'عام' ORDER BY Added_Time DESC ");
                while($row4 = mysqli_fetch_array($query4)){
               ?>

                    <div class="column2">

                    <table>
                      <tr><td><?php echo $row4['message'];?></td></tr>
                    </table>
                    <span class="time"><?php $dt = new DateTime($row4['Added_Time']); echo $dt->format('H:i    d/m '); ?></span>
                  </div>
               <?php }}
                //show notifications sent to examiners only or general notifications
                elseif($role == 'مختبر'){
                $query5 = mysqli_query($db,"SELECT * FROM  notifications WHERE sendFor = 'المختبرين' OR sendFor = 'عام' ORDER BY Added_Time DESC ");
                while($row5 = mysqli_fetch_array($query5)){
               ?>

                    <div class="column2">

                    <table>
                      <tr><td><?php echo $row5['message'];?></td></tr>
                    </table>
                    <span class="time"><?php $dt = new DateTime($row5['Added_Time']); echo $dt->format('H:i    d/m '); ?></span>

                  </div>
               <?php }}
               //show notifications sent to Gp_committee only or general notifications
               elseif($role == 'عضو لجنة المشاريع'){
                $query6 = mysqli_query($db,"SELECT * FROM  notifications WHERE sendFor = 'أعضاء لجنة المشاريع' OR sendFor = 'عام' ORDER BY Added_Time DESC ");
                while($row6 = mysqli_fetch_array($query6)){
               ?>
                    <div class="column2">

                    <table>
                      <tr><td><?php echo $row6['message'];?></td></tr>
                    </table>
                    <span class="time"><?php $dt = new DateTime($row6['Added_Time']); echo $dt->format('H:i    d/m '); ?></span>

                  </div>
               <?php }}

               else{
                echo '';
               }
            }
        ?>
        </div>

      </div>


   </body>
   </html>
