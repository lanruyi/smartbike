<div class = "base_center">
    <div style="margin-bottom:10px;width:100%;">
        <font>后台 >> 基站批量设置报告</font>
    </div>

        <form id='subform' action='/backend/esgconf/batch_setting_report' method='post'>
        <input type='hidden' name='c' value='<?= $command_json?>'>
        </form>
        <script>
            $(function(){
                $("#refresh_command_status").click(function(){
                    document.getElementById('subform').submit();
                });
            });
        </script>

    <div style="float:left;width:200px">

        *离开页面后此报告无法再打开
        <br />
        <br />
        <a id="refresh_command_status" href="javascript:void(0)"> 点此刷新最新状态 </a>
        <br />
        <br />
        <table class="table2">
        <tr>
            <td> 总共设置 </td>
            <td> <?= $nums['total']?> 个 </td>
        </tr>
        
        <? foreach(h_command_status_array() as $status => $name){?> 
        <tr>
            <td> <?= $name?> </td>
            <td> <?= $nums[$status]?> 个  </td>
        </tr>
        <? }?>
        
        <tr>
            <td> 未知错误 </td>
            <td> <?= $nums['unknow']?> 个 </td>
        </tr>
        </table>
    </div>

    <div style="float:left;width:800px">
        <table class="table2">
        <? foreach($unfinish_stations as $status => $stations){?> 
        <tr style="background-color:#ccc;font-weight:bold">
            <td colspan=4> 
                <?= h_command_status_name_chn($status)?>
                (<?= count($stations)?>)
            </td>
        </tr>
            <? foreach($stations as $station){?> 
            <tr>
                <td> 
                    <?= $station['project_name_chn']?>
                </td> 
                <td> 
                    <?= $station['city_name_chn']?>
                </td> 
                <td style="text-align:left"> 
                    <img src=<?= h_online_gif_new($station['alive'])?>>
                    <a href="/backend/command?station_id=<?= $station['id']?>" target="_blank">
                        <?= $station['name_chn']?>
                    </a>
                </td>
                <td> 
                    <?php if($station['setting_lock'] == ESC_STATION_SETTING_LOCK){?>
                       <?= h_command_setting_lock_name_chn() ?> 
                    <? } else {?>
                        <?= h_command_status_color_name_chn($status)?>
                    <? }?>
                </td> 
            </tr>
            <? }?>
        <? }?>
        </table>
        
<!--        <? if(isset($unfinish_stations['unknow'])){?>
        <table class="table2"> <tr>
        <? foreach($unfinish_stations['unknow'] as $station){?> 
                <td style="text-align:left"> 
                    <img src=<?= h_online_gif_new($station['alive'])?>>
                    <a href="/backend/command?station_id=<?= $station['id']?>" target="_blank">
                        <?= $station['name_chn']?>
                    </a>
                </td>
        <? }?>
        </tr> </table>
        <? }?>-->
    </div>

</div>


<div style="clear:both;height:20px">
</div>

