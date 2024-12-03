
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

	
	
	    <!-- BEGIN: Content-->
	    <div class="app-content content no-printme">
	    	<div class="content-wrapper">    		
	            <div class="content-body">
	                <div class="row">
	                    <div class="col-7 mx-auto">
							<?php echo $this->fetch('content'); ?>
	                    </div>
	                </div>
	            </div>
	    	</div>
	    </div>
	    <!-- END: Content-->



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