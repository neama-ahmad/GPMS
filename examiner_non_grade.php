<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>نظام إدارة مشاريع التخرج | الدرجات</title>
  
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
            padding-top:200px;
        }

        #error{
            font-size:15px;
            width: 50%;
            padding:12px;
            background-color: Gainsboro;
            color: green;
            border-radius:5px;
            text-align: center; 
                
        }

        .button{
            border: 2px solid white;
            color: white;
            padding: 9px 30px;
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

    
        

        @media (max-width:780px){
            p{
              font-size: 22px;
            }

           a{
               font-size: 22px;
            }

        }
   </style>
   
</head>

<body>

    <div id="mother">
    <?php
        echo 'ليس لديك مجموعة تناقشها حتى الآن';                   
    ?>
    </div>
    
</body>
</html>