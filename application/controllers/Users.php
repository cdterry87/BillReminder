<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends BILLS_Controller {
	
	public function __construct(){
		parent::__construct();
		
		//Determine the action of a form submission.
		$this->action=strtolower($this->input->post('action'));
		
		$this->load->model('User_model');
	}
	
	/* --------------------------------------------------------------------------------
	 * A users index page does not exist so redirect to the main page.
	 * NOTE: This will force the user to login if they are not already logged in.
	 * -------------------------------------------------------------------------------- */
	public function index(){
		redirect('bills');
	}
	
	/* --------------------------------------------------------------------------------
	 * Load the user registration page.
	 * -------------------------------------------------------------------------------- */
	public function register(){
		$this->data['page']='users/register';
		$this->data['header']='REGISTER';
		
		$this->load->view('users/template', $this->data);
	}
	
	/* --------------------------------------------------------------------------------
	 * Load the Analytics page.
	 * -------------------------------------------------------------------------------- */
	public function analytics(){
		$this->data['page']='users/analytics';
		$this->data['header']='ANALYTICS';
		
		$this->load->model('Bill_model');
		$this->data['bills']=$this->Bill_model->get_bills();
		
		$this->load->view('template', $this->data);
	}
	
	/* --------------------------------------------------------------------------------
	 * Load the user login page.
	 * NOTE: If a user is already logged in, redirect to the main page.
	 * -------------------------------------------------------------------------------- */
	public function login(){
		//Verify if user is already logged in.
		if($this->logged_in()){
			redirect('bills');
		}
		
		//A user is not logged in, so load the user login page.
		$this->data['page']='users/login';
		$this->data['header']='MyBILLS';
		
		$this->load->view('users/template', $this->data);
	}
	
	/* --------------------------------------------------------------------------------
	 * Verify if a user is already logged in by whether their USER ID is set.
	 * -------------------------------------------------------------------------------- */
	public function logged_in(){
		if(trim($this->session->userdata('user_id'))!=''){
			return true;
		}
		return false;
	}
	
	/* --------------------------------------------------------------------------------
	 * Authenticate a user upon login attempt.
	 * -------------------------------------------------------------------------------- */
	public function authenticate(){
		if(!empty($user=$this->User_model->get_login($this->input->post('username')))){
			if(password_verify($this->input->post('password'), $user['password'])){
				//This user exists and their passwords match so set their session so they can login.
				$this->set_sessions($user);
			}
		}
		
		//If session information is empty or user_id is blank, set an error message because the user was not logged in.
		if(!$this->logged_in()){
			$this->set_message('Invalid username/password.');
			//redirect('users/login');
			$this->login();
			echo "not logged in";
		}
		
		redirect('bills');
	}
	
	/* --------------------------------------------------------------------------------
	 * When a user signs in or updates their information, set/reset user session.
	 * -------------------------------------------------------------------------------- */
	public function set_sessions($user){
		//Set new sessions based on the user information provided.
		if(!empty($user)){
			$session=array(
				'user_id'		=> $user['user_id'],
				'username'		=> $user['username'],
				'email'			=> $user['email'],
				'firstname'		=> $user['firstname'],
				'lastname'		=> $user['lastname'],
				'income'		=> $user['income'],
			);
			
			$this->session->set_userdata($session);
		}
	}
	
	/* --------------------------------------------------------------------------------
	 * Load the user account page.
	 * NOTE: Access to this page requires user to be logged in.
	 * -------------------------------------------------------------------------------- */
	public function account(){
		$this->data['page']='users/account';
		
		//Get the user's information.
		if(!empty($result=$this->User_model->get_user($this->session->userdata('user_id')))){
			$this->populate_screen($result);
		}
		
		$this->load->view('template', $this->data);
	}
	
	public function password(){
		$this->data['page']='users/change_password';
		
		$this->load->view('template', $this->data);
	}
	
	/* --------------------------------------------------------------------------------
	 * Destroy user session and redirect to the login page.
	 * -------------------------------------------------------------------------------- */
	public function logout(){
		$this->session->sess_destroy();
		redirect('users/login');
	}
	
	public function validate(){
		//Get form validations.
		$pass=$this->get_validations();
		
		//Form specific validations.
		switch($this->action){
			case "create account":
				if(!empty($user=$this->User_model->get_login($username))){
					$this->set_message('This username already exists!');
					$pass=false;
				}
				
				if($this->input->post('password')!=$this->input->post('password_confirm')){
					$this->set_message('Passwords must match!');
					$pass=false;
				}
				break;
			case "change password":
				if($this->input->post('password')!=$this->input->post('password_confirm')){
					$this->set_message('Passwords must match!');
					$pass=false;
				}
				break;
		}
		
		return $pass;
	}
	
	/* --------------------------------------------------------------------------------
	 * Determine the action of a form submission.
	 * -------------------------------------------------------------------------------- */
	public function action(){
		switch($this->action){
			case "create account":
				if($this->validate()){
					$this->User_model->create();
					$this->set_message('Your account was created successfully! You may now login!', 'success');
					redirect('users/login');
				}
				
				//The validation failed so reload the page with all of the existing post data.
				$this->populate_screen($this->input->post());
				
				//Reload the page.
				redirect('users/register');
				break;
			case "update information":
				if($this->validate()){
					$this->User_model->update();
					
					//Reset user sessions.
					if(!empty($user=$this->User_model->get_user($this->session->userdata('user_id')))){
						$this->set_sessions($user);
					}
					
					$this->set_message('Your account information was updated successfully!', 'success');
				}
				
				//Reload the page.
				redirect('users/account');
				break;
			case "change password":
				if($this->validate()){
					$this->User_model->change_password();
					$this->set_message('Your password has been changed successfully!', 'success');
				}
				
				//Reload the page.
				redirect('users/password');
				break;
		}
	}
	
}
