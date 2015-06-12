<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function appxml_heads(){
	$string = read_file('./application/libraries/appxmls/heads.xml');
	return $string;
}

function appxml_get_version($str){
	$heads_str = appxml_heads();
	$xmlobj    = simplexml_load_string($heads_str);
	$xmlarr    = object_to_array($xmlobj);
	foreach($xmlarr as $head){
		 
		if($head["@attributes"]["type"] == $str){
			return $head["@attributes"]["version"];
		}
		 
		//        foreach($head as $item) {
		//            if($item["@attributes"]["type"] == $str){
		//                return $item["@attributes"]["version"];
		//            }
		//        }
	}
	return null;
}

function appxml_body($str,$ver=""){
	if($ver){
		$string = read_file('./application/libraries/appxmls/'.$str.'_v'.$ver.'.xml');
	}else{
		$string = read_file('./application/libraries/appxmls/'.$str.'.xml');
	}
	return $string;
}


function appxml_parse_items($xmlstr){
	$xmlobj  = simplexml_load_string($xmlstr);
	$new_arr = object_to_array($xmlobj);
	$items_hash = array();
	foreach($new_arr as $pages){
		foreach($pages as $page){
			foreach($page["item"] as $item){
				$items_hash[$item['@attributes']['id']] = array(
                    "name"=>$item['@attributes']['name'],
                    "type"=>$item['@attributes']['type']);
				if(in_array($item['@attributes']['type'],array("select","checkbox"))){
					$options = array();
					foreach($item['option'] as $option){
						if($option['@attributes']['value']){
							$options[$option['@attributes']['value']] =
							$option['@attributes']['name'];
						}
					}
					$items_hash[$item['@attributes']['id']]['options'] = $options;
				}
			}
		}
	}
	return $items_hash;
}

function appxml_newest_items($str){
	$ver  = appxml_get_version($str);
	$body = appxml_body($str,$ver);
	$items = appxml_parse_items($body);
	return $items;
}






