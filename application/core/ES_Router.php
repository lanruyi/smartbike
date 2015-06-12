<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ES_Router extends CI_Router {
    var $suffix;
    function __construct() {
        parent::__construct();
        $this->suffix = '_controller';
    }
    function set_class($class) {
        $this->class = $class . $this->suffix;
    }
    function controller_name() {
        if (strstr($this->class, $this->suffix)) {
            return str_replace($this->suffix, '', $this->class);
        }else {
            return $this->class;
        }
    }
}
