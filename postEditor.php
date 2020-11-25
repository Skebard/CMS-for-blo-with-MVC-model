<?php
session_start();
require 'app/Utility/Session.php';

if(!Session::checkSession()){
    header('Location: adminLogin.php');
    exit;
}
require_once __DIR__.'/app/view/templates/adminHeader.php';
$id = $_GET['id'] ?? ' invalid';
//echo '<h1>Editor '.$id.'</h1>';
?>
<script defer type='module' src='client/controller/editor/editor.js'></script>
<link rel="stylesheet" href="client/css/postEditor.css">
<main class="max-width">
            <div class = "title-container">
                <small  class="title-tag">Title</small>
                <h3 id='title-id' contenteditable="true" class="title-content">Introduce your title</h3>
            </div>
            <div class = "title-container">
                <small  class="title-tag">Main Image</small>
                <h3 id='main-image-id' contenteditable="true" class="title-content">Introduce your main image</h3>
            </div>
            <div class="category-wrapper">
                <h3>Tags: </h3>
                <button class="btn-add-category" id="btn-add-tag-id">+</button>
                <ul class="category-tags" id='category-tags-id'>
                    <!-- <li>CSS</li>
                    <li>HTML</li> -->
                </ul>

            </div>
            <div  class='menu-wrapper'>
                <ul id='content-options-id' class="content-options">
                    <!-- <li>Subtitle</li>
                    <li>Text content</li>
                    <li>link</li>
                    <li>bold</li>
                    <li>cursive</li>
                    <li>Image</li>
                    <li>code</li> -->
                </ul>
                <div class="save-cancel-publish-wrapper">
                    <button id='btn-cancel-id' class='my-btn btn-cancel'>Cancel</button>
                    <button id='btn-save-id' class='my-btn btn-save'>Save</button>
                    <button id='btn-publish-id' class='my-btn btn-publish'>Publish</button>
                    <button id='btn-withdraw-id' class='my-btn btn-publish'>Withdraw</button>
                </div>
            </div>
            <div id="post-wrapper" class="post-wrapper">
                <!-- <div class="box">
                    <div class="box-header">
                        <span class="arrows"> 
                            <i class="fas fa-sort-up"></i>
                            <i class="fas  fa-sort-down"></i>
                        </span>
                        <span class="right-container">
                            <span class="content-type">subtitle</span>
                            <i class="fas fa-trash-alt"></i>
                        </span>

                    </div>
                    <div class="box-content" contenteditable="true">
                        Here there is going to be a great content

                    </div>

                </div> -->



            </div>
        </main>
        <div class="modal link-modal hidden" id="link-modal-id">

            <div class='modal-body'>
                <span class="close">X</span>
                <h3>Introduce your link</h3>
                <input type="text" placeholder="your link">
                <button class="btn-add-link">Add link</button>
            </div>
        </div>
        <footer>

        </footer>
    </body>
</html>