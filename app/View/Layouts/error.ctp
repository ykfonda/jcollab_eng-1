
<!DOCTYPE html>
<?php $darkmode = ( isset( $SessionInfo['User']['darkmode'] ) AND $SessionInfo['User']['darkmode'] == 'on' ) ? true : false ; ?>
<html class="loading <?php echo ( $darkmode ) ? 'light-layout dark-layout' : 'light-layout' ; ?> loaded" lang="en" data-textdirection="ltr">

	<!-- BEGIN: Head-->
	<head>

	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	    <title>ERROR - JCOLLAB</title>

	    <link rel="apple-touch-icon" href="<?php echo $this->Html->url('/app-assets/images/ico/apple-icon-120.png'); ?>">
	    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->Html->url('/app-assets/images/ico/favicon.ico'); ?>">

	    <?php echo $this->Html->css('/app-assets/fonts/css2.css?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600'); ?>
	    <!-- BEGIN: Vendor CSS-->
	    <?php echo $this->Html->css('/app-assets/vendors/css/vendors.min.css'); ?>
	    <!-- END: Vendor CSS-->

	    <!-- BEGIN: Theme CSS-->
	    <?php echo $this->Html->css('/app-assets/css/bootstrap.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/bootstrap-extended.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/colors.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/components.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/themes/dark-layout.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/themes/bordered-layout.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/themes/semi-dark-layout.css'); ?>
	    <!-- BEGIN: Theme CSS-->

	    <!-- Plugins -->
		<?php echo $this->Html->css('/app-assets/plugins/font-awesome/css/font-awesome.min.css'); ?>
		<?php echo $this->Html->css('/app-assets/plugins/bootstrap-toastr/toastr.min.css'); ?>
		<?php echo $this->Html->css('/app-assets/plugins/bootstrap-select/bootstrap-select.min.css'); ?>
		<?php echo $this->Html->css('/app-assets/plugins/animation/font-awesome-animation.min'); ?>
		<?php echo $this->Html->css('/app-assets/plugins/select2/css/select2.css'); ?>
		<?php echo $this->Html->css('/app-assets/plugins/uniform/css/uniform.default.css'); ?>
		<?php echo $this->Html->css('/app-assets/css/plugins/forms/pickers/form-flat-pickr.min.css'); ?>
	    <!-- Plugins -->

	    <!-- BEGIN: Page CSS-->
	    <?php echo $this->Html->css('/app-assets/css/core/menu/menu-types/vertical-menu.css'); ?>
		<?php echo $this->Html->css('/app-assets/css/global/components-rounded.css'); ?>
		<?php echo $this->Html->css('/app-assets/css/global/plugins.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/style.css'); ?>
	    <!-- END: Page CSS-->

	</head>
	<!-- END: Head-->

	<!-- BEGIN: Body-->
	<!-- Meny type : menu-expanded / menu-collapsed -->
	<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="">

	    <!-- BEGIN: Header-->
	    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-shadow navbar-light">
	        <div class="navbar-container d-flex content">
	        	<!-- bookmarks -->
	            <div class="bookmark-wrapper d-flex align-items-center">


	                <ul class="nav navbar-nav d-xl-none">
	                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
	                </ul>
	                <!-- Stores -->
	                <ul class="nav navbar-nav bookmark-icons">
		                <li class="nav-item dropdown dropdown-notification">
		                	<a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
		                		<i class="fa fa-map-marker"></i> 
		                		<?php echo ( isset( $storesList[0]['Store']['id'] ) AND !empty( $storesList[0]['Store']['id'] ) ) ? $storesList[0]['Societe']['designation'].' : '.$storesList[0]['Store']['libelle'] : '' ; ?>
		                	</a>
		                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
		                        <li class="dropdown-menu-header">
		                            <div class="dropdown-header d-flex">
		                                <h4 class="notification-title mb-0 mr-auto"></h4>
		                                <div class="badge badge-pill badge-light-primary"><?php echo count($storesList) ?></div>
		                            </div>
		                        </li>
		                        <li class="scrollable-container media-list">
		                        	<?php foreach ($storesList as $store): ?>
			                            <a class="d-flex" href="javascript:void(0);">
			                                <div class="media d-flex align-items-start">
			                                    <div class="media-left">
			                                        <div class="avatar bg-light-danger">
			                                            <div class="avatar-content">S</div>
			                                        </div>
			                                    </div>
			                                    <div class="media-body">
			                                    	<p class="media-heading"><?php echo h($store['Societe']['designation']); ?> : <?php echo h($store['Store']['libelle']); ?></p>
				                                    <small class="notification-text">
				                                    	<?php echo h($store['Store']['adresse']); ?>
				                                    </small>
			                                    </div>
			                                </div>
			                            </a>
			                        <?php endforeach ?>
		                        </li>
		                    </ul>
		                </li>
		                <!-- Stores -->
	                </ul>
	            </div>
	        	<!-- bookmarks -->
	            <ul class="nav navbar-nav align-items-center ml-auto">

	                <li class="nav-item d-lg-block">
	                	<a class="nav-link nav-link-style dark-mode"><i class="ficon" data-feather="<?php echo ( $darkmode ) ? 'sun' : 'moon' ; ?>"></i></a>
	                </li>

	                <!-- Notifications -->
	                <li class="nav-item dropdown dropdown-notification mr-25">
	                	<a class="nav-link" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon" data-feather="bell"></i>
	                		<span class="badge badge-pill badge-danger badge-up"><?php echo count($notifications) ?></span>
	                	</a>
	                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
	                        <li class="dropdown-menu-header">
	                            <div class="dropdown-header d-flex">
	                                <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
	                                <div class="badge badge-pill badge-light-primary"><?php echo count($notifications) ?></div>
	                            </div>
	                        </li>
	                        <li class="scrollable-container media-list">
	                        	<?php foreach ($notifications as $notification): ?>
		                            <a class="d-flex" href="<?php echo $this->Html->url(['controller' => 'notifications','action' => 'link', $notification['Notification']['id']]) ?>">
		                                <div class="media d-flex align-items-start">
		                                    <div class="media-left">
		                                        <div class="avatar bg-light-danger">
		                                            <div class="avatar-content">N</div>
		                                        </div>
		                                    </div>
		                                    <div class="media-body">
			                                    <small class="notification-text"><?php echo h($notification['Notification']['message']); ?></small>
		                                    </div>
		                                </div>
		                            </a>
		                        <?php endforeach ?>
	                        </li>
	                        <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block" href="<?php echo $this->Html->url(['controller' => 'notifications','action' => 'index']) ?>">Read all notifications</a></li>
	                    </ul>
	                </li>
	                <!-- Notifications -->

	                <li class="nav-item dropdown dropdown-user">
	                	<a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                        <div class="user-nav d-sm-flex d-none">
	                        	<span class="user-name font-weight-bolder">
	                        		<?php echo (isset($SessionInfo['User']['nom'])) ? $SessionInfo['User']['nom'] : '' ; ?> <?php echo (isset($SessionInfo['User']['prenom'])) ? $SessionInfo['User']['prenom'] : '' ; ?>
	                        	</span>
	                        	<span class="user-status"><?php echo (isset($SessionInfo['Role']['libelle'])) ? $SessionInfo['Role']['libelle'] : '' ; ?></span>
	                        </div>
                        	<span class="avatar">
								<?php if (isset($SessionInfo['User']['avatar']) AND file_exists(WWW_ROOT.'/uploads/avatar/user/'.$SessionInfo['User']['avatar'])): ?>
									<img class="round" src="<?php echo $this->Html->url('/uploads/avatar/user/'.$SessionInfo['User']['avatar']) ?>" alt="avatar" height="40" width="40" />
								<?php else: ?>		
									<img class="round" src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" alt="avatar" height="40" width="40" />
								<?php endif ?>
                        		<span class="avatar-status-online"></span>
                        	</span>
	                    </a>
	                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">

							<a class="dropdown-item" href="<?php echo $this->Html->url(['controller' => 'users', 'action' => 'profil']) ?>"><i class="mr-50" data-feather="user"></i> Profile </a>
							<a class="dropdown-item" href="<?php echo $this->Html->url(['controller' => 'notifications', 'action' => 'index']) ?>"><i class="mr-50" data-feather="bell"></i> Notifications </a>
							<a class="dropdown-item" href="<?php echo $this->Html->url(['controller' => 'alerts', 'action' => 'index']) ?>"><i class="mr-50" data-feather="check-square"></i> Alerts </a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo $this->Html->url(array('controller' => 'users','action' => 'logout')) ?>"><i class="mr-50" data-feather="power"></i> Se déconnecter </a>

	                    </div>
	                </li>

	            </ul>
	        </div>
	    </nav>
	    <!-- END: Header-->


	    <!-- BEGIN: Main Menu-->
	    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">

	        <!-- Navbar -->
	        <div class="navbar-header">
	            <ul class="nav navbar-nav flex-row">
	                <li class="nav-item mr-auto">
	                	<a class="navbar-brand" href="<?php echo $this->Html->url('/') ?>">
		                	<span class="brand-logo">
		                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
		                            <defs>
		                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
		                                    <stop stop-color="#000000" offset="0%"></stop>
		                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
		                                </lineargradient>
		                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
		                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
		                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
		                                </lineargradient>
		                            </defs>
		                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
		                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
		                                    <g id="Group" transform="translate(400.000000, 178.000000)">
		                                        <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
		                                        <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
		                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
		                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
		                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
		                                    </g>
		                                </g>
		                            </g>
		                        </svg>
		                    </span>
	                        <h2 class="brand-text">JCOLLAB</h2>
	                    </a>
	                </li>
	                <li class="nav-item nav-toggle">
	                	<a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
	                		<i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
	                	</a>
	                </li>
	            </ul>
	        </div>
	        <!-- Navbar -->

	        <div class="shadow-bottom"></div>

	        <div class="main-menu-content">
	        	<!-- Sidebar -->
	        	<?php echo $this->element('sidebar') ?>
	            <!-- Sidebar -->
	        </div>
	    </div>
	    <!-- END: Main Menu-->

	    <!-- BEGIN: Content-->
	    <div class="app-content content ">
	        <div class="content-overlay"></div>
	        <div class="header-navbar-shadow"></div>
	        <div class="content-wrapper">

	            <div class="content-header row">
	            	<!-- breadcrumb -->
					<?php $pageBar = $this->fetch('page-bar'); ?>
					<?php $barMore = $this->fetch('page-bar-more'); ?>
					<?php if( empty($pageBar) ): ?>
		                <div class="content-header-left col-md-9 col-12 mb-2">
		                    <div class="row breadcrumbs-top">
		                        <div class="col-12">
										<div class="breadcrumb-wrapper">
			                                <ol class="breadcrumb">
			                                    <li class="breadcrumb-item">
			                                    	<a href="<?php echo $this->Html->url('/') ?>">
			                                    		<i class="fa fa-line-chart"></i> 
			                                    		<span>Tableau de bord</span>
			                                    	</a>
			                                    </li>
			                                    <?php if (isset($bar) && !empty($bar)): ?>
													<?php foreach ($bar as $key => $val): ?>
													<li class="breadcrumb-item">
														<?php if (empty($val['Module']['link'])): ?>
															<span><i class="fa <?php echo $val['Module']['icon'] ?>"></i> <?php echo $val['Module']['libelle'] ?></span>
														<?php else: ?>
					                                    	<a href="<?php echo $this->Html->url($val['Module']['link']) ?>">
					                                    		<i class="fa <?php echo $val['Module']['icon'] ?>"></i> 
					                                    		<span><?php echo $val['Module']['libelle'] ?></span>
					                                    	</a>
														<?php endif ?>
													</li>
													<?php endforeach ?>
													<?php echo $this->fetch('page-bar-more') ?>
												<?php endif ?>
			                                </ol>
			                            </div>
		                        </div>
		                    </div>
		                </div>
					<?php else: ?>
						<?php echo $this->fetch('page-bar'); ?>
					<?php endif ?>
	            	<!-- breadcrumb -->

	            </div>

	            <div class="content-body">
	                <div class="row">
	                    <div class="col-12">
							<?php echo $this->fetch('modal') ?>
							<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
							  <div class="modal-dialog modal-xl">
							    <div class="modal-content">
							    </div>
							  </div>
							</div>
	                        <?php echo $this->Session->flash(); ?>
							<?php echo $this->fetch('content'); ?>
	                    </div>
	                </div>
	            </div>

	        </div>
	    </div>
	    <!-- END: Content-->

	    <div class="sidenav-overlay"></div>
	    <div class="drag-target"></div>

	    <!-- BEGIN: Footer-->
	    <footer class="footer footer-static footer-light">
	        <p class="clearfix mb-0">
	        	<span class="float-md-left d-block d-md-inline-block mt-25">
	        		JCOLLAB - version dev (2.3)
	        	</span>
	        </p>
	    </footer>
	    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
	    <!-- END: Footer-->

	    <!-- BEGIN: Vendor JS-->
	    <?php echo $this->Html->script('/app-assets/vendors/js/vendors.min.js'); ?>
	    <!-- BEGIN Vendor JS-->

	    <!-- Plugins JS-->
		<?php echo $this->Html->script('/app-assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>
		<?php echo $this->Html->script('/app-assets/plugins/uniform/jquery.uniform.min.js'); ?>
		<?php echo $this->Html->script('/app-assets/plugins/bootstrap-toastr/toastr.min.js'); ?>
		<?php echo $this->Html->script('/app-assets/plugins/bootstrap-select/bootstrap-select.min.js'); ?>
		<?php echo $this->Html->script('/app-assets/plugins/bootbox/bootbox.min.js'); ?>
		<?php echo $this->Html->script('/app-assets/plugins/select2/js/select2.min.js') ?>
		<?php echo $this->Html->script('/app-assets/plugins/select2/js/i18n/fr.js') ?>
		<?php echo $this->Html->script('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') ?>
		<?php echo $this->Html->script('/app-assets/vendors/js/pickers/flatpickr/fr.js') ?>
	    <!-- Plugins JS-->

	    <!-- BEGIN: Theme JS-->
	    <?php echo $this->Html->script('/app-assets/js/core/app-menu.js'); ?>
	    <?php echo $this->Html->script('/app-assets/js/core/app.js'); ?>
	    <!-- END: Theme JS-->
		<script>
			// Delay Typing...
			var delay = (function () {
			    var timer = 0;
			    return function (callback, ms) {
			        clearTimeout(timer);
			        timer = setTimeout(callback, ms);
			    };
			})()
			if( $('.alert-success').length != 0 ){
				$('.alert-success i').remove();
				$('.alert-success button').remove();
				toastr.success($('.alert-success').html());
				$('.alert-success').remove();
			} else if( $('.alert-danger').length != 0 ){
				$('.alert-danger i').remove();
				$('.alert-danger button').remove();
				toastr.error( $('.alert-danger').html() );
				$('.alert-danger').remove();
			}
		</script>
	    <script>
	        $(window).on('load', function() {
	        	
	            if (feather) {
	                feather.replace({
	                    width: 14,
	                    height: 14
	                });
	            }

			  	$('.dark-mode').on('click',function(e){
				    $('.dark-mode').attr('disabled',true);
				    var element = $(this).children('svg:nth-child(1)').attr('class').split(" ");
				    var darkmode = 'off';  if ( element[1] == 'feather-sun' ) darkmode = 'on';
				    $.ajax({
				      url: "<?php echo $this->Html->url(['controller'=>'users','action'=>'darkmode']) ?>/"+darkmode,
				      success: function(dt){
				    	$('.dark-mode').attr('disabled',false);
				      }
				    });
			  	});

	        })
	    </script>
	    <?php echo $this->fetch('js') ?>
	</body>
	<!-- END: Body-->

</html>