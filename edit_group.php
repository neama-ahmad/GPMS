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

            $GroupID = $_POST["group_id"];
            

            if(!empty($_POST["Group_Description"])) {
                $Group_Description = $_POST["Group_Description"];
            }


            $query = mysqli_query($db,"UPDATE groups SET  Group_Description = '$Group_Description' WHERE ID =  '$GroupID' ");
            $msg = "تم حفظ التعديلات";
            
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

    <title>نظام إدارة مشاريع التخرج |تعديل بيانات المجموعة</title>

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
            padding-top: 40px;
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
           width:90%;
           direction:rtl;
           padding-bottom: 2px;
           margin:20px;
        }

        td{
            text-align: right;
            color:#333;
            padding: 12px;
            font-size:14px;
            border-bottom:1px solid #ccc;
        }

        th{
            font-size:14px;
            padding: 12px;
            text-align: right;
            border-bottom:1px solid #ccc;
            color:#038C85;
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
            margin-right:50px;
        }

        .Toback:hover{
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
            width: 70%;
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
            font-size: 14px;
        }
        .button{
            padding: 6px 40px;
            font-size: 14px;
        }

        .button:hover{
            text-decoration: none;
            background-color: #444;
            color: #fff;
        }

        .forminput{
            padding: 4px;
            width: 90%;
            font-size: 14px;
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
          <a href="myGroup.php?link='.$Group_id.'" class="Toback">&#8594;</a>';
        ?>
        
        
        <div class="column">
        
        <?php
            $query = mysqli_query( $db,"SELECT * FROM groups where ID = '".$Group_id."' ");
            while($row = mysqli_fetch_array($query)){
        ?>

        <div class="card">
            <div class="card-body">

                <form method ="POST" action ="">
                   <h3 >بيانات المجموعة</h3><br/>
                    <?php 
                        //show error message
                        if(!empty($msg)) {
                            echo "<p id='error'>$msg</p>";
                        }  
                    ?>
                    <table  id ="table" class="table">
                        <tr><th>اسم المجموعة</th><td><?php echo $row['Group_Name']; ?></td></tr>
                        <tr><th> وصف المجموعة</th><td><textarea  name="Group_Description"  placeholder="  قم بكتابة مالا يزيد عن 200 حرف بوصف المشاريع التي تهتم بها مجموعتك"  cols="120" rows= "6" class="forminput area" maxlength="200" ><?php echo $row['Group_Description']; ?></textarea></td></td></tr>
                    </table>
                    
                    <input type="hidden"  name="group_id" value= "<?php echo $Group_id;?>" readonly>
                    <input type="submit" name="save-btn"  class="button" value="حفظ التعديلات">
                </form>
            </div>
        </div> 
        <?php } ?> 

       </div> 
    </div> 



</body>
</html>