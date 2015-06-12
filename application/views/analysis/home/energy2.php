<style type= "text/css">
 select{width:120px}
.table_head{height: 80px}
.item_frame{width:1000px; clear:left}
.item_name0 {width:175px; height:18px; float:left; padding: 5px 0 5px 25px}
.item_name1 {width:175px; height:18px; float:left; padding: 5px 0 5px 25px}
.item_name2 {width:175px; height:36px; float:left; padding: 5px 0 5px 25px}
.item_name3 {width:175px; height:54px; float:left; padding: 5px 0 5px 25px}
.item_value0{width:800px; height:18px; float:left; background: url('/static/site/img/chart_bg/ruler.jpg') repeat-y; padding-top: 5px;padding-bottom: 5px}
.item_value1{width:800px; height:18px; float:left; background: url('/static/site/img/chart_bg/ruler.jpg') repeat-y; padding-top: 5px;padding-bottom: 5px}
.item_value2{width:800px; height:36px; float:left; background: url('/static/site/img/chart_bg/ruler.jpg') repeat-y; padding-top: 5px;padding-bottom: 5px}
.item_value3{width:800px; height:54px; float:left; background: url('/static/site/img/chart_bg/ruler.jpg') repeat-y; padding-top: 5px;padding-bottom: 5px}
.main_energy_value_pic{background: #abc;  height:18px }
.ac_energy_value_pic{background: #a1d88b;  height:18px }
.dc_energy_value_pic{background: #d76618;  height:18px }
.ruler{float:left;width:79px; height: 14px;padding-bottom: 4px}
.rulerend{float:left;width:10px; height:14px;padding-bottom: 4px}
.energy_level{float:left;width:775px; height: 24px; padding-top:5px }
.label_name{float:left; width:55px;height:18px;padding:5px 0;font-size: 12px;vertical-align: bottom}
.ac_label{float:left; width:10px; height: 18px; margin:5px 5px 5px 3px; background:#a1d88b }
.dc_label{float:left; width:10px; height: 18px;  margin:5px 5px 5px 3px;background: #d76618}
.sum_label{float:left; width:10px; height: 18px;  margin:5px 5px 5px 3px;background: #abc}
</style> 

<div class = "base_center">
    
    <form id ="filter" action="" method="get">
    <div class="filter"> 
        项目:<?= h_station_relative_select_sql('project_id',$projects,$project_id,null); ?>
        基站类型：<?= h_station_type_select($station_type,null)?>
        建筑类型：<?= h_station_building_select($building,null)?>
        时间：日期:<input class="es_day" name='projectdate' type="text"  style="width:68px;height:16px" 
                         value=<?= $project_select_date?> />
      
    AC:<input type="checkbox" id="disp_mark_ac_energy"  <?= $disp_mark_array[0] ? "checked":" " ?> > 
    DC:<input type="checkbox" id="disp_mark_dc_energy"  <?= $disp_mark_array[1] ? "checked":" "?> > 
    SUM:<input type="checkbox"id="disp_mark_sum_energy"  <?= $disp_mark_array[2] ? "checked":" "?> > 
    <input type="hidden" id="disp_mark"  name="disp_mark" value="1-1-1">
    </div>
    <!--确定按键-->  
    <div class='operate'>
	<a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    </div>
    </form>    
   


    <div id="table">
        <div class="table_head">
            <ul>
                <li>项目：<?php echo $project_name ?></li>
                <li>时间：<?php echo $project_select_date ?></li>
                <li>基站类型：<?php echo $station_type_name ?></li>
                <li>建筑类型：<?php echo $building_name ?></li>
            </ul>
        </div>
        <div id="table_body">
<?php foreach($result_datas as $key => $rawdatas){ ?>
        <div class="energy_level">
            <ul>
                <li><h3>能耗档位：<?= $energy_level[$key]?></h3>单位：千瓦时</li>
            </ul>    
        </div>
        <div style="float:left; width:220px; height:29px; pading-top:5px">
            <div class="label_name">日AC能耗</div><div class="ac_label"></div>
            <div class="label_name">日DC能耗</div><div class="dc_label"></div>
            <div class="label_name">日总能耗</div><div class="sum_label"></div>        
        </div>
            <div style="clear:both;border-bottom:1px solid #79bf69;width:1000px;height:20px">
                <div style="width:195px;height: 14px;float: left"></div>
                <div class="ruler">0</div>
                <div class="ruler">25</div>
                <div class="ruler">50</div>
                <div class="ruler">75</div>
                <div class="ruler">100</div>
                <div class="ruler">125</div>
                <div class="ruler">150</div>
                <div class="ruler">175</div>
                <div class="ruler">200</div>
                <div class="ruler">225</div>
                <div class="rulerend">250</div>  
            </div>
    <?php 
    $css_item_name = array(
        "0"=>"item_name0",
        "1"=>"item_name1",
        "2"=>"item_name2",
        "3"=>"item_name3"        
    );
    $css_item_value = array(
        "0"=>"item_value0",
        "1"=>"item_value1",
        "2"=>"item_value2",
        "3"=>"item_value3"        
    );
    ?>
    <?php foreach($rawdatas as $station_id => $item){ ?>
   
            <div class="item_frame"> 
                <div class="<?= $css_item_name[array_sum($disp_mark_array)]?>">
                
                <?= $item['city_name']?> <a href="/backend/station/slist?station_ids=<?= $station_id?>"><?= $item['station_name_chn']?></a>
                
            </div>
                <div class="<?= $css_item_value[array_sum($disp_mark_array)]?>">
               <?php if($disp_mark_array[0]){?>
                <div class="ac_energy_value_pic" style="width:<?= $item['ac_energy']*3.2 ?>px;"></div>
               <?php }
               if($disp_mark_array[1]){ ?>
                <div class="dc_energy_value_pic" style="width:<?= $item['dc_energy']*3.2 ?>px;"></div>
                <?php }
               if($disp_mark_array[2]){ ?>
                <div class="main_energy_value_pic" style="width:<?= $item['main_energy']*3.2 ?>px;"></div>
               <? }?>
            </div>
        </div>
       
    <? }?>
        <div style="clear:both;border-top:1px solid #79bf69;width:1000px;height:10px"></div>       
<? }?>
        </div>
    </div>
</div>
<script>
	
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/analysis/home/energy2";
            var str = "";
            if($("#disp_mark_ac_energy").attr("checked")){
                str+="1-";
            }else{
                str+="0-";
            }
            if($("#disp_mark_dc_energy").attr("checked")){
                str+="1-";
            }else{
                str+="0-";
            }
            if($("#disp_mark_sum_energy").attr("checked")){
                str+="1";
            }else{
                str+="0";
            }
            $("#disp_mark").val(str);
            document.getElementById('filter').submit();
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
