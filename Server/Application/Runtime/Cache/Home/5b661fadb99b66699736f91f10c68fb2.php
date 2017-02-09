<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>LoveInn Admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- ZUI 标准版压缩后的 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/zui/1.5.0/css/zui.min.css">

    <link rel="stylesheet" type="text/css" href="/LoveInn/Public/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/LoveInn/Public/lib/font-awesome/css/font-awesome.min.css">

    <script src="/LoveInn/Public/lib/jquery-1.11.1.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="/LoveInn/Public/stylesheets/theme.css">
    <link rel="stylesheet" type="text/css" href="/LoveInn/Public/stylesheets/premium.css">

</head>
<body class=" theme-blue">

<!-- Demo page code -->

<script type="text/javascript">
    $(function () {
        var match = document.cookie.match(new RegExp('color=([^;]+)'));
        if (match) var color = match[1];
        if (color) {
            $('body').removeClass(function (index, css) {
                return (css.match(/\btheme-\S+/g) || []).join(' ')
            })
            $('body').addClass('theme-' + color);
        }

        $('[data-popover="true"]').popover({html: true});

    });
</script>
<style type="text/css">
    #line-chart {
        height: 300px;
        width: 800px;
        margin: 0px auto;
        margin-top: 1em;
    }

    .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover {
        color: #fff;
    }
</style>

<script type="text/javascript">
    $(function () {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="../assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">


<!--[if lt IE 7 ]>
<body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]>
<body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]>
<body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<!--<![endif]-->

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="" href="index.html"><span class="navbar-brand"><span
                class="fa fa-paper-plane"></span> LoveInn后台管理</span></a>
    </div>

    <div class="navbar-collapse collapse" style="height: 1px;">
        <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="btn-group">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small"
                          style="position:relative;top: 3px;"></span> <?php echo ($name); ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <?php if($power == 0 ): ?><li><a href="<?php echo U('/Home/Index/order');?>"></a></li>
                        <?php else: ?>
                        <li><a href="<?php echo U('/Home/Index/a_myinfo');?>">我的资料</a></li><?php endif; ?>
                    <li class="divider"></li>
                    <li><a tabindex="-1" href="<?php echo U('/Home/Index/quitlogin');?>">退出</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>
<div class="copyrights">Collect from <a href="http://www.cssmoban.com/" title="WEBSHOP">WEBSHOP</a></div>

<div class="sidebar-nav">
    <ul>
        <li><a href="#" data-target=".dashboard-menu" class="nav-header" data-toggle="collapse"><i
                class="fa fa-fw fa-dashboard"></i>LoveInn后台<i class="fa fa-collapse"></i></a>
        </li>
        <li>
            <ul class="dashboard-menu nav nav-list collapse in">
                <li><a href="<?php echo U('/Home/Index/index');?>"><span class="fa fa-caret-right"></span>后台首页</a></li>
            </ul>
        </li>
        <!--判断用户权限 0为管理员, 1为组织者-->
        <?php if($power == 0): ?><li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".room-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>活动管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="room-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/categorys');?>"><span class="fa fa-caret-right"></span>活动分类</a></li>
                    <li><a href="<?php echo U('/Home/Index/activities');?>"><span class="fa fa-caret-right"></span>活动列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/applies');?>"><span class="fa fa-caret-right"></span>报名管理</a></li>
                </ul>
            </li>
            <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".premium-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>志愿者管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="premium-menu nav nav-list collapse in">
                    <li class="visible-xs visible-sm"><a href="#">- Premium features require a license -</a>
                    <li><a href="<?php echo U('/Home/Index/volunteers');?>"><span class="fa fa-caret-right"></span>志愿者列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/volunteers_auth');?>"><span class="fa fa-caret-right"></span>待审核列表</a></li>
                </ul>
            </li>

            <li><a href="#" data-target=".accounts-menu" class="nav-header" data-toggle="collapse"><i
                    class="fa fa-fw fa-briefcase"></i>组织者管理<span class="label label-info">+3</span></a></li>
            <li>
                <ul class="accounts-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/agencys');?>"><span class="fa fa-caret-right"></span>组织者列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/agencys_auth');?>"><span class="fa fa-caret-right"></span>待审核列表</a></li>
                </ul>
            </li>

            <li><a href="#" data-target=".legal-menu" class="nav-header" data-toggle="collapse"><i
                    class="fa fa-fw fa-legal"></i>管理员管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="legal-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/admins');?>"><span class="fa fa-caret-right"></span>管理员列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/addadmin');?>"><span class="fa fa-caret-right"></span>新增管理员</a></li>
                </ul>
            </li>
            <!--为组织者登录-->
            <?php else: ?>
            <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".room-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>活动管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="room-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/a_activities');?>"><span class="fa fa-caret-right"></span>活动列表</a></li>
                </ul>
            </li>

            <li><a href="#" data-target=".accounts-menu" class="nav-header" data-toggle="collapse"><i
                    class="fa fa-fw fa-briefcase"></i>个人管理<span class="label label-info">+3</span></a></li>
            <li>
                <ul class="accounts-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/a_password');?>"><span class="fa fa-caret-right"></span>修改密码</a></li>
                    <li><a href="<?php echo U('/Home/Index/a_myinfo');?>"><span class="fa fa-caret-right"></span>我的资料</a></li>
                </ul>
            </li><?php endif; ?>

        <li><a href="#" class="nav-header"><i class="fa fa-fw fa-question-circle"></i>帮助</a></li>
    </ul>
</div>


<div class="content">
    <div class="main-content">

        
        <h2><?php echo ($activity_name); ?></h2>
<h3 class="header-dividing">活动报名列表</h3>
<h4>待审核<?php echo (count($list)); ?>人</h4>
<table class="table datatable" id="datatable">
    <thead>
    <tr>
        <th>#</th>
        <th>用户姓名</th>
        <th>用户帐号</th>
        <th>报名时间</th>
        <th>用户爱心币</th>
        <!--<th class="sort-disabled">操作</th>-->
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr id="<?php echo ($vo["id"]); ?>">
            <td><?php echo ($k); ?><input type="text" hidden value="<?php echo ($vo["id"]); ?>" class="hide_input"></td>
            <td><?php echo ($vo["user_realname"]); ?></td>
            <td><?php echo ($vo["user_name"]); ?></td>
            <td><?php echo ($vo["time"]); ?></td>
            <td><?php echo ($vo["user_money"]); ?></td>
            <!--<td>-->
                <!--<a href="<?php echo U("/Home/Index/a_apply_success?id=$vo[id]");?>" type="button" class="btn btn-success">通过</a>-->
                <!--<a href="<?php echo U("/Home/Index/a_apply_deny?id=$vo[id]");?>" type="button" class="btn btn-danger">拒绝</a>-->
            <!--</td>-->
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>
<div>
    <button class="btn btn-success" id="success_many">批量通过</button>&nbsp;&nbsp;
    <button class="btn btn-danger" id="deny_many">批量拒绝</button>
</div>
<br>
<h4>已通过<?php echo (count($list_join)); ?>人</h4>
<table class="table datatable" id="datatable_true">
    <thead>
    <tr>
        <th>#</th>
        <th>用户姓名</th>
        <th>用户帐号</th>
        <th>报名时间</th>
        <th>用户爱心币</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($list_join)): $k = 0; $__LIST__ = $list_join;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr id="<?php echo ($vo["id"]); ?>">
            <td><?php echo ($k); ?></td>
            <td><?php echo ($vo["user_realname"]); ?></td>
            <td><?php echo ($vo["user_name"]); ?></td>
            <td><?php echo ($vo["time"]); ?></td>
            <td><?php echo ($vo["user_money"]); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>

<script src="//cdn.bootcss.com/zui/1.5.0/js/zui.min.js"></script>
<link rel="stylesheet" href="/LoveInn/Public/lib/datatable/zui.datatable.min.css">
<script src="/LoveInn/Public/lib/datatable/zui.datatable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').datatable({
            sortable: true,
            checkable: true,
        });

        $('#datatable_true').datatable({
            sortable: true,
        });

        // 批量通过
        $("#success_many").on('click', function() {
            // 获取数据表格实例对象
            var myDatatable = $('#datatable').data('zui.datatable');

            // 获取行选中数据
            var checksStatus = myDatatable.checks;
            if(!checksStatus) {
                alert('请选择至少一行');
                return;
            }
            var checksArray = checksStatus.checks;
            if(checksArray.length == 0) {
                alert('请选择至少一行');
                return;
            }
            // 发送选中的行id, 即apply id
            var postdata = {
                ids: checksArray
            };
            $.ajax({
                url: '<?php echo U("/Home/Index/a_apply_success_many");?>',
                method: "POST",
                data: postdata,
            }).done(function(dataget) {
                console.log(dataget);
                if(dataget == 1) {
                    alert('通过成功');
                    location.reload();
                }
                if(dataget == 0) {
                    alert('通过失败, 请稍后重试');
                }
            }).fail(function() {
                alert('请求失败, 请稍后重试');
            })

        });

        // 批量拒绝
        $("#deny_many").on('click', function() {
            // 获取数据表格实例对象
            var myDatatable = $('#datatable').data('zui.datatable');

            // 获取行选中数据
            var checksStatus = myDatatable.checks;
            if(!checksStatus) {
                alert('请选择至少一行');
                return;
            }
            var checksArray = checksStatus.checks;
            if(checksArray.length == 0) {
                alert('请选择至少一行');
                return;
            }
            // 发送选中的行id, 即apply id
            var postdata = {
                ids: checksArray
            };
            $.ajax({
                url: '<?php echo U("/Home/Index/a_apply_deny_many");?>',
                method: "POST",
                data: postdata,
            }).done(function(dataget) {
                console.log(dataget);
                if(dataget == 1) {
                    alert('拒绝成功');
                    location.reload();
                }
                if(dataget == 0) {
                    alert('拒绝失败, 请稍后重试');
                }
            }).fail(function() {
                alert('请求失败, 请稍后重试');
            })

        });
    });
</script>
        


    </div>
</div>

<!-- ZUI 标准版压缩后的 JavaScript 文件 -->
<script src="//cdn.bootcss.com/zui/1.5.0/js/zui.min.js"></script>

<!--<script src="/LoveInn/Public/lib/bootstrap/js/bootstrap.min.js"></script>-->
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function () {
        $('.demo-cancel-click').click(function () {
            return false;
        });
    });
</script>


</body>
</html>