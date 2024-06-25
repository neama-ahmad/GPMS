<?php 
   require_once "config.php";
   require_once "session.php";
 
   //to stop showing this page if not login in
   if(!isset($_SESSION['loggedin'])) {
      header('Location:login.php');
      exit;
   }


   if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
      //insert topics added by supervisor to database
      if(isset($_POST["btn-add"])){

        $message = $_POST['message'];


        $email = $_SESSION['email'];
        $query1 = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
        while($row1 = mysqli_fetch_array($query1)){
            $userID = $row1['ID'];

            $query2 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
            while($row2 = mysqli_fetch_array($query2)){

            $Group_id = $row2["group_id"];
          
            $query = mysqli_query($db, "INSERT INTO chat (message, sendFor, user_id , group_id) VALUES ('$message','مشرف', '$userID' , '$Group_id')");

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
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <title>نظام إدارة مشاريع التخرج |إرسال رسالة</title>

        <!-- CSS here -->
        <link rel="stylesheet" href="css/main.css">
    
    <style>

        body{
            background-color:#eee;
        }
    
    #mother{
        display:flex;
        flex-direction:row;
        justify-content: flex-start;
        height: auto;
        width: 100%;
        padding-top:30px;
        
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
        background: none;
        box-shadow:none;
        height:auto;
        position:sticky;
       
        
    }

    .column form{
        display: flex;
        flex-direction: row;
        align-Items:center;
        justify-content: center;
        width:100%;
        height:auto;
        background: none;
        box-shadow:none;
        padding-bottom: 20px;
    }


    .button{
        border: 2px solid white;
        color: white;
        padding: 7px;
        width:10%;
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
        padding: 7px;
        color: #333; 
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 8px;
        width: 70%;
        border: 1px solid #ccc;
        transition: all 0.5s ease-in-out;
        font-family: 'JF Flat Regular', sans-serif;
        background-color: #fff;
        border-radius: 5px;
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

    .row2{
        padding:10px;
        padding-right:40px;
        align-Items:right;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        width:100%;
        flex-wrap:wrap;
        height:auto;
       
    }
    .column2{
        width:40%;
        padding:8px;
        height:auto;
        background: rgb(255, 255, 255);
        box-shadow: 5px 5px 30px 15px rgba(218, 218, 218, 0.25), 
            -5px -5px 30px 15px rgba(211, 211, 211, 0.22);
        padding: 4px 0px;
        display: flex;
       
        margin: 12px 20px;
        border-radius: 50px 50px 0px 50px;
       position:relative;

        

    }

    .col2{
        flex-direction: column;
        align-Items: left;
        justify-content:flex-end;
    }

    .col1{
        flex-direction: column;
        align-Items: right;
        justify-content:flex-start;
    }

    h4{
        font-size:15px;
        padding-bottom:0;
        margin-bottom:0;
        color: #555;
    }

    .column2 .r1{
       font-size: 16px;
       color:#038C85;
       padding:4px;
       margin:2px;
    }

    .column2 .r2{
       font-size: 15px;
       color:#555;
       padding:0px;
       margin:2px;
       margin-bottom:14px;
    }

    
    table {
  width:90%;
  direction:rtl;
  margin: 6px 20px;
  padding: 12px;
}

td{
  text-align: right;
  color:#333;
  padding: 9px;
  font-size:14px;
  word-wrap:break-word;
  /*border-bottom:1px solid #ccc;*/
}

.bold{
  color:#038C85;
}

.time{
    font-size:11px;
    color: #999;
    position:absolute;
    bottom:6px;
    left: 25px;
}

.how{
    font-size:11px;
    position:absolute;
    bottom:6px;
    right: 22px;
    color:#999;
}


    #del-btn{
        width:60px;
        background-color: indianred;
        margin:0;
        margin-top: 12px;
    }

    #del-btn:hover{
        background:#999;
    }
    @media (max-width: 1000px){
   
    body{
        font-size: 15px;
    }
    #mother h3{
        font-size: 20px;
    }
    
    .row2{
        padding-top:12px;
        align-Items:center;
        justify-content: center;
        width:100%;
    }
    .column2{
        width:100%;
        height:350px;
        margin:20px 12px;
        padding:10px;
    }


    .button{
        padding: 6px;
    }

    .button:hover{
        text-decoration: none;
        background-color: #444;
        color: #fff;
    }

    .forminput{
        padding: 8px;
        margin: 8px;
        width: 60%;

    }

    #error{
        width: 90%
            
    }

    #del-btn{
        padding: 12px;
        width:100px;
    }



}



</style>




    </style>



    </head>

    <body>

 

        <div id="mother">
         <br/>
       
         <div class="row2">
         <h3>مراسلة المشرف</h3>
            <?php
            $email = $_SESSION['email'];
            $query = mysqli_query($db,"SELECT * FROM user WHERE email = '$email' ");
            while($row = mysqli_fetch_array($query)){
              $userID = $row['ID'];

              
            $query2 = mysqli_query($db,"SELECT * FROM group_members WHERE user_id = '$userID' ");
            while($row2 = mysqli_fetch_array($query2)){

            $Group_id = $row2["group_id"];
            
              $query3 = mysqli_query($db,"SELECT * FROM chat WHERE group_id = '$Group_id' AND sendFor = 'مشرف' OR sendFor = 'طلاب' ORDER BY Added_Time ASC  ");
              while($row3 = mysqli_fetch_array($query3)){
                $writer_id = $row3['user_id'];
                $message = $row3['message'];
                $Added_Time = $row3['Added_Time'];
                $dt = new DateTime($Added_Time);
                
            ?>
            <?php
               $query4 = mysqli_query($db,"SELECT * FROM user WHERE ID = '$writer_id' ");
                 while($row4 = mysqli_fetch_array($query4)){
                    $writer_name = $row4['fullName'];
                    if($writer_id == $userID){
                     echo '
                     <div class="column2 col1">

                     <table>
                         <tr><td>'.$message.'</td></tr>
                     </table>
                     <span class="how">أنا</span> 
                     <span class="time">'.$dt->format("H:i    d/m ").' </span>
                     </div>
                     
                     ';
                    }
                    else{
                      echo '
                      <div class="column2 col2">

                       <table>
                       <tr><td>'.$message.'</td></tr>
                       </table>

                       <span class="how">'.$writer_name.'</span>
                       <span class="time">'.$dt->format("H:i    d/m ").' </span>
                       </div>
                     
                     ';
                    }
                }}}}

            ?>
            <div class="column">
            <!--form-->
            <form method="POST" action="">
                <textarea  name="message" placeholder="اكتب شيئا.."   maxlength="400" cols="3" rows= "3" class="forminput area" required></textarea>
                <input type="submit"  id="btn-add" name="btn-add" class="button btn-send" value="إرسال">
            </form>
            </div>
       
        </div>

      </div>

      

  
   </body>
   </html>
