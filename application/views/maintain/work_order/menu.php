<style>
    .maintain_sub_menu{float:left;height:25px;width:1000px;background-color:#fff;}
    .maintain_sub_menu ul{float:left;list-style:none;padding:0;margin:0;}
    .maintain_sub_menu ul li{float:left;list-style:none;padding:0 12px;margin:0 8px 0 0;background-color:#999;
                height:25px;line-height:25px;color:#fff}
    .maintain_sub_menu ul li a{color:#fff;}
    .maintain_sub_menu ul li.active{background-color:#444}
    .maintain_sub_menu ul li.active a{font-weight:bold}
</style>

<div class="base_center" style="height:40px">
<div class = "maintain_sub_menu">
    <ul>
        <li class="<?= $this->uri->rsegment(2) == "prepare_orders"?"active":"" ?>">
            <a href="/maintain/work_order/prepare_orders">需派发工单基站</a>
        </li>
        <li class="<?= $this->uri->rsegment(2) == "new_orders"?"active":"" ?>">
            <a href="/maintain/work_order/new_orders">已派发未确认工单</a>
        </li>
        <li class="<?= $this->uri->rsegment(2) == "confirme_orders"?"active":"" ?>">
            <a href="/maintain/work_order/confirme_orders">已确认未修复工单</a>
        </li>
        <li class="<?= $this->uri->rsegment(2) == "fixed_orders"?"active":"" ?>">
            <a href="/maintain/work_order/fixed_orders">已修复工单</a>
        </li>
        <li class="<?= $this->uri->rsegment(2) == "third_party"?"active":"" ?>">
            <a href="/maintain/work_order/third_party">第三方工单</a>
        </li>
    </ul>
</div>
</div>

