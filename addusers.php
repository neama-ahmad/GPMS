<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if ($_SERVER["REQUEST_METHOD"] == "POST") {

      if(isset($_POST["btn-add"])){
         $email = $_POST['email'];
         $fullName = $_POST['fullName'];
         $gender = $_POST['gender'];
         $acadmicID = $_POST['acadmicID'];
         $phone = $_POST['phone'];
         $password = $_POST['password'];
         $role = $_POST['role'];

         //check if user has account before
         $check_email = mysqli_query($db, "SELECT email FROM user WHERE email = '$email' ");
         if(mysqli_num_rows($check_email) > 0){
            $msg = "هذا الإيميل مسجل من قبل جرب إيميل آخر";
         }
        
         else{
            //insert data into database
            $query = mysqli_query($db, "INSERT INTO user (email,fullName,gender,acadmicID, phone, password,role) VALUES ('$email','$fullName','$gender','$acadmicID', '$phone', '$password' , '$role')");
            header('Location:users.php');
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

        <title>نظام إدارة مشاريع التخرج |إدارة بيانات المستخدمين</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">

        <style>
    
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:20px;
        }

        h3{
            text-align:center;
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
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


        .column  form  > small{
         font-size: 13px;
         color: green;
         padding:0;

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
            padding: 8px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 8px;
            margin-bottom: 16px;
            width: 40%;
            border: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            font-family: 'JF Flat Regular', sans-serif;
            background-color: transparent;
            border-radius: 12px;
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

        h4{
         padding:0;
         margin:0;
         padding-top:6px;
         color:#777;
        }
        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        #mother h3{
            font-size: 20px;
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

      <div id="mother">
         <?php
          echo'
          <a href="users.php" class="Toback">&#8594;</a>';
        ?>
         <div class="column">

            <!--form-->
            <form method="POST" action="">
               <h3>إضافة مستخدم جديد</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                     }  
                  ?>

               <input type="email" name="email" placeholder="البريد الإلكتروني الجامعي" class="forminput" required >
               <input type="text" name="fullName"  class="forminput" placeholder="الاسم الثلاثي" required >  
               <h4>نوع الجنس</h4>
               <select name="gender"  class="forminput" required>
               <option value="">اختر...</option>
                  <?php
                     $genderType = array("ذكر" , "أنثى");
                     foreach($genderType as $item){
                        echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                     }
                  ?>
               </select>  
               <input type="text" name="acadmicID" class="forminput" maxlength="6" minlength="6" placeholder="الرقم الجامعي أو الوظيفي"  required >
               <input type="tel" name="phone" maxlength="12" class="forminput" minlength="10" pattern="[9]{1}[6]{2}[5]{1}[0-9]{8}" placeholder="رقم الجوال" required >
                    <br/><small>اكتب رقم الجوال بالصيغة التالية ××××××××9665</small>
               <input type="text"  name="password" class="forminput" placeholder="كلمة المرور" required>
               <h4>الصلاحية</h4>
               <select name="role"  class="forminput" required>
               <option value="">اختر...</option>
                  <?php
                     $roleType = array("طالب", "مشرف" , "مختبر", "عضو لجنة المشاريع");
                     foreach($roleType as $item){
                        echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                     }
                  ?>
               </select>  
               <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إضافة">
            </form>

         </div>

      </div>

  
   </body>
   </html>
