<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<style media="screen">
.modal-backdrop {
    display: none;
}
#sidebar {
    width:20%;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="Chrome=1">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Xenon Boostrap Admin Panel" />
    <meta name="author" content="" />
    
    <title>远程数据管理系统</title>

    <link rel="stylesheet" href="http://fonts.useso.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/fonts/linecons/css/linecons.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/bootstrap.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/xenon-core.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/xenon-forms.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/xenon-components.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/xenon-skins.css">
    <link rel="stylesheet" href="__DIR__/../Xenon/assets/css/custom.css">
    <link rel="stylesheet" href="__DIR__/../css/jquery.dataTables.min.css">

    <script src="__DIR__/../Xenon/assets/js/jquery-1.11.1.min.js"></script>
    <script src="__DIR__/../js/jquery.dataTables.min.js"></script>
    <script src="__DIR__/../Xenon/assets/js/datatables/dataTables.bootstrap.js"></script>
</head>
<body class="page-body">

    <div class="settings-pane">
            
        <a href="#" data-toggle="settings-pane" data-animate="true">
            &times;
        </a>
        
        <div class="settings-pane-inner">
            
            <div class="row">
                
                <div class="col-md-4">
                    
                    <div class="user-info">

                        <div class="user-details">
                            <h3>
                                <?php echo '<li>'
                                .Html::beginForm(['site/logout'], 'post')
                                .Html::submitButton(
                                    'Logout ()',
                                    ['class' => 'btn btn-link']
                                )
                                .Html::endForm()
                                .'</li>'
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
            
        <!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
        <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
        <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
        <div class="sidebar-menu fusion-widget-area fusion-content-widget-area side-nav-left" id="sidebar">
            <div class="sidebar-menu-inner">    
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="./?r=site/index" class="logo-expanded">
                            <img src="__DIR__/../Xenon/assets/images/logo2.png" width="80" alt="" />
                        </a>
                        
                        <a href="./?r=site/index" class="logo-collapsed">
                            <img src="__DIR__/../Xenon/assets/images/logo2.png" width="40" alt="" />
                        </a>
                    </div>
                    
                    <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa-bars"></i>
                        </a>
                    </div>
                </header>
                        
                
                        
                <ul id="main-menu" class="main-menu">
                    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                    <li><a href="./?r=site/index">
                            <i class="linecons-cog"></i>
                            <span class="title">产品</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?r=site/client">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="title">客户</span>
                        </a>
                    </li>
                    <li>
                        <a href="./?r=site/purchase">
                            <i class="glyphicon glyphicon-inbox"></i>
                            <span class="title">订单</span>
                        </a>
                        <ul>
                            <li>
                                <a href="./?r=site/purchase">
                                    <span class="title">采购订单</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/order">
                                    <span class="title">销售订单</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/dispatch">
                                    <span class="title">调度订单</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./?r=site/notaccount">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <span class="title">报表管理</span>
                        </a>
                        <ul>
                            <li>
                                <a href="./?r=site/notaccount">
                                    <span class="title">销售未到账</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/notsettlement">
                                    <span class="title">已销账未结算</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/notpay">
                                    <span class="title">已到帐期尚未支付采购清单</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/notpurchasebatchandbill">
                                    <span class="title">采购发票号与批次不全</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/notorderbatchandbill">
                                    <span class="title">销售发票号与批次不全</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/orderinventory">
                                    <span class="title">采购批次库存清单</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/productinventory">
                                    <span class="title">产品库存清单</span>
                                </a>
                            </li>
                            <li>
                                <a href="./?r=site/dispatchlist">
                                    <span class="title">调度报表</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="main-content">
                    
            <!-- User Info, Notifications and Menu Bar -->
            <nav class="navbar user-info-navbar" role="navigation">
                
                <!-- Left links for user info navbar -->
                <ul class="user-info-menu left-links list-inline list-unstyled">
                    
                    <li class="hidden-sm hidden-xs">
                        <a href="#" data-toggle="sidebar">
                            <i class="fa-bars"></i>
                        </a>
                    </li>
                </ul>
                
                
                <!-- Right links for user info navbar -->
                <ul class="user-info-menu right-links list-inline list-unstyled">
                    
                    <li class="dropdown user-profile">
                        <a href="#" data-toggle="dropdown">
                            <img src="__DIR__/../Xenon/assets/images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                            <span>
                                <i class="fa-angle-down"></i>
                            </span>
                        </a>
                        
                        <ul class="dropdown-menu user-profile-menu">
                            <?php echo '<li>'
                            .Html::beginForm(['site/logout'], 'post')
                            .Html::submitButton(
                                isset(Yii::$app->user->identity->username)?
                                'Logout ('.Yii::$app->user->identity->username.')':
                                '请登录',
                                ['class' => 'btn btn-link']
                            )
                            .Html::endForm()
                            .'</li>'
                            ?>
                            <li>
                                <a href="?r=site/manageuser"><button class="btn btn-link">管理登陆账号</button></a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
            </nav>
            <div class="container col-lg-12">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
            <!-- Main Footer -->
            <!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
            <!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
            <!-- Or class "fixed" to  always fix the footer to the end of page -->
            <footer class="main-footer sticky footer-type-1">
                
                <div class="footer-inner">
                
                    <!-- Add your copyright text here -->
                    <div class="footer-text">
                        &copy; 2016
                        <strong>Klein</strong> 
                        More Templates <a href="#" target="_blank" title="毕业设计">毕业设计</a> - Collect from <a href="#/" title="网页模板" target="_blank">Xenon</a>
                    </div>
                    
                    
                    <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                    <div class="go-up">
                    
                        <a href="#" rel="go-top">
                            <i class="fa-angle-up"></i>
                        </a>
                        
                    </div>
                    
                </div>
                
            </footer>
        </div>
        
            
        <!-- start: Chat Section -->
        <div id="chat" class="fixed">
            
            <div class="chat-inner">
            
                
                <h2 class="chat-header">
                    <a href="#" class="chat-close" data-toggle="chat">
                        <i class="fa-plus-circle rotate-45deg"></i>
                    </a>
                    
                    Chat
                    <span class="badge badge-success is-hidden">0</span>
                </h2>
                
                <script type="text/javascript">
                // Here is just a sample how to open chat conversation box
                jQuery(document).ready(function($)
                {
                    var $chat_conversation = $(".chat-conversation");
                    
                    $(".chat-group a").on('click', function(ev)
                    {
                        ev.preventDefault();
                        
                        $chat_conversation.toggleClass('is-open');
                        
                        $(".chat-conversation textarea").trigger('autosize.resize').focus();
                    });
                    
                    $(".conversation-close").on('click', function(ev)
                    {
                        ev.preventDefault();
                        $chat_conversation.removeClass('is-open');
                    });
                });
                </script>
            </div>
        </div>
        <!-- end: Chat Section -->
        
        
    </div>
    <!-- Bottom Scripts -->
    <script src="__DIR__/../Xenon/assets/js/bootstrap.min.js"></script>
    <script src="__DIR__/../Xenon/assets/js/TweenMax.min.js"></script>
    <script src="__DIR__/../Xenon/assets/js/resizeable.js"></script>
    <script src="__DIR__/../Xenon/assets/js/joinable.js"></script>
    <script src="__DIR__/../Xenon/assets/js/xenon-api.js"></script>
    <script src="__DIR__/../Xenon/assets/js/xenon-toggles.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="__DIR__/../Xenon/assets/js/xenon-custom.js"></script>

</body>
</html>