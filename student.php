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
    if($role != 'طالب'){
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
        $userID = $row['ID'];
    
    ?>
    <li  class="logo">نظام إدارة مشاريع التخرج GPMS</li>
    <li  class="user"><?php echo $row['fullName']?> - <?php echo $row['role']?></li>
    
   
    <a href="userinfo.php" target="iframe1" id="a1" >الملف الشخصي</a>
    <a href="notification.php"  target="iframe1" id="a2">إشعارات</a>
    <?php
  
      $hasGroup = mysqli_query($db,"SELECT user_id FROM group_members WHERE user_id = '$userID' ");
      $count = mysqli_num_rows($hasGroup);
      if($count < 1){
        echo ' <a href="non_group.php" target="iframe1"  id="a3">مجموعتي</a>';
      }
      else{
        $query2 = mysqli_query($db,"SELECT * FROM group_members where  user_id =  '". $userID."' ");
        while($row2 = mysqli_fetch_array($query2)){
          $leadership = $row2['leadership'];
          if($leadership == 1){
            echo ' <a href="myGroup.php" target="iframe1" >مجموعتي</a>';
          }
          else{
            echo ' <a href="mainGroup.php" target="iframe1" >مجموعتي</a>';
          }
        
        }
      }

    }
    

  ?>
    <a href="groups.php" target="iframe1" id="a4">البحث عن مجموعة</a>
    
    <a href="searchForSupervisor.php" target="iframe1"  id="a5">طلب إشراف دراسي</a>
    <a href="discussion_Table.php"  target="iframe1"  id="a6">جدول المناقشة النهائية</a>
    <a href="reports.php"   target="iframe1" id="a7">تقارير مشروع التخرج</a>
    <a href="projects.php"   target="iframe1" id="a7">أرشيف المشاريع</a>
    
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