<?php
class Model_Stats extends Model_Base{
	
	function __construct() {
        parent::__construct();
	}

    /**
     * Fetch stats for authorized user as per access permissions
     * @param datetime $start_date
     * @param datetime $end_date
     * @param string $campaigns (comma separated campaign-ids)
     * @return array of objects
     */
	public function getStats($start_date, $end_date, $campaigns = '') {
        $sql = "select * from stats where date_time between '{$start_date}' and '{$end_date}'";
        if(!empty($campaigns)) {
            $sql .= " and campaign_id in ($campaigns)";
        }
        //echo $sql;
        $res = mysql_query($sql, $this->db);
        $result = array();
        while($row = mysql_fetch_object($res)) {
            $result[] = $row;
        }
        return $result;
    }
}
?>
