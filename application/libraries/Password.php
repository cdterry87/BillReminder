<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Password {
	
	/* --------------------------------------------------------------------------------
	 * Encrypt a password using BCRYPT.  Encrypted passwords will always be 60 chars.
	 * -------------------------------------------------------------------------------- */
	public function encrypt($password){
		return password_hash($password, PASSWORD_BCRYPT);
	}
	
}