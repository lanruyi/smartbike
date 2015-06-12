<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Excel/PHPExcel.php';
require_once 'Excel/PHPExcel/IOFactory.php';

class Excel extends PHPExcel {

    public $writer;
    function __construct() {
        parent::__construct();
        $this->writer = IOFactory::createWriter($this, 'Excel5');
    }

    function export_excel($sFileName, $charset = 'utf-8') {
        $sFileName = iconv($charset, 'gb2312', $sFileName);
        header("Content-Type: application/vnd.ms-excel; charset=Excel5");
        header("Content-Disposition: attachment;filename=$sFileName");
        header('Cache-Control: max-age=0');
        $this->writer->save('php://output');
    }

}

?>
