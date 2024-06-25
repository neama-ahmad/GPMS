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
  /*$rand = rand();
  $docs = "docs" . $rand .;*/
  $location = "Files/";
  $path = $location.$name;

  $fileType  = strtolower(pathinfo($path,PATHINFO_EXTENSION));
  $allowTypes = array('pdf','doc','docx' ,'ppt','pptx');

  if(in_array($fileType, $allowTypes)){ 
   
    move_uploaded_file($tmp_name, $path);
    $query = mysqli_query($db,"INSERT INTO reports (docs, file_Name,group_id,user_id, report_type  ,to_examiner) VALUES ('$name','$file_Name','$group_id','$user_id', 'project_examiner', 1)"); 
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
 
  <title>نظام إدارة مشاريع التخرج | إرسال ملف المشروع للمختبرين</title>
  <link rel="stylesheet" href="css/main.css">

    <style>
        #mother{
            display:flex;
            flex-direction:column;
            align-Items:center;
            justify-content: center;
            height: auto;
            width: 100%;
            padding-top:30px;
        }

        h3{
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
            padding-top:60px;
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


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px;
            width:20%;
            font-size:14px;
            text-align: center;
            text-decoration: none;
            background-color: #038C85;
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            margin: 20px 0px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
            color:#fff;
        }
        
        .file-btn{
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            padding:6px 60px;
            margin:4px;
           background-color: transparent;
           border: solid 2px #038C85;
           color:#333;
           text-decoration: none;
           font-size: 14px;
        }

        .file-btn:hover{
            text-decoration: none;
            background-color: #038C85;
            color: #fff;
        }

        h4{
            padding: 2px;
            padding-top: 12px;
            margin:2px;
        }

        .forminput{
            padding: 8px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 12px;
            width: 40%;
            border: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            font-family: 'JF Flat Regular', sans-serif;
            background-color: transparent;
            border-radius: 10px;
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

        .row2{
            padding-top:12px;
            align-Items:right;
            display: flex;
            justify-content: flex-start;
            width:100%;
            flex-wrap:wrap;
            height:auto;
        }
        .row2 .column2{
            width:30%;
            height:180px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px;
            padding-top:16px;
            display: flex;
            flex-direction: column;
            align-Items: center;
            margin: 12px;
            

        }

        table {
      width:90%;
      direction:rtl;
      margin: 6px 20px;
    }

    td{
      text-align: right;
      color:#333;
      padding: 9px;
      font-size:14px;
      word-wrap:break-word;
      border-bottom:1px solid #ccc;
    }

    .bold{
      color:#038C85;
    }

    .buttons{
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
            width:100%;
            padding: 12px;
            margin:7px;
            
        }

    .buttons .back{
            width: 12%;
            margin:7px;
            background-color: orange;
        }

    #del-btn{
      width:16%;
      background-color: indianred;
      margin-top: 12px;
    }

    #del-btn:hover{
      background:#999;
    }
        .column2 .r1{
           font-size: 16px;
           color:#038C85;
           padding:4px;
           margin:2px;
        }

        .column2 .r2{
           font-size: 15px;
           color:#555;
           padding:0px;
           margin:2px;
           margin-bottom:14px;
        }

        #del-btn{
            width:60px;
            background-color: indianred;
            margin:0;
        }

        #del-btn:hover{
            background:#999;
        }

        .fa-download{
            color:#038C85;
        }

        
        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        #mother h3{
            font-size: 20px;
        }
        
        .row2{
            padding-top:12px;
            align-Items:center;
            justify-content: center;
            width:100%;
        }
        .column2{
            width:100%;
            height:350px;
            margin:20px 12px;
            padding:10px;
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

        #del-btn{
            padding: 12px;
            width:100px;
        }

    

    }



    </style>
    </head>

<body>
    
 <!--team-->
 <div id="mother">
    <div class="column">

    <form method="POST" action="" enctype="multipart/form-data">
      <h3>إرسال ملف المشروع إلى المختبرين</h3>
      <?php if (!empty($msg)) {
        echo "<p class='error' style='color:green; font-size:16px; padding:5px 22px;'>$msg</p>";
      } ?>
      <input type="text" name="file_Name" class="forminput" placeholder="قم بتسمية الملف" required>
      <h4>قم برفع الملف من هنا</h4>
      <input type="file" class="forminput" name="docs"  accept=".pdf , .doc , .docx , .ppt, pptx" required >
      <input type="submit" id="btn"  class="button" name ="send-btn" value="إرسال">
    </form>
  </div>



    <br/>
         <h3 >ملفات المشروع</h3><br/>
         <div class="row2">
        
            <?php
            $query = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row = mysqli_fetch_array($query)){
              $userID = $row['ID'];
              $fullName = $row['fullName'];
              $sameEmail = $row['email'];

              $query1 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
              while($row1 = mysqli_fetch_array($query1)){
                $group_id = $row1['group_id'];
              
              $query2 = mysqli_query($db,"SELECT * FROM reports WHERE group_id = '$group_id' AND report_type = 'project_examiner' ORDER BY upload_Time DESC ");
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