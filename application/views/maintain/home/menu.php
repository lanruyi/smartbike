<div class="es_sub_menu">
    <div class="base_center">
        <ul>
          <li class="<?= $this->uri->rsegment(2) == "detail"?"active":"" ?>">
            <a href="/maintain/home/detail">故障详细</a>
          </li>
          <li class="<?= $this->uri->rsegment(2) == "history"?"active":"" ?>"> 
            <a href="/maintain/home/history">故障历史</a> 
          </li>
          <li class="<?= $this->uri->rsegment(2) == "map"?"active":"" ?>"> 
            <a href="/maintain/home/map">故障地图</a> 
          </li>
          <li class="<?= $this->uri->rsegment(2) == "rinse"?"active":"" ?>"> 
            <a href="/maintain/home/rinse">基站数据清洗</a> 
          </li>
          <li class="<?= $this->uri->rsegment(2) == "uncorrected"?"active":"" ?>">
            <a href="/maintain/home/uncorrected">同步电表问题基站</a> 
          </li>
        </ul>
    </div>
</div>
<div style="clear:both;height:12px;"> </div>
