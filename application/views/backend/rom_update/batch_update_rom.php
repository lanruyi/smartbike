<style type="text/css">
    selected_stations{padding-top:20px;}
    #selected_stations ul, #selected_stations li{list-style:none;margin:0}
    #selected_stations li{float:left;} 
    #selected_stations p{padding: 3px 6px; font-weight:bold;background:#3066a6;color:#FFFFFF;border:1px solid #3066a6; text-align:left;}
    #batch_update_rom p select{width:300px;}
</style>

<div class = "base_center">
    <div style="margin-bottom:10px;width:100%;">
        <font>后台 >> 基站批量固件更新</font>
    </div>
    
    <form action="/backend/rom_update/batch_update_rom_process" method="post">
    <div id="selected_stations">
        <p>已选基站</p>
        <ul>
            <?php foreach($stations as $key=>$station){ ?>
                <li style="width:16%;"><?= $station['name_chn']?></li>
                <li style="width:34%;">
                    [当前固件版本: <?= $station['rom']['version']?> ] 
                    [更新状态: <?= $station['current_rom_update']?"更新中":"无"?>] 
                </li>
            <? }?>
        </ul>
    </div>
    <div style="clear:left;height:20px;"></div>

    <div id="batch_update_rom">
        <p>版本选择: 
            <select name="new_rom_id">
                <?php foreach ($roms as $rom){ ?>
                    <option value="<?= $rom['id'] ?>">Name:<?= $rom['version'] ?> Size:<?= $rom['size'] ?></option>
                <? }?>
            </select>
            <input type='hidden' name=station_ids_str value="<?= $station_ids_str?>">
            <input type='hidden' name=backurlstr value="<?= $backurlstr?>">
            <input type="submit" name="submit" value="启动批量固件更新" />
        </p>
    </div>
    </form>
    
</div>
