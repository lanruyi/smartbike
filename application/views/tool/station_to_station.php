<style>
.bs-docs-example {
position: relative;
margin: 15px 0;
padding: 39px 19px 14px;
background-color: #fff;
border: 1px solid #ddd;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
}

.bs-docs-example:after {
content: "<?=$title?>";
position: absolute;
top: -1px;
left: -1px;
padding: 3px 7px;
font-size: 12px;
font-weight: bold;
background-color: #f5f5f5;
border: 1px solid #ddd;
color: #9da0a4;
-webkit-border-radius: 4px 0 4px 0;
-moz-border-radius: 4px 0 4px 0;
border-radius: 4px 0 4px 0;
}


.wl-orderinfo {
line-height: 30px;
background: #f2f2f2;
border: 1px solid #e5e5e5;
padding: 0 5px;
}
.wl-field {
display: inline-block;
width: 120px;
text-align: right;
}
</style>
<div class=base_center>
  <form id="filter" method="get" action="/tool/station_to_station">
    <div class='filter'>
      <span style='color:green'>基准站</span>
      城市：<?= h_common_select('s_city_id',$cities,$this->input->get('s_city_id')); ?>
      基站名：<input type="text" style="width:80px;height:28px;"  name="s_station_name_chn" value="<?=$this->input->get('s_station_name_chn'); ?>"/>
      <span style='color:red'>节能站</span>
      城市：<?= h_common_select('e_city_id',$cities,$this->input->get('e_city_id')); ?>
      基站名：<input type="text" style="width:80px;height:28px;"  name="e_station_name_chn" value="<?=$this->input->get('e_station_name_chn'); ?>"/>
      日期：<input type="text" class="es_day" name="start_time" style="width:68px; height:16px" value="<?=$this->input->get('start_time')?>">
      节能方式：<?=h_energy_save_select(h_energy_save_type(),'energy_save_type',$this->input->get('energy_save_type'));?>
      <!--每页：<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />-->
      </div>
      <div class='operate'>
      <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
      <a href="/tool/station_to_station" class="btn btn-primary">清除查询</a>
    </div>
  </form>
  <div class="bs-docs-example">
    <table class="table table-striped">
      <tr>
        <th>#日期</th>
        <th>基准站</th>
        <th>负载</th>
        <th>本日耗电</th>
        <th>节能站</th>
        <th>负载</th>
        <th>本日耗电</th>
        <th>节能率</th>
        <th>节能量</th>
      </tr>
      <?if($error){?>
      <tr><td colspan='6' style="text-align:center"><?=$error?></td></tr>
      <?}else{ 
        foreach($sv_datas as $sv_data){?>
        <tr>
          <td><?=$sv_data['time']?></td>
          <td><?=$this->input->get('s_station_name_chn')?></td>
          <td><?=$s_station['load_num']?></td>
          <td><?=round($sv_data['s_energy_main'],2)?></td>
          <td><?=$this->input->get('e_station_name_chn')?></td>
          <td><?=$e_station['load_num']?></td>
          <td><?=round($sv_data['e_energy_main'],2)?></td>
          <td><?=$sv_data['saving_rate']?></td>
          <td><?= round($sv_date['saving_energy'],2)?> </td>
        </tr>
        <tr>
          <td>总计</td>
          <td><?=$this->input->get('s_station_name_chn')?></td>
          <td><?=$s_station['load_num']?></td>
          <td><?=array_sum($sv_datas['s_energy_main'])?>
          <td><?=$this->input->get('e_station_name_chn')?></td>
          <td><?=$e_station['load_num']?></td>
          <td><?=array_sum($sv_datas['e_energy_main'])?></td>
          <td><?=array_sum($sv_datas['saving_rate'])/count($sv_datas['saving_rate'])?></td>
          <td><?=array_sum($sv_datas['saving_energy'])?></td>
        </tr>
        <?}?>
      <?}?>
    </table>
  </div>

<script>
  $(function(){
    $("#confirm_s").click(function(){
      $("#filter").submit();
    })
    $('.es_day').datepicker({
        showButtonPanel: true,
        dateFormat: "yy-mm-dd",
        inline: false,
        timezone: '+8000',
        defaultDate: '+7d', 
        onClose:function(datatimeText,instance){
        }
      })
  })
</script>
