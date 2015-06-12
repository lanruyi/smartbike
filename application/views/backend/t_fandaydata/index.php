<script type="text/javascript">
    $(function(){
        $("#confirm_s").click(function(){
            document.getElementById('filter').action = "/backend/t_fandaydata/index";
            document.getElementById('filter').submit();
        });
    });
</script>
    
<div class = "base_center">

    <div style="margin:0;width:100%">
    </div>

<form id="filter" method="get" action="">
<div class='filter'>
    项目:<?= h_common_select('project_id',$projects,$this->input->get('project_id')); ?>
    城市:<?= h_common_select('city_id',$cities,$this->input->get('city_id')); ?>
    基站类型:<?= h_station_station_type_select($this->input->get('station_type')); ?>
    开始时间:<input class="input-mini" name="start_time" value="<?= $this->input->get('start_time') ?>" type="text" />
    结束时间:<input class="input-mini" name="end_time" value="<?= $this->input->get('end_time') ?>" type="text" />
    每页:<input class="input-mini" name="per_page" value="<?= $this->input->get('per_page') ?>" type="text" />
</div>
<div class='operate'>
    <a href="javascript:void(0)" id="confirm_s" class="btn btn-primary">确定查询</a> 
    <a href="/backend/t_fandaydata/index" class="btn btn-primary">清除查询</a>
    <p style="float:right">
        <a href="javascript:void(0)" id="download_xls" class="btn btn-primary">导出xls</a>
    </p>
</div>
</form>

</div>



<div class = "base_center">
    <div style="clear:right;"><?= $pagination ?></div>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th> <b>基站名</b> </th>
                    <th> <b>基站类型</b> </th>
                    <th> <b>项目</b></th>
                    <th> <b>城市</b> </th>
                    <th> <b>统计时间</b> </th>
                    <th> <b>节能时间（分钟）</b></th>
                    <th> <b>采集总时间</b></th>
                    <th> <b>操作</b> </th>           
                </tr>
            </thead>
            <tbody id="tbody">
                <?php foreach ($fandaydatas as $fandaydata): ?>
                <tr>
                    <td> <?= $fandaydata['station_name_chn']?> </td>
                    <td><?= h_station_type($fandaydata['station_type'])?> </td>
                    <td> <?= $fandaydata['project_name_chn']?> </td>
                    <td> <?= $fandaydata['city_name_chn']?> </td>
                    <td> <?= $fandaydata['record_time']?> </td>
                    <td> <?= $fandaydata['fan_total']?>  </td>
                    <td> <?= $fandaydata['data_total']?>  </td>
                    <td> <a href="javascript:;">设置</a></td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>        
        <div style="clear:right;"><?= $pagination ?></div>
    </div>
</div>


