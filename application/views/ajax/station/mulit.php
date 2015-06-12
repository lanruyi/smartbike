<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>

<div class="modal-dialog" style="width:800px;">
    <div class="modal-content">                             
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">批量修改</h4>
            <small>
                当前选中 <?= count($stations);?> 个站点 
            </small>
            <br>
            <small>
                请给需要修改的属性打钩 <font color=red>谨慎修改</font>
            </small>
        </div>
        <div class="modal-body">
            <form id="modal_mulit_station_update_form">
                <input type="hidden" name="station_ids_str" value="<?= $station_ids_str?>" />
                <div class="row">
                    <div class="col-xs-3"> 
                        <input type="checkbox" name="mod_strs[]" value="project_id" />
                        项目:<br>
                        <select name="project_id" class="form-control input-sm ">
                            <?= h_make_options(h_array_2_select($projects),0,""); ?>
                        </select>
                    </div>

                    <div class="col-xs-3"> 
                        <input type="checkbox" name="mod_strs[]" value="city_id" />
                        城市:<br>
                        <select name="city_id" class="form-control input-sm ">
                            <?= h_make_options(h_array_2_select($cities),0,""); ?>
                        </select>
                    </div>

                    <div class="col-xs-3"> 
                        <input type="checkbox" name="mod_strs[]" value="total_load" />
                        档位:<br>
                        <select name="total_load" class="form-control input-sm">
                            <?= h_make_options(h_station_total_load_array(),0,""); ?>
                        </select>
                    </div>

                    <div class="col-xs-3"> 
                        <input type="checkbox" name="mod_strs[]" value="building" />
                        建筑:<br>
                        <select name="building" class="form-control input-sm">
                            <?= h_make_options(h_station_building_array(),0,""); ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-xs-3"> 
                        <input type="checkbox" name="mod_strs[]" value="load_num" />
                        负载:<br>
                        <input name="load_num" class="form-control input-sm" value="" />
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="" />
                        ESG
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="sim_num" />
                        电话:<br>
                        <input name="sim_num" class="form-control input-sm" value="" />
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="box_type" />
                        恒温柜:<br>
                        <select name="box_type" class="form-control input-sm">
                            <?= h_make_options(h_station_box_type_array(),0,""); ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="colds_num" />
                        空调:<br>
                        <input name="colds_num" class="form-control input-sm" value="" />
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="equip_with_outdoor_sensor" />
                        外温感:<br>
                        <select name="equip_with_outdoor_sensor" class="form-control input-sm">
                            <?= h_make_options(array("1"=>"有","2"=>"没有"),0,""); ?>
                        </select>
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="air_volume" />
                        风量:<br>
                        <select name="air_volume" class="form-control input-sm">
                            <?= h_make_options(h_station_air_volume_array(),0,""); ?>
                        </select>
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="creator_id" />
                        督导:<br>
                        <select name="creator_id" class="form-control input-sm">
                            <?= h_make_options(h_array_2_select($creators),0,"未知"); ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="" />
                        建站时间:<br>
                        <input class="form-control input-sm " value=""  disabled />
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="price" />
                        电价:<br>
                        <input name="price" class="form-control input-sm" value="" />
                    </div>

                    <div class="col-xs-3">
                        <input type="checkbox" name="mod_strs[]" value="batch_id" />
                        分期:<br>
                        <select name="batch_id" class="form-control input-sm">
                            <?= h_make_options(h_array_2_select($batches),0,"未知"); ?>
                        </select>
                    </div>

                    <div class="col-xs-3">

                    </div>


                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" id="modal_mulit_station_update_go" class="btn btn-info" >批量修改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
 
<script>
$("#modal_mulit_station_update_go").click(function(){
    $.ajax({
       cache: true,
       type: "POST",
       url:"/ajax/station/mulit_update_process",
       data:$('#modal_mulit_station_update_form').serialize(),// 你的formid
       async: false,
       error: function(request) {
           alert("连接失败 再试一遍!");
       },
       success: function(data) {
           /*alert(data);*/
           /*$("#commonLayout_appcreshi").parent().html(data);*/
           $("#modal_station_update").modal("hide");
       }
    });
});
</script>
 
