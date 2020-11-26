<?php
session_start();

require 'app/Utility/Session.php';

if(!Session::checkSession()){
    header('Location: adminLogin.php');
    exit;
}
require __DIR__ . '/app/view/templates/adminHeader.php';
?>

<script defer type="module" src="client/controller/adminPanel.js"></script>
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
                require_once __DIR__ . '/app/controller/C_adminPanel.php';
                $admPanCon = new AdminPanelController(intval($_SESSION['authorId']));
                $admPanCon->generateTables();

                ?>

            </div>
        </div>
    </div>


</main>
<div id='modal-create-post-id' class='modal hidden'>
    <div class='my-modal-content'>
        <h2>New post</h2>
        <form action="app/routes/postData.php" method="post" id='create-post-form-id'>
            <label>Title</label>
            <input placeholder='Your title' name='title' type="text">
            <label>Main Image</label>
            <input name='mainImage' type='text'>
            <label>Main Category</label>
            <select name='mainCategory'>
                <?php
                $admPanCon->generateCategoryOptions();
                ?>
            </select>
            <label>Description</label>
            <textarea name='description' type='text' rows='3'></textarea>
            <div class='form-btns'>
            <button id='cancel-id' class='btn-cancel'> cancel</button>
            <input  class='btn-create' type="submit" value='Create'>
            </div>
        </form>
    </div>
</div>

<footer>

</footer>
</body>

</html>