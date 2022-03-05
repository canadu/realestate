<?php
function escape($var)
{
    return isset($var) ? $var : '';
}
