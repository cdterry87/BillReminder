<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class Validate extends CI_Controller {
 
    /* --------------------------------------------------------------------------------
     * Process the validations and return any fields that failed validation as JSON.
     * -------------------------------------------------------------------------------- */
    public function index(){
        $this->session->set_userdata('bill_validations', $this->input->post('validations'));
    }
    
}
