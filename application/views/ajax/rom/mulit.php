<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>

<div class="modal-dialog" style="width:800px;">
    <div class="modal-content">                             
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">批量 升级</h4>
            <small>
                当前选中 <?= count($stations);?> 个站点 
            </small>
            <br>
            <small>
                请选择要升级的ROM <font color=red>谨慎升级</font>
            </small>
</div>
<div class="modal-body">
<!--
<div class="row">
      <div class="col-xs-12">
          <h4>设置</h4>
      </div>
</div>
-->
<form id="modal_mulit_update_form">
<input type="hidden" name="station_ids_str" value="<?= $station_ids_str?>" />
<div class="row">
    <? foreach($roms as $rom){?>
    <div class="rom_item" >
    <a href="javascript:;" data-rom_id="<?= $rom['id']?>" class="icon-btn js_rom_version_btn">
        <!-- <i class="icon-barcode"></i> -->
        <div class="rom_title">
            <span style="font-size:15px;font-weight:bold">
                <?= $rom['version']?></span>
            <br>
            <?= h_dt_format($rom['created'],"Y-m-d")?>
        </div>
        <div class="rom_body">
            <?= $rom['comment']?>
        </div> 
        <span class="badge badge-success"><?= $rom['station_num']?></span>
    </a>
    </div>
    <?}?>
</div>
</form>
<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" id="modal_mulit_upd" class="btn btn-info" >批量升级</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 
<script>
var rom_id = 0;
$(".js_rom_version_btn").click(function(){
    rom_id = $(this).attr("data-rom_id");
    $(".js_rom_version_btn").removeClass("active");
    $(this).addClass("active");
});

$("#modal_mulit_upd").click(function(){
    $.ajax({
       cache: true,
       type: "POST",
       url:"/ajax/rom/mulit_process",
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
 
