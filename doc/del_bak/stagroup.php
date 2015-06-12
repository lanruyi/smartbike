
class Stagroup extends ES_Model {

  public function __construct()
  {
    $this->load->database();
    $this->table_name = "stagroups";
    $this->entities_str="Entities\Stagroup";
  }


}
?>
