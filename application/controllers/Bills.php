<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bills extends BILLS_Controller {
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Bill_model');
	}
	
	public function index(){
		$this->data['page']='bills/bills';
		
		//Get all bills for this user.
		$this->data['bills']=$this->Bill_model->get_bills();
		
		//Get all bills that are due today for this user.
		$due_today=$this->Bill_model->due_today();
		if(!empty($due_today)){
			foreach($due_today as $row){
				$this->set_message('Your <strong>'.$row['name'].'</strong> bill of <strong class="currency">'.$row['amount'].'</strong> is due <strong>today</strong>!');
			}
		}
		
		//Get a list of bills that will be due in the next 5 days.
		$due_soon=$this->Bill_model->due_soon();
		if(!empty($due_soon)){
			foreach($due_soon as $row){
				$this->set_message('Your <strong>'.$row['name'].'</strong> bill of <strong class="currency">'.$row['amount'].'</strong> is due on <strong>'.date('m').'/'.$row['day'].'</strong>!', 'warning');
			}
		}
		
		$this->load->view('template', $this->data);
	}
	
	public function all(){
		$this->data['page']='bills/all';
		
		//Get all bills for this user.
		$this->data['bills']=$this->Bill_model->get_bills();
		
		$this->load->view('template', $this->data);
	}
	
	public function create(){
		$this->data['page']='bills/form';
		
		$this->data['form_header']='Create Bill';
		$this->data['form_button']='Create Bill';
		
		$this->load->view('template', $this->data);
	}
	
	public function view($id){
		$this->data['page']='bills/form';
		
		$this->data['form_header']='View/Edit Bill';
		$this->data['form_button']='Update Bill';
		
		//Get record in order to populate the screen.
		if(!empty($result=$this->Bill_model->get_bill($id))){
			$this->populate_screen($result);
		}
		
		$this->load->view('template', $this->data);
	}
	
	public function validate(){
		//Get form validations.
		$pass=$this->get_validations();
		
		return $pass;
	}
	
	public function action(){
		$bill_id=$this->input->post('bill_id');
		
		switch($this->action){
			case "create bill":
				if($this->validate()){
					$this->Bill_model->create();
					$this->set_message('Your bill was created successfully!', 'success');
					redirect('bills');
				}
				
				//The validation failed so reload the page with all of the existing post data.
				$this->populate_screen($this->input->post());
				
				//Reload the page.
				redirect('bills/create');
				break;
			case "update bill":
				if($this->validate()){
					$this->Bill_model->update($bill_id);
					$this->set_message('Your bill was updated successfully!', 'success');
					redirect('bills/view/'.$bill_id);
				}
				break;
			case "delete bill":
				$this->Bill_model->delete($bill_id);
				$this->set_message('Bill deleted successfully');
				redirect('bills');
				break;
		}
	}
	
}
