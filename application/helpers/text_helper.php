<?php
/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 13/09/2016
 * Time: 09.42
 */

/**
 * @param int $length
 * @param string $keyspaces
 * @return string
 */
function random_string($length = 10, $keyspaces = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
	$characters = $keyspaces;
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
