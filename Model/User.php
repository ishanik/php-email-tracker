<?php
class Model_User extends Model_Base{
	
	function __construct() {
        parent::__construct();
	}

    /**
     * Validate the token provided in request
     * 
     * @param string $token
     * @return boolean
     */
	public function validateToken($token) {
        $sql = "select u.user_type, group_concat(c.campaign_id) as campaigns from users u left join clients c on u.id = c.user_id where u.token = '{$token}'";
        $res = mysql_query($sql, $this->db);
        $row = mysql_fetch_object($res);
        if (!empty($row)) {
            return $row;
        }
        return false;
	}
    
    /**
     * Generate and set token for user for future API auth
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
