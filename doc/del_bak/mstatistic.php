<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mstatistic extends Data_Model {

  public function __construct()
  {
      $this->load->database();
	  $this->load->dbforge();
      $this->table_name="mstatistics";
  }
  
  public function create_table()
  {
  	  if(!$this->db->table_exists($this->table_name)){
	  	  $fields = array('id'=>array('type'=>'int', 'constraint'=>'10', 'unsigned'=>true,'auto_increment'=>true),
	  	  				'station_id'=>array('type'=>'int', 'constraint'=>'10', 'unsigned'=>true,'default'=>0),
	  	  				'num'=>array('type'=>'int', 'constraint'=>'10', 'unsigned'=>true,'null'=>true),
	  	  				'create_time'=>array('type'=>'datetime','default'=>'0000-00-00 00:00:00'),
	  	  				'type'=>array('type'=>'tinyint', 'constraint'=>'1', 'unsigned'=>true,'null'=>true),
	  	  				'duration'=>array('type'=>'tinyint', 'constraint'=>'1', 'unsigned'=>true,'null'=>true)
	  	  				 );
		  $this->dbforge->add_field($fields);
		  $this->dbforge->add_key('id',true);
		  $this->dbforge->create_table($this->table_name,true);
  	  }
  }
  
  public function insert_counts($stations,$switchons,$energies,$start_time)
  {
	  foreach($stations as $station){
	  	
		$_counts = array('ESC_FAN_0_ON'=>0, 'ESC_COLDS_0_ON'=>0, 'ESC_COLDS_1_ON'=>0);
	    $_energies = array('energy_start'=>0, 'energy_end'=>0);
	  
	  	foreach($switchons as $switchon){
	  		if(($station['id']==$switchon['station_id'])&&($switchon['num']==1)){
	  			if($switchon['type']==ESC_FAN_0_ON){
	  				$_counts['ESC_FAN_0_ON']++;
	  			}
				if($switchon['type']==ESC_COLDS_0_ON){
	  				$_counts['ESC_COLDS_0_ON']++;
	  			}
				if($switchon['type']==ESC_COLDS_1_ON){
	  				$_counts['ESC_COLDS_1_ON']++;
	  			}
	  		}
	  	}
		foreach($energies as $energy){
			if($station['id']==$energy['station_id']){
				if(!$_energies['energy_start']){
					$_energies['energy_end']= $energy['num'];
				}
				$_energies['energy_start'] = $energy['num'];
			}
		}
		$_energy = intval($_energies['energy_end'])-intval($_energies['energy_start']);
		
		$args = array("station_id"=>$station['id'], "num"=>$_counts['ESC_FAN_0_ON'], "type"=>ESC_FAN_0_ON, 'create_time'=>$start_time, 'duration'=>1);
		$this->db->insert($this->table_name, $args);
		$args = array("station_id"=>$station['id'], "num"=>$_counts['ESC_COLDS_0_ON'], "type"=>ESC_COLDS_0_ON, 'create_time'=>$start_time, 'duration'=>1);
		$this->db->insert($this->table_name, $args);
		$args = array("station_id"=>$station['id'], "num"=>$_counts['ESC_COLDS_1_ON'], "type"=>ESC_COLDS_1_ON, 'create_time'=>$start_time, 'duration'=>1);
		$this->db->insert($this->table_name, $args);
		$args = array("station_id"=>$station['id'], "num"=>$_energy, "type"=>0, 'create_time'=>$start_time, 'duration'=>1);
		$this->db->insert($this->table_name, $args);	
	  }
  }
}

?>
