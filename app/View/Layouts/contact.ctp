<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Hotel</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <?php echo $this->Html->css('/app-assets/plugins/google-font/Open+Sans-400-300-600-700.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/font-awesome/css/font-awesome.min.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/bootstrap/css/bootstrap.min.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/uniform/css/uniform.default.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/bootstrap-toastr/toastr.min.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/bootstrap-datepicker/css/datepicker3.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/bootstrap-select/bootstrap-select.min.css'); ?>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <?php echo $this->Html->css('/app-assets/css/components.css'); ?>
    <?php echo $this->Html->css('/app-assets/css/plugins.css'); ?>
    <?php echo $this->Html->css('/assets/admin/layout/css/layout.css'); ?>
    <?php echo $this->Html->css('/assets/admin/layout/css/custom.css'); ?>
    <?php echo $this->Html->css('/assets/admin/layout/css/themes/default.css'); ?>

    <link href="" rel="stylesheet" type="text/css"/>

    <?php echo $this->fetch('css'); ?>

    <?php echo $this->Html->css('/css/style.css'); ?>
    <style type="text/css">
        @media (min-width: 992px) {
            .page-content-wrapper .page-content{
                margin-left:0px;
            }
        }
    </style>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="<?php echo $this->webroot ?>favicon.ico"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-sidebar-closed-hide-logo" >
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="<?php echo $this->Html->url('/') ?>">
                    <img src="<?php echo $this->Html->url('/assets/admin/layout/img/logo-mini.png') ?>" alt="logo" class="logo-default"/>
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
            <div class="page-top">
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-user">
                            <a href="<?php echo $this->Html->url(['controller'=>'users','action'=>'login']) ?>" class="dropdown-toggle"> Se connectez </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="hr"></div>
    <div class="page-content-wrapper">
        <div class="page-content" style="margin-left:0px;">
            <div class="hr"></div>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner">
            2017 &copy; Hotel.
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <?php echo $this->Html->script('/app-assets/plugins/jquery.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/jquery-migrate.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap/js/bootstrap.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/jquery.blockui.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/jquery.cokie.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/uniform/jquery.uniform.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap-toastr/toastr.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.fr.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootstrap-select/bootstrap-select.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/plugins/bootbox/bootbox.min.js'); ?>
    <?php echo $this->Html->script('/app-assets/scripts/metronic.js'); ?>
    <?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>
    <?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js'); ?>
    <?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js'); ?>
    <?php echo $this->fetch('js') ?>
    </body>
    </html>