<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      //insert members data to database
      if(isset($_POST["btn-add"])){

        $email = $_SESSION['email'];
        $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
        while($row1 = mysqli_fetch_array($query1)){
        $userID = $row1['ID'];

          $Project_Name = $_POST['Project_Name'];
          $scope = $_POST['scope'];
          $objectives = $_POST['objectives'];
          $students_Name = $_POST['students_Name'];
          $supervisor_Name = $_POST['supervisor_Name'];
          $year = date("Y");

          $name = $_FILES["project_file"]["name"]; 
          $tmp_name = $_FILES['project_file']['tmp_name'];
    
          $location = "Reports/";
          $path = $location.$name;
          //allowed files type extensions
          $fileType  = strtolower(pathinfo($path,PATHINFO_EXTENSION));
          $allowTypes = array('pdf','docx' ,'pptx', 'xlsx', 'zip');


        if(in_array($fileType, $allowTypes)){ 

            move_uploaded_file($tmp_name, $path);

            $query = mysqli_query($db, "INSERT INTO projects (Project_Name, year, scope, objectives,students_Name,supervisor_Name,project_file) VALUES ('$Project_Name', '$year', '$scope', '$objectives','$students_Name', '$supervisor_Name','$name')");
            $msg = "تم رفع المشروع";
        
        }
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

        <title>نظام إدارة مشاريع التخرج |إضافة مشاريع</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">

        <style>
    
        #mother{
            display:flex;
            flex-direction:row;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:20px;
        }

        #mother h3{
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
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 6px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 8px;
            width: 50%;
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
        .column2{
            width:30%;
            padding:8px;
            height:300px;
            background: rgb(255, 255, 255);
            box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
                -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
            padding: 20px 0px;
            display: flex;
            flex-direction: column;
            align-Items: center;
            margin: 12px 20px;
            

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


        #del-btn{
            width:60px;
            background-color: indianred;
            margin:0;
            margin-top: 12px;
        }

        #del-btn:hover{
            background:#999;
        }
        .buttons{
            display: flex;
            flex-direction: row;
            align-Items:center;
            justify-content: center;
            width:100%;
            padding: 12px;
        }

        .buttons .back{
            width: 10%;
            background-color: orange;
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


        <div id="mother">
        <?php
        echo'
        <a href="reports.php" class="Toback">&#8594;</a>';
        ?>
         <div class="column">

            <!--form-->
            <form method="POST" action="" enctype="multipart/form-data">
               <h3 >قم برفع التقرير النهائي</h3><br/>

                  <?php 
                     //show error message
                     if(!empty($msg)) {
                        echo "<p id='error'>$msg</p>";
                     }  
                  ?>
               <input type="text"  name="Project_Name" class="forminput" maxlength="120" placeholder="اسم المشروع"  required>
               <textarea  name="scope" placeholder="مجال المشروع"  maxlength="200" cols="2" rows= "4" class="forminput area" required></textarea>
               <textarea  name="objectives" placeholder="التفاصيل"  maxlength="300" cols="2" rows= "4" class="forminput area" required></textarea>
               <textarea  name="students_Name" placeholder="أسماء الطلاب وأرقامهم الجامعية"  maxlength="300" cols="3" rows= "4" class="forminput area" required></textarea>
               <input type="text"  name="supervisor_Name" class="forminput" maxlength="120" placeholder="اسم المشرف"  required>
               <h4>قم برفع ملف المشروع من هنا</h4>
               <input type="file" class="forminput" name="project_file"  accept=".pdf , .docx , .pptx, .xlsx , .zip" required >
               <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال">
                
            </form>

            

         </div>
         <div>
  
   </body>
   </html>
