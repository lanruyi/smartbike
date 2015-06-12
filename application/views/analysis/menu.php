<div class="es_sub_menu">
    <div class="base_center">
        <ul>
          <li class="<?= $this->uri->rsegment(3) == "index"?"active":"" ?>">
            <a href="/analysis">数据分析</a>
          </li>
          <li class="<?= $this->uri->rsegment(2) == "energy_sort"?"active":""?>">
            <a href="/analysis/home/energy_sort">能耗排序 <strong>[新]</strong></a> 
          </li>
          <li class="<?= $this->uri->rsegment(2) == "energy_compare"?"active":""?>">
            <a href="/analysis/home/energy_compare">节能数据分析 <strong>[新]</strong></a>
          </li>
          <li class="<?= $this->uri->rsegment(2) == "optional_energy_compare"?"active":""?>">
            <a href="/analysis/home/optional_energy_compare">自选节能数据分析 <strong>[新]</strong></a>
          </li>

          <li  class="<?= $this->uri->rsegment(2) == "dc_error"?"active":""?>">
            <a  href="/analysis/home/dc_error">DC负载错误的基站</a>
          </li>
            
          <li>
            <a href="/analysis/home/energy_sav_vs_std">标杆基准能耗对比分析</a>
          </li>
        </ul>
    </div>
</div>
<div style="clear:both;height:4px;"> </div>

<div class="base_center">
    <? $this->load->view('templates/notice');?>
</div>

