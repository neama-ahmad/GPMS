<?php 
    require_once "config.php";
    require_once "session.php";
  
   //to stop showing this page if not login in
    if (!isset($_SESSION['loggedin'])) {
	    header('Location:login.php');
	    exit;
    }

    $discussion_id = $_GET["link"]; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Update data
        if (isset($_POST["save-btn"])){

            $ID = $_POST["ID"];
            $final_discussion_ID = $_POST["final_discussion_ID"];

            if(!empty($_POST["discussion_date"])) {
                $discussion_date = $_POST["discussion_date"];
                //set name of day according by date
                $days = array('يوم الأحد' ,'يوم الآثنين', 'يوم الثلاثاء' , 'يوم الأربعاء','يوم الخميس','يوم الجمعة','يوم السبت');
                $day = date ('w', strtotime($discussion_date));
                $discussion_day = $days[$day];
                $Update_date = mysqli_query($db,"UPDATE discussion_appointment SET discussion_date = '$discussion_date', discussion_day = '$discussion_day' WHERE ID =  '$ID' ");
            }

            if(!empty($_POST["discussion_time"])) {
                $discussion_time = $_POST["discussion_time"];
                $Update_time = mysqli_query($db,"UPDATE discussion_appointment SET discussion_time = '$discussion_time' WHERE ID =  '$ID' ");
            }

            if(!empty($_POST["discussion_place"])) {
                $discussion_place = $_POST["discussion_place"];
                $Update_place = mysqli_query($db,"UPDATE discussion_appointment SET  discussion_place = '$discussion_place' WHERE ID =  '$ID' ");
            }

            if(!empty($_POST["first_examiner"])) {
                $first_examiner = $_POST["first_examiner"];
                $Update_first_examiner = mysqli_query($db,"UPDATE discussion_user SET  user_id = '$first_examiner' WHERE final_discussion_ID =  '$final_discussion_ID' AND rank = 1");
            }

            if(!empty($_POST["second_examiner"])) {
                $second_examiner = $_POST["second_examiner"];
                $Update_second_examiner = mysqli_query($db,"UPDATE discussion_user SET  user_id = '$second_examiner' WHERE final_discussion_ID =  '$final_discussion_ID' AND rank = 2");
            }

        }

       

    }
    

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title>نظام إدارة مشاريع التخرج |إدارة بيانات المستخدمين</title>

    <!-- CSS here -->
    <link rel="stylesheet" href="css/main.css">
    

    <style>
      
        body{
            direction:rtl;
        }
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:20px;
           
        }

        h3{
            font-size: 20px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            text-align:center;
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
            padding-bottom: 40px;
        }

        .card{
            display: flex;
            flex-direction: row;
            text-align: center;
            align-Items:center;
            justify-content: center;
            width:80%;
        }
        
        table {
           width:100%;
           direction:rtl;
           padding-bottom: 2px;
        }

        td{
            text-align: right;
            color:#333;
            padding: 2px;
            font-size:14px;
            border-bottom:1px solid #ccc;
        }

        th{
            font-size:14px;
            padding: 2px;
            text-align: right;
            border-bottom:1px solid #ccc;
            color:#553965;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding:8px 40px;
            font-size:14px;
            text-align: center;
            text-decoration: none;
            background-color: #038C85;
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            width: 22%;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        
        .back{
            width: 12%;
            margin:7px;
            background-color: orange;
        }

        .del-btn{
            background-color: indianred;

        }

        .forminput{
            padding: 7px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
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
        @media (max-width: 1000px){
       
        body{
            font-size: 15px;
        }
        #mother h3{
            font-size: 20px;
        }
        
        .card{
            width: 95%;
        }

        td{
            font-size: 16px;
        }
        .button{
            padding: 6px 40px;
            font-size: 15px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 4px;
            width: 90%;
            font-size: 15px;
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
          <a href="all_discussionTables.php" class="Toback">&#8594;</a>';
        ?>
        
        <div class="column">
            <?php 

                $query2 = mysqli_query($db,"SELECT * FROM final_discussion WHERE ID = '$discussion_id' ");
                while($row2 = mysqli_fetch_array($query2)){
                $appointment_ID = $row2['appointment_ID'];
                $Group_id = $row2['group_id'];
                $final_discussion_ID = $row2['ID'];
                
                
              
        ?>

        <div class="card">
            <div class="card-body">

                <form method ="POST" action ="">
                   <h3 >من هنا يمكنك تعديل  موعد المناقشة</h3><br/>
                    <?php 
                        //show error message
                        if(!empty($msg)) {
                            echo "<p id='error'>$msg</p>";
                        }  
                    ?>
                    <table  id ="table" class="table">
                        <?php
                        $query4 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                        while($row4 = mysqli_fetch_array($query4)){
                            $group_name = $row4['Group_Name'];
                        ?>
                        <tr><th>اسم المجموعة</th><td><?php echo $group_name; }?></td></tr>
                        
                        <tr><th>أسماء المختبرين</th>
                        <td>
                        <?php
                         $query5 = mysqli_query($db,"SELECT * FROM discussion_user WHERE final_discussion_ID = '$final_discussion_ID' ");
                         while($row5 = mysqli_fetch_array($query5)){
                         $examiner_id = $row5['user_id'];
         
                         $query6 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$examiner_id' ");
                         while($row6 = mysqli_fetch_array($query6)){
                             $examiner_name = $row6['fullName'];
         
                        ?>
                        <?php echo $examiner_name; echo'<br/>';}}?>
                        </td></tr>
                        <tr>
                        <th>تغيير المختبر الأول</th>
                        <td>
                        <select name="first_examiner"  class="forminput">
                        <option value="">اختر...</option>
                        <?php
                            $query7 = mysqli_query($db,"SELECT * FROM user WHERE role = 'مختبر' AND Active = 1 ");
                            while($row7 = mysqli_fetch_array($query7)){
                            echo "<option value=". $row7['ID']. ">" .$row7['fullName']."</option>";
                            }
                        ?>
                        </select>  
                        </td>
                        </tr>
                        <tr>
                        <th>تغيير المختبر الثاني</th>
                        <td>
                        <select name="second_examiner"  class="forminput" >
                        <option value="">اختر...</option>
                        <?php
                            $query8 = mysqli_query($db,"SELECT * FROM user WHERE role = 'مختبر' AND Active = 1 ");
                            while($row8 = mysqli_fetch_array($query8)){
                            echo "<option value=". $row8['ID']. ">" .$row8['fullName']."</option>";
                            }
                        ?>
                        </select>  
                        </td>
                        </tr>
                        <?php
                         $query3 = mysqli_query($db,"SELECT * FROM discussion_appointment WHERE ID = '$appointment_ID' ");
                         while($row3 = mysqli_fetch_array($query3)){
                        ?>
                        <tr><th>اليوم</th><td><?php echo $row3['discussion_day'];?></td></tr>
                        <tr><th>التاريخ</th><td><?php echo $row3['discussion_date']; ?></td></tr>
                        <tr><th>تغيير التاريخ</th><td><input type="date" id="discussion_date" name="discussion_date" class="forminput"></td></tr>
                        <tr><th>الوقت</th><td><?php echo $row3['discussion_time']; ?></td></tr>
                        <tr><th>تغيير الوقت</th><td><input type="time" id="discussion_time" name="discussion_time" class="forminput"></td></tr>
                        <tr><th>المكان</th><td><?php echo $row3['discussion_place']; ?></td></tr>
                        <tr><th>تغيير المكان</th><td><input type="text" id="discussion_place" name="discussion_place" class="forminput" placeholder="حدد المكان"  ></td></tr>
                    </table>

                    <input type="hidden"  name="ID" value= "<?php echo $row3['ID']?>" readonly>
                    <input type="hidden"  name="final_discussion_ID" value= "<?php echo $final_discussion_ID?>" readonly>
                    <input type="submit" name="save-btn"  class="button" value="حفظ التعديلات">
                </form>
                <?php } }?> 


            </div>
        </div> 
        

       </div> 
    </div> 



</body>
</html>