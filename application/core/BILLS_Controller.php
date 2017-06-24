<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BILLS_Controller extends CI_Controller {
	
	public $data;
	public $action;
	public $message;
	public $system, $system_page;
	
	public function __construct(){
		parent::__construct();
		
		//Set the system and the page the user is on.
		$this->system=strtolower($this->uri->segment(1));
		$this->system_page=strtolower($this->uri->segment(2));
		
		//If user is not on the login/register screen, check to see if they are logged in.
		if($this->system!='users' or ($this->system=='users' and $this->system_page=='account')){
			//If user id is not set, the user is not logged in so redirect to login screen.
			if(trim($this->session->userdata('user_id'))==''){
				redirect('users/login');
			}
		}
		
		
		//Determine the action of a form submission.
		$this->action=strtolower($this->input->post('action'));
	}
	
	/* --------------------------------------------------------------------------------
	 * Populate the screen with a result set.
	 * -------------------------------------------------------------------------------- */
	public function populate_screen($data){
		$populate=array();

		if(!empty($data) and is_array($data)){
			foreach($data as $key=>$val){
				//Set the data to be populated.
				$populate[$key]=$val;
			}
		}
		
		//Get the existing populate data if it exists so it can be merged with the new populate data.
		$existing=$this->session->userdata('bill_populate');
		if(trim($existing)!=''){
			//Populate data already exists.  Merge with the new populate data.
			$populate_json=json_encode(array_merge(json_decode($existing, true), $populate));
		}else{
			//Convert populate data to JSON.  There is NO existing populate data.
			$populate_json=json_encode($populate);
		}
		
		//Save populate data to session for use on page reloads.
		$this->session->set_userdata('bill_populate', $populate_json);
	}
	
	/* --------------------------------------------------------------------------------
	 * Set a message to be displayed on the screen.
	 * -------------------------------------------------------------------------------- */
	public function set_message($message, $class='danger'){
		$this->message[$class][]=$message;
		
		$this->session->set_userdata('bill_messages', $this->message);
	}
	
	public function get_validations(){
		$pass=true;
		$validations=json_decode($this->session->userdata('bill_validations'), true);
		
        if(!empty($validations)){
            foreach($validations as $type=>$validation){
                if(!empty($validation)){
                    foreach($validation as $fieldname=>$info){
                        if(trim($info['label'])!=""){
                            $field_name_format=$info['label'];
                        }else{
                            //Format the fieldname
                            $field_name_format=ucwords(str_replace('_', ' ', $fieldname));
                        }
                         
                        //Determine the type of validation, and validate accordingly.
                        switch($type){
                            //This field is required.  If the value is blank, set an error message.
                            case "required":
                                if(trim($info['value'])==''){
                                    $this->set_message($field_name_format.' is required.');
									$pass=false;
                                }
                                break;
                        }
                    }
                }
            }
        }
		
		return $pass;
	}
	
}