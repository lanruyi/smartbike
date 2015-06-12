<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>

<div class="modal-dialog" style="width:800px;">
    <div class="modal-content">                             
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">批量 升级</h4>
        </div>
        <div class="modal-body">
            <form id="modal_mulit_update_form">
                <input type="hidden" name="station_ids_str" value="<?= $station_ids_str?>" />
                <div class="row">
                    <div class="col-xs-1"> <div class="pull-right"><b>项目</b></div> </div>
                    <div class="col-xs-2">
                        <select name="stations#project_id" class="form-control input-sm ">
                            <?= h_make_options(h_array_2_select($projects),$station['project_id'],""); ?>
                        </select>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>城市</b></div> </div>
                    <div class="col-xs-2">
                        <select name="stations#city_id" class="form-control input-sm ">
                            <?= h_make_options(h_array_2_select($cities),$station['city_id'],""); ?>
                        </select>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>档位</b></div> </div>
                    <div class="col-xs-2">
                        <select name="stations#total_load" class="form-control input-sm">
                            <?= h_make_options(h_station_total_load_array(),$station['total_load'],""); ?>
                        </select>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>建筑</b></div> </div>
                    <div class="col-xs-2">
                        <select name="stations#building" class="form-control input-sm">
                            <?= h_make_options(h_station_building_array(),$station['building'],""); ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-xs-1"> <div class="pull-right"><b>负载</b></div> </div>
                    <div class="col-xs-2">
                        <input class="form-control input-sm" value="<?= $station['load_num'] ?>" />
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>ESG</b></div> </div>
                    <div class="col-xs-2">
                        <?= $station['esg']['id'] ?>
                    </div>

                    <div class="col-xs-1"> <div class="pull-right"><b>电话</b></div> </div>
                    <div class="col-xs-2">
                        <input class="form-control input-sm" value="<?= $station['sim_num'] ?>" />
                    </div>
                    <div class="col-xs-1">
                        <div class="pull-right"><b>恒温柜</b></div>
                    </div>
                    <div class="col-xs-2">
                        <select name="stations#box_type" class="form-control input-sm">
                            <?= h_make_options(h_station_box_type_array(),$station['box_type'],""); ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-xs-1">
                        <div class="pull-right"><b>空调</b></div>
                    </div>
                    <div class="col-xs-2">
                        <input class="form-control input-sm" value="<?= $station['colds_num'] ?>" />
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>外温感</b></div>
                    </div>
                    <div class="col-xs-2">
                        <select name="stations#equip_with_outdoor_sensor" class="form-control input-sm">
                            <?= h_make_options(array("1"=>"有","2"=>"没有"),$station['equip_with_outdoor_sensor'],""); ?>
                        </select>
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>风量</b></div>
                    </div>
                    <div class="col-xs-2">
                        <select name="stations#air_volume" class="form-control input-sm">
                            <?= h_make_options(h_station_air_volume_array(),$station['air_volume'],""); ?>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <div class="pull-right"><b>督导</b></div>
                    </div>
                    <div class="col-xs-2">
                        <select name="stations#creator_id" class="form-control input-sm">
                            <?= h_make_options(h_array_2_select($creators),$station['creator_id'],"未知"); ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-xs-1">
                        <div class="pull-right"><b>建站</b></div>
                    </div>
                    <div class="col-xs-2">
                        <?= h_dt_format($station['create_time'],"Y-m-d")?>
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>电价</b></div>
                    </div>
                    <div class="col-xs-2">
                        <input class="form-control input-sm" value="<?= $station['price'] ?>" />
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b>分期</b></div>
                    </div>
                    <div class="col-xs-3">
                        <select name="stations#batch_id" class="form-control input-sm">
                            <?= h_make_options(h_array_2_select($batches),$station['batch_id'],"未知"); ?>
                        </select>
                    </div>

                    <div class="col-xs-1">
                        <div class="pull-right"><b></b></div>
                    </div>
                    <div class="col-xs-1">

                    </div>


                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" id="modal_mulit_sta" class="btn btn-info" >批量修改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
 
<script>
$("#modal_mulit_sta").click(function(){
    $.ajax({
       cache: true,
       type: "POST",
       url:"/ajax/station/mulit_process",
       data:"station_ids_str=<?= $station_ids_str?>&rom_id="+rom_id,// 你的formid
       async: false,
       error: function(request) {
           alert("连接失败 再试一遍!");
       },
       success: function(data) {
           /*alert(data);*/
           /*$("#commonLayout_appcreshi").parent().html(data);*/
           $("#modal_update").modal("hide");
       }
    });
});
</script>
 
