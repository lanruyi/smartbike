<style>
    .log_content{width:100%;min-height:200px;}
    .log_content .log_content_menu{width:320px;background:#ECEEF0;display: inline-block}
    .log_content .log_content_space{width:10px;display: inline-block}
    .log_content table{border: 1px solid #B8D4E8;border-collapse: collapse;margin:0;width: 100%;word-wrap: break-word;}
    .log_content table tbody td{border: 1px solid #DDD;border-collapse: collapse;height: 30px;line-height: 16px;text-align: center; border-spacing: 2px;}
</style>

<div class="base_center">
    <div style="margin:0;width:100%">
        <font>后台 >> 基站历史修改记录 </font>
    </div>
    <? $this->load->view("backend/onestation",array('station'=>$station))?>
</div>
<div style="clear:both;height:2px;"></div>
<div class="base_center">
    <h4 style="font-size: 12px;font-weight:bold;clear:both"><?=$title?></h4>
    <div class="log_content">
        <?foreach($station_logs as $station_log){?>
            <div class="log_content_menu">
                <table>
                    <tbody>
                        <tr>
                            <td style="text" colspan="2"><b><?=$station_log['creator_name_chn']?></b> <?=$station_log['create_time']?> </td>
                        </tr>
                        <?foreach(h_station_column_to_name_chn() as $k=>$v){?>
                            <tr>
                                <td width="80px"><?=$v?></td>
                                <td>
                                    <span style="color:green"><?=$station_log['original_content'][$k]?><span>&nbsp;
                                        <?if(isset($station_log['change_content'][$k])){?>
                                            ->&nbsp;<span style='color:red'><?=$station_log['change_content'][$k]?></span>
                                        <?}?>
                                </td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
            </div>
            <div class="log_content_space"></div>
        <?}?>   
    </div>
    <?=$pagination?>
</div>