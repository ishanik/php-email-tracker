<?php
class Controller_Login {
	
	/**
     * Constructor
     * Load model and call index
     * @param string $method
     * @param array $input
     */
	function __construct($method, $input) { 
		$this->model = new Model_Login();
		$this->method = $method;
		$this->input = $input;
        
        $this->index();
	}

    /**
     * Validate input and generate API token
     * 
     * @param json response
     */
	protected function index() {
		if($this->checkInput()) {
			if($user = $this->model->isValidUser($this->input['username'], $this->input['password'])) {
                $token = $this->model->getToken($user->id);
                echo json_encode(array('status' => 0, 'token' => $token));
            } else {
                echo json_encode(array('status' => 400, 'error' => 'Invalid credentials'));
            }
		} else {
			echo json_encode(array('status' => 400, 'error' => 'Missing parameters'));
		}
	}

    /**
     * Check if required inputs are provided
     * @return boolean
     */
	protected function checkInput() {
		if(empty($this->input['username']) || empty($this->input['password'])) {
			return false;
		}
		return true;
	}
    
    
}
?>
