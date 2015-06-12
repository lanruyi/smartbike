<style>
.filter{ background-color:#333;color:white;line-height:35px;padding:10px 10px 0 10px;}
.filter input,select{border:1px solid black}
.operate{ background-color:#666;color:white;padding:5px 10px ;}
#stations_div{position:absolute;z-index:1;display: none;width:400px;background-color: #eee;border:1px solid #666;}
#stations_div ul,#stations_div ul li{float:left;list-style: none;margin:0;padding:0}
#stations_div ul li{margin:3px;}
</style>

<script>
$(function(){
    $('.filter select[value!=0],.filter input[value!=""]').css({'background-color':'green','color':'white'});
});
</script>


<div class=base_center>

<div style="margin:0;width:100%">
<font>后台 >> 维修列表</font>
</div>

    <? if($station){?>
        <? $this->load->view("backend/onestation",array('station'=>$station))?>

        <div style="border:1px solid #333;padding:10px;margin-bottom:10px;">
            <form action="/backend/esgfix/add_esgfix/<?= $station['id']?>" method="post">
            维修前配置：
            <?= h_make_select(h_esgfix_ver_name_chn_array(), 
                "esg_ver", 0,"",100);?>
            维修后配置：
            <?= h_make_select(h_esgfix_ver_name_chn_array(), 
                "new_esg_ver",0,"",100);?>
            故障原因
            <?= h_make_select(h_esgfix_reason_array(), 
                "reason",0,"", 100);?>
            其他原因:
            <input type="text" name="other_reason" />
            <input type="submit" name="提交">
            </form>
        </div>
    <?}?>


<form id="filter" method="get" action="">
    <div class='filter'>
      <input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
      每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
    </div>
    <div class='operate'>
      <button type="submit" class="btn btn-primary">确定查询</button> 
      <? if($station){ ?>
        <a href="/backend/autocheck?station_id=<?= $station['id'] ?>" class="btn btn-primary">清除查询</a>
      <?}else{?>
        <a href="/backend/autocheck" class="btn btn-primary">清除查询</a>
      <?}?>
      
    <? if($station){?>
    <span style="float:right">
    <a href="/backend/autocheck/add_autocheck?station_id=<?=  $this->input->get('station_id')?>&backurl=<?=$backurlstr?>" class="btn btn-primary">添加命令</a>
    </span>
    <?}?>
    </div>
</form>


<?= $pagination?>
<table class="table2">
<tr>
<td> <b>#</b> </td>
<td> <b>基站</b> </td>
<td> <b>时间</b> </td>
<td> <b>原esg_id </b> </td>
<td> <b>原esg版本配置 </b> </td>
<td> <b>新esg_id </b> </td>
<td> <b>新esg版本配置 </b> </td>
<td> <b>原因</b> </td>
<td> <b>其他原因</b> </td>
<td> <b>维修人员</b> </td>
<td>  </td>
</tr>
<?php foreach ($esgfixs as $esgfix){?>
<tr>
<td> <?= $esgfix['id'] ?> </td>
<td> 
    <?= $this->station->getNameChn($esgfix['station_id'])?> 
</td>
<td> <?= $esgfix['datetime'] ?>    </td>
<td> <?= $esgfix['esg_id'] ?>      </td>
<td> <?= h_esgfix_ver_name_chn($esgfix['esg_ver']) ?>     </td>
<td> <?= $esgfix['new_esg_id'] ?>  </td>
<td> <?= h_esgfix_ver_name_chn($esgfix['new_esg_ver']) ?> </td>
<td> <?= h_esgfix_reason($esgfix['reason']) ?>      </td>
<td> <?= $esgfix['other_reason'] ?>      </td>
<td> <?= $this->user->getUserNameChn($esgfix['user_id']) ?>      </td>
<td> </tr>
<?}?>
</table>
<?= $pagination?>

</div>


