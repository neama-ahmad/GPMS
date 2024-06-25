<?php

require_once "config.php";
require_once "session.php";

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Delete group
    if(isset($_POST["del-btn"])){ 
        $Group_id = $_GET["link"];
        $Group_Name = $_POST["Group_Name"];
        $check_group = mysqli_query($db, "SELECT ID FROM groups WHERE Group_Name = '$Group_Name' ");
        if(mysqli_num_rows($check_group) > 0){

            $result1 = mysqli_query($db, "DELETE FROM request WHERE group_id = '$Group_id' ");
            $result2 = mysqli_query($db, "DELETE FROM offer WHERE group_id = '$Group_id' ");
            $result3 = mysqli_query($db, "DELETE FROM files WHERE group_id = '$Group_id' ");
            $result = mysqli_query($db, "DELETE FROM chat WHERE group_id = '$Group_id' ");
            $result = mysqli_query($db, "DELETE FROM group_members WHERE group_id = '$Group_id' ");
            $result = mysqli_query($db, "DELETE FROM group_members WHERE group_id = '$Group_id' ");
            $result4 = mysqli_query($db, "DELETE FROM groups WHERE Group_Name = '$Group_Name' ");
            header("Location:manageGroup.php");
        }

        else{
            $msg = "تأكد من اسم المجموعة";
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
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.0.0/css/all.css">
    
    <title>نظام إدارة مشاريع التخرج |إدارة بيانات المستخدمين</title>

    <!-- CSS here -->
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
            color:#038C85;
            padding: 2px;
            margin: 2px;
        }

        h4{
            font-size:15px;
            color:#038C85;
            padding: 4px;
            margin:0;
            padding-right: 12px;
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
           padding-bottom: 20px;
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
            font-size:14px;
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
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .btn2{
            background-color: indianred;
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

        .Toback{
            font-size:25px;
            background-color:LightSlateGray;
            text-align:center;
            border: none;
            color: white;
            text-decoration: none;
            font-family: 'JF Flat Regular', sans-serif;
            cursor: pointer; 
            width:5%;
            padding:0;
            }

        .Toback:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
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
      font-size: 14px;
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
            padding:2px 12px;
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
           width:98%;
        }

        td,th{
            text-align: right;
            padding: 9px;
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
            <h3>إدارة بيانات المجموعات</h3>
          <?php $Group_id = $_GET["link"]; ?>
            <div class="column">
            <a href="sub_manageGroup.php?link=<?php echo $Group_id; ?>" class="Toback">&#8594;</a>
            <br/><br/>
            <!--Delete Form-->
            <form method="POST" action="" class="del-form">
                <h4 class="del">حذف مجموعة</h4>
                <p style="padding: 8px 20px; margin:0; color:indianred;">تنويه **عندما تقوم بحذف مجموعة سوف يتم حذف جميع البيانات والعمليات التي  تتبع لها**</p>
                <?php 
                   //show error message
                    if(!empty($msg)) {
                       echo "<p id='error'>$msg</p>";
                    } 
                ?>
                <input type ="text" name="Group_Name" class="forminput"  placeholder="ادخل اسم المجموعة المراد حذفه" >
                <input type="submit" name="del-btn" id="del-btn" class="button" value=" حذف ">
            </form> 

            


      </div>
        
    <div>



</body>
</html>