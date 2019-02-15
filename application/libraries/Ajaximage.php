<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajaximage {

	public function __construct()
	{

	}

	public function saveToFile($str_image,$file_name, $file_path){
        if (preg_match('/^data:image\/(\w+);base64,/', $str_image, $type)) {
            $str_image = substr($str_image, strpos($str_image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new Exception('invalid image type');
            }

            $str_image = base64_decode($str_image);

            if ($str_image === false) {
                throw new Exception('base64_decode failed');
            }
        } else {
            throw new Exception('did not match data URI with image data');
        }

        if(!file_put_contents("$file_path/$file_name.$type", $str_image))
            throw new Exception("Failure when saving file");
        return "$file_name.$type";
    }

}
