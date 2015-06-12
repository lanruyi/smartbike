<div class="base_center">

<style>
div.scmain{float:left;width:1000px;margin-top:5px;margin-bottom:15px;background-color:#ded;padding:5px;}

div.scright{float:left;width:240px}
div.scright > h2{text-align:left;font-size:14px;font-weight:bold;line-height:25px;}
div.scright > .detail{margin-bottom:8px;}

div.scleft{float:left;width:760px}
div.scleft > .stations > li{border:1px solid;margin:2px;padding:2px}
</style>



        <div class="scmain" style="background-color:#fff">
            <div class="scright" style="height:60px;width:1000px">
                <h2> 所有合同总体统计 </h2>
                <li> 
                    <b>合同总数</b>： <?= count($contracts)?> 个  
                    <b>基站总数</b>： <?= $all_count['normal']?> 个
                    <b>即将投入运营站点</b>: &nbsp;
                    <? foreach($projects as $project){?>
                        <?= $project['name_chn']?> <?= $project['out_num']?> 个 
                    <?}?>
                </li>

            </div>
            <div class="scleft" style="width:1000px">
                <ul class="stations">
                    <li>  
                        <? $pie_array=array();?>
                        <?foreach(h_station_station_type_array() as $station_type => $name){?>
                            <? $pie_array[] = array($all_count['station_type'][$station_type],$name);?>
                        <?}?>
                        <?= h_draw_line_pie($pie_array,array("color"=>0,"width"=>985,"height"=>10))?>
                    </li>
                    <li> 
                        <? $pie_array=array();?>
                        <?foreach(h_station_total_load_array() as $total_load => $name){?>
                            <? $pie_array[] = array($all_count['load_level'][$total_load],$name);?>
                        <?}?>
                        <?= h_draw_line_pie($pie_array,array("color"=>1,"width"=>985,"height"=>20))?>
                    </li>
                    <li> 
                        <? $pie_array=array();?>
                        <?foreach(h_station_building_array() as $building => $name){?>
                            <? $pie_array[] = array($all_count['building'][$building],$name);?>
                        <?}?>
                        <?= h_draw_line_pie($pie_array,array("color"=>0,"width"=>985,"height"=>10))?>
                    </li>
                </ul>
            </div><!--scleft-->
        </div>






    <? foreach($contracts as $contract){?>
        <? $count = $contract['count'];?>
        
        <div class="scmain">
            <div class="scright">
                <h2> <?= $contract['project']['name_chn'].h_contract_phase_name_chn($contract['phase_num'])?> </h2>
                <li> 合同号：<?= $contract['name_chn']?> </li>
                <li> 基站总数： <?= $count['normal']?> 个 </li>
                <li> 分成比例：</li>
            </div>
            <div class="scleft">
                <ul class="stations">
                    <li>  
                        <? $pie_array=array();?>
                        <?foreach(h_station_station_type_array() as $station_type => $name){?>
                            <? $pie_array[] = array($count['station_type'][$station_type],$name);?>
                        <?}?>
                        <?= h_draw_line_pie($pie_array,array("color"=>0,"width"=>742,"height"=>10))?>
                    </li>
                    <li> 
                        <? $pie_array=array();?>
                        <?foreach(h_station_total_load_array() as $total_load => $name){?>
                            <? $pie_array[] = array($count['load_level'][$total_load],$name);?>
                        <?}?>
                        <?= h_draw_line_pie($pie_array,array("color"=>1,"width"=>742,"height"=>20))?>
                    </li>
                    <li> 
                        <? $pie_array=array();?>
                        <?foreach(h_station_building_array() as $building => $name){?>
                            <? $pie_array[] = array($count['building'][$building],$name);?>
                        <?}?>
                        <?= h_draw_line_pie($pie_array,array("color"=>0,"width"=>742,"height"=>10))?>
                    </li>

                        <?foreach($contract['batches'] as $batch){?>
                    <li>
                        <div style="float:left;width:1000px;;"> 
                            <ul style="float:left;width:200px">
                                <?= $batch['name_chn']?>  
                            </ul>
                            <ul style="float:left;width:110px">
                                站点数量: <?= $count['batch'][$batch['id']]?>  
                            </ul>
                            <ul style="float:left;width:140px">
                                开始运营: <?= h_dt_format($batch['start_time'],"Y-m-d")?>  
                            </ul>
                            <ul style="float:left;width:140px">
                                上次结算: <?= $batch['current_time']?h_dt_format($batch['current_time'],"Y-m-d"):"还未收款"?>  
                            </ul>
                        </div>
                        <div style="float:left;width:1000px;"> 
                            <ul style="float:left;width:200px">
                                 &nbsp;
                            </ul>
                            <ul style="float:left;width:640px">
                              <? $pie_array = array(
                                array(h_batch_interval($batch['start_time'],$batch['current_time']),"已付款月"),
                                array(h_batch_interval($batch['start_time'],'now') - 
                                      h_batch_interval($batch['start_time'],$batch['current_time']),"未付款月"),
                                array($batch['total_month'] - 
                                      h_batch_interval($batch['start_time'],'now'),"未结算月"));?>
                              <?= h_draw_line_pie($pie_array,array("color"=>2,"width"=>245,"height"=>10,"one_line"=>true))?>
                            </ul>
                        </div>
                        <div style="clear:both"> </div>
                    </li>
                        <?}?>
                </ul>
            </div><!--scleft-->
        </div>
    <?}?>

</div>
