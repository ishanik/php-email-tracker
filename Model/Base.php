<?php
class Model_Base {
    protected $db_settings;
    protected $db;

    /**
     * Constructor
     * Call parser for DB config and make DB connection
     */
    public function __construct() {
        $this->parseDBConfig();
        $this->db = $this->connectLocalDB();
    }

    /**
     * Make DB connection using class variables
     * @return sql object
     * @throws Exception
     */
    protected function connectLocalDB() {
        try {
            $db = mysql_connect(
                    $this->db_settings['host'], $this->db_settings['user'], $this->global_settings['password']
            );
            mysql_select_db($this->db_settings['database']);
            return $db;
        } catch (Exception $e) {
            throw new Exception('Error connecting to DB: '.$e->getMessage());
        }
    }
    
    /**
     * Parse DB config file and load the class variable with settings
     * @throws Exception
     */
    protected function parseDBConfig() {
        $configFile = ROOT_DIR . DIR_SEPARATOR . 'ini' . DIR_SEPARATOR . 'db.ini';

        if (file_exists($configFile)) {
            $this->db_settings = parse_ini_file($configFile, true);
        } else {            
            throw new Exception('Global config file '.$configFile.' does not exist');
        }
    }
    
    public function __destruct() {
        mysql_close($this->db);
    }
}
?>
