<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AutoTransfer extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('AutoTransfer_model', 'transfer');
    }

    public function index() {
        $line_cd = $this->input->get('line_cd');
        $result = $this->transfer->transferProduction($line_cd);
        echo json_encode($result);
    }

    public function getLot() {
        echo json_encode($this->transfer->getProductionLot(date('Y-m-d H:i:s')));

    }
}