<?php 
    require_once "config.php";
    require_once "session.php";
  
   //to stop showing this page if not login in
    if (!isset($_SESSION['loggedin'])) {
	    header('Location:login.php');
	    exit;
    }

   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Update data
        if (isset($_POST["active-btn"])){

            $ID = $_POST["userID"];
            $query = mysqli_query($db,"UPDATE user SET  Active = 1 WHERE ID =  '$ID' ");
            header('Location:users.php');
        }

        //Delete data
        if (isset($_POST["del-btn"])){

            $ID = $_POST["userID"];
            $query = mysqli_query($db,"DELETE from user WHERE ID =  '$ID' ");
            header('Location:users.php');
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
            text-align:center;
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
            text-align: center;
            color:#333;
            font-size:14px;
            
            border-bottom:1px solid #ccc;
        }

        th{
            font-size:14px;
            padding-top: 12px ;
            text-align: center;
            border-bottom:1px solid #ccc;
            color:#555;
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
            width: 20%;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 4px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            width: 50%;
            border: none;
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
            font-size: 18px;
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
          <a href="users.php" class="Toback">&#8594;</a>';
        ?>
        
        <div class="column">
        <?php
            //get userID from last page (users.php)
            $userID = $_GET["link"]; 

            //fetch user data by user ID
            $query = mysqli_query( $db,"SELECT * FROM user where ID = '". $userID."' ");
            while($row = mysqli_fetch_array($query)){
        ?>

        <div class="card">
            <div class="card-body">

                <form method ="POST" action ="">
                   <h3 >  من هنا يمكنك قبول المستخدم حتى  يسمح له بدخول النظام أو رفضه</h3><br/>
                    <?php 
                        //show error message
                        if(!empty($msg)) {
                            echo "<p id='error'>$msg</p>";
                        }  
                    ?>
                    <table  id ="table" class="table">
                        <tr><th>الايميل</th><td><input type="email" id="email" name="email" class="forminput" value="<?php echo $row['email']; ?>"  readonly  style="border:none;"></td></tr>
                        <tr><th>الاسم الثلاثي</th><td><input type="text" id="fullName" name="fullName"  class="forminput" value="<?php echo $row['fullName']; ?>"  required readonly></td></tr>
                        <tr><th>نوع الجنس</th><td><input type="text" id="gender" name="gender"  class="forminput" value="<?php echo $row['gender']; ?>"  required readonly></td></tr>
                        <tr><th>الرقم الجامعي أو الوظيفي</th><td><input type="text" id="acadmicID" name="acadmicID"  class="forminput" value="<?php echo $row['acadmicID']; ?>"  required readonly></td></tr>
                        <tr><th>رقم الجوال</th><td><input type="text" id="phone" name="phone"  class="forminput" value="<?php echo $row['phone']; ?>"  required readonly></td></tr>
                        <tr><th>كلمة المرور</th><td><input type="text" id="password" name="password" class="forminput" value="<?php echo $row['password']; ?>" required readonly></td></tr>
                        <tr><th>الصلاحية</th><td><?php echo $row['role']; ?></td></tr>
                    </table>
                    
                    <!--<a href="users.php"  class="button back">إلى الخلف</a>-->
                    <input type="hidden"  name="userID" value= "<?php echo $row['ID']?>" readonly>
                    <input type="submit" name="active-btn"  class="button" value="قبول">
                    <input type="submit" name="del-btn"  class="button" value="رفض">
                </form>
            </div>
        </div> 
        <?php } ?> 

       </div> 
    </div> 



</body>
</html>