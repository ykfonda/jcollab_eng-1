
<!DOCTYPE html>
<?php $darkmode = ( isset( $SessionInfo['User']['darkmode'] ) AND $SessionInfo['User']['darkmode'] == 'on' ) ? true : false ; ?>
<html class="loading <?php echo ( $darkmode ) ? 'light-layout dark-layout' : 'light-layout' ; ?> loaded" lang="en" data-textdirection="ltr">

	<!-- BEGIN: Head-->
	<head>

	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	    <title>POS JCOLLAB</title>

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
		<?php echo $this->Html->css('/app-assets/css/global/components-rounded.css'); ?>
		<?php echo $this->Html->css('/app-assets/css/global/plugins.css'); ?>
	    <?php echo $this->Html->css('/app-assets/css/style.css'); ?>
	    <!-- END: Page CSS-->

	</head>
	<!-- END: Head-->

	<!-- BEGIN: Body-->
	<!-- Meny type : menu-expanded / menu-collapsed -->
	<body class="vertical-layout vertical-menu-modern 1-column navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">

	<!-- BEGIN: Header-->
	    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-shadow navbar-light no-printme">
	        <div class="navbar-container d-flex content">
	        	<!-- bookmarks -->
	            <div class="bookmark-wrapper d-flex align-items-center">
	                <ul class="nav navbar-nav d-xl-none">
	                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
	                </ul>
	                <!-- Stores -->
	                <ul class="nav navbar-nav bookmark-icons">
		                <li class="nav-item dropdown dropdown-notification">
		                	<a class="nav-link" href="javascript:void(0);">
		                		<i class="fa fa-map-marker"></i> 
		                		<?php echo ( isset( $storeSession['Store']['id'] ) AND !empty( $storeSession['Store']['id'] ) ) ? $storeSession['Societe']['designation'].' : '.$storeSession['Store']['libelle'] : '' ; ?>
		                	</a>
		                </li>
		            </ul>
		            <!-- Stores -->
	            </div>
	        	<!-- bookmarks -->

	            <ul class="nav navbar-nav align-items-center ml-auto">

				 
	<?php
      // Vérifier la disponibilité de la connexion Internet
      if(checkdnsrr('google.com', 'A')){		
		echo $this->Html->link('Syncroniser les ventes', ['controller' => 'Pos', 'action' => 'syncmanuel'], ['class' => 'btn btn-warning']);
		echo '&ensp;  <i class="fa fa-wifi green-icon" aria-hidden="true"></i>';

      } else {
        echo '<i class="fa fa-wifi red-icon" aria-hidden="true"></i>';
      }
    ?>

    				<!-- dark and light mode -->
	                <li class="nav-item d-lg-block">
	                	<a class="nav-link nav-link-style dark-mode"><i class="ficon" data-feather="<?php echo ( $darkmode ) ? 'sun' : 'moon' ; ?>"></i></a>
	                </li>
    				<!-- END dark and light mode -->

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
	                <!-- END Notifications -->

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


	
	    <!-- BEGIN: Content-->
		<?php echo $this->fetch('modal') ?>
		<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog modal-xl">
		    <div class="modal-content">
		    </div>
		  </div>
		</div>
	    <div class="app-content content no-printme">
	    	<div class="content-wrapper">    		
	            <div class="content-body">
	                <div class="row">
	                    <div class="col-12">
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
	    <footer class="footer footer-static footer-light no-printme">
	        <p class="clearfix mb-0">
	        	<span class="float-md-left d-block d-md-inline-block mt-25"
						style="color: #c1a5a5;">
					<?php
                        // Récupérer les informations de l'application 
                        $result = $this->requestAction(array('controller' => 'Configs', 'action' => 'Getinfo'));
						
						$name_app 			= $result['name_app'];
                        $version_app 		= $result['version_app'];
                        $type_app 			= $result['type_app'];
                        $app_last_commit 	= $result['app_last_commit'];
                        $app_last_commit = substr($app_last_commit, 0, 10);

						echo $name_app." | Version : ".$version_app." | Commit : ".$app_last_commit;
                    ?>

	        	</span>
	        </p>
	    </footer>
	    <button class="btn btn-primary btn-icon scroll-top no-printme" type="button"><i data-feather="arrow-up"></i></button>
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
			})();
			
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