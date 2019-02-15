<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . "libraries/Rest_client.php");

class Test extends CI_Controller
{
    public function index()
    {
        $rest_client = new Rest_client('http://myworks.me/ci/api', 'admin', '1234', 'AiZa');
        $r = $rest_client->post('',array(),['anakku'=>'Akmal','istriku'=>'Ika Nurwalidah']);
        var_dump($r->body());
    }
}
