<?php
// This page has to display the post to the page visitors
require 'app/view/templates/header.php';
?>
<main>
    <div class="title-wrapper">
        <h1 class="page-title noselect">Blog</h1>
    </div>

    <div id="posts-overview-id" class="page-wrapper">
        <div class='search-wrapper max-width'>
            <input id='search-input-id' type='text' placeholder="Search">
            <i id='search-btn-id' class="fas fa-search"></i>
        </div>
        <ul class="categories-tags center max-width">
            <li>Javascript</li>
            <li>HTML</li>
            <li>CSS</li>
            <li>PHP</li>
            <li>MySql</li>
            <li>Random</li>
        </ul>


        <div id="posts-container-id" class="posts-container center max-width">
            <ul class="posts-page">


            </ul>

        </div>
        <div id='loading-spinner-id' class="loadingio-spinner-cube-d4ujiebb12h center">
            <div class="ldio-18ly8xy9adv">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="load-more center" id='load-more-btn-id'>
            <button class="center btn-load-more">load more </button>
            <i class="fas fa-angle-double-down"></i>
        </div>


    </div>
</main>



<?php
require 'app/view/templates/footer.php';
?>