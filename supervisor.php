<?php
  require_once "config.php";
  require_once "session.php";
  
  if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
  }

  //incure user cannot change his role
  $query = mysqli_query($db,"SELECT * FROM user where  email =  '". $_SESSION['email']."' ");
  while($row = mysqli_fetch_array($query)){
    $role = $row['role'];
    if($role != 'مشرف'){
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
      $query = mysqli_query( $db,"SELECT * FROM user where  email =  '". $_SESSION['email']."' ");
      while($row = mysqli_fetch_array($query)){
    ?>
    <li  class="logo">نظام إدارة مشاريع التخرج GPMS</li>
    <li  class="user"><?php echo $row['fullName']?> - <?php echo $row['role']?></li>
    <?php
    }
    ?>
   
    <a href="userinfo.php" target="iframe1" id="a1" >الملف الشخصي</a>
    <a href="notification.php"  target="iframe1" id="a2">إشعارات</a>
    <a href="idea.php"  target="iframe1" id="a3">مقترح فكرة مشروع تخرج</a>
    <a href="allOffers.php" target="iframe1" id="a4">طلبات الإشراف</a>
    <a href="supervisor_group.php" target="iframe1"   id="a5">المجموعات</a>
    <a href="supervisor_discussionTable.php"  target="iframe1" id="a6">جدول المناقشات النهائية</a>
     <a href="supervisor_grade.php" target="iframe1"  id="a7">الدرجات</a>
    <a href="projects.php" target="iframe1"  id="a8">أرشيف المشاريع</a>
    
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