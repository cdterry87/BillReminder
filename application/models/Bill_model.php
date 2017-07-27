<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_model extends BILLS_Model {
	
	/* --------------------------------------------------------------------------------
	 * Get all bills for a user.
	 * -------------------------------------------------------------------------------- */
	public function get_bills(){
		$this->db->select('*');
		$this->db->from('bills');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->order_by('day,name');
		$query=$this->db->get();
		
		return $query->result_array();
	}
	
	/* --------------------------------------------------------------------------------
	 * Get bill information based on the Bill ID.
	 * -------------------------------------------------------------------------------- */
	public function get_bill($bill_id){
		$this->db->select('*');
		$this->db->from('bills');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->where('bill_id',$bill_id);
		$query=$this->db->get();
		
		return $query->row_array();
	}
	
	/* --------------------------------------------------------------------------------
	 * Get all bills for a user that are due today.
	 * -------------------------------------------------------------------------------- */
	public function due_today(){
		$this->db->select('name, amount');
		$this->db->from('bills');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		
		//This statement will only check to see if the bill is due today without taking the month into consideration (deprecated).
		//$this->db->where('day', date('d'));
		
		//If month='Y', check to see if this month is a/the month this bill is due, as well as the day.
		$month_field='month'.date('n');
		$this->db->where("(IF(month='Y', day='' and ".$month_field."='CHECKED', day='".date('d')."'))");
		
		$this->db->order_by('day,name');
		$query=$this->db->get();
		
		return $query->result_array();
	}
	
	/* --------------------------------------------------------------------------------
	 * Get all bills for a user that will be due in the next 5 days.
	 * -------------------------------------------------------------------------------- */
	public function due_soon(){
		$this->db->select('name, amount, day');
		$this->db->from('bills');
		
		//Get only records that have a day filled out for this user.
		$this->db->group_start();
		$this->db->where('user_id', $this->session->userdata('user_id'));
		
		//This statement will only check to see if the day is not filled out without taking the month into consideration (deprecated).
		//$this->db->where("day != ''");
		
		//Check to see if the bill will be due this month.
		$month_field='month'.date('n');
		$this->db->where("(IF(month='Y', ".$month_field."='CHECKED' and day!='', day!=''))");
		
		$this->db->group_end();
		
		//Get the records that will be due in the next 5 days.
		$this->db->group_start();
		$today=new DateTime("now");
		for($i=1;$i<=5;$i++){
			$today->modify("+1 day");
			$day=$today->format('d');
			
			if($i==1){
				$this->db->where('day', $day);
			}else{
				$this->db->or_where('day', $day);
			}
		}
		$this->db->group_end();
		
		$this->db->order_by('day,name');
		$query=$this->db->get();
		
		return $query->result_array();
	}
	
	
	/* --------------------------------------------------------------------------------
	 * Create a new bill.
	 * -------------------------------------------------------------------------------- */
	public function create(){
		//Prepare the data from the screen.
		$data=$this->prepare('bills');
		
		//Set the user id for this bill.
		$data['user_id']=$this->session->userdata('user_id');
		
		//unset($data['bill_id']);
		
		//Insert the data into the database.
		$this->db->insert('bills', $data);
			
		//Return the ID of the record that was inserted.
		return $this->db->insert_id();
	}
	
	/* --------------------------------------------------------------------------------
	 * Update an existing bill.
	 * -------------------------------------------------------------------------------- */
	public function update($bill_id){
		//Prepare the data from the screen.
		$data=$this->prepare('bills');
		
		unset($data['user_id']);
		unset($data['bill_id']);
		
		//Update the data in the database.
		$this->db->where('bill_id', $bill_id);
		$this->db->update('bills', $data);
	}
	
	/* --------------------------------------------------------------------------------
	 * Delete a bill.
	 * -------------------------------------------------------------------------------- */
	public function delete($bill_id){
		$this->db->where('bill_id', $bill_id);
		$this->db->delete('bills');
	}
	
}