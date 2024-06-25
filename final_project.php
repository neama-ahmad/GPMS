<?php
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }

   $email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   if(isset($_POST['send-btn'])){
    $user_id = $_SESSION["ID"];

    $query1 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$user_id' ");
    while($row1 = mysqli_fetch_array($query1)){
    $group_id = $row1['group_id'];

    $file_Name = $_POST['file_Name'];

    $name = $_FILES["docs"]["name"]; 
    $tmp_name = $_FILES['docs']['tmp_name'];
 
    $location = "Reports/";
    $path = $location.$name;

   //allowed files type extensions
   $fileType  = strtolower(pathinfo($path,PATHINFO_EXTENSION));
   $allowTypes = array('pdf','docx' ,'pptx' ,'xlsx' ,'zip');

  if(in_array($fileType, $allowTypes)){ 
   
    move_uploaded_file($tmp_name, $path);
    //add files into database
    $query = mysqli_query($db,"INSERT INTO reports (docs, file_Name,group_id,user_id, report_type) VALUES ('$name','$file_Name','$group_id','$user_id', 'final_project')"); 
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
 
  <title>نظام إدارة مشاريع التخرج | رفع ملفات المشروع</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/files.css">
</head>

<body>
    
 
 <div id="mother">
    <?php
        echo'
        <a href="reports.php" class="Toback">&#8594;</a>';
    ?>
    <div class="column">
    <!--form-->
    <form method="POST" action="" enctype="multipart/form-data">
      <h3>رفع المشروع النهائي</h3>
      <?php if (!empty($msg)) {
        echo "<p class='error' style='color:green; font-size:16px; padding:5px 22px;'>$msg</p>";
      } ?>
      <input type="text" name="file_Name" class="forminput" placeholder="قم بتسمية الملف" required>
      <h4>قم برفع الملف من هنا</h4>
      <input type="file" class="forminput" name="docs"  accept=".pdf , .docx , .pptx , .xlsx , .zip" required >
      <input type="submit" id="btn"  class="button" name ="send-btn" value="إرسال">
    </form>
  </div>



    <br/>
         
         <div class="row2">
         <h3 >ملفات المشروع</h3><br/>
        
            <?php
            //show uploaded files 
            $query = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row = mysqli_fetch_array($query)){
              $userID = $row['ID'];
              $fullName = $row['fullName'];
              $sameEmail = $row['email'];

              $query1 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
              while($row1 = mysqli_fetch_array($query1)){
                $group_id = $row1['group_id'];
              
              $query2 = mysqli_query($db,"SELECT * FROM reports WHERE group_id = '$group_id' AND report_type = 'final_project' ORDER BY upload_Time DESC ");
              while($row2 = mysqli_fetch_array($query2)){
                $report_ID = $row2['ID'];
                $docs = $row2['docs'];
                $upload_Time = $row2['upload_Time'];
                $file_userId = $row2['user_id'];
                $file_Name = $row2['file_Name'];
                
            
            ?>

           <div class="column2">
               
                <a href="reportOpen.php?ID=<?php echo $row2['ID'];?>" class="file-btn" target="_blank"> <i class="fa-solid fa-download"></i>  <?php echo "$docs";?></a>
                <table>
                <tr><td class="bold">اسم الملف</td><td><?php echo $file_Name;?></tr>
                <tr><td class="bold">وقت الرفع</td><td><?php echo $upload_Time;?></tr>
                </table>
            </div>
             
        <?php
        }}}
        ?>
        </div>

      </div>


</body>

</html>