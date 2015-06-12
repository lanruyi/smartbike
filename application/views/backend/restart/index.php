

<script>
$(function(){ })
    $(document).ready(function(){
        $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'}); 
    });
</script>

<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}
</style>

<div class=base_center>

<div style="margin:0;width:100%">
<font>后台 >> 重启列表</font>
</div>
    <? if(isset($station) && $station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>
    <?}?>

<form id="filter" method="get" action="">
<div class='filter'>
        <input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
        重启时间:<input type="text" name="restart_start_time" style="width:120px" value="<?= $this->input->get('restart_start_time')?>" title="例: 20120815/20120815010000"/> 
        到:<input type="text" name="restart_stop_time" style="width:120px"  value="<?= $this->input->get('restart_stop_time')?>" title="例: 20120816/20120815030000"/> 
	每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page')?>" type="text" title="默认: 20"/>	
</div>
<div class='operate'>
	<button type="submit" class="btn btn-primary">确定查询</button> 
        <? if($station){ ?>
        <a href="/backend/restart?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
      <?}else{?>
        <a href="/backend/restart" class="btn btn-primary">清除查询</a>
      <?}?>
</div>
</form>



    <?= $pagination?>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th>#</th>
                <th>基站</th>
                <th>ESG_ID</th>
                <th>重启时间</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($restarts as $restart): ?>
            <tr>
                <td><?= $restart['id']?></td>
                <td><?= $restart['station_name_chn']?$restart['station_name_chn']:""?></td>
                <td><?= $restart['esg_id']?></td>
                <td><?= $restart['restart_time']?></td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
    <?= $pagination?>

</div>

