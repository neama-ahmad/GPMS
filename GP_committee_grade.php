<?php
require_once "config.php";
require_once "session.php";

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit; 
}  

//get Group_id from last page using get method
$Group_id = $_GET["link"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
     //save total of grades in database and will be shown for GP_Committee
    if(isset($_POST["btn-ok"])){
        $total = $_POST['total'];
        $student_id = $_POST['student_id'];
        $Save_Total = mysqli_query($db,"UPDATE grades SET total = '$total' WHERE student_id = '$student_id' ");
        echo '<script>window.location.href ="GP_committee_grade.php?link='.$Group_id.'"</script>';
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

        .top{
            background-color:#eee;
            width:100%;
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
            margin: 0px 6px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #F5B041;
            color: #fff;
        }

        #btn-ok{
            background-color: orange;
        }

        
        .btn2{
            pointer-events:none;
            background-color: #888;
        }

        .btn3{
            pointer-events:none;
            background-color:lightcoral;
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
          <a href="grades.php" class="Toback">&#8594;</a>';
        ?>
            <h3 class="title">تفاصيل الدرجات</h3>
            <br/>
          
            <div class="column">
                <?php
                    $query2 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                    while($row2 = mysqli_fetch_array($query2)){
                    $Group_Name = $row2['Group_Name'];

                    $query3 = mysqli_query($db,"SELECT * FROM group_supervisor WHERE group_id = '$Group_id' ");
                    while($row3 = mysqli_fetch_array($query3)){
                    $supervisor_id = $row3['user_id'];

                  

                    $query4 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$supervisor_id' ");
                    while($row4 = mysqli_fetch_array($query4)){
                    $supervisor_name =  $row4['fullName'];


                    }
                    ?>

            <table>
                
            <tr class="top"><th>اسم المجموعة</th><td><?php echo $Group_Name;?></td><th>المشرف</th><td><?php echo $supervisor_name;?></td>
                    <?php
                    $query5 = mysqli_query($db,"SELECT * FROM final_discussion WHERE group_id = '$Group_id' ");
                    while($row5 = mysqli_fetch_array($query5)){
                    $final_ID =  $row5['ID'];

                    $query11 = mysqli_query($db,"SELECT * FROM discussion_user WHERE final_discussion_ID = '$final_ID' ");
                    while($row11 = mysqli_fetch_array($query11)){
                    $examiner_id =  $row11['user_id'];
                    $rank = $row11['rank'];
                    $query12 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$examiner_id' ");
                    while($row12 = mysqli_fetch_array($query12)){
                    $examiner_name =  $row12['fullName'];
                    if($rank == 1){
                       echo '<th>المختبر الأول</th><td>'.$examiner_name.'</td>';
                    }
                    else{
                       echo '<th>المختبر الثاني</th><td>'.$examiner_name.'</td>';
                    }
                }}}
                 ?>
                </tr>
             
            </table>
   
           <!--show data in table-->
           <form  method="POST" >
                <table id="rowTable">

                    <tr>
                        <th>اسم الطالب</th>
                        <th>الرقم الجامعي</th>
                        <th>درجة المشرف</th>  
                        <th>درجة المختبر الأول</th> 
                        <th>درجة المختبر الثاني</th> 
                        <th>الدرجة النهائية</th>    
                        <th class="lastEdit">تحرير</th>
                    </tr>

                    <tr>

                        <?php

                        $query6 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = '$Group_id' ");
                        while($row6 = mysqli_fetch_array($query6)){
                        $student_id = $row6['user_id'];

                        $query7 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$student_id' ");
                        while($row7 = mysqli_fetch_array($query7)){
                        ?>
                        <td><?php echo $row7['fullName']; ?></td>
                        <td><?php echo $row7['acadmicID']; ?></td>
                        <td>
                        <?php
                        $supervisorGrade = mysqli_query($db,"SELECT * FROM grades WHERE student_id = '$student_id' AND recorder = 'supervisor'");
                        $count = mysqli_num_rows($supervisorGrade);

                        if($count > 0){
                            while($row8 = mysqli_fetch_array($supervisorGrade)){
                            $supervisor_mark = $row8['mark'];
                            $supervisor_confirm = $row8['confirm'];
                            $supervisor_total = $row8['total'];

                            if($supervisor_confirm == 1){
                               echo $supervisor_mark;
                            }

                            else{
                               echo'----';
                            }
                           }
                        }
                        else{
                           echo'----';
                        }

                       ?>
                       </td>

                       <td>
                        <?php
                        $examiner1Grade = mysqli_query($db,"SELECT * FROM grades WHERE student_id = '$student_id' AND recorder = 'examiner1'");
                        $count1 = mysqli_num_rows($examiner1Grade);

                        if($count1 > 0){
                            while($row9 = mysqli_fetch_array($examiner1Grade)){
                            $examiner1_mark = $row9['mark'];
                            $examiner1_confirm = $row9['confirm'];
                            $examiner1_total = $row9['total'];

                            if($examiner1_confirm == 1){
                               echo $examiner1_mark;
                            }

                            else{
                                echo'----';
                            }
                           }
                        }
                        else{
                            echo'----';
                        }

                       ?>
                       </td>

                       <td>
                       <?php
                        $examiner2Grade = mysqli_query($db,"SELECT * FROM grades WHERE student_id = '$student_id' AND recorder = 'examiner2'");
                        $count2 = mysqli_num_rows($examiner2Grade);

                        if($count2 > 0){
                            while($row10 = mysqli_fetch_array($examiner2Grade)){
                            $examiner2_mark = $row10['mark'];
                            $examiner2_confirm = $row10['confirm'];
                            $examiner2_total = $row10['total'];

                            if($examiner2_confirm == 1){
                               echo $examiner2_mark;
                            }

                            else{
                                echo'----';
                            }
                           }
                        }
                        else{
                            echo'----';
                        }

                       ?>
                       </td>

                       <td>
                        <?php
                        if($count > 0 && $count1 > 0 && $count2 > 0){
                        //if all grades confirmed the system will calculate total of grades
                        if($supervisor_confirm == 1 && $examiner1_confirm == 1 && $examiner2_confirm == 1){
                            $total = ($examiner1_mark + $examiner2_mark) / 2 + $supervisor_mark;
                            echo $total;
                        }
                        else{
                            echo '----';
                        }
                       }
                        else{
                         echo '----';
                        }

                        ?>

                       </td>
                        <td>
                        <?php
                        if($count > 0 && $count1 > 0 && $count2 > 0){
                            if($supervisor_total > 0 && $examiner1_total > 0 && $examiner2_total > 0 ){
                                echo '<a href="#" class="button btn3">تم الاعتماد</a>';
                            }
                            elseif($supervisor_confirm == 1 && $examiner1_confirm == 1 && $examiner2_confirm == 1){
                                  
                                echo'
                                <input type="hidden" name="student_id" class="forminput" value="'.$student_id.'" readonly>
                                <input type="hidden" name="total" class="forminput" value="'.$total.'" readonly>
                                <input type="submit" id="btn-ok" name="btn-ok" class="button btn-send" value="اعتماد الدرجة">'; 
   
                            }
                            else{
                                echo '<a href="#" class="button btn2">غير مكتمل</a>';
                            }
                        }

                        else{
                            echo '<a href="#" class="button btn2">غير مكتمل</a>';
                        }
                              
                                  
                        ?>
                        </td>

                        </tr>
                  
                    
                    <?php }}}}?>   
                </table>
                </form>
               
           
      </div>
        
    <div>



</body>
</html>