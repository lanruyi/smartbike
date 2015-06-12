<style type="text/css">
    .frametable{border: 2px solid; border-collapse:collapse;}
    .frametable th{font-size:1.8em;text-align: center;padding: 15px 0 15px 0;border: 1px solid}
    .frametable td{font-size: 1.2em;border: 1px solid;text-align: center;}
    .header{padding:5px 5px;font-weight:bold;text-align: center; }
    td{padding:0 0}
</style>
<div class='base_center'>
   
    
<form method="get" action="/frontend/single/add_meter_record">
<div>
<input type='hidden' name='station_id' value="<?= $this->input->get('station_id')?>" />
    <li  id="es_day">  
    基站电表采集时间 &nbsp;&nbsp;<input type="text" name="time" style="width:100px;height:16px">
    </li>
    <li>
        基站电表采集值 &nbsp;&nbsp;
        <input type ="text" name="meter_sample" style="width:100px;height:16px">
    </li>
    <li>      
        <button type="submit" class="btn btn-primary">提交</button>
    </li>
</div>
</form>
    
    <table class="frametable">
    <tr style="background-color:#ccc">
        <td width="100px" class="header"><b>基站</b></td>
    <td width="100px" class="header"><b>本次抄表时间T2</b></td>
    <td width="100px" class="header"><b>局方本次抄表数据K2</b></td>
    <td width="100px" class="header"><b>博欧电表本次读数H2</b></td>
    <td width="100px" class="header"><b>上次抄表时间T1</b></td>
    <td width="100px" class="header"><b>局方上次抄表数据K1</b</td>
    <td width="100px" class="header"><b>博欧电表上次读数H1</b</td>
    <td width="140px" class="header"><b>联通电表与博欧电表用电量比值系数<br>(K2-K1)/(H2-H1)</b</td>
    <td>本次原始数据</td>
    <td></td>
    </tr>
    <?$num =count($corrects);?>
    <? for($k=0;$k<$num;$k++){?>
        <tr>
        <td><?= $station['name_chn']?></td>
        <td><?= h_dt_format($corrects[$k]['time'],"Y-m-d H:i")?> </td>
        <td><?= $corrects[$k]['correct_num']?> </td>
        <td><?= $corrects[$k]['org_num']?> </td>
        <?if($k<$num-1){?>
            <td><?= h_dt_format($corrects[$k+1]['time'],"Y-m-d H:i")?> </td>
            <td><?= $corrects[$k+1]['correct_num']?> </td>
            <td><?= $corrects[$k+1]['org_num']?> </td>
            <td><?=h_round2(($corrects[$k]['correct_num']-$corrects[$k+1]['correct_num'])/($corrects[$k]['org_num']-$corrects[$k+1]['org_num']))?></td>
        <?} else {?>
            <td></td>
            <td></td>
            <td></td>
            <td>1.00</td>
        <?}?>
        <td>
            <a href="/frontend/single/data?station_id=<?=$station['id']?>&time=<?= h_dt_format($corrects[$k]['time'],"YmdHis")?>&type=hour" target="_blank">
                原始数据
            </a>
        </td>
        <td> 
            <?if ($k===0){?>
                <a href="javascript:
                    if(confirm('确实要删除'))
                        location='/backend/correct/del_correct/<?= 
                        $station['id']?>/<?= $corrects[$k]['id']?>?backurl=<?= $backurlstr?>';void(0)">
                    删除
                </a>
            <?}?>
        </td>
        </tr>
    <? }?>
</table>

<div style="clear:both"> </div>

<br />
<br />

</div>

<script type="text/javascript">
    // Json struct for different params. Initial: time, last 3_hours
    window.global_options = {
        "station_id": "<?= $station['id'] ?>",
        "day_offset": "0",
        "time": "<?= $time_disp?>"
    };

    $(document).ready(function(){
        $("#es_refresh").click(function(){ window.location.reload();});

        $('#es_day input').datetimepicker({
            showButtonPanel: true,
            dateFormat: "yy-mm-dd",
            inline: false,
            timezone: '+8000',
            defaultDate: '+7d', 
            onClose:function(datatimeText,instance){
                window.global_options.time = $('#es_day input').attr("value");
                window.location.href="?station_id=" + <?=$station['id']?> + "&time="+window.global_options.time;
            }
        });
        $('#es_day input').attr("value",window.global_options.time);	

    });


</script>