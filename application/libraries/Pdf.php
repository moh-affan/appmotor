<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    /**
     * PDF filename
     * @var String
     */
    public $filename;

    public function __construct()
    {
        parent::__construct();
        $this->filename = "laporan.pdf";
    }

    /**
     * Load a CodeIgniter view into domPDF
     *
     * @access    public
     * @param    string $view The view to load
     * @param    array $data The view data
     * @return    void
     */
    public function load_view($view, $data = array())
    {
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->loadHtml($html);
        // Render the PDF
        $this->render();
        // Output the generated PDF to Browser
        $this->stream($this->filename, array("Attachment" => false));
    }

    /**
     * Get an instance of CodeIgniter
     *
     * @access    protected
     * @return    CI_Controller
     */
    protected function ci()
    {
        return get_instance();
    }

    public function generate($view, $data, $filename = '', $stream = TRUE, $paper = 'LEGAL', $orientation = "landscape")
    {
        $html = $this->ci()->load->view($view, $data, TRUE);
        $option = new \Dompdf\Options();
        $option->setIsRemoteEnabled(true);
        $option->setDebugCss(true);
        $option->setIsHtml5ParserEnabled(true);
        $this->setOptions($option);
        $this->loadHtml($html);
        $this->setPaper($paper, $orientation);
        $this->render();
        if ($stream) {
            $this->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            return $this->output();
        }
    }
}
