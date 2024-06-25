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

        <title>نظام إدارة مشاريع التخرج | إضافة مواعيد المناقشات</title>

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
        }

        .pop-up{
            display:flex;
            flex-direction:column;
            align-Items:center;
            justify-content: center;
            height: 100%;
            width: 100%;
            position: absolute;
            top:0;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px 0px;
            padding: 30px;
        
        }

        .pop-up .up {
            font-size: 15px;
            background-color: #fff; 
            color:#000;
            text-align:center;
            padding:5px;
            margin:0px;
        }

        .pop-up .sub {
            font-size: 14px;
            background-color: #eee; 
            color:#000;
            text-align:center;
        }
        .pop-up .sub span {
            font-size: 14px;
            background-color: #eee; 
            color:darkorange;
            text-align:center;
        }

        .pop-up .close {
            position: absolute;
            left: 50px;
            top: 40px;
            color: #000;
            font-size: 40px;
            float: left;
        }
    
        .pop-up .close:hover,
        .pop-up  .close:focus {
            color:rgb(218, 120, 120);
            cursor: pointer;
        }
    </style>



    </head>

    <body>

 

        <div id="mother">
          <div class="pop-up" id="pop-up" >
            <a href="discussions.php">
               <span class="close" title="إغلاق النافذة"  >&times;</span>
            </a>
            <p class="up">إذا لم تقم بإنشاء حسابات المختبرين... قم بإنشاءها أولا</p>
            <p class="sub">إذهب إلى <span>إدارة بيانات المستخدمين</span> ثم اذهب إلى  <span>مستخدم جديد</span> بعد إنشاء الحسابات <span>قم بتفعيلها عن طريق زر تحقق</span></p>
        </div>  

        
  
    </body>
</html>
