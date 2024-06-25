<?php
require_once "config.php";
require_once "session.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'];
    $acadmicID = $_POST['acadmicID'];
    $phone = $_POST['phone'];
    $password= $_POST['password'];
    $confirm_password= $_POST['confirm_password'];
    //$token = bin2hex(openssl_random_pseudo_bytes(32));

    $number = preg_match('@[0-9]@' , $password);
    $lower_char = preg_match('@[a-z]@' , $password);
    $upper_char = preg_match('@[A-Z]@' , $password);
    $spcial_char = preg_match('@[^\w]@' , $password);

 
    //check the email of student if it exists in the system
    $check_email = mysqli_query($db, "SELECT email FROM user where email = '$email' ");
    if(mysqli_num_rows($check_email) > 0){
      $msg="يبدو أن لديك حساب سابق قم بتسجيل الدخول فقط";
    }
    else{
        //check the intered email is an academic email affiliated with Tiabah university
        $validemail = substr($email, -14);
        if($validemail != 'taibahu.edu.sa' ){
            $msg="تحقق من صحة الايميل الجامعي ";
        }

        //check the password and confirmation password intered by student are identical
        else if($password != $confirm_password){
            $msg ="كلمة المرور غير متطابقة";
        }

        else if(!$number || !$upper_char || !$lower_char || !$spcial_char){
            $msg="يجب أن تتكون كلمة المرور  تتكون من حروف إنجليزية صغيرة وكبيرة وأرقام ورموز";
        }
    

        else{
        //insert data to database
        $query = mysqli_query($db,"INSERT INTO user (email,fullName, gender,acadmicID, phone, password) VALUES ('$email','$fullName','$gender','$acadmicID', '$phone','$password')"); 
        $_SESSION["message"]="<p id='error'> تم انشاء حسابك بنجاح انتظر حتى يصلك ايميل جديد عند تأكيد حسابك من قبلنا خلال 24</p>";
        header("Location: Active.php");

        /*email sending
        include('mail.php');
        $mail->Subject  =  'نظام إدارة مشاريع التخرج (رابط تأكيد حساب جديد)';
        $mail->Body   = 
        '<html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
                <style>
                    body {
                        margin: 0;
                        font-family: Tajawal, sans-serif;
                    }
                    #confirm {
                        height: auto;
                        margin-bottom:100px;
                        padding-top: 50px ;
                        text-align: right;
                        background: white;
                    }
                    #confirm h3{
                       color:#444;
                       font-size:16px;
                       padding:2px;
                       margin:0px;
                       text-align: right;
                    }
                    #confirm  p{
                       color:#222;
                       font-size:16px;
                       text-align: right;
                    }
                    #confirm a{
                       padding: 10px 50px;
                       background-color:#222;
                       border-radius: 5px 5px 5px 5px;
                       text-decoration: none;
                       border:none;
                       color:#fff;
                       font-size: 16px;
                       cursor:pointer;
                    }
                    #confirm a:hover{
                       background-color:#b19263;
                    }
                    #confirm a:focus{
                       outline: none;
                    }
                    img{
                        height: 70%;
                        width: 20%;
                    }
                    @media(max-width:1200px){
                        #confirm h3{
                           font-size:16px;
                        }
                        #confirm a{
                           padding: 9px 36px;
                        }
                        #confirm img{
                           height: 70%;
                           width: 30%;
                        }
                    }    
                    @media(max-width:780px){
                        #confirm img{
                           height: 70%;
                           width: 40%;
                       }
                    }
                </style>
            </head>
        <body>
 
        <div id="confirm">
            <img src="https://res.cloudinary.com/dyu3t4zmc/image/upload/v1609001599/logo_vezmet.jpg">
        
            <h3> مرحبا ' .$fullName.' </h3>
            
            <p>لقد قمت مؤخرًا بإنشاء حساب في نظام إدارة مشاريع GPMS..لتنشيط الحساب، يرجى تأكيد حسابك</p>
            <a href="http://localhost/GPMS/Active.php?token='.$token.' ">تأكيد حسابك</a>

        </div>
        </body>
       </htm>';
        if (!$mail->send()) {
           $msg = "حدث خطأ ما..حاول في وقت آخر";
        } 
        else {
    
            $_SESSION["message"]="قمنا بإرسال رساله تأكيد على ايميلك..في حال لم تصلك على البريد الوارد..ابحث عنها في الرسائل الغير المرغوب فيها";
            $_SESSION["undo"]="<a href='login.php'>تسجيل الدخول</a>";
            header("Location: Active.php");
        }
       


    }*/

  }
       
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
  
        <title>نظام إدارة مشاريع التخرج | إنشاء حساب  جديد</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
        <style>
            .right img{
                height:100%;
                width:85%;
            }
        </style>

    </head>

    <body>
        <div class="container">
        <div class="row">
            <div class="right">
                <img src="https://th.bing.com/th/id/OIP.Rus_82dXJX3j3vILeBsL4QHaHa?rs=1&pid=ImgDetMain">
            </div>
            <div class="left">
                <!--Form-->
                <form method="POST" action="">
                    <h2 class="title" >إنشاء حساب جديد في نظام GPMS</h2>
                    <?php if (!empty($msg)) {
                        echo "<p class='error' style='color:indianred'>$msg</p>";
                    } ?>
                    <input type="email" name="email" placeholder="البريد الإلكتروني الجامعي" class="forminput" required >
                    <input type="text" name="fullName"  class="forminput" placeholder="الاسم الثلاثي" required >  
                    <h4>نوع الجنس</h4>
                    <select name="gender"  class="forminput" required>
                    <option value="">اختر...</option>
                    <?php
                     $genderType = array( "ذكر" , "أنثى");
                     foreach($genderType as $item){
                        echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                     }
                    ?>
                    </select>  
                    <input type="text" name="acadmicID" class="forminput" maxlength="6" minlength="6" placeholder="الرقم الجامعي"  required >
                    <input type="tel" name="phone" maxlength="12" class="forminput" minlength="10" pattern="[9]{1}[6]{2}[5]{1}[0-9]{8}" placeholder="رقم الجوال" required >
                    <br/><small>اكتب رقم الجوال بالصيغة التالية ××××××××9665</small>
                    <input type="password" name="password" placeholder="كلمة المرور" class="forminput" minlength="8"  required>
                    <input type="password"  name="confirm_password" placeholder="تأكيد كلمة المرور" class="forminput" minlength="8" required>
                    <input type="submit" class="btn-send" value="إنشاء">
                    <p>لدي حساب سابق <a href="login.php" class= "link"> تسجيل دخول</a></p>
                    
                </form>

            </div>
        </div>
      </div>


    </body>
</html>