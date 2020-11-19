
<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Admin panel</title>
    <link rel='stylesheet' href="client/css/adminPanel/main.css">
    <link rel='stylesheet' href="client/css/adminPanel/adminPanel.css">
    <script defer  type="module" src="client/controller/adminPanel.js"></script>
    <!--Font awesome-->
    <script src="https://kit.fontawesome.com/9547750bbd.js" crossorigin="anonymous"></script>
</head>

<body class='light'>
    <header>
        <div class='left-header'>
        <i class="fas fa-bars"></i>
        <i class='logo'>
            Admin Panel
        </i>
        </div>
        <div class='right-header'>
        <i class="fas fa-cog"></i>
            <div class='profile-icon'>
                <img src='https://i.imgur.com/wIHZKq1.png'>
            </div>
        </div>

    </header>
    <main class="">
        <div class="panel-container">
            <aside class='sidebar'>
                <ul class='options'>
                    <li class='active'>Posts</li>
                    <li>Styles</li>
                    <li>Settings</li>
                </ul>
                <div id='create-post-btn-id' class='create-post-btn'>New post</div>
            </aside>
            <div class='main-content'>
                <ul class='legend'>
                    <li>Published <span class='indicator green'></span></li>
                    <li>Draft<span class='indicator blue'></span></li>
                    <li>Deleted<span class='indicator red'></span></li>
                </ul>
                <div class="wrapper">
                    <?php
                    require_once __DIR__.'/app/controller/C_adminPanel.php';
                    $admPanCon = new AdminPanelController(3);
                    $admPanCon->generateTables();

                    ?>

                </div>
            </div>
        </div>


    </main>
    <div id='modal-create-post-id' class='modal hidden'>
        <div class='modal-content'>;
        <form id = 'create-post-form-id'>
            <input  name='post-title' type="text">
            <input type="submit" value = 'Create'>
        </form>
        <button id='cancel-id'> cancel</button>
        </div>
    </div>

    <footer>

    </footer>
</body>

</html>