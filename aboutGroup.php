<?php
require_once "config.php";
require_once "session.php";

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
}

$Group_id = $_GET["link"]; 
?>



<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v6.0.0/css/all.css">
    
    <title>نظام إدارة مشاريع التخرج | معلومات المجموعة</title>

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
            font-size: 19px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding-top: 20px;
            text-align:center;
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
            margin: 0px 6px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #F5B041;
            color: #fff;
        }

        .btn2{
            pointer-events:none;
            background-color: #888;
        }

        .back{
            width: 12%;
            margin:7px;
            background-color: orange;
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
          <a href="examiner_discussionTable.php" class="Toback">&#8594;</a>';
        ?>
            <h3 class="title">معلومات المجموعة</h3>
          
            <div class="column">
            
        
           <!--show data in table-->
           <form  method="POST" >
            <?php 

                $query3 = mysqli_query($db,"SELECT * FROM groups WHERE ID = '$Group_id' ");
                while($row3 = mysqli_fetch_array($query3)){
                $Group_Name = $row3['Group_Name'];
                $Group_Description = $row3['Group_Description'];

                $query8 = mysqli_query($db,"SELECT * FROM group_supervisor WHERE group_id = '$Group_id' ");
                while($row8 = mysqli_fetch_array($query8)){
                $supervisor_id = $row8['user_id'];

                $query9 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$supervisor_id' ");
                while($row9 = mysqli_fetch_array($query9)){
                $supervisor_name = $row9['fullName'];
            

            ?>
                    
                    <br/>
                <table id="rowTable">

                
                    <tr><th>اسم المجموعة</th><td><?php echo $Group_Name;?></td></tr>
                    <tr><th>وصف المجموعة</th><td><?php echo $Group_Description;?></td></tr>
                    <tr><th>اسم المشرف</th><td><?php echo $supervisor_name;?></td></tr>
                    <tr>
                        <th>اسم الطالب</th>
                        <th>الرقم الجامعي</th>
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

                    </tr>

                    <?php }} }}}?>
                  
                    
                </table>
                </form>

           
      </div>
        
    <div>



</body>
</html>