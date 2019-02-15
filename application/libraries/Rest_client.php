<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 13/01/2019
 * Time: 14:26
 */

define('POST', 'POST');
define('GET', 'GET');

/**
 * Class Rest_client
 */
class Rest_client
{
    private $_base_url;
    private $_url = '';
    private $_headers = array();
    private $_post_fields = array();
    private $_method = GET;
    private $_username = '';
    private $_password = '';
    private $_apikey = '';

    /**
     * Rest_client constructor.
     * @param string $base_url
     * @param string $username
     * @param string $password
     * @param string $apikey
     */
    public function __construct($base_url = '', $username = '', $password = '', $apikey = '')
    {
        $this->_base_url = $base_url;
        $this->_username = $username;
        $this->_password = $password;
        $this->_apikey = $apikey;
    }

    /**
     * @param string $base_url
     * @return $this
     */
    public function set_base_url($base_url)
    {
        $this->_base_url = $base_url;
        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function set_username($username)
    {
        $this->_username = $username;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function set_password($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * @param string $apikey
     * @return $this
     */
    public function set_apikey($apikey)
    {
        $this->_apikey = $apikey;
        return $this;
    }

    /**
     * @return string
     * Generate basic auth string header
     */
    private function _gen_auth()
    {
        return "Basic " . base64_encode(utf8_encode("$this->_username:$this->_password"));
    }

    /**
     * @return Response
     * Execute curl based on user request
     */
    private function _exec_url()
    {
        $url = $this->_base_url . $this->_url;
        $fields = /*http_build_query($this->_post_fields);*/ /*json_encode($this->_post_fields)*/ $this->_post_fields;
        $headers = array(
//            'Content-Type: application/json'
        );
        (!empty($this->_username) && !empty($this->_password)) && $headers[] = 'Authorization: ' . $this->_gen_auth();
        !empty($this->_apikey) && $headers[] = 'x-api-key: ' . $this->_apikey;
        $headers = array_merge($headers, $this->_headers);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($this->_method == POST) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        $result = curl_exec($ch);
//        var_dump(curl_getinfo($ch));
        curl_close($ch);
        return new Response($result);
    }

    /**
     * @param string $url
     * @param array $headers
     * @param array $fields post fields
     * @return Response
     * Executing post request
     */
    public function post($url, $headers = array(), $fields = array())
    {
        $this->_method = POST;
        $this->_url = $url;
        $this->_headers = $headers;
        $this->_post_fields = $fields;
        return $this->_exec_url();
    }

    /**
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return Response
     * Executing get request
     */
    public function get($url, $headers = array(), $params = array())
    {
        $this->_method = GET;
//        $par = [];
//        foreach ($params as $k => $v) {
//            $par[] = "$k=$v";
//        }
//        $par = implode('&', $par);
        $par = http_build_query($params);
        $this->_url = $url . "?$par";
        $this->_headers = $headers;
        return $this->_exec_url();
    }
}

/**
 * Class Response
 * Response yang dihasilkan dari cURL
 */
class Response
{
    private $_header;
    private $_body;
    private $_raw_body;

    /**
     * Response constructor.
     * @param $result string curl result
     */
    public function __construct($result)
    {
        list($rawHeader, $response) = array_pad(explode("\r\n\r\n", $result, 2),2,'');
        $this->_header['raw'] = $rawHeader;
        $this->_header['code'] = intval(substr($rawHeader, 9, 3));
        $this->_header['status'] = substr($rawHeader, 13, strpos($rawHeader, 'Date') - 14 - 1);
        $this->_header['version'] = substr($rawHeader, 0, 8);
        $this->_body = json_decode($response);
        $this->_raw_body = $response;
    }

    /**
     * @return mixed
     */
    public function body()
    {
        return $this->_body;
    }

    /**
     * @return string
     */
    public function raw_body()
    {
        return $this->_raw_body;
    }

    /**
     * @return mixed
     */
    public function header()
    {
        return $this->_header;
    }
}