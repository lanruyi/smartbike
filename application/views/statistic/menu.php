<div class="es_sub_menu">
    <div class="base_center">
        <ul>
            <li class="<?= $this->uri->rsegment(1) == "system"?"active":"" ?>">
                <a href="/statistic/system">系统统计</a>
            </li>
            <li class="<?= $this->uri->rsegment(1) == "contract"?"active":"" ?>">
                <a href="/statistic/contract">合同统计</a>
            </li>
            <li class="<?= $this->uri->rsegment(1) == "saving"?"active":"" ?>">
                <a href="/statistic/saving">节能统计</a>
            </li>
        </ul>
    </div>
</div>
<div style="clear:both;height:12px;"> </div>
<div class="base_center">
    <? $this->load->view('templates/notice');?>
</div>
