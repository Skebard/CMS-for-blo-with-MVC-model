<?php
session_start();
require 'app/Utility/Session.php';

if(!Session::checkSession()){
    header('Location: adminLogin.php');
    exit;
}
$page = $_GET['page'] ?? null;
require __DIR__.'/app/view/templates/adminHeader.php';

?>

<main class="">
<!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="client/css/adminSettings.css"> -->

        <div class="container mt-5">
            <div class="col">
                <div class="row w-100 mr-0 ml-0 pb-5">
                    <!-- Account Sidebar-->
                    <div class="author-card w-100 pb-3">
                        <div class="author-card-cover" style="background-image: url(https://demo.createx.studio/createx-html/img/widgets/author/cover.jpg);"><a class="btn btn-style-1 btn-white btn-sm" href="#" data-toggle="tooltip" title="" data-original-title="You currently have 290 Reward points to spend"><i class="fas fa-bookmark text-md"></i>&nbsp;5 posts</a></div>
                        <div class="author-card-profile">
                            <div class="author-card-avatar"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Daniel Adams">
                            <div class='upload'> upload</div>    
                        </div>
                            <div class="author-card-details">
                                <h5 class="author-card-name text-lg">Daniel Adams</h5><span class="author-card-position">Joined February 06, 2017</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        <nav class="list-group list-group-flush">
                            <!-- <a class="list-group-item" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fe-icon-shopping-bag mr-1 text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">Orders List</div>
                            </div><span class="badge badge-secondary">6</span>
                        </div>
                    </a> -->
                    
                    

                            <a class="list-group-item <?php echo $page? '':'active' ?>" href="<?php echo $page? 'adminSettings.php':'#' ?>"><i class="fe-icon-user text-muted"></i><i class="fas fa-cog"></i>Profile Settings</a>
                            <a class="list-group-item <?php echo $page==='password'? 'active':'' ?>" href="<?php echo $page==='password'? '#':'adminSettings.php?page=password' ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-heart mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase"><i class="fas fa-shield-alt"></i>Password</div>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item disabled" href="#">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div><i class="fe-icon-tag mr-1 text-muted"></i>
                                        <div class="d-inline-block font-weight-medium text-uppercase"><i class="fas fa-ticket-alt"></i>My Tickets ('under development')</div>
                                    </div><span class="badge badge-secondary">4</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>
                <!-- Profile Settings-->
                <div class="row  mr-0 ml-0 w-100 ">
                    <form class="row w-100 mr-0 ml-0 pb-5">
                        <?php
                        if(!isset($page)){
                            require_once __DIR__.'/app/view/adminSettings/profileSettings.html';
                        }else if($page==='password'){
                            require_once __DIR__.'/app/view/adminSettings/password.html';
                        }else{
                            //! page not found
                            echo '<h1>page not found</h1>';
                        }
                        ?>


                        <div class="col-12 col-12">
                            <hr class="mt-2 mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <input class="btn btn-style-1 btn-primary" type="submit" data-toast="" data-toast-position="topRight" data-toast-type="success" data-toast-icon="fe-icon-check-circle" data-toast-title="Success!" data-toast-message="Your profile updated successfuly.">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
</body>

</html>