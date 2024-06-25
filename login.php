<?php
  require_once "config.php";
  require_once "session.php";

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //verify the user email and password if is exist in the system
    $sql = "SELECT * FROM user WHERE email = '$email' and password = '$password'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
    $count = mysqli_num_rows($result);
        
    if($count == 1) {
      
      //verify the user account is active
      if($row['Active'] == 1){

      session_regenerate_id();
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['ID'] = $row['ID'];
            
      
      //direct each user to his own dashboard according to role

      if($row["role"]=="طالب"){
        header("location:student.php");
        exit;
      }

      else if($row["role"]=="مشرف"){
        header("location:supervisor.php");
        exit;
      }

      else if($row["role"]=="مختبر"){
        header("location:examiner.php");
        exit;
      }

      else if($row["role"]=="عضو لجنة المشاريع"){
        header("location:GP_committee.php");
        exit;
      }

      else{
        header("location:login.php");
      }
            
    }

    else{
      //if user account not active shows this messsage
      $msg = "لم يتم تفغيل حسابك بعد..سوف تتلقى إيميل قريبا";
    }
  }

  else {
    //if user account not exist shows this messsage
    $msg ="خطأ في الايميل أو في كلمة المرور تححق منها"; 
     
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
  
        <title>نظام إدارة مشاريع التخرج | تسجيل الدخول</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">

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
                    <h2 class="title" >تسجيل الدخول إلى نظام GPMS</h2>
                    <?php if (!empty($msg)){
                        echo "<p class='error' style='color:indianred'>$msg</p>";
                    } ?>
                    <input type="email" id="email"  name="email" placeholder="البريد الإلكتروني الجامعي" class="forminput" required >
                    <input type="password" id="password"  name="password" placeholder="كلمة المرور" class="forminput"  required>
                    <input type="submit" class="btn-send" value="دخول">
                    <p>ليس لدي حساب أرغب في إنشاء <a href="sginup.php" class= "link"> حساب جديد</a></p>
                    <a href="#" class= "link">نسيت كلمة المرور</a>
                </form>

            </div>
        </div>
        </div>
        
    </body>
</html>