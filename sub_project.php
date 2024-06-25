<?php 
    require_once "config.php";
    require_once "session.php";
  
   //to stop showing this page if not login in
    if (!isset($_SESSION['loggedin'])) {
	    header('Location:login.php');
	    exit;
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
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.0.0/css/all.css">

    <title>نظام إدارة مشاريع التخرج |أرشيف مشاريع التخرج</title>

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
            font-size: 24px;
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
            padding-top:20px;
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
           word-wrap:break-word;
        }

        td{
            text-align: right;
            color:#333;
            padding: 2px;
            font-size:14px;
            word-wrap:break-word;
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
            padding: 7px 60px;
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
            padding: 4px;
            color: #333; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            width: 50%;
            border: none;
            transition: all 0.5s ease-in-out;
            font-family: 'JF Flat Regular', sans-serif;
            background-color: transparent;
            border-radius: 10px;
        }

        .file-btn{
            border-radius: 50px;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            margin:8px;
            background-color: transparent;
            border: solid 1px #038C85;
            color:#333;
            text-decoration: none;
            white-space:nowrap;
            font-size:14px;
            width:80%;
            padding:7px 100px;
        }

        .file-btn:hover{
            text-decoration: none;
            background-color: #ddd;
            color: #038C85;
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


        .back{
            padding: 7px 20px;
            background-color: orange;
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
        <a href="projects.php" class="Toback">&#8594;</a>';
        ?>
        
        <div class="column">
        <?php
            //get userID from last page (memmbers.php)
            $ID = $_GET["link"]; 
            $query = mysqli_query( $db,"SELECT * FROM projects where ID = '$ID' ");
            while($row = mysqli_fetch_array($query)){
        ?>

        <div class="card">
            <div class="card-body">
            <h3>تفاصيل مشروع التخرج</h3><br/>

                <form method ="POST" action ="">
                    <?php 
                        //show error message
                        if(!empty($msg)) {
                            echo "<p id='error'>$msg</p>";
                        }  
                    ?>
                    <table  id ="table" class="table">
                       <tr><th>اسم المشروع</th><td><?php echo $row['Project_Name']; ?></td></tr>
                        <tr><th>مجال المشروع</th><td><?php echo $row['scope']; ?></td></tr>
                        <tr><th>التفاصيل</th><td><?php echo $row['objectives']; ?></td></tr>
                        <tr><th>أسماء الطلاب</th><td><?php echo $row['students_Name']; ?></td></tr>
                        <tr><th>اسم المشرف</th><td><?php echo $row['supervisor_Name']; ?></td></tr>
                        <tr><th>العام الدراسي</th><td><?php echo $row['year']; ?></td></tr>
                        <tr><th>ملف المشروع</th><td><a href="FileOpen.php?ID=<?php echo $row['ID'];?>" class="file-btn" target="_blank">   <i class="fa-solid fa-download"></i>  <?php echo $row['project_file'];?></a></td></tr>
                    </table>
                    
                </form>
            </div>
        </div> 
        <?php } ?> 

       </div> 
    </div> 



</body>
</html>