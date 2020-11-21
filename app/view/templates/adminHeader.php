<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Admin panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">




    <link rel='stylesheet' href="client/css/adminPanel/main.css">
    <link rel='stylesheet' href="client/css/adminPanel/adminPanel.css">
    
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/9547750bbd.js" crossorigin="anonymous"></script>



    <?php

if($_SERVER['PHP_SELF']){
    
    echo '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>';
    echo '<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>';
    echo '<link rel="stylesheet" href="client/css/adminSettings.css">';
}
?>


</head>

<body class='light'>
    <header>
        <div class='left-header'>
        <i class="fas fa-bars"></i>
        <a href='adminPanel.php'><i class='logo'>
            Admin Panel
        </i></a>
        </div>
        <div class='right-header'>
        <a href='adminSettings.php'> <i class="fas fa-cog"></i></a>
            <div class='profile-icon'>
                <img src='https://i.imgur.com/wIHZKq1.png'>
            </div>
        </div>

    </header>
    <!-- <div class='page-loader'>

    </div> -->
   