<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>WebStock</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<?php echo $this->Html->css('/app-assets/plugins/font-awesome/css/font-awesome.min.css'); ?>
<?php echo $this->Html->css('/app-assets/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
<?php echo $this->Html->css('/app-assets/plugins/bootstrap/css/bootstrap.min.css'); ?>
<?php echo $this->Html->css('/app-assets/plugins/uniform/css/uniform.default.css'); ?>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<?php echo $this->Html->css('/assets/admin/pages/css/lock2.css'); ?>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<?php echo $this->Html->css('/app-assets/css/components.css'); ?>
<?php echo $this->Html->css('/app-assets/css/plugins.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/layout.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/themes/default.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/custom.css'); ?>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?php echo $this->webroot ?>favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
<div class="page-lock">
	<div class="page-logo">
		<a class="brand" href="#">
			<img src="<?php echo $this->Html->url('/assets/admin/layout/img/WebStock.png'); ?>" alt="logo" style="width: 20%" />
		</a>
	</div>
	<div class="page-body">
		<?php if (isset($SessionInfo['User']['avatar']) AND file_exists(WWW_ROOT.'/uploads/avatar/user/'.$SessionInfo['User']['avatar'])): ?>
			<img alt="<?php echo $this->Session->Read('Auth.User.nom') ?> <?php echo $this->Session->Read('Auth.User.prenom') ?>" class="page-lock-img" src="<?php echo $this->Html->url('/uploads/avatar/user/'.$SessionInfo['User']['avatar']) ?>"/>
		<?php else: ?>		
			<img alt="" class="page-lock-img" src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>"/>
		<?php endif ?>
		<div class="page-lock-info">
			<h1><?php echo $this->Session->Read('Auth.User.nom') ?> <?php echo $this->Session->Read('Auth.User.prenom') ?></h1>
			<span class="email">
			<?php echo $this->Session->Read('Auth.User.email') ?> </span>
			<span class="locked">
			Verrouillé </span>
			<div style="color: #B22020">
				<?php echo $this->Session->flash(); ?>
			</div>
			<?php echo $this->Form->create('User') ?>
				<div class="input-group input-medium">
				<?php echo $this->Form->hidden('username',array('value' => $this->Session->read('Auth.User.username'))) ?>
				<?php echo $this->Form->input('password',array('label' => false,'class' => 'form-control','placeholder' => 'Mot de passe','div' => false)) ?>
					<span class="input-group-btn">
					<button type="submit" class="btn blue icn-only"><i class="m-icon-swapright m-icon-white"></i></button>
					</span>
				</div>
				<!-- /input-group -->
				<div class="relogin">
					<?php echo $this->Html->link('Changer d\'utilisateur',array('controller' => 'users','action' => 'logout')) ?>
				</div>
			<?php echo $this->Form->end() ?>
		</div>
	</div>
	<div class="page-footer-custom">
		2017-<?php echo date('Y') ?> &copy; WebStock
	</div>
</div>
<?php echo $this->Html->script('/app-assets/plugins/jquery.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-migrate.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap/js/bootstrap.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery.blockui.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/uniform/jquery.uniform.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery.cokie.min.js') ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php echo $this->Html->script('/app-assets/plugins/backstretch/jquery.backstretch.min.js') ?>
<!-- END PAGE LEVEL PLUGINS -->
<?php echo $this->Html->script('/app-assets/scripts/metronic.js') ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js') ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js') ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/lock.js') ?>
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
    Lock.init();
    Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>