<style type="text/css">
    .logo{float:left ;height: 40px; line-height: 40px; padding-top: 10px;overflow: hidden;color: #fff;font-size: 30px}
</style>
<div class="es_sub_menu">
    <div class="base_center">
        <div class="logo">
            报表系统
        </div>
        <div style="clear:both;height:3px;overflow:hidden"></div>
        <ul>
          <li class="<?= $this->uri->rsegment(1) == "savpair"?"active":""?>">
            <a href="/reporting/savpair">设定基准节能站对</a> 
          </li> 
          <li class="<?= $this->uri->rsegment(1) == "table"?"active":""?>">
            <a href="/reporting/table">报表列表</a>
          </li>
          <li class="<?= $this->uri->rsegment(1) == "sav_std"?"active":""?>">
            <a href="/reporting/sav_std">设定基准站</a> 
          </li> 
          <li class="<?= $this->uri->rsegment(1) == "stdtable"?"active":""?>">
            <a href="/reporting/stdtable">报表列表</a>
          </li>
          <li class="<?= $this->uri->rsegment(1) == "alltab"?"active":""?>">
            <a href="/reporting/alltab">任意天列表 new</a>
          </li>
        <!--
          <li> 
            <a href="/reporting/home/set_sav_pairs">设定基准节能站对</a> 
          </li> -->
        </ul>
    </div>
</div>
<div style="clear:both;height:12px;"> </div>

