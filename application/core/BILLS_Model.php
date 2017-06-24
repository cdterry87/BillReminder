<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BILLS_Model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
	}
	
	/* --------------------------------------------------------------------------------
	 * Prepare $_POST data to be inserted into a database table.
	 * -------------------------------------------------------------------------------- */
	public function prepare($table){
		$prepared='';
		
		//Set post data.
		$data=$this->input->post();
		
		if(!empty($data) and is_array($data)){
			//Get a list of database fields from the specified table.
			$db_fields=$this->db->list_fields($table);
			
			//Compare prefixed field names to the database field names, and if the fields are in the database, add them to the prepared array.
			//The end result should leave out anything that was on the screen but isn't in the database so there won't be any SQL errors.
			foreach ($data as $key=>$val){
				if(in_array($key,$db_fields)){
					$prepared[$key] = $val;
				}
			}
			
			//Return the prepared array.
			return $prepared;
		}
		return false;
	}
	
}