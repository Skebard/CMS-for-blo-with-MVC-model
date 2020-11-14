<?php
require_once '../controller/C_blog.php';
//This endpoint provides the required data to show the main blog page

//1-Return all Categories that have at least 1 published post
//2-Return published posts by category, offset and limit (pagination) all this parameters should be optional


//** Security measures
//it would not be necessary since it is for public data but might be useful
/**
 *  1-Make sure the right method is used (GET) Done
 *  2-Give a maximum of 20 request per minute. if exceeded then block the ip address for 1 hour
 *  3-Make sure the request comes from a legitimate site (token, something)
 */

$response = new stdClass;
if($_SERVER['REQUEST_METHOD']!=='GET'){
    echo 'Access denied';
}else{
    //send published categories
    if(isset($_GET['categories'])){

    }
}
