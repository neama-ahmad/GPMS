<?php
  require_once "config.php";
  require_once "session.php";

  if(!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
  }

   //incure user cannot change his role
   $query = mysqli_query($db,"SELECT * FROM user where  email =  '". $_SESSION['email']."' ");
   while($row = mysqli_fetch_array($query)){
     $role = $row['role'];
     if($role != 'عضو لجنة المشاريع'){
       header('Location: logout.php');
       exit;
     }
   }
  
?>
  
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>نظام إدارة مشاريع التخرج | لوحة التحكم</title>
    
  <!-- CSS here -->
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  
<span  id="openbtn" onclick="openNav()"> &#9776 عرض القائمة </span>
  <div class="vertical-menu" id="menu">
  <a href="javascript:void(0)"  id="closebtn" onclick="closeNav()">&times;</a>
    <?php
      $query = mysqli_query($db,"SELECT * FROM user where  email =  '". $_SESSION['email']."' ");
      while($row = mysqli_fetch_array($query)){
    ?>
    <li  class="logo">نظام إدارة مشاريع التخرج GPMS</li>
    <li  class="user"><?php echo $row['fullName']?> - <?php echo $row['role']?></li>
    <?php
    }
    ?>
   
    <a href="userinfo.php" target="iframe1" id="a1" >الملف الشخصي</a>
     <a href="send_notification.php"  target="iframe1"  id="a2">إرسال إشعارات</a>
    <a href="users.php"  target="iframe1" id="a3">إدراة بيانات المستخدمين</a>
    <a href="manageGroup.php"   target="iframe1"  id="a4">إدارة بيانات المجموعات</a>
    <a href="discussions.php"    target="iframe1"   id="a6">تنظيم المناقشات النهائية</a>
    <a href="admin_reports.php"  target="iframe1"  id="a7"> تقارير مشاريع التخرج</a>
    <a href="grades.php" target="iframe1" id="a7">الدرجات</a>
    <a href="archive.php" target="iframe1"  id="a8">أرشيف المشاريع</a>
    
      <a href="logout.php"  id="a10" >تسجيل خروج</a>
  </div>
  

  <iframe id="iframe1" name="iframe1" src="userinfo.php" class="content" ></iframe>
  

  <script>
    function openNav(){
      document.getElementById("menu").style.display ="block";
      document.getElementById("iframe1").style.display ="none";
      document.getElementById("openbtn").style.display ="none";
      document.getElementById("closebtn").style.display ="block";

    }

    function closeNav(){
      document.getElementById("menu").style.display = "none";
      document.getElementById("iframe1").style.display ="block";
      document.getElementById("openbtn").style.display ="block";
      document.getElementById("closebtn").style.display ="none";

    }

 
  </script>
  
</body>
</html>