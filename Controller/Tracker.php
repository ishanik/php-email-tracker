<?php
class Controller_Tracker extends Controller_Base{	
	protected $tracker_settings, $method, $input;
    
    /**
     * Constructor
     * 
     * @param string $method
     * @param array $input
     */
    function __construct($method, $input) { 
		$this->method = $method;
		$this->input = $input;        
        $this->index();
	}

    /**
     * Track and register event information in event log
     * 
     * @param json response
     */
	protected function index() {
        // ensure correct method is used
        if(!$this->validateMethod('get')) {
			echo json_encode(array('status' => 400, 'error' => 'Incorrect method'));
            return;
        }
        // process client info
        $info = array(
            'date_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
            'campaign_id' => $_REQUEST['c'],
            'event' => $_REQUEST['e'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'lang' => $_SERVER['HTTP_ACCEPT_LANGUAGE']
        );

        $filepath = ROOT_DIR . DIR_SEPARATOR . 'event_logs' . DIR_SEPARATOR;
        $filepath .= 'event_log_'.date('Y-m-d-H-i-s').'.csv';

        file_put_contents($filepath, implode('^', $info).PHP_EOL , FILE_APPEND);
        
        // track open event
        // track and redirect click event
        if($info['event']=='open') {
            // display a transparent pixel
            header('Content-Type: image/gif');
            readfile('tracking.gif');
        } elseif($info['event']=='click' && !empty($_REQUEST['r'])) {
            // redirect to the click url
            header("Location: ".  urldecode($_REQUEST['r']));
            die();
        }
	}

    /**
     * Parse tracker config and set class variables with settings
     */
	protected function parseTrackerConfig() {
        $configFile = ROOT_DIR . DIR_SEPARATOR . 'ini' . DIR_SEPARATOR . 'tracker.ini';

        if (file_exists($configFile)) {
            $this->tracker_settings = parse_ini_file($configFile, true);
        } else {
            $this->tracker_settings['dir'] = 'event_logs';
        }
    }
    
    
}
?>
