<?php
class Model_Login extends Model_Base{
	
	function __construct() {
        parent::__construct();
	}

    /**
     * Check if user exists and is valid
     * 
     * @param string $username
     * @param string $password
     * @return boolean
     */
	public function isValidUser($username, $password) {
        $password = md5($password);
		$sql = "select * from users where username = '{$username}' and password = '{$password}'";
        $res = mysql_query($sql, $this->db);
        $row = mysql_fetch_object($res);
        if (!empty($row)) {
            return $row;
        }
        return false;
	}
    
    /**
     * Generate a cryptographic token for the logged in user
     * 
     * @param int $user_id
     * @return string
     */
    public function getToken($user_id) {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
		$sql = "update users set token = '{$token}' where id = {$user_id}";
        $res = mysql_query($sql, $this->db) or die(mysql_error());
        return $token;
	}
}
?>
