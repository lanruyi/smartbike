<script>
$(function(){ $('.pairs select[value!=0]').css({'background-color':'green','color':'white'}); })
$(function(){ $('.pairs select[value=="erro"]').css({'background-color':'red','color':'white'}); })
</script>
<style type="text/css">
   .content_frame{display: block}
   .city_label{padding: 15px 0 17px 25px; font-size: 1.5em;font-weight:bold; background-color: #DCDCDC;}
   .content_block{float:left;}
   .pairs{float:left; width:450px; padding:5px 25px} 
   .pairs ul{float:left;width:440px} 
   .pairs>ul>li{float:left;width:210px;height:30px;line-height:30px} 
   .load_level{font-size: 1.1em; width: 475px;padding:5px 0 5px 25px;background-color: #EFEFEF}
   #submit{float:left;width: 980px;padding: 5px 10px;text-align: right;background-color: #DCDCDC;border-style: solid;border-width:1px 0 0 0;border-color: #4F79A9}
   .sub_sub_menu{height: 20px;background-color:#4F79A9;padding-left: 20px}
   .sub_sub_menu li{float:left;line-height: 20px;margin:0 0 0 5px;padding:0 10px; background-color:#4F79A9}
   .sub_sub_menu a{height:20px; color:#fff }
</style>

<div class="base_center">
    <form id="filter" action="" method="get"> 
      <div class="filter">

          项目:<?= h_station_relative_select_sql('project_id', $projects, $conditions['project_id'], null,150) ?>
          城市:<span id="city_select"><?= h_station_relative_select_sql('city_id', $cities, $conditions['city_id'], "") ?></span>
          
          建筑类型：<?= h_station_building_select($conditions['building_type'],null,100)?>
          日期:<input class="es_day" name='datetime' type="text"  style="width:68px;height:16px" 
	        value=<?= $conditions['datetime']?> />
      </div>
      <div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
     </div>    
   </form>
  
    <form id="content" action="" method="post">
        <input type="hidden" name="project_id" value="<?= $conditions['project_id']?>">
        <input type="hidden" name="city_id" value="<?= $conditions['city_id']?>">
        <input type="hidden" name="datetime" value="<?= $conditions['datetime']?>">
        <input type="hidden" name="building_type" value="<?= $conditions['building_type']?>">
        <input type="hidden" name="pair_num" value="<?= $pair_num?>">
        <input type="hidden" name="backurl" value="<?= $backurl?>">
    <div class="city_label"><?= $city_name_chn?></div>
    <div style="clear:both;height:0;border-style: solid;border-width:0 0 2px 0;border-color: #4F79A9"> </div>
    <div class="content_frame">
        <?php foreach($total_load_chn_array as $total_load=>$total_load_chn){?>
            <div class="content_block">
                <div class="load_level">能耗档位：<?= $total_load_chn?></div>
                <div class="pairs">
                <ul>
                    <?php foreach(range(0,$pair_num-1) as $pos){?>
                        <li>
                        标杆站：<?if($station_select_array[$total_load][ESC_STATION_TYPE_SAVING]){?>
                                    <?= h_station_relative_select_sql("savpairs[$total_load][$pos][".ESC_STATION_TYPE_SAVING."]",
                                        $station_select_array[$total_load][ESC_STATION_TYPE_SAVING],
                                        $stations_pair_disp[$total_load][$pos]['sav_station_id'],$first=" ",$width=150)?>
                                <?}else{?>
                                    无
                                <?}?>
                        </li>
                        <li>
                        基准站：<?if($station_select_array[$total_load][ESC_STATION_TYPE_STANDARD]){?>
                                    <?= h_station_relative_select_sql("savpairs[$total_load][$pos][".ESC_STATION_TYPE_STANDARD."]",
                                        $station_select_array[$total_load][ESC_STATION_TYPE_STANDARD],
                                        $stations_pair_disp[$total_load][$pos]['std_station_id'],$first=" ",$width=150)?>
                                <?}else{?>
                                    无
                                <?}?>
                        </li>
                        <li style="width:210px;padding:5px 0 5px 210px">
                        基准站月能耗调整：<?if($station_select_array[$total_load][ESC_STATION_TYPE_STANDARD]){?>
                                    <input style="width:75px" type="text" name="<?= "savpairs[$total_load][$pos][std_cspt_adjust]"?>" 
                                           value="<?= $stations_pair_disp[$total_load][$pos]['std_cspt_adjust']?>">
                                <?}else{?>
                                    无
                                <?}?>
                        </li>
                    <?}?>
                </ul>    
                </div>
             </div>
        <?}?>     
    </div>    
    <div id="submit">
        <a href="javascript:void(0)" id="confirm_c" class="btn btn-primary">提交</a>
        <a href="javascript:void(0)" id="calc_c" class ="btn btn-success">计算</a>
        <a href="javascript:void(0)" id="adjust_c" class="btn btn-success">数据补齐</a>
        <!--<a href="/rake/saving/calcInitedDataFrom/<?= h_dt_start_time_of_month($conditions['datetime'])?>/<?= h_dt_stop_time_of_month($conditions['datetime'])?>?backurl=<?= urlencode($backurl)?>" id="calc_c" class="btn btn-success">计算</a>-->
        <!--<a href="/rake/saving/adjustCalcedDataFrom/<?= h_dt_start_time_of_month($conditions['datetime'])?>/<?= h_dt_stop_time_of_month($conditions['datetime'])?>?backurl=<?= urlencode($backurl)?>" id="adjust_c" class="btn btn-success">数据补齐</a>-->
    </div> 
   </form>
   <div style="clear:both;border-top:1px solid #ffffff;width:1000px;height:1px"></div>  
<script>

window.options = {
        "prj_cities":'<?= $prj_cities ?>',
        "city_id":'<?= $conditions['city_id']?>'
    }

    function project_cities(prj_id){
        //    var cities = jQuery.parseJSON(window.options.prj_cities);
        var cities = eval('('+window.options.prj_cities+')');
        str =  "<select id='city_id' name='city_id' value='"+window.options.city_id+"' style='width:100px;'>";
        //str += "<option value='0'"+(window.options.city_id==0?"selected":"")+">请选择</option>";
        $.each(cities[prj_id],function(i,n){
            str += "<option value='"+i+"'"+(window.options.city_id==i?"selected":"")+">"+n+"</option>";
        });      
        str += "</select>";
        $('#city_select').html(str);
    }

	
$(document).ready(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/reporting/home/set_sav_pairs";
            document.getElementById('filter').submit();
        });
        $("#confirm_c").click(function(){
            document.getElementById('content').action = "/reporting/home/insert_to_savpair";
            document.getElementById('content').submit();
        });
        
        $("#calc_c").click(function(){
            document.getElementById('content').action = "/rake/saving/calcInitedDataFrom";
            document.getElementById('content').submit();
        });
        
        $("#adjust_c").click(function(){
            document.getElementById('content').action = "/rake/saving/adjustCalcedDataFrom";
            document.getElementById('content').submit();
        });
        
        
        
        
        $('#project_id').change(function(){
            project_cities($(this).attr("value"));
        });

        $('.es_day').datepicker({
                showButtonPanel: true,
                dateFormat: "yy-mm-dd",
                inline: false,
                timezone: '+8000',
                defaultDate: '+7d', 
                onClose:function(datatimeText,instance){

        
        }
    });
	});
        function energy_type_check(){
            
        }
</script>
