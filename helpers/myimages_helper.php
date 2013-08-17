<?php defined('BASEPATH') OR exit('No direct script access allowed');

function myimages_attributes($attributes)
{
    $pairs = array();

    foreach ($attributes as $key => $val)
    {
        $pairs[] = $key . '="' . $val . '"';
    }

    return implode(' ', $pairs);
}