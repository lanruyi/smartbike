<div class=base_center>

<style>
    .ur_all{float:left;width:985px;border:1px solid #666;}
    .ur_head{float:left;width:100%;height:25px;padding:0;margin:0;}
    .ur_body{float:left;width:100%;height:32px;padding:0;margin:0;background-color:#6c6}
    .ur_all ul{float:left;height:25px;line-height:25px;padding:2px 12px;margin:0;}
    .ur_head ul.active{float:left;background-color:#8d8;font-weight:bold}
    .ur_body ul{float:left;height:32px;line-height:32px;}
</style>


<div><?= $pagination ?></div>
<?foreach($rom_updates as $current_rom_update){?>

<div style="float:left;width:985px;border:1px solid #666;margin-bottom:4px;padding-left:20px;
        background:url(<?= h_online_gif_new($current_rom_update['station']['alive'])?>) 0px 0px no-repeat;">
    <a href="/backend/station/slist?station_ids=<?= $current_rom_update['station']['id']?>"> 
         <?= $current_rom_update['station']['name_chn']?>
    </a>
</div>

<div class='ur_all'>
    <div class='ur_head'>
        <ul class="">
            <li class="icon icon-ok"></li>
            开始更新rom &nbsp; <b style="font-size:15px"><?= $current_rom_update['new_rom']['version']?></b>
        </ul>
        <ul class="<?= (1==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(1,$current_rom_update['status'])?>
            已发送更新请求 
        </ul>
        <ul class="<?= (2==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(2,$current_rom_update['status'])?>
            正在更新中
        </ul>
        <ul class="<?= (3==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(3,$current_rom_update['status'])?>
            等待测试结果
        </ul>
        <ul class="<?= (4==$current_rom_update['status'])?"active":"" ?>">
            <?= get_process_status_icon(4,$current_rom_update['status'])?>
            已发送确认
        </ul>
        <ul>
            <a href="/backend/rom_update/reset_update_rom?station_id=<?= $current_rom_update['station']['id']?>"> 
                手动强制结束本次更新(有问题的话) 
            </a>
        </ul>
    </div>

    <div class='ur_body'>
    <ul>
        花去时间 [<?= h_last_time($current_rom_update['start_time'])?>]
    </ul>

    <?if($current_rom_update['status'] == 1):?>
        <ul>
        即将更新固件：<?= $current_rom_update['new_rom']['version']?>
        等待ESG智能网关接受命令... (此过程1到2分钟)
        </ul>
    <? endif ?>


    <?if($current_rom_update['status'] == 2){?>
        <ul>
            更新 <?= $current_rom_update['new_rom']['version'] ?>
            固件进度：<?= $current_rom_update['update_percent']?> %
        </ul>
        <ul style="padding-top:8px">
            <div class="progress progress-striped active" style="width:420px">
            <div class="bar" style="width:<?= $current_rom_update['update_percent']?>%;"></div>
            </div>
        </ul>
    <?}?>

    <?if($current_rom_update['status'] == 3){?>
        <ul>
            确认固件：<?= $current_rom_update['new_rom']['version'] ?>
            请在20分钟时间内确认 若确定正常工作 请按确认更新按钮 此过程会自动执行 手欠也可以
            <a href="/backend/rom_update/urcsent_update_rom?station_id=<?= $current_rom_update['station']['id']?>"> >>> 手动确认更新 </a>
             
        </ul>
    <?}?>

    <?if($current_rom_update['status'] == 4){?>
        <ul>
            已发出确认消息 确认urc已被开发版执行 即可关闭 此过程会自动执行 手欠也可以
            <a href="/backend/rom_update/confirm_update_rom?station_id=<?= $current_rom_update['station']['id']?>"> >>> 手动确认关闭 </a>
        </ul>
    <?}?>

    </div>
</div>
<div style="clear:both;height:10px;"> </div>
<?}?>
<div><?= $pagination ?></div>

</div>
