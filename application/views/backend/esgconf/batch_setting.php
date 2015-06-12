<style type="text/css">
    #selected_stations{padding-top:20px;}
    #selected_stations ul,li{list-style:none;margin:0}
    #selected_stations li{width:16%;float:left;} 
    #s_bar{padding: 3px 6px; font-weight:bold;background:#3066a6;color:#FFFFFF;border:1px solid #3066a6; text-align:left;}
    #station_setting_list {display:none;}
    
    #batch_setting table{float:left;}
    #batch_setting table th{background-color:#ccc;border-right:solid 1px #fff;}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $("#setting_datas").click(function(){
            if($("#selected_stations").css("display")=="none"){
                $(this).html("<i class='icon-arrow-right'></i> 点击查看各基站设置详情");
                $("#station_setting_list").css("display","none");
                $("#selected_stations").css("display","block");
            }else if($("#station_setting_list").css("display")=="none"){
                $(this).html("<i class='icon-arrow-left'></i> 点击显示基站列表");
                $("#selected_stations").css("display","none");
                $("#station_setting_list").css("display","block");
            }
        });
    });
</script>

<div class = "base_center">
    <div style="margin-bottom:10px;width:100%;">
        <font>后台 >> 基站批量设置</font>
    </div>
    
    <form action="/backend/esgconf/batch_setting_process" method="post">
    <input type="hidden" name="station_ids_str" value="<?= $station_ids_str?>" />
    <p id="s_bar">已选基站<span id="setting_datas" class="btn btn-mini" style="float:right;"><i class="icon-arrow-right"></i> 点击查看各基站设置详情</span></p>
    <div id="selected_stations">
        <ul>
            <?php foreach($stations as $station){ ?>
                <li><?= $station['name_chn']?></li>
            <? }?>
        </ul>
    </div>
    <div id="station_setting_list">
        <table class="table table-striped table-bordered table-condensed">
            <tr><th style="width:16%;">站点\参数</th>
                <?php foreach(h_esgconf_array() as $_c => $_esgconf){ 
                    if(h_esgconf_is_dis($_c)) continue;
                    echo "<th>".$_c."</th>";
                } ?>
                <th>最后读取时间</th>
            </tr>
            <?php foreach($stations as $station){ ?>
                <tr>
                    <td><?= $station['name_chn'] ?></td>
                    <?php foreach(h_esgconf_array() as $_c => $_esgconf){ 
                        if(h_esgconf_is_dis($_c)) continue;
                        if($station['esgconf']){
                            echo "<td>".$station['esgconf'][$_esgconf['en']]."</td>";
                        }else{
                            echo "<td></td>";
                        }
                    }
                    if($station['esgconf']){
                        echo "<td>".$station['esgconf']['last_update_time']."</td>";
                    }else{
                        echo "<td></td>";
                    }?>
                </tr>
            <? }?>
        </table>        
    </div>
    <div style="clear:left;height:20px;"></div>
     
    <div id="batch_setting">
        <table>
            <tr><th>变量</th><th>中文名</th><th>数值</th><th>描述</th></tr>
            <?php foreach (h_esgconf_array() as $_c => $_esgconf): ?>
                <tr>
                    <td><?= $_c ?>.<?= $_esgconf['en'] ?></td> 
                    <td><?= $_esgconf['cn'] ?></td>
                    <td><input type="text" name="<?= $_esgconf['en'] ?>" value="" <?= h_esgconf_is_dis($_c) ? 'disabled = "disabled"' : '' ?> /> </td>
                    <td> <?= $_esgconf['desc'] ?> </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    
    <div style="clear:left;text-align:center;">
        <input type="submit" name="submit" value="确认批量设置" />
    </div>   
    </form>
</div>
