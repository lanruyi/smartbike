<div class="es_sub_menu">
    <div class="base_center">
        <ul>
          <li class="<?= $this->uri->rsegment(3) == "index"?"active":"" ?>">
            <a href="/setup">安装维修主页</a>
          </li>
          <li class="<?= $this->uri->rsegment(3) == "station"?"active":"" ?>">
            <a href="/setup/home/station">PC安装基站</a>
          </li>
          <li class="<?//= $this->uri->rsegment(3) == "station"?"active":"" ?>">
            <a href="/setup/home/work_order_maintain">工单维修</a>
        </ul>
    </div>
</div>
<div style="clear:both;height:12px;"> </div>
<div class="base_center">
    <? $this->load->view('templates/notice');?>
</div>
