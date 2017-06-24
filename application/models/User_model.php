<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends BILLS_Model {
	
	/* --------------------------------------------------------------------------------
	 * Get login information based on the username.
	 * -------------------------------------------------------------------------------- */
	public function get_login($username){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('username',$username);
		$query=$this->db->get();
		
		return $query->row_array();
	}
	
	/* --------------------------------------------------------------------------------
	 * Get user information based on the User ID.
	 * -------------------------------------------------------------------------------- */
	public function get_user($user_id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get();
		
		return $query->row_array();
	}
	
	/* --------------------------------------------------------------------------------
	 * Create a new user.
	 * -------------------------------------------------------------------------------- */
	public function create(){
		//Prepare the data from the screen.
		$data=$this->prepare('users');
		
		//Encrypt the user's password.
		$this->load->library('Password');
		$data['password']=$this->password->encrypt($data['password']);
		
		//Insert the data into the database.
		$this->db->insert('users', $data);
			
		//Return the ID of the record that was inserted.
		return $this->db->insert_id();
	}
	
	/* --------------------------------------------------------------------------------
	 * Update an existing user.
	 * -------------------------------------------------------------------------------- */
	public function update(){
		//Prepare the data from the screen.
		$data=$this->prepare('users');
		
		//Define the user ID that will be updated.
		$user_id=$this->session->userdata('user_id');
		
		//These fields should never be updated.
		unset($data['user_id']);
		unset($data['username']);
		unset($data['password']);
		
		//Update the data in the database.
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}
	
	/* --------------------------------------------------------------------------------
	 * Change the password for an existing user.
	 * -------------------------------------------------------------------------------- */
	public function change_password(){
		//Prepare the data from the screen.
		$data=$this->prepare('users');
		
		//Encrypt the user's password.
		$this->load->library('Password');
		$data['password']=$this->password->encrypt($data['password']);
		
		//Define the user ID that will be updated.
		$user_id=$this->session->userdata('user_id');
		
		//These fields should never be updated.
		unset($data['user_id']);
		unset($data['username']);
		
		//Update the data in the database.
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}
	
}