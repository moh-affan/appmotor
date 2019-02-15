<?php
/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 13/09/2016
 * Time: 09.42
 */

function extract_text($text) {
    $text = preg_replace ( "/(\<(\/?.*?[^\>])\>)/", " ", $text );
    return trim($text);
}