<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . "libraries/REST_Controller.php");
require_once(APPPATH . "libraries/Format.php");
require_once(APPPATH . "libraries/Rest_client.php");

class Api extends \Restserver\Libraries\REST_Controller
{

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
    }

    public function index_get()
    {
        $this->response(['message' => 'get']);
    }

    public function index_post()
    {
        $this->response(array_merge(['message' => 'postal'], $_POST));
    }
}
