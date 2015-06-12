<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>

<div class="modal-dialog" style="width:800px;">
    <div class="modal-content">                             
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">批量设置</h4>
            <small>
                当前选中 <?= count($stations);?> 个站点 
            </small>
            <br>
            <small>
                请进行设置 <font color=red>谨慎设置</font>
            </small>
</div>
<div class="modal-body">
<!--
<div class="row">
      <div class="col-xs-12">
          <h4>选项设置</h4>
      </div>
</div>
-->
<form id="modal_mulit_setting_form">
<input type="hidden" name="station_ids_str" value="<?= $station_ids_str?>" />
<div class="row">
      <? foreach($this->esgconf->ec_array as $ec_item){?>
      <? if($ec_item['is_hide'])continue;?>
      <div class="col-xs-3" style="margin-top:5px;">
          <span style="font-size:12px">
             <?= $ec_item['sid']?>. 
             <?= $ec_item['cn']?>
             <? if($ec_item['desc']){?>
                 <a href="javascipt:;" title="<?= $ec_item['desc']?>"><i class="icon-info-sign"></i></a>
             <?}?>
          </span>
          <input name="<?= $ec_item['dbc']?>" type="text" class="form-control input-xs">
      </div>
      <?}?>
</div>
</form>
<div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" id="modal_mulit_set" class="btn btn-info" >批量设置</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
 
<script>
$("#modal_mulit_set").click(function(){
    $.ajax({
       cache: true,
       type: "POST",
       url:"/ajax/esgconf/mulit_process",
       data:$('#modal_mulit_setting_form').serialize(),// 你的formid
       async: false,
       error: function(request) {
           alert("连接失败 再试一遍!");
       },
       success: function(data) {
           /*alert(data);*/
           /*$("#commonLayout_appcreshi").parent().html(data);*/
           $("#modal_setting").modal("hide");
       }
    });
});
</script>
 
