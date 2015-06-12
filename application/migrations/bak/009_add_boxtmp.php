<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_boxtmp extends CI_Migration {

    public function up()
    {
        $this->db->insert('users', array("id"=>1,"username"=>"admin","password"=>'$2a$08$bWCcu38Z2JSYZg5MQ9f7xuqr4ogV/.ISIaRI61voDKt3664C9WF86',"activated"=>'1'));
    }

    public function down()
    {
    }
}

?>
