<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qrcode {
    private $qrcode;
    public function __construct()
    {
        $this->qrcode = new \Endroid\QrCode\QrCode();
    }

    public function generate($str){
        $this->qrcode->setText($str)->setSize(200);
        $this->qrcode->setLogoPath(FCPATH."images/sumenepg.png")->setLogoWidth(40);
        return $this->qrcode->writeDataUri();
    }
}