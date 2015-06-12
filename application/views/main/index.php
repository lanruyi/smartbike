
<style>
.main_choose {width:720px;margin:0 auto;margin-top:20px}
.main_choose ul{float:left;}
.main_choose ul>li{list-style:none;margin:4px 0; }
.main_choose ul>li.choose_split{text-align:center;background-color:#fff;color:#666 ;}
.main_choose ul>li>a{display:block;width:184px;font-size:16px;height:36px;line-height:36px;
                    text-align:center;background-color:#369;color:#fff;border-right:3px solid #da7}
.main_choose ul>li>a.no_right{background-color:#999;color:#fff}
.main_choose ul>li>a:hover.no_right {background-color:#ccc}
.main_choose ul>li>a:hover {background-color:#69f}
</style>

<div class="base_center">
    <div class='main_choose'> 
        <ul>  
            <li class='choose_split'>客户</li>
            <li><a <?= $frontend_right? "href='/frontend'" :"class='no_right'"?>>前端系统</a> </li>

            <li class='choose_split'>统计 分析</li>
            <li><a href='/statistic'>项目统计</a> </li>
            <li><a <?= $analysis_right? "href='/analysis'" :"class='no_right'"?>>数据分析</a> </li>
            <li><a <?= $reporting_system?  "href='/reporting'"  :"class='no_right'"?>>结算报表</a> </li>

            <li class='choose_split'>生产 工程</li>
            <li><a <?= $aging_right?    "href='/aging'"    :"class='no_right'"?>>老化系统</a> </li>
            <li><a <?= $setup_right?    "href='/setup'"    :"class='no_right'"?>>装站维修系统</a> </li>


            <li class='choose_split'>后端 </li>
            <li><a <?= $backend_right?  "href='/backend'"  :"class='no_right'"?>>系统管理</a> </li>

            <li class='choose_split'>支撑系统</li>
            <li><a <?= $maintain_right? "href='/maintain'" :"class='no_right'"?>>故障统计</a> </li>
            <li><a href='http://wo.semos-cloud.com:2000' > 故障处理</a> </li>
            <li><a href='http://gk.semos-cloud.com:2000' > 工堪工程</a> </li>
            <li class='choose_split'>其他系统</li>
            <li><a <?= $backend_right?  "href='/newback/station'"  :"class='no_right'"?>>节能新后端(开发中)</a> </li>
            <li><a href='http://to.semos-cloud.com:8988' > 协议接入系统  </a> </li>
        </ul>  
        <ul style='width:200px;margin-left:60px;'>  
            <br />
            您好！<b><?= $this->curr_user['name_chn'] ?></b>
            <br />
            您是 <b><?= $this->user_role['name_chn'] ?></b>
            <br />
            <br />
            欢迎使用节能云系统: 
            <br />
            <br />
            本系统按不同的使用者用途分成了十个子系统，
            请<a href="javascript:void(0)" title="点击右侧">选择</a>您需要的系统
            <br/>
            <br/>
            注:灰色按钮代表
            您没有该系统的使用权限 
            如有问题
            请联系管理员
            chuanqi.zheng@airborne-es.com
            <br/>
        </ul>  
        <ul style='width:200px;margin-left:60px;'>  
            <br />
            <b>前端系统</b>：展示某项目或某地区的基站整体节能情况，可以分基站分时间查看，可打印报表
            <br />
            <br />
            <b>老化系统</b>：产品老化 老化数据分析 返修及出库产品管理
            <br />
            <br />
            <b>装站维修系统</b>：现场新装站 现场维修 安装及其维修指南 日志等
            <br/>
            <br/>
            <b>结算报表</b>：节能核算报表
            <br/>
            <br/>
            <b>故障统计</b>：运行中基站故障统计 
            <br/>
            <br/>
            <b>数据分析</b>：数据分析对比
            <br/>
            <br/>
            <b>系统管理</b>：系统及原始数据维护管理
        </ul>  
    </div>  
</div>
