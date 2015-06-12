      
      <!-- BEGIN SIDEBAR -->
      <div class="page-sidebar navbar-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->        
         <ul class="page-sidebar-menu">
            <li>
               <form class="search-form search-form-sidebar" role="form">
                  <div class="input-icon right">
                     <i class="icon-search"></i>
                     <input type="text" class="form-control input-medium input-sm" placeholder="Search...">
                  </div>
               </form>
            </li>
            <li>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
               <div class="sidebar-toggler"></div>
               <div class="clearfix"></div>
               <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="<?= $this->uri->rsegment(1) == "home"?"start active":"" ?>">
               <a href="/newback/home">
               <i class="icon-dashboard"></i> 
               <span class="title">仪表盘</span>
               <span class="selected"></span>
               </a>
            </li>
            <li class="<?= $this->uri->rsegment(1) == "station"?"start active":"" ?>">
               <a href="/newback/station">
               <i class="icon-home"></i> 
               <span class="title">基站管理</span>
               <span class="selected"></span>
               </a>
            </li>
            <li class="<?= $this->uri->rsegment(1) == "basedata"?"start active":"" ?>">
               <a href="javascript:;">
               <i class="icon-cogs"></i> 
               <span class="title">基础数据</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li  class="<?= $this->uri->rsegment(2) == "project_and_city"?"active":"" ?>">
                     <a href="/newback/basedata/project_and_city">
                     城市&项目</a>
                  </li>
                  <li  class="<?= $this->uri->rsegment(2) == "appdata"?"active":"" ?>">
                     <a href="/newback/basedata/appdata">
                     移动端数据</a>
                  </li>
                  <li >
                     <a href="/newback/basedata/batch">
                     合同&批次</a>
                  </li>
                  <li >
                     <a href="/newback/basedata/rom">
                     固件&升级</a>
                  </li>
               </ul>
            </li>
            <li class="<?= $this->uri->rsegment(1) == "stati"?"start active":"" ?>">
               <a href="javascript:;">
               <i class="icon-bar-chart"></i> 
               <span class="title"> 统&nbsp;&nbsp;&nbsp;&nbsp;计 </span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="/newback/stati/system">
                     基本统计</a>
                  </li>
                  <li >
                     <a href="/newback/stati/contract">
                     合同统计</a>
                  </li>
               </ul>
            </li>
            <li class="">
               <a href="javascript:;">
               <i class="icon-warning-sign"></i> 
               <span class="title">故障&告警</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="">
                     总体故障</a>
                  <li >
                     <a href="">
                     故障历史</a>
                  </li>
                  <li >
                     <a href="">
                     <span class="badge badge-important">new</span>故障统计</a>
                  </li>
               </ul>
            </li>
            <li class="">
               <a href="javascript:;">
               <i class="icon-bolt"></i> 
               <span class="title">能 耗</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="">
                     能耗分析</a>
                  </li>
               </ul>
            </li>
            <li class="">
               <a href="javascript:;">
               <i class="icon-file-text"></i> 
               <span class="title">结算用报表</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="">江苏方式</a>
                  </li>
                  <li >
                     <a href="">
                     <span class="badge badge-warning badge-roundless">new</span>云南方式</a>
                  </li>
               </ul>
            </li>
            <li class="">
               <a href="javascript:;">
               <i class="icon-fire"></i> 
               <span class="title">老化系统</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="">
                     老化列表</a>
                  </li>
               </ul>
            </li>
            <li class="<?= $this->uri->rsegment(1) == "inspection"?"start active":"" ?>">
               <a href="javascript:;">
               <i class="icon-pencil"></i> 
               <span class="title">巡检</span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="/newback/inspection/slist">
                     站点列表</a>
                  </li>
               </ul>
            </li>
           
            <li class="last ">
               <a href="login.html">
               <i class="icon-user"></i> 
               <span class="title"> 用 户 </span>
               <span class="arrow "></span>
               </a>
               <ul class="sub-menu">
                  <li >
                     <a href="maps_google.html">
                     新建基站</a>
                  </li>
                  <li >
                     <a href="maps_vector.html">
                     工勘站点</a>
                  </li>
               </ul>
            </li>
         </ul>
         <!-- END SIDEBAR MENU -->
      </div>
      <!-- END SIDEBAR -->

