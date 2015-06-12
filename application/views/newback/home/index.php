<?if(0){?> <!-- vim:set filetype=phtml: --> <?}?>
<?if(0){?> <!-- vimjumper ../back_header.php --> <?}?>
<?= $this->load->view('newback/back_header'); ?>

<!-- BEGIN OVERVIEW STATISTIC BARS-->
<div class="row stats-overview-cont">
    <div class="col-xs-3">
        <div class="stats-overview stat-block">
            <div class="display stat ok huge">
                <span class="line-chart">12, 11, 10, 11, 14, 10, 15, 12, 15, 14</span>
                <div class="percent">92.5%</div>
            </div>
            <div class="details">
                <div class="title">基站在线率</div>
                <div class="numbers">2250/2400</div>
            </div>
            <div class="progress">
                <span style="width: 93%;" class="progress-bar progress-bar-info" aria-valuenow="93" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">66% Complete</span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="stats-overview stat-block">
            <div class="display stat good huge">
                <span class="line-chart">2,6,8,12, 11, 15, 16, 11, 16, 11, 10, 3, 7, 8, 12, 19</span>
                <div class="percent">+16%</div>
            </div>
            <div class="details">
                <div class="title">平均节能率</div>
                <div class="numbers">1800</div>
                <div class="progress">
                    <span style="width: 16%;" class="progress-bar progress-bar-warning" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">16% Complete</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="stats-overview stat-block">
            <div class="display stat bad huge">
                <span class="line-chart">2,6,8,11, 14, 11, 12, 13, 15, 12, 9, 5, 11, 12, 15, 9,3</span>
                <div class="percent">+6%</div>
            </div>
            <div class="details">
                <div class="title">故障数目</div>
                <div class="numbers">509</div>
                <div class="progress">
                    <span style="width: 16%;" class="progress-bar progress-bar-success" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">16% Complete</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="stats-overview stat-block">
            <div class="display stat good huge">
                <span class="bar-chart">1,4,9,12, 10, 11, 12, 15, 12, 11, 9, 12, 15, 19, 14, 13, 15</span>
                <div class="percent">+86%</div>
            </div>
            <div class="details">
                <div class="title">工勘数量</div>
                <div class="numbers">1550</div>
                <div class="progress">
                    <span style="width: 56%;" class="progress-bar progress-bar-warning" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">56% Complete</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END OVERVIEW STATISTIC BARS-->

<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="icon-bar-chart"></i>节能量</div>
                <div class="actions">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default btn-sm active">
                            <input type="radio" name="options" class="toggle">New
                        </label>
                        <label class="btn btn-default btn-sm">
                            <input type="radio" name="options" class="toggle">Returning
                        </label>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div id="site_statistics_loading">
                    <img src="/static/assets/img/loading.gif" alt="loading"/>
                </div>
                <div id="site_statistics_content" class="display-none">
                    <div id="site_statistics" class="chart"></div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
    <div class="col-xs-6">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="icon-bell"></i>Notifications</div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="" class="reload"></a>
                    <a href="" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body">
                <!--BEGIN TABS-->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1_1" data-toggle="tab">System</a></li>
                    <li><a href="#tab_1_2" data-toggle="tab">Activities</a></li>
                    <li><a href="#tab_1_3" data-toggle="tab">Recent Users</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_1">
                        <div class="scroller" style="height: 250px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">                        
                                                <i class="icon-bell"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                You have 4 pending tasks.
                                                <span class="label label-sm label-danger ">
                                                    Take action 
                                                    <i class="icon-share-alt"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        Just now
                                    </div>
                                </div>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New version v1.4 just lunched!   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            20 mins
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-danger">                      
                                                <i class="icon-bolt"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                Database server #12 overloaded. Please fix the issue.                      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        24 mins
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        30 mins
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        40 mins
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-warning">                        
                                                <i class="icon-plus"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New user registered.                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        1.5 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">                        
                                                <i class="icon-bell-alt"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                Web server hardware needs to be upgraded. 
                                                <span class="label label-sm label-default ">Overdue</span>             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        2 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">                       
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        3 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-warning">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        5 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        18 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">                       
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        21 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        22 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">                       
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        21 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        22 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">                       
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        21 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        22 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">                       
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        21 hours
                                    </div>
                                </div>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">                        
                                                <i class="icon-bullhorn"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                New order received. Please take care of it.                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        22 hours
                                    </div>
                                </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_2">
                        <div class="scroller" style="height: 250px;" data-always-visible="1" data-rail-visible1="1">
                            <ul class="feeds">
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New order received 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            10 mins
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-danger">                      
                                                <i class="icon-bolt"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                Order #24DOP4 has been rejected.    
                                                <span class="label label-sm label-danger ">Take action <i class="icon-share-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date">
                                        24 mins
                                    </div>
                                </div>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                                <li>
                                <a href="#">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">                        
                                                    <i class="icon-bell"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc">
                                                    New user registered
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date">
                                            Just now
                                        </div>
                                    </div>
                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_3">
                        <div class="scroller" style="height: 250px;" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Robert Nilson</a> 
                                            <span class="label label-sm label-success label-sm">Approved</span>
                                        </div>
                                        <div>29 Jan 2013 10:45AM</div>
                                    </div>
                                </div>
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Lisa Miller</a> 
                                            <span class="label label-sm label-info">Pending</span>
                                        </div>
                                        <div>19 Jan 2013 10:45AM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Eric Kim</a> 
                                            <span class="label label-sm label-info">Pending</span>
                                        </div>
                                        <div>19 Jan 2013 12:45PM</div>
                                    </div>
                                </div>
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Lisa Miller</a> 
                                            <span class="label label-sm label-danger">In progress</span>
                                        </div>
                                        <div>19 Jan 2013 11:55PM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Eric Kim</a> 
                                            <span class="label label-sm label-info">Pending</span>
                                        </div>
                                        <div>19 Jan 2013 12:45PM</div>
                                    </div>
                                </div>
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Lisa Miller</a> 
                                            <span class="label label-sm label-danger">In progress</span>
                                        </div>
                                        <div>19 Jan 2013 11:55PM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div><a href="#">Eric Kim</a> <span class="label label-sm label-info">Pending</span></div>
                                        <div>19 Jan 2013 12:45PM</div>
                                    </div>
                                </div>
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Lisa Miller</a> 
                                            <span class="label label-sm label-danger">In progress</span>
                                        </div>
                                        <div>19 Jan 2013 11:55PM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div><a href="#">Eric Kim</a> <span class="label label-sm label-info">Pending</span></div>
                                        <div>19 Jan 2013 12:45PM</div>
                                    </div>
                                </div>
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Lisa Miller</a> 
                                            <span class="label label-sm label-danger">In progress</span>
                                        </div>
                                        <div>19 Jan 2013 11:55PM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Eric Kim</a> 
                                            <span class="label label-sm label-info">Pending</span>
                                        </div>
                                        <div>19 Jan 2013 12:45PM</div>
                                    </div>
                                </div>
                                <div class="col-xs-6 user-info">
                                    <img alt="" src="/static/assets/img/avatar.png" class="img-responsive" />
                                    <div class="details">
                                        <div>
                                            <a href="#">Lisa Miller</a> 
                                            <span class="label label-sm label-danger">In progress</span>
                                        </div>
                                        <div>19 Jan 2013 11:55PM</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END TABS-->
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="icon-bell"></i>Recent Orders</div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            Filter By
                            <i class="icon-angle-down"></i>
                        </a>
                        <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                            <label><input type="checkbox" /> Finance</label>
                            <label><input type="checkbox" checked="" /> Membership</label>
                            <label><input type="checkbox" /> Customer Support</label>
                            <label><input type="checkbox" checked="" /> HR</label>
                            <label><input type="checkbox" /> System</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Contact</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a href="#">Ikea</a>
                            </td>
                            <td>Elis Yong</td>
                            <td>4560.60$ 
                                <span class="label label-warning label-sm">Paid</span>
                            </td>
                            <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#">Apple</a>
                            </td>
                            <td>Daniel Kim</td>
                            <td>360.60$</td>
                            <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#">37Singals</a>
                            </td>
                            <td>Edward Cooper</td>
                            <td>960.50$ 
                                <span class="label label-success label-sm">Pending</span>
                            </td>
                            <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#">Google</a>
                            </td>
                            <td>Paris Simpson</td>
                            <td>1101.60$ 
                                <span class="label label-success label-sm">Pending</span>
                            </td>
                            <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#">Ikea</a>
                            </td>
                            <td>Elis Yong</td>
                            <td>4560.60$ 
                                <span class="label label-warning label-sm">Paid</span>
                            </td>
                            <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#">Google</a>
                            </td>
                            <td>Paris Simpson</td>
                            <td>1101.60$ 
                                <span class="label label-success label-sm">Pending</span>
                            </td>
                            <td><a href="#" class="btn btn-default btn-xs">View</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row ">
    <div class="col-xs-6">
        <!-- BEGIN REGIONAL STATS PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="icon-globe"></i>Regional Stats</div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="" class="reload"></a>
                    <a href="" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body">
                <div id="region_statistics_loading">
                    <img src="/static/assets/img/loading.gif" alt="loading"/>
                </div>
                <div id="region_statistics_content" class="display-none">
                    <div class="btn-toolbar margin-bottom-10">
                        <div class="btn-group" data-toggle="buttons"> 
                            <label class="btn btn-info btn-sm">
                                <input type="radio" name="options" class="toggle">Users
                            </label>
                            <label class="btn btn-info btn-sm">
                                <input type="radio" name="options" class="toggle">Orders
                            </label>
                        </div>
                        <div class="btn-group pull-right">
                            <a href="" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                Select Region <span class="icon-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:;" id="regional_stat_world">World</a></li>
                                <li><a href="javascript:;" id="regional_stat_usa">USA</a></li>
                                <li><a href="javascript:;" id="regional_stat_europe">Europe</a></li>
                                <li><a href="javascript:;" id="regional_stat_russia">Russia</a></li>
                                <li><a href="javascript:;" id="regional_stat_germany">Germany</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="vmap_world" class="vmaps display-none"></div>
                    <div id="vmap_usa" class="vmaps display-none"></div>
                    <div id="vmap_europe" class="vmaps display-none"></div>
                    <div id="vmap_russia" class="vmaps display-none"></div>
                    <div id="vmap_germany" class="vmaps display-none"></div>
                </div>
            </div>
        </div>
        <!-- END REGIONAL STATS PORTLET-->
    </div>
    <div class="col-xs-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="icon-signal"></i>Realtime Server Load</div>
                <div class="actions">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-success btn-sm">
                            <input type="radio" name="options" class="toggle"  >Database
                        </label>
                        <label class="btn btn-success btn-sm">
                            <input type="radio" name="options" class="toggle"  >Web
                        </label>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div id="load_statistics_loading">
                    <img src="/static/assets/img/loading.gif" alt="loading" />
                </div>
                <div id="load_statistics_content" class="display-none">
                    <div id="load_statistics" style="height: 340px;"></div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
<div class="clearfix"></div>
<!-- BEGIN OVERVIEW STATISTIC BLOCKS-->
<div class="row">
    <div class="col-xs-3">
        <div class="circle-stat stat-block">
            <div class="visual">
                <input class="knobify" data-width="115" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="+89" data-max="100" data-min="-100" />
            </div>
            <div class="details">
                <div class="title">Unique Visits <i class="icon-caret-up"></i></div>
                <div class="number">10112</div>
                <span class="label label-success"><i class="icon-map-marker"></i> 123</span>
                <span class="label label-warning"><i class="icon-comment"></i> 3</span>
                <span class="label label-info"><i class="icon-bullhorn"></i> 3</span>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="circle-stat stat-block">
            <div class="visual">
                <input class="knobify" data-width="115" data-fgcolor="#66EE66" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="+19" data-max="100" data-min="-100" />
            </div>
            <div class="details">
                <div class="title">New Users <i class="icon-caret-up"></i></div>
                <div class="number">987</div>
                <span class="label label-danger"><i class="icon-bullhorn"></i> 567</span>
                <span class="label label-default"><i class="icon-plus"></i> 16</span>
            </div>
        </div>
    </div>
    <div class="col-xs-3" data-tablet="span6 fix-margin" data-desktop="span3">
        <div class="circle-stat stat-block">
            <div class="visual">
                <input class="knobify" data-width="115" data-fgcolor="#e23e29" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="-12" data-max="100" data-min="-100" />
            </div>
            <div class="details">
                <div class="title">Downtime <i class="icon-caret-down down"></i></div>
                <div class="number">0.01%</div>
                <span class="label label-info"><i class="icon-bookmark-empty"></i> 23</span>
                <span class="label label-warning"><i class="icon-ok"></i> 31</span>
                <span class="label label-success"><i class="icon-briefcase"></i> 39</span>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="circle-stat stat-block">
            <div class="visual">
                <input class="knobify" data-width="115" data-fgcolor="#fdbb39" data-thickness=".2" data-skin="tron" data-displayprevious="true" value="+58" data-max="100" data-min="-100" />
            </div>
            <div class="details">
                <div class="title">Profit <i class="icon-caret-up"></i></div>
                <div class="number">1120.32$</div>
                <span class="label label-success"><i class="icon-comment"></i> 453</span>
                <span class="label label-default"><i class="icon-globe"></i> 123</span>
            </div>
        </div>
    </div>
</div>
<!-- END OVERVIEW STATISTIC BLOCKS-->
<div class="clearfix"></div>
<div class="row ">
    <div class="col-xs-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet calendar">
            <div class="portlet-title">
                <div class="caption"><i class="icon-calendar"></i>Event Calendar</div>
            </div>
            <div class="portlet-body">
                <div id="calendar"></div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
    <div class="col-xs-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption"><i class="icon-comments"></i>Conversations</div>
                <div class="tools">
                    <a href="" class="collapse"></a>
                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                    <a href="" class="reload"></a>
                    <a href="" class="remove"></a>
                </div>
            </div>
            <div class="portlet-body" id="chats">
                <div class="scroller" style="height: 435px;" data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        <li class="in">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar1.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Bob Nilson</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="out">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar2.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Lisa Wong</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="in">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar1.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Bob Nilson</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="out">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar3.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Richard Doe</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="in">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar3.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Richard Doe</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="out">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar1.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Bob Nilson</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="in">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar3.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Richard Doe</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, 
                                sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </span>
                        </div>
                        </li>
                        <li class="out">
                        <img class="avatar img-responsive" alt="" src="/static/assets/img/avatar1.jpg" />
                        <div class="message">
                            <span class="arrow"></span>
                            <a href="#" class="name">Bob Nilson</a>
                            <span class="datetime">at Jul 25, 2012 11:09</span>
                            <span class="body">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet.
                            </span>
                        </div>
                        </li>
                    </ul>
                </div>
                <div class="chat-form">
                    <div class="input-cont">   
                        <input class="form-control" type="text" placeholder="Type a message here..." />
                    </div>
                    <div class="btn-cont"> 
                        <span class="arrow"></span>
                        <a href="" class="btn btn-primary icn-only"><i class="icon-ok icon-white"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

<!-- vimjumper ../back_footer.php -->
<?= $this->load->view('newback/back_footer'); ?>
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <script src="/static/assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>   
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>  
   <script src="/static/assets/plugins/jquery.peity.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery-knob/js/jquery.knob.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>     
   <script src="/static/assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
   <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
   <script src="/static/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
   <script src="/static/assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>  
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="/static/assets/scripts/app.js" type="text/javascript"></script>
   <script src="/static/assets/scripts/index.js" type="text/javascript"></script>  
   <!-- END PAGE LEVEL SCRIPTS -->  

<script>
      jQuery(document).ready(function() {    
         App.init(); // initlayout and core plugins
         Index.init();
         Index.initJQVMAP(); // init index page's custom scripts
         Index.initCalendar(); // init index page's custom scripts
         Index.initCharts(); // init index page's custom scripts
         Index.initChat();
         Index.initMiniCharts();
         Index.initPeityElements();
         Index.initKnowElements();
         Index.initDashboardDaterange();

         document.onkeydown = function(e){
             if(!e) e=window.event;
             if(e.keyCode==13 || e.which==13){
                 document.getElementById("confirm_s").click();
             }
         }
      });
</script>
   <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
