<?php





function externalResourceExists($url){
    $file_headers = @get_headers($url);
    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return false;
    }
    else {
        return true;
    }
}


/**
 *  Creates the absolute route to a resource
 * @param  $fullPath put  __DIR__
 * @param string $relativeResourcePath the relative path to the resource from the CURRENT FILE
 * @return string the absolute path to the resource
 */
function getResourceUrl($fullPath,$relativeResourcePath){
    $fullPath = str_replace('\\','/',$fullPath);
    $serverPath = $_SERVER['DOCUMENT_ROOT'];
    $protocol = 'http://';
    $route =$protocol . $_SERVER['HTTP_HOST'] . str_replace($serverPath,'',$fullPath);
    $route .= "/".$relativeResourcePath;
    return $route;
}