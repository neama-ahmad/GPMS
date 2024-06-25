<?php
  require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


  if($_SERVER["REQUEST_METHOD"] == "POST") {

   if(isset($_POST['send-btn'])){
    
    $user_id = $_SESSION["ID"];
    
    $query1 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$user_id' ");
    while($row1 = mysqli_fetch_array($query1)){
    $group_id = $row1['group_id'];

    $file_Name = $_POST['file_Name'];

    $name = $_FILES["docs"]["name"]; 
    $tmp_name = $_FILES['docs']['tmp_name'];
    
    $location = "Files/";
    $path = $location.$name;
    //allowed files type extensions
    $fileType  = strtolower(pathinfo($path,PATHINFO_EXTENSION));
    $allowTypes = array('pdf','docx' ,'pptx', 'xlsx', 'zip');


   if(in_array($fileType, $allowTypes)){ 

    move_uploaded_file($tmp_name, $path);
    //add files into database
    $query = mysqli_query($db,"INSERT INTO files (docs, file_Name, group_id, user_id) VALUES ('$name','$file_Name','$group_id','$user_id')"); 
    $msg = "تم رفع الملف";
   }

   else{
    $msg = "لا يمكنك رفع ملف من هذا النوع..";
  }

 }
}
}

    
  
        
?>
<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.0.0/css/all.css">
 
  <title>نظام إدارة مشاريع التخرج | رفع ملف</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/files.css">
  

</head>

<body>
    <?php
    $email = $_SESSION['email'];
    $query = mysqli_query($db,"SELECT * FROM user WHERE email = '".$_SESSION['email']."' ");
    while($row = mysqli_fetch_array($query)){
    $userID = $row['ID'];
    $sameEmail = $row['email'];
    
    $query1 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
    while($row1 = mysqli_fetch_array($query1)){
    $group_id = $row1['group_id'];
    $leadership = $row1['leadership'];
    
    ?>
 
    <div id="mother">
    <?php
    if($leadership == 1){
        echo'
        <a href="myGroup.php" class="Toback">&#8594;</a>';
    }
    else{
        echo'
        <a href="mainGroup.php" class="Toback">&#8594;</a>';
    }
        
    ?>
    <div class="column">
    <!--form-->
    <form method="POST" action="" enctype="multipart/form-data">
      <h3>رفع ملفات</h3>
      <?php if (!empty($msg)) {
        echo "<p class='error' style='color:green; font-size:16px; padding:5px 22px;'>$msg</p>";
      } ?>
      <input type="text" name="file_Name" class="forminput" placeholder="قم بتسمية الملف" required>
      <h4>قم برفع الملف من هنا</h4>
      <input type="file" class="forminput" name="docs"  accept=".pdf , .docx , .pptx, .xlsx , .zip" required >
        <input type="submit" id="btn"  class="button" name ="send-btn" value="رفع">
    </form>
  </div>



    <br/>
      
         <div class="row2">
         <h3 >ملفات المجموعة</h3><br/>
        
            <?php
            //show uploaded files 
              
              $query2 = mysqli_query($db,"SELECT * FROM Files WHERE group_id = '$group_id' ORDER BY upload_Time DESC ");
              while($row2 = mysqli_fetch_array($query2)){
                $fileID = $row2['ID'];
                $upload_Time = $row2['upload_Time'];
                $file_userId = $row2['user_id'];
                $file_Name = $row2['file_Name'];
                $docs = $row2['docs'];
                $supervisor = $row2['supervisor'];
                
            
            ?>

           <div class="column2">
                
                <table>
                    <tr><td class="bold">الملف</td><td><a href="FileOpen.php?ID=<?php echo $row2['ID'];?>" class="file-btn" target="_blank">   <i class="fa-solid fa-download"></i>  <?php echo "$docs";?></a></td></tr>
                    <tr><td class="bold">اسم الملف</td><td><?php echo $file_Name;?></tr>
                    <tr><td class="bold">قام برفعه</td><td><?php 
                        $query3 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$file_userId' ");
                        while($row3 = mysqli_fetch_array($query3)){
                        $fileuser_email = $row3['email'];
                        $fileuser_fullName = $row3['fullName'];
                        if($sameEmail == $fileuser_email ){ echo 'أنا';} else {echo $fileuser_fullName;}} if($supervisor == 1){echo '<span class="supervisor">المشرف</span>';}?></td></tr>
                    <tr><td class="bold">وقت الرفع</td><td><?php $dt = new DateTime($upload_Time); echo $dt->format('(H:i) Y-m-d'); ?></tr>

                </table>
                <?php
                if($leadership == 1){
                    echo '
                    <form method ="POST">
                    <input type="hidden"  name="ID" value= "'.$fileID.'" readonly>
                    <input type="submit" id="del-btn" name="del-btn"  class="button" value="حذف">
                    </form>
                    ';
                }
                ?>

            </div>
             
        <?php
        }}}
        ?>
        </div>

      </div>

  <?php
    //delete files by leadership
    if(isset($_POST["del-btn"])&& isset($_POST["ID"])) { 
      $query = mysqli_query($db,"DELETE FROM Files WHERE ID = '".$_POST["ID"]."' ");
      echo "<meta http-equiv='refresh' content='0'>";
    }
  ?>

</body>

</html>