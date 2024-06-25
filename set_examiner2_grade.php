<?php
require_once "config.php";
require_once "session.php";

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
}

//get student_id form last page using get method
$student_id = $_GET["link"]; 

if($_SERVER["REQUEST_METHOD"] == "POST"){

 //Submit grade
 if(isset($_POST["btn-add"])){

    $examiner_mark = $_POST['examiner_mark'];
    $examiner_id = $_POST['examiner_id'];

    //check examiner2 didn't submit grade before for this student
    $hasGrade = mysqli_query($db, "SELECT * FROM grades WHERE student_id = '$student_id'  AND recorder = 'examiner2' ");
    $count = mysqli_num_rows($hasGrade);
    if($count < 1 ){
        //examiner2 submit student's grade
        $Submit_Grade = mysqli_query($db, "INSERT INTO grades (mark, recorder, student_id) VALUES ('$examiner_mark', 'examiner2', '$student_id')");
        $grade_id = mysqli_insert_id($db);
        if($grade_id){
            $save_recorder_id = mysqli_query($db, "INSERT INTO grade_recorder (recorder_id, grade_id) VALUES ('$examiner_id', '$grade_id')");
            header('Location:examiner_grade.php');
        }
    }
    else{
     //if examiner2 submit grade for this student before just Update the grade
     $Update_Grade = mysqli_query($db,"UPDATE grades SET  mark  = '$examiner_mark' WHERE student_id =  '$student_id' AND recorder = 'examiner2'");
     header('Location:examiner_grade.php');
    }

 }

//Confirm student's grade (اعتماد الدرجة)
if(isset($_POST["btn-ok"])){
    $examiner_mark = $_POST['examiner_mark'];
    $examiner_id = $_POST['examiner_id'];

    $Update_grade = mysqli_query($db,"UPDATE grades SET  mark  = '$examiner_mark' WHERE student_id =  '$student_id' AND recorder = 'examiner2' ");
    $Confirm_grade = mysqli_query($db,"UPDATE grades SET  confirm = 1 WHERE student_id = '$student_id' AND recorder = 'examiner2' ");
    header('Location:examiner_grade.php');
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
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.0.0/css/all.css">
    
    <title>نظام إدارة مشاريع التخرج | رصد الدرجات</title>

    <!-- CSS here -->
    <link rel="stylesheet" href="css/main.css">
    

    <style>
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:30px;
        }

        h3{
            text-align:center;
            font-size: 19px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding-top: 20px;
        }
        
        .column{
            display: flex;
            flex-direction: column;
            align-Items:right;
            justify-content: flex-start;
            width:100%;
            height:auto;
            padding:2px 50px;
            padding-bottom: 40px;
            background: none;
            box-shadow:none;
        }

        .del-form{
            margin-bottom: 40px;
        }
        #del-btn{
            background-color: indianred;
        }

        #del-btn:hover{
            background:#999;
        }

        table {
           width:100%;
           direction:rtl;
           padding-bottom: 50px;
        }

        td{
            text-align: center;
            color:#333;
            padding: 9px;
            font-size:14px;
            word-wrap:break-word;
            border-bottom:1px solid #ccc;
        }

        th{
            font-size:15px;
            border-bottom:1px solid #ccc;
            color:#038C85;
        }


        .button{
            border: none;
            color: white;
            padding: 7px 20px;
            font-size:14px;
            text-align: center;
            text-decoration: none;
            background-color: #038C85;
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            margin: 0px 2px;
            width:40%;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        #btn-ok{
            background-color: orange;
        }

        
        .btn2{
            pointer-events:none;
            background-color: #888;
        }
        .forminput{
            padding: 8px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 8px;
            width: 35%;
            border: 1px solid #ccc;
            transition: all 0.5s ease-in-out;
            font-family: 'JF Flat Regular', sans-serif;
            background-color: transparent;
            border-radius: 10px;
        }

        .number{
            width:50%;
        }

        #total{
            width:10%;
        }
        .role{
            width: 20%;
        }
        label{
            background-color: transparent;
            color: #333;
            padding-right:12px;
            font-size:15px;
        }

        .new-btn{
            float:left;
        }

        *:focus{
            outline:none;
        }

        
        .lastEdit{
            padding: 9px 40px;
        }

        #error{
            font-size:15px;
            text-align: right;
            margin: 12px;
            width: 30%;
            padding:9px;
            padding-right:20px;
            background-color: Gainsboro;
            color:#666;
            border-radius:5px;
                
        }

        .fa-circle{
            font-size:12px;
            color:red;
        }

        
        .pagination{
      display: flex;
      flex-direction:row;
      align-Items: center;
      justify-content:center;
      margin: 40px 0;
    }

    .pagination a{
      text-decoration: none;
      border : 1px solid #999;
      color: #333;
      padding: 8px 12px;
      margin: 0 2px;
      font-size: 16px;
      border-radius: 5px;
    }
    .pagination a.active{
      background-color: SandyBrown;
    }

    .pagination a:hover:not(.active){
      background-color: LightSlateGray;
    }

        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        #mother h3{
            font-size: 20px;
        }
        
        .column{
            padding:2px 9px;
        }


        .button{
            padding: 6px 16px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 8px;
            margin: 8px;
            width: 30%;

        }

        table {
           width:100%;
           padding: 0px;
           margin: 0px;
           margin-top:20px;
           text-align:center;
        }

        td,th{
            text-align:center;
            padding: 9px;
            font-size: 14px;
        }

        table .button{
            width: 80%;
            white-space:nowrap;
        }

        #search-btn{
            width:50%;
            padding:8px;
            font-size:14px;
        }

        #total{
            width:16%;
        }
        .role{
            width: 20%;
        }

        #error{
            width: 70%;
        }
    

    }



    </style>

    </head>
    <body>
 
        <div id="mother">
        <?php
          echo'
          <a href="examiner_grade.php" class="Toback">&#8594;</a>';
        ?>
            <h3 class="title">درجات الطلاب</h3>
          
            <div class="column">
    
               <?php
                   
                    $email = $_SESSION['email'];
                    $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
                    while($row1 = mysqli_fetch_array($query1)){
                    $userID = $row1['ID'];

                    
                ?>
             
   
           <!--show data in table-->
           <form  method="POST" >
           <?php 
                $query6 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$student_id' ");
                while($row6 = mysqli_fetch_array($query6)){
                $Group_id = $row6['group_id'];

                $query3 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                while($row3 = mysqli_fetch_array($query3)){
                $Group_Name = $row3['Group_Name'];
            ?>
              <br/>
              <p style="color:indianred; font-size: 14px;">ملاحظة: بعد اعتماد الدرجة يتم رسالها إلى لجنة المشاريع ولا يمكنك التعديل عليها</p>
                
                <table id="rowTable">


                    <tr><th>اسم المجموعة</th><td><?php echo $Group_Name;?></td></tr>
                    <?php }} ?>
                    <tr>
                        <th>اسم الطالب</th>
                       
                        <th>الرقم الجامعي</th>
                        <th>درجة المختبر</th>  
                        <th class="lastEdit">تحرير</th>
                    </tr>

                    <tr>

                        <?php

                        $query7 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$student_id' ");
                        while($row7 = mysqli_fetch_array($query7)){
                        ?>
                        <td><?php echo $row7['fullName']; ?></td>
                        <td><?php echo $row7['acadmicID']; ?></td>

                        <?php   
                        $hasGrade = mysqli_query($db,"SELECT * FROM grades WHERE student_id = '$student_id' AND recorder = 'examiner2' ");
                        $count = mysqli_num_rows($hasGrade);
                        if($count > 0){
                            while($row8 = mysqli_fetch_array($hasGrade)){
                            $mark = $row8['mark'];
                            $confirm = $row8['confirm'];
                           echo'
                           <td>
                           <input type="number" name="examiner_mark"  max="45"  min="0" class="forminput number" placeholdeer="ادخل درجة الطالب" value="'.$mark.'" required></td>
                           <td>
                           <input type="hidden" name="examiner_id" class="forminput" value="'.$userID.'" readonly>
                           <input type="submit" id="btn-add" name="btn-add" class="button btn-send" value="حفظ">
                           <input type="submit" id="btn-ok" name="btn-ok" class="button btn-send" value="اعتماد">
                           </td>';
                          }
                        }
                        else{
                          echo'
                          <td>
                          <input type="number" name="examiner_mark" max="45"  min="0" class="forminput number" placeholdeer="ادخل درجة الطالب" required></td>
                          <td>
                          <input type="hidden" name="examiner_id" class="forminput" value="'.$userID.'" readonly>
                          <input type="submit" id="btn-add" name="btn-add" class="button btn-send" value="حفظ">
                          <input type="submit" class="button btn2" value="اعتماد">
                          </td>';

                        }
                    
                      ?>
                      </tr>
                
                  
                    
                    <?php }} ?>   
                </table>
                </form>
               
           
      </div>
        
    <div>



</body>
</html>