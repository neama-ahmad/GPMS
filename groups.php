<?php
require_once "config.php";
require_once "session.php";

if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit;
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
  $result_count = mysqli_query($db,"SELECT COUNT(*) As total_records FROM groups ");
  $total_records = mysqli_fetch_array($result_count);
  $total_records = $total_records['total_records'];
  
  //number of pages
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1; // total pages minus 1
  
  //fectch records data from DB table
  $sql = "SELECT * FROM groups ORDER BY ID DESC LIMIT $offset, $total_records_per_page";
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
    
    <title>نظام إدارة مشاريع التخرج | المجموعات</title>

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
        #close{
            font-size:15px;
            width: 50%;
            padding:12px;
            background-color: Gainsboro;
            color: green;
            border-radius:5px;
            text-align: center; 
            margin-top: 120px;
        }

        h3{
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
           padding-bottom: 20px;
           word-wrap:break-word;
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
            white-space:nowrap;
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
            //close this page
            $closed = mysqli_query($db, "SELECT * FROM closed WHERE search_for_group = 1 AND search_for_supervisor = 1 "); 
            $close = mysqli_num_rows($closed);
            if($close > 0){
                echo '<p id="close">هذه الميزة غير متاحة حاليا</p>';
            }
            else{ 
            ?>
       
            <h3 class="title">البحث عن مجموعة</h3>
          
            <div class="column">
            
            <form  method="POST" >
               <?php
                    //count number of records
                    $result = mysqli_query($db,"SELECT COUNT(*) As total FROM groups ");
                    $total_group = mysqli_fetch_array($result);
                ?>
                <label for="total">العدد الكلي للمجموعات</label>
                <input type ="text" id="total" class="forminput" name="total" placeholder="العدد الكلي" value="<?php echo $total_group[0];?>" readonly > 
              
            </form>
   
           <!--show data in table-->
            <form  method="POST" >
                <table id="rowTable">
                    <!--search box-->
                    <input type ="text" id="search-btn" name="search-btn" class="forminput space" placeholder="ابحث باسم المجموعة" onkeyup="Search()">   
                    <?php 
                     $email = $_SESSION['email'];
                     $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
                     while($row1 = mysqli_fetch_array($query1)){
                     $userID = $row1['ID'];

                     //hide create new group button for student already has group
                     $hasGroup = mysqli_query($db, "SELECT user_id FROM group_members where user_id = '$userID' ");
                     $count = mysqli_num_rows($hasGroup);

                     $ask_member = mysqli_query($db, "SELECT user_id FROM member_ask where user_id = '$userID' AND status = 'wait' ");
                     $count2 = mysqli_num_rows($ask_member);

                     if($count < 1 && $count2 < 1){
                        echo '<a href="createGroup.php" class="button new-btn"><i class="fa-solid fa-plus"></i>إنشاء مجموعة جديدة</a>';
                     }
                    }

                    //show alert if there is a group want to add current student to thiere group
                     if($count2 > 0){
                        echo '<a href="askMember.php" class="button new-btn">  <i class="fa-solid fa-circle"></i>   إشعار بإضافتك لمجموعة</a>';
                     }
                    
                    ?>
                    
                    
                    <br/><br/> 
                    

                    <tr>
                        <th>اسم المجموعة</th>
                        <th>وصف المجموعة</th>
                        <th>الشطر</th>
                        <th>أعضاء المجموعة</th>
                        <th>مشرف المجموعة</th>
                        
                        <th class="lastEdit">حالة المجموعة</th>
                    </tr>

                    <?php
                       foreach($arr_rows as $row) { 
                        $Group_id = $row['ID'];
                       
                    ?>
                    <tr>
                        <td id="emailTable"><?php echo $row['Group_Name']; ?></td>
                        <td><?php echo $row['Group_Description']; ?></td>
                        <td><?php echo $row['part']; ?></td>
                        <td>
                        <?php
                        
                        $query6 = mysqli_query($db,"SELECT * FROM group_members WHERE group_id = '$Group_id' ");
                        while($row6 = mysqli_fetch_array($query6)){
                        $user_id = $row6['user_id'];

                        $query7 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$user_id' ");
                        while($row7 = mysqli_fetch_array($query7)){

                            $full_name = $row7['fullName'];
                            echo $full_name;
                            echo'<br/>';
                        }}
                        ?>
                        </td>
                        <td>
                        <?php 
                        $hasSupervisor = mysqli_query($db,"SELECT * FROM group_supervisor WHERE group_id = '$Group_id' ");
                        $count2 = mysqli_num_rows($hasSupervisor);
                        if($count2 < 1){
                            echo '<p>لايوجد مشرف</p>';
                        }
                        else{
                             while($row = mysqli_fetch_array($hasSupervisor)){
                                $supervisor_id = $row['user_id'];
                            $query6 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$supervisor_id' ");
                            while($row6 = mysqli_fetch_array($query6)){
                                $supervisor_Name = $row6['fullName'];
                                
                            echo $supervisor_Name;
                        }
                      }
                     
                      }
                      ?>
                      </td>

                        <?php 
                        //after five members in a group show 'مجموعة مكتملة'
                        $completedGroup = mysqli_query($db, "SELECT user_id FROM group_members where group_id = '$Group_id' ");
                        $count = mysqli_num_rows($completedGroup);
                        if($count < 5){
                        echo'<td><a href="sendRequest.php?link='.$Group_id.'" class="button">طلب انضمام</a></td>';
                        } else {
                        echo '<td><a href="#" class="button btn2">مجموعة مكتملة</a></td>';
                        }
                        ?>
                    </tr>
                    
                    <?php } ?>   
                </table>
            </form>

        <!--pagination-->
        <div class="pagination">
        <?php
        $page_link = "";
        if($page_no >= 2){
          echo "<a href='groups.php?page_no=".($page_no - 1)."'>السابق</a>";
        }

        for($i=1; $i<=$total_no_of_pages; $i++){
          if($i == $page_no){
            if($page_no == 1 && $total_no_of_pages == 1){
              $page_link .="";
            }
            else{
              $page_link .="<a class='active' href='groups.php?page_no=".$i."'>".$i."</a>";
            }
          }
          else{
            $page_link .="<a href='groups.php?page_no=".$i."'>".$i."</a>";
          }
        }
        echo $page_link;
          if($page_no < $total_no_of_pages){
            echo "<a href='groups.php?page_no=".($page_no + 1)."'>التالي</a>";
          }

        ?>
      </div>
        
    <div>


    <!--Search inside table-->
    <script type="text/javascript">
           function Search() {
                var input, filter, table, tr, td,txt, i, txtValue;
                input = document.getElementById("search-btn");
                filter = input.value.toUpperCase();
                table = document.getElementById("rowTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if(td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } 
                        else {
                            tr[i].style.display = "none";
                        }
            
                    }       
                }
            }

       
    

        </script>


</body>
</html>
<?php } ?>