<div style="clear:both"></div>
<div style="width:100%;margin:0 0 18px 0; padding:4px 0; background-color:#507aaa;">
<div class=base_center>

<div style="float:left; width:100%;">

    <li style="color:#fff;padding:2px;font-size:12px;border-top:">
        <b>基础数据</b>
            <? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_STATION_DATA)){ ?>	
              <a class="btn btn-mini" href="/backend/station"> 基站 </a>
              <a class="btn btn-mini" href="/backend/esg"> esg </a>
              <a class="btn btn-mini" href="/backend/bug"> 故障 </a>
              <a class="btn btn-mini" href="/backend/bug/config"> 故障设置 </a>
              <a class="btn btn-mini" href="/backend/command"> 命令 </a>
              <a class="btn btn-mini" href="/backend/esgconf"> 设置 </a>
              <a class="btn btn-mini" href="/backend/rom_update/rlist"> rom升级 </a>
              <a class="btn btn-mini" href="/backend/blog/alist"> 维护日志 </a>
              <a class="btn btn-mini" href="/backend/esgfix"> 维修信息 </a>
              <a class="btn btn-mini" href="/backend/t_fandaydata"> 开关时间 </a>
            <?}?>
            <b>小工具</b>
              
              <a class="btn btn-mini" href="/backend/restart/station_list"> 重启统计</a>
              <a class="btn btn-mini" href="/backend/edge"> 边界 </a>
              <a class="btn btn-mini" href="/backend/bug/colds_out_ctrl"> 空调故障计算 </a>
              <a class="btn btn-mini" href="/backend/update_log"> <font color = "red">更新日志 </font></a>
    </li>
    <? if(h_auth_check_role($this->user_role,ESC_AUTHORITY__BACKEND_ADMINISTRATOR)){ ?>
    <li style="color:#fff;padding:2px;font-size:12px;border-top:">
        <b>系统设置</b>
            <a class="btn btn-mini" href="/backend/contract"> 合同 </a>
            <a class="btn btn-mini" href="/backend/batch"> 批次 </a>
            <a class="btn btn-mini" href="/backend/area"> 地区 </a>
            <a class="btn btn-mini" href="/backend/rom"> rom </a>
            <a class="btn btn-mini" href="/backend/cmail"> 邮件 </a>
            <a class="btn btn-mini" href="/backend/user"> 用户 </a>
            <a class="btn btn-mini" href="/backend/role"> 角色 </a>
            <a class="btn btn-mini" href="/backend/department"> 部门 </a>
            <a class="btn btn-mini" href="/backend/project"> 项目 </a>
            <a class="btn btn-mini" href="/backend/prjconfig"> 项目设置 </a>
            <a class="btn btn-mini" href="/backend/home/server_info"> php探针 </a>
            <a class="btn btn-mini" href="/backend/home/apc_info"> APC </a>
            <a class="btn btn-mini" href="/backend/home/onebridge"> DEBUG </a>
    </li>
    <?}?>
</div>

<div class="base_center">
    <? $this->load->view('templates/notice');?>
</div>

<div style="clear:both"></div>
</div>
</div>
