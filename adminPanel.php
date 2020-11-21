<?php
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
                $admPanCon = new AdminPanelController(1);
                $admPanCon->generateTables();

                ?>

            </div>
        </div>
    </div>


</main>
<div id='modal-create-post-id' class='modal hidden'>
    <div class='modal-content'>;
        <form id='create-post-form-id'>
            <input name='post-title' type="text">
            <input type="submit" value='Create'>
        </form>
        <button id='cancel-id'> cancel</button>
    </div>
</div>

<footer>

</footer>
</body>

</html>