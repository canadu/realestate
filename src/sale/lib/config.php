<?php
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function getUrl($uri)
{   
    return  (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $uri;
}