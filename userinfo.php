<?php
require_once "config.php";
require_once "session.php";

//to stop showing this page if not login in
if(!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
}   

?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.0/css/all.css">
  
        <title>نظام إدارة مشاريع التخرج | الملف الشخصي</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <style>
        body{
            font-family: 'JF Flat Regular', sans-serif;
            background:transparent;
        }

        .banner{
            display: flex;
            flex-direction: column;
            padding: 12px 35px;
            width: 100%;
      
        }

        #email{
        background-color:#dedede;
            
        }
        small{
            color: green;
        }

        table {
           font-family: 'JF Flat Regular', sans-serif;
           border-collapse: collapse;
           width: 90%;
           padding:20px;
           margin: 20px;
           direction:rtl;
        }

        td, th {
           border-bottom: 1px solid #ddd;
           text-align: right;
           padding:12px;
           font-size:14px;
       }
       .forminput{
          font-size:14px;
          margin:8px 0px;
       }

        .banner .button{
            margin: 24px 4px;
            padding:6px;
            border-radius: 50px;
            text-align: center;
            border:none;
            color:white;
            font-family: 'JF Flat Regular', sans-serif;
            cursor:pointer;
            background-color:#038C85; 
            width:25%;
            font-size:14px;
            text-decoration: none;
        }


        .button:hover{
            background-color: #f16465;
        }
        #add-btn{
            background-color:#038C85; 
            width:30%;
            padding:6px;
        }
        #undo-btn{
            background-color: #553965; 
            width:30%;
            padding:6px;
        }


        #add-btn:hover{
            background-color: #f16465;
        }

        #undo-btn:hover{
            background-color: #f16465;
        }

        h3{
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding-top: 20px;
        }

        @media (max-width: 1000px){

       .banner{
        align-items: center;
        width:100%;
        height:100%;
        padding:9px;
        padding-top: 30px;
        background: none;
    
       }


       .banner .button{
        width: 50%;
       }
      
       table{
        width: 100%;
        padding:7px;
        margin:12px 0px;
       }


       #add-btn{
            width:35%;
            padding:7px;
            margin:6px;
            font-size:14px;
        }
        #undo-btn{
            font-size:14px;
            width:35%;
            padding:7px;
            margin:6px;
        }
        }

        </style>

    </head>

    <body>
        <div class="banner">
    
            <h3 class="Title" >الملف الشخصي</h3>  

               <?php                      
                //fetch user data by his email session
                $query = mysqli_query( $db,"SELECT * FROM user where  email =  '". $_SESSION['email']."' ");
                while($row = mysqli_fetch_array($query)){
                    $userId = $row['ID'];
                ?>
        
                <table>
                    <tr><td id="email" >البريد الالكتروني الجامعي</td><td id="email" ><?php echo $row['email'] ?></td></tr>
                    <tr><td>الاسم الثلاثي</td><td><?php echo $row['fullName'] ?></td></tr>
                    <tr><td>نوع الجنس</td><td><?php echo $row['gender'] ?></td></tr>
                    <tr><td>الرقم الجامعي أو الرقم الوظيفي</td><td><?php echo $row['acadmicID'] ?></td></tr>
                    <tr><td>رقم الجوال</td><td><?php echo $row['phone'] ?></td></tr>

                </table> 
                <?php
                echo'
                <a href="edit_userinfo.php?link='.$userId.'" class="button">تعديل البيانات</a>';
                } ?>
                      
        </div>

        
       

    </body>
</html>