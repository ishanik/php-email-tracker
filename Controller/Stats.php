<?php
class Controller_Stats {
	protected $usermodel;
    protected $model;
    protected $method;
    protected $input;
        
    /**
     * Constructor
     * Load required models
     * 
     * @param string $method
     * @param array $input
     */
	function __construct($method, $input) { 
		$this->model = new Model_Stats();
		$this->usermodel = new Model_User();
		$this->method = $method;
		$this->input = $input;
        
        $this->index();
	}

    /**
     * Fetch and return stats for the end-user according to the access permissions
     * for user types
     * 
     * @param json response
     */
	protected function index() {
        // Check if start/end date provided
        if(empty($this->input['start_date']) || empty($this->input['end_date'])) {
            echo json_encode(array('status' => 400, 'error' => 'Missing parameters'));
            return;
        }
        // Check if token provided
        if(isset($this->input['token']) && !empty($this->input['token'])) {
            // Validate token
            if($user = $this->usermodel->validateToken($this->input['token'])) {
                // check data access for user-type
                if($user->user_type == 'admin') {
                    $stats = $this->model->getStats($this->input['start_date'], $this->input['end_date']);
                } elseif($user->user_type == 'client' && !empty($user->campaigns)) {
                    $stats = $this->model->getStats($this->input['start_date'], $this->input['end_date'], $user->campaigns);
                }
                echo json_encode($stats);return;
            } else {
                echo json_encode(array('status' => 500, 'error' => 'Invalid token')); return;
            }
        } else {
            echo json_encode(array('status' => 400, 'error' => 'Missing token')); return;
        }
	}    
    
}
?>
