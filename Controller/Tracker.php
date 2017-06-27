<?php
class Controller_Tracker {	
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
        $info = array(
            'date_time' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
            'campaign_id' => $_REQUEST['c'],
            'event' => $_REQUEST['e'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'lang' => $_SERVER['HTTP_ACCEPT_LANGUAGE']
        );

        $filepath = ROOT_DIR . DIR_SEPARATOR . 'event_logs' . DIR_SEPARATOR;

        $myfile = file_put_contents($filepath, implode('^', $info).PHP_EOL , FILE_APPEND);
        
        // display a transparent pixel
        header('Content-Type: image/gif');
        readfile('tracking.gif');
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
