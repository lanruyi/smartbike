<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Move_correct_base extends CI_Migration {

    public function up()
    {
        $this->db->query("
ALTER TABLE  `corrects` ADD  `base` DECIMAL( 10, 2 )  default null AFTER  `type` ,
ADD  `correct_base` DECIMAL( 10, 2 ) default null  AFTER  `base` ,
ADD  `slope` DECIMAL( 6, 5 )  default null  AFTER `correct_base`
            ");
        $this->db->query("alter table stations drop column new_rom_id");
        $this->db->query("alter table stations drop column current_part_id");
        $this->db->query("alter table stations drop column rom_version");
        $this->db->query("alter table stations drop column ac_revise_base");
        $this->db->query("alter table stations drop column ac_revise");
        $this->db->query("alter table stations drop column main_energy_base");
        $this->db->query("alter table stations drop column main_energy_correct_base");
        $this->db->query("alter table stations drop column main_energy_slope");
    }

    public function down()
    {
    }

}
