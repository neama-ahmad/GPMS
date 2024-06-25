<?php
require_once "config.php";
require_once "session.php";

   //to stop showing this page if not login in
if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
}

$Group_id = $_GET["link"];

if($_SERVER["REQUEST_METHOD"] == "POST") {

    //accept user request and adding him as a member in the group
    if(isset($_POST['ok-btn'])){
        $user_id = $_POST['user_id'];
        $ID = $_POST['ID'];
        $query = mysqli_query($db, "INSERT INTO group_members(group_id, user_id) VALUES ('$Group_id','$user_id')");
        $query = mysqli_query($db, "UPDATE requests SET status = 'accept' WHERE ID =  '$ID' ");
        header("Location:myGroup.php");
    }

    //deny user request
    if(isset($_POST['deny-btn'])){
        $ID = $_POST['ID'];
        $query = mysqli_query($db, "UPDATE requests SET status = 'deny' WHERE ID =  '$ID' ");
        header("Location:myGroup.php");
    }
}




//pagination
if(isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
  }
      
  else {
    $page_no = 1;
  }
      
  //each page show only 20 records
  $total_records_per_page = 20;
      
  $offset = ($page_no-1) * $total_records_per_page;
      
  //count records in DB table
  $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM requests WHERE group_id = '$Group_id' AND status = 'wait' ");
  $total_records = mysqli_fetch_array($result_count);
  $total_records = $total_records['total_records'];
  
  //number of pages
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1; // total pages minus 1
  
  //fectch records data from DB table
  $sql = "SELECT * FROM requests WHERE group_id = '$Group_id' AND status = 'wait' ORDER BY ID DESC LIMIT $offset, $total_records_per_page";
  $result = $db->query($sql);
  $arr_rows = [];
  
  if ($result->num_rows > 0) {
      $arr_rows = $result->fetch_all(MYSQLI_ASSOC);
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
    
    <title>نظام إدارة مشاريع التخرج | طلبات الانضمام</title>

    <!-- CSS here -->
    <link rel="stylesheet" href="css/main.css">
    

    <style>
        #mother{
            display:flex;
            flex-direction:column;
            justify-content: flex-start;
            height: auto;
            width: 100%;
            padding-top:20px;
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
            height:1%;
            padding:0;
            border-radius:5px;
            font-style:bold;
            margin-right:10px;
        }

        .Toback:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }


        h3{
            font-size: 19px;
            color: #f16465;
            padding: 2px;
            margin: 2px;
            padding-top: 20px;
            text-align: center;
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
            padding: 12px;
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
        }
        

        .button:hover{
            text-decoration: none;
            background-color: #F5B041;
            color: #fff;
        }

        .del{
            background-color:indianred;
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
        <?php
        echo'
        <a href="myGroup.php" class="Toback">&#8594;</a>';
        ?>
    
            <h3 class="title">طلبات الانضمام</h3>
          
            <div class="column">
            
            <!--show records number-->
            <form  method="POST" >
                <label for="total">العدد الكلي للطلبات</label>
                <input type ="text" id="total" class="forminput" name="total" placeholder="العدد الكلي" value="<?php echo $total_records;?>" readonly > 
              
            </form>
   
           <!--show data in table-->
            <form  method="POST" >
                <table id="rowTable">

                    <tr>
                        <th>الاسم</th>
                        <th>رسالة الانضمام</th>
                        <th class="lastEdit">تحرير</th>
                    </tr>

                    <?php
                       foreach($arr_rows as $row) { 
                        $ID = $row['ID'];
                        $user_id = $row['user_id'];
                        $query4 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$user_id' ");
                        while($row4 = mysqli_fetch_array($query4)){
                       
                    ?>
                    <tr>
                        <td id="emailTable"><?php echo $row4['fullName']; ?></td>
                        <td><?php echo $row['request_content']; ?></td>
                        <?php 
                        echo '<td>
                        <form method ="POST">
                        <input type="hidden"  name="ID" value= "'.$ID.'" readonly>
                        <input type="hidden"  name="user_id" value= "'.$user_id.'" readonly>
                        <input type="submit" name="ok-btn"  class="button" value="قبول">
                        <input type="submit" name="deny-btn" class="button del" value="رفض">
                        </form>
                        </td>';
                        
                        ?>
                    </tr>
                    
                    <?php } }
                    ?>   
                </table>
            </form>

    <!--pagination-->
    <div class="pagination">
      <?php
        $page_link = "";
        if($page_no >= 2){
          echo "<a href='group_Request.php?page_no=".($page_no - 1)."'>السابق</a>";
        }

        for($i=1; $i<=$total_no_of_pages; $i++){
          if($i == $page_no){
            if($page_no == 1 && $total_no_of_pages == 1){
              $page_link .="";
            }
            else{
              $page_link .="<a class='active' href='group_Request.php?page_no=".$i."'>".$i."</a>";
            }
          }
          else{
            $page_link .="<a href='group_Request.php?page_no=".$i."'>".$i."</a>";
          }
        }
        echo $page_link;
          if($page_no < $total_no_of_pages){
            echo "<a href='group_Request.php?page_no=".($page_no + 1)."'>التالي</a>";
          }

        ?>
      </div>
        
    <div>



<?php
 
?>

</body>
</html>