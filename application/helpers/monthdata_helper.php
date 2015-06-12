<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function h_monthdata_true_energy($monthdata){
    return $monthdata['true_energy']>0?$monthdata['true_energy']:$monthdata['main_energy'];
}

function h_monthdata_true_energy_color($monthdata){
    return $monthdata['true_energy']>0?
        "<font style='color:blue'>".h_round2($monthdata['true_energy'])."</font>":
        h_round2($monthdata['main_energy']);
}
