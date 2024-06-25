<?php 
    require_once "config.php";
    require_once "session.php";
  
   //to stop showing this page if not login in
    if (!isset($_SESSION['loggedin'])) {
	    header('Location:login.php');
	    exit;
    }

    $Group_id = $_GET["link"]; 
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Update data
        if (isset($_POST["save-btn"])){
 
            if(!empty($_POST["Group_Name"])) {
                $Group_Name = $_POST["Group_Name"];
                //check group name is uniqe
                $queryGroupName = mysqli_query($db, "SELECT Group_Name FROM groups WHERE Group_Name = '$Group_Name' AND ID <> '$Group_id' ");
                $count3 = mysqli_num_rows($queryGroupName);
                if($count3 > 0 ){
                    $msg = "اسم المجموعة التي اخترتها محجوز قم باختيار اسم آخر";

                }
                else{
                    $query = mysqli_query($db,"UPDATE groups SET  Group_Name= '$Group_Name' WHERE ID =  '$Group_id' ");
                }
              
                
            }

            if(!empty($_POST["Group_Description"])) {
                $Group_Description = $_POST["Group_Description"];
                $query3 = mysqli_query($db,"UPDATE groups SET Group_Description = '$Group_Description' WHERE ID =  '$Group_id' ");
            }

            if(!empty($_POST["part"])) {
                $part = $_POST["part"];
                $query3 = mysqli_query($db,"UPDATE groups SET part = '$part' WHERE ID =  '$Group_id' ");
            }

            if(!empty($_POST["supervisor"])) {
                $supervisor = $_POST["supervisor"];
                 //update goup supervisor
                $hasSupervisor = mysqli_query($db,"SELECT user_id FROM group_supervisor WHERE group_id = '$Group_id' ");
                $count2 = mysqli_num_rows($hasSupervisor);
                if($count2 < 1){
                  $query5 = mysqli_query($db,"INSERT INTO group_supervisor (user_id, group_id) VALUES ('$supervisor','$Group_id') ");
                 
                }
                else{
                   $query6 = mysqli_query($db,"UPDATE group_supervisor SET  user_id = '$supervisor_id'  AND group_id = '$Group_id' WHERE group_id = '$Group_id' ");
                  
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
            padding:100px;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .card{
            display: flex;
            flex-direction: row;
            text-align: center;
            align-Items:center;
            justify-content: center;
            width:60%;
        }
        
        table {
           width:60%;
           direction:rtl;
           padding-bottom: 2px;
           margin:20px;
        }

        td{
            text-align: center;
            color:#333;
            padding: 2px;
            font-size:14px;
            
            border-bottom:1px solid #ccc;
        }

        th{
            font-size:14px;
            padding: 2px;
            text-align: center;
            border-bottom:1px solid #ccc;
            color:#553965;
        }


        .button{
            border: 2px solid white;
            color: white;
            padding: 7px 40px;
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

        
        .back{
            width: 12%;
            margin:7px;
            background-color: orange;
        }

        .forminput{
            padding: 4px;
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
        @media (max-width: 1200px){
       
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
          <a href="sub_manageGroup.php?link='.$Group_id.'" class="Toback">&#8594;</a>';
        ?>

        <div class="column">
    
        
        <?php
            $query = mysqli_query( $db,"SELECT * FROM groups where ID = '".$Group_id."' ");
            while($row = mysqli_fetch_array($query)){
                $Group_Description = $row['Group_Description'];
        ?>

        <div class="card">
            <div class="card-body">

                <form method ="POST" action ="">
                   <h3 >من هنا يمكنك تعديل البيانات</h3><br/>
                    <?php 
                        //show error message
                        if(!empty($msg)) {
                            echo "<p id='error'>$msg</p>";
                        }  
                    ?>
                    
                    <table  id ="table" class="table">
                        <tr><th>اسم المجموعة</th><td><input type="text" name="Group_Name" class="forminput" value="<?php echo $row['Group_Name']; ?>" ></td></tr>
                        <tr><th> وصف المجموعة</th><td><textarea  name="Group_Description"  placeholder="  قم بكتابة مالا يزيد عن 200 حرف بوصف المشاريع التي تهتم بها مجموعتك"  cols="120" rows= "6" class="forminput area" maxlength="200" ><?php echo $Group_Description; ?></textarea></td></td></tr>
                        <tr><th>الشطر</th><td><?php echo $row['part']; ?></td></tr>
                        <tr><th>تعديل الشطر</th>
                        <td>
                        <select name="part"  class="forminput" >
                        <option value="">اختر...</option>
                        <?php
                            $part = array("طالبات" , "طلاب");
                            foreach($part as $item){
                                echo '<option value="' . strtolower($item) . '">' . $item . '</option>';
                            }
                        ?>
                        </select>  </td></tr>
                        <tr><th>المشرف</th><td><?php
                        $hasSupervisor = mysqli_query($db,"SELECT * FROM group_supervisor WHERE group_id = '$Group_id' ");
                        $count2 = mysqli_num_rows($hasSupervisor);
                        if($count2 < 1){
                            echo 'لايوجد مشرف';
                        }
                        else{
                            $query1 = mysqli_query( $db,"SELECT * FROM group_supervisor where group_id = '".$Group_id."' ");
                            while($row1 = mysqli_fetch_array($query1)){
                               $supervisor_id = $row1['user_id'];

                               $query2 = mysqli_query( $db,"SELECT * FROM user where ID = '".$supervisor_id."' ");
                               while($row2 = mysqli_fetch_array($query2)){
                                $fullName = $row2['fullName'];
                    
                        echo $fullName;}}}?></td></tr>
                        <tr><th>تغيير المشرف</th>
                        <td>
                        <select name="supervisor" class="forminput">
                        <option>...اختر</option>
                        <?php
                            $result = mysqli_query($db,"SELECT * FROM user WHERE role = 'مشرف'");
                            while ($row4 = mysqli_fetch_array($result)){
                                echo "<option value=". $row4['ID']. ">" .$row4['fullName']."</option>";
                            }
                            ?>
                            </select>
                         
                        
                    </td>  
                    </tr>
                    </table>
                    
                    <input type="submit" name="save-btn"  class="button" value="حفظ التعديلات">
                </form>
            </div>
        </div> 
        <?php } ?> 

       </div> 
    </div> 



</body>
</html>