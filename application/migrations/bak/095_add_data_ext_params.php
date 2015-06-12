<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_data_ext_params extends CI_Migration {

    public function up()
    {
        $this->db->query("
 CREATE TABLE `data_exts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) NOT NULL,
  `true_out_tmp`    decimal(3,1)	DEFAULT NULL, 
  `box_tmp_1`    decimal(3,1)	DEFAULT NULL,
  `box_tmp_2`    decimal(3,1)	DEFAULT NULL,
    PRIMARY KEY (`id`)
  )DEFAULT CHARSET=utf8;
            ");

        //$fields = array("`true_out_tmp`    decimal(3,1)	DEFAULT NULL",
                        //"`box_tmp_1`    decimal(3,1)	DEFAULT NULL",
                        //"`box_tmp_2`    decimal(3,1)	DEFAULT NULL");
        //$this->dbforge->add_column('datas', $fields);
    }

    public function down()
    {
        //$this->dbforge->drop_column('datas', 'arg');
    }

}
