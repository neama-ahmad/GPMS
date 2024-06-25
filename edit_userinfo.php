<?php
require_once "config.php";
require_once "session.php";

//to stop showing this page if not login in
if(!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
} 

    $user_id = $_GET["link"];
               
    //Edit user profile
    if($_SERVER["REQUEST_METHOD"] == "POST") { 
    
      
        //check thier is no empty field
        if(empty($_POST["fullName"]) || empty($_POST["acadmicID"]) || empty($_POST["phone"]) ){
          $msg = "لا بد من تعبيئة كل البيانات";
        }
  
        else{
  
          if(!empty($_POST["fullName"])) {
              $fullName = $_POST["fullName"];
            }
              
           if(!empty($_POST["acadmicID"])) {
              $acadmicID = $_POST["acadmicID"];
            }
  
            if(!empty($_POST["phone"])) {
              $phone = $_POST["phone"];
            }
             
          
            //update user information
            $edit_profile = mysqli_query($db,"UPDATE user SET fullName= '$fullName' , acadmicID= '$acadmicID' ,phone= '$phone' WHERE  email =  '". $_SESSION['email']. "' ");
            header("Location:userinfo.php");
        }
  
  
    }






?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.0/css/all.css">
  
        <title>نظام إدارة مشاريع التخرج | تعديل الملف الشخصي</title>

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
            padding: 12px 20px;
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
           padding: 10px;
           font-size:14px;
       }
       .forminput{
          font-size:14px;
          margin:8px 0px;
       }

        .button{
            margin: 24px 4px;
            padding:6px 20px;
            border-radius: 50px;
            text-align: center;
            border:none;
            color:white;
            font-family: 'JF Flat Regular', sans-serif;
            cursor:pointer;
            background-color:#F5B041; 
            width:60%;
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

        #error{
            display:inline-block;
            font-size:15px;
            text-align: center;
            width: 50%;
            padding:5px;
            padding-right:20px;
            background-color: Gainsboro;
            color:#666;
            border-radius:5px;
                
        }

        h3{
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding-top: 20px;
        }

        .Toback{
            font-size:25px;
            background-color:LightSlateGray;
            text-align:center;
            border: none;
            color: white;
            text-decoration: none;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            width:5%;
            height:1%;
            padding:0;
            border-radius:5px;
            font-style:bold;
        }

        .Toback:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
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

      
       table{
        width: 100%;
        padding:7px;
        margin:0;
        margin-bottom:6px;
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
            <a href="userinfo.php" class="Toback">&#8594;</a>
            <!--Form-->
            <form method="POST" action="" id="form1">
                <h3 class="Title" >تعديل الملف الشخصي</h3>
                <?php if (!empty($msg)) {
                    echo "<p id='error' style='color:indianred'>$msg</p>";
                } ?>
                <?php                         
                $query = mysqli_query( $db,"SELECT * FROM user where  ID =  '".$user_id."' ");
                while($row = mysqli_fetch_array($query)){
                    $userID = $row['ID'];
                ?>
        
                <table>
                    <tr><td id="email" >البريد الالكتروني الجامعي</td><td id="email" ><?php echo $row['email'] ?></td></tr>
                    <tr><td>الاسم الثلاثي</td><td  data-id="fullName"><input type="text" id="fullName" name="fullName"  class="forminput"  value="<?php echo $row['fullName'] ?>"></td></tr>
                    <tr><td>نوع الجنس</td><td  data-id="gender"><?php echo $row['gender'] ?></td></tr>
                    <tr><td>الرقم الجامعي أو الرقم الوظيفي</td><td  data-id="acadmicID"><input type="text" id="acadmicID" name="acadmicID" class="forminput" maxlength="6" minlength="6"  value="<?php echo $row['acadmicID'] ?>"></td></tr>
                    <tr><td>رقم الجوال</td><td  data-id="phone"><input type="tel" id="phone" name="phone" maxlength="12" class="forminput" minlength="10" pattern="[9]{1}[6]{2}[5]{1}[0-9]{8}" value="<?php echo $row['phone'] ?>">
                    <br/><small>اكتب رقم الجوال بالصيغة التالية ××××××××9665</small></td></tr>
                    <tr><td>كلمة المرور</td>
                    <td  data-id="password">
                    <?php
                    echo'
                    <a href="change_password.php?link='.$userID.'" class="button small-btn" >تغيير كلمة المرور</a>';
                    }?></td></tr>
                </table> 
                <input type="submit" name="add-btn" id="add-btn" class="button" value="حفظ التعديل" >
            </form>
                      
        </div>

        

    </body>
</html>