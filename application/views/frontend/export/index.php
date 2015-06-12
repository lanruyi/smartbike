<style>
.tool_box{padding:10px}
.tool_box ul{padding:5px}
.tool_box ul li {padding:0 70px}
.tool_box h1{padding:5px;font-size:20px;}
.tool_box h3{padding:0px 10px;font-size:14px; font-weight:bold}
.line1{width:100%;border-bottom:2px solid #999;margin-top:20px}
.line3{width:98%;margin-left:1%;border-bottom:1px solid #aaa;margin-top:20px}
</style>

<div class="base_center">

    <div style='clear:both;height:10px'>  </div>
    <div style='clear:both;height:24px;line-height:24px;padding:0 8px;width:980px;border:1px solid #c96'>  
        当前导出数据为csv格式，可以直接用excel软件打开。
    </div>
    
    <div class=tool_box>
    <form action="/frontend/export/save_csv" method="post" id="export">
        <ul class='line1'> <h1> 正在准备为您导出数据 </h1> </ul>

        <ul class='line3'> <h3> 导出基站 </h3> </ul>
            
        <ul> 
            <li>
                <?=$this->lang->line('load')?>:
                <?= h_station_total_load_select($this->input->get('total_load'),""); ?>
            </li>
            <li>
                <?=$this->lang->line('build')?>:
                <?= h_station_building_select($this->input->get('building'),""); ?>
            </li>
        </ul> 

        <ul class='line3'>  <h3> 时间模式 </h3> </ul>

        <ul> 
            <li>
                <input type="radio" name="month_or_free" value="month" id="month_export" checked="checked">
                按月导出(选择月份)
            </li>
            <li>
                <input type="radio" name="month_or_free" value="free" id="free_export">
                自由导出导出(选择起止时间)
            </li>
        </ul>

        <ul class='line3'> <h3> 导出月份 </h3> </ul>
        <ul> 
            <li>
                2013-05
            </li>
        </ul>
            

        <ul class='line3'> <h3> 导出内容 </h3> </ul>
        <ul> 
            <li>
                <input type="radio" name="content_type" value="day_use" id="" checked="checked">
                每天一个能耗数据
            </li>
            <li>
                <input type="radio" name="content_type" value="day_energy" id="">
                每天一个凌晨电表数据
            </li>
            <li>
                <input type="radio" name="content_type" value="month_use" id="">
                每月一个能耗数据 (不受时间影响 导出所有)
            </li>
            <li>
                <input type="radio" name="content_type" value="month_energy" id="">
                每月一个凌晨能耗数据 (不受时间影响 导出所有)
            </li>
        </ul>

        <ul class='line3'></ul>
        <ul> 
            <li>
                <a href="#">点此导出 </a> <font color=#f66>(请申请权限) </font>
                <a href="javascript:document.getElementById('export').submit();"></a> 
            
            </li>
        </ul>
    </form>
    </div>

</div>
