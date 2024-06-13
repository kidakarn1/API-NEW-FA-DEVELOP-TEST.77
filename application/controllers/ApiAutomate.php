<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiAutomate extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ApiAutomate_model', 'automate');
    }

    public function index() {
        
    }

    public function getExplannerLineMaster() {
        echo json_encode($this->automate->getExplannerLineMaster());
    }
}