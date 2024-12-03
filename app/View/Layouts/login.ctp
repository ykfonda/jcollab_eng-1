<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>JCOLLAB - Connexion</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<?php echo $this->Html->css('/app-assets/plugins/google-font/Open+Sans-400-300-600-700.css'); ?>
	<?php echo $this->Html->css('/app-assets/vendors/css/vendors.min.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/bootstrap.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/bootstrap-extended.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/colors.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/components.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/themes/dark-layout.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/themes/bordered-layout.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/themes/semi-dark-layout.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/core/menu/menu-types/vertical-menu.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/plugins/forms/form-validation.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/pages/page-auth.css'); ?>
	<?php echo $this->Html->css('/app-assets/plugins/bootstrap-toastr/toastr.min.css'); ?>
	<?php echo $this->Html->css('/app-assets/plugins/font-awesome/css/font-awesome.min.css'); ?>
	<?php echo $this->Html->css('/app-assets/plugins/animation/font-awesome-animation.min'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/select2/css/select2.css'); ?>
    <?php echo $this->Html->css('/app-assets/plugins/easy-numpad/css/easy-numpad.min.css'); ?>
	<?php echo $this->Html->css('/app-assets/css/style.css'); ?>
    <style type="text/css">
        .numberClick{
            background-color: #2c3e50 !important;
            border-color: #2c3e50 !important;
            font-weight: bold;
            font-size: 20px;
            height: 55px;
        }


    </style>
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/app-assets/images/ico/apple-icon-120.png') ?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->Html->url('/app-assets/images/ico/favicon.ico') ?>">
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

                    <?php
                        // Récupérer les informations de l'application 
                        $result = $this->requestAction(array('controller' => 'Configs', 'action' => 'Getinfo'));

                        $version_app 		= $result['version_app'];
                        $type_app 			= $result['type_app'];
                        $store_id 			= $result['store_id'];
                        $caisse_id 			= $result['caisse_id'];
                        $app_last_commit 	= $result['app_last_commit'];
                        $app_last_commit = substr($app_last_commit, 0, 5);

                        if($type_app==1){$type_app_libelle='Administration';}
                        if($type_app==2){$type_app_libelle='POS';}
                        if($type_app==3){$type_app_libelle='Serveur';}

                        function testConnexionInternet()
                        {
                            $dnsResolver = dns_get_record("www.google.com", DNS_A);
                            return !empty($dnsResolver);
                        }
                        
                        if (testConnexionInternet() && $type_app==3) {
                           // echo "La connexion Internet est active.";
                           $ipAddress = $_SERVER['REMOTE_ADDR'];
                                
                                // pour faire les teste en mode localhost
                                if($ipAddress == "::1"){
                                    $ipAddress = "'105.155.159.158,105.155.159.155'"; 
                                }
                            
                            //debug($ipAddress);
                            
                            // Stockez l'adresse IP dans la variable de session 'jiji'
                            CakeSession::write('adresse_ip_public_user', $ipAddress);
                        } else {
                            // echo "La connexion Internet est inactive.";
                        }                      
                    ?>

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2" style="max-width: 800px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Login v1 -->
                            <div class="card mb-0">
                                <div class="card-body">
                                    

                        <div class="text-center">
                            <?php
                            echo $this->Html->image('LOGO_JCOLLAB.jpg', array(
                                'alt' => 'JCOLLAB LOGO',
                                'width' => 220,
                                'id' => 'logo-image',
                            ));
                            ?>
                        </div>

                        <script>
                            document.getElementById('logo-image').addEventListener('click', function() {
                                var passwordInput = document.getElementById('easy-numpad-output');
                                var password = passwordInput.value;

                                if (password === '131313') {
                                    window.location.href = './../configs/install';
                                } else {
                                    alert('Mot de passe incorrect.');
                                }
                            });
                        </script>


                
                                    <?php echo $this->Form->create("User",array('class' => 'auth-login-form mt-2','id'=>'LoginForm')) ?>
                                        <?php echo $this->Session->flash(); ?>

                                    <?php 
                                        echo $this->Form->input('type_app', array('type' => 'hidden','value'=>$type_app)); 
                                        echo $this->Form->input('store_id', array('type' => 'hidden','value'=>$store_id)); 
                                        echo $this->Form->input('caisse_id', array('type' => 'hidden','value'=>$caisse_id)); 
                                    ?>

                                <!--         <div class="form-group">
                                            <label for="login-email" class="form-label">Utilisateur</label>
                                            <?php echo $this->Form->input('username',array('label' => false,'class' => 'form-control','autocomplete' => 'off','placeholder' => 'Utilisateur','div' => false,'required' => true,'autofocus' => true,'id'=>'login-email','aria-describedby' => 'login-email' )) ?>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="login-password" class="form-label">Mot de passe</label>
                                            <div class="input-group input-group-merge form-password-toggle"><!-- 'default'=>'12345', -->
                                                <?php echo $this->Form->input('password',array('label' => false,'class' => 'form-control form-control-merge','autocomplete' => 'off','div' => false,'required'=>true,'autofocus'=>true,'id'=>'easy-numpad-output','aria-describedby'=>'login-password')) ?>
                                                <div class="input-group-append">
                                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary btn-block loginBtn btn-lg"> Se connecter 
                                            <i class="fa fa-sign-in"></i>
                                            <i class="fa fa-spinner faa-spin animated" style="font-size:15px !important;display: none;"></i>
                                        </button>

                                    <?php echo $this->Form->end() ?>

                                <br />
                                <div class="container">
                                <div class="row">
                                    <div class="col">
                                    <?php echo 'Version : '.$version_app; ?>
                                    </div>
                                    <div class="col">
                                        <?php echo 'Type : '.$type_app_libelle; ?>
                                    </div>
                                </div>
                                </div>

                                </div>
                            </div>
                            <!-- /Login v1 -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Login v1 -->
                            <div class="card mb-0">
                                <div class="card-body">
                                    <!-- KeyPad -->
                                    <table style="width:100%;">
                                        <tr>
                                            <td><button class="btn btn-primary btn-block numberClick" href="7" >7</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="8" >8</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="9" >9</button></td>
                                        </tr>
                                        <tr>
                                            <td><button class="btn btn-primary btn-block numberClick" href="4" >4</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="5" >5</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="6" >6</button></td>
                                        </tr>
                                        <tr>
                                            <td><button class="btn btn-primary btn-block numberClick" href="1" >1</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="2" >2</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="3" >3</button></td>
                                        </tr>
                                        <tr>
                                            <td><button class="btn btn-primary btn-block numberClick" href="±" disabled="disabled">±</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="0">0</button></td>
                                            <td><button class="btn btn-primary btn-block numberClick" href="." disabled="disabled">.</button></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><button class="btn btn-primary btn-danger btn-block btn-lg" href="Clear" id="clear" onclick="easy_numpad_clear()"><i class="fa fa-eraser"></i> Vider</button></td>
                                        </tr>
                                    </table>
                                    <!-- KeyPad -->
                                </div>
                            </div>
                            <!-- /Login v1 -->
                            
                        </div>

                    </div>




                    <div class="container">
                        <div class="row justify-content-center align-items-center">
                            <div class="text-center p-4">
                                <?php
                                echo $this->Html->image('logo_iaf.png', array(
                                    'alt' => 'JCOLLAB LOGO',
                                    'width' => 250,
                                    'id' => 'logo-image',
                                    'class' => 'animated-logo' // Ajoutez une classe pour l'animation personnalisée
                                ));
                                ?>
                            </div>
                        </div>
                    </div>











                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php echo $this->Html->script('/app-assets/vendors/js/vendors.min.js') ?>
<?php echo $this->Html->script('/app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?php echo $this->Html->script('/app-assets/js/core/app-menu.js') ?>
<?php echo $this->Html->script('/app-assets/js/core/app.js') ?>
<?php echo $this->Html->script('/app-assets/js/scripts/pages/page-auth-login.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap-toastr/toastr.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/select2/js/select2.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/select2/js/i18n/fr.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/easy-numpad/js/easy-num-pad.js'); ?>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
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

        //setInterval(function(){ $('#easy-numpad-output').focus() }, 1000);
        
        setInterval(function(){ showButtons() }, 3000);

        function showButtons() {
            $('.loginBtn').attr('disabled',false);
            $('.animated').hide();
            $('.fa-sign-in').show();
        }

        if (feather) feather.replace({ width: 14,height: 14 });
        $('.select2').select2();
		$('#LoginForm').on('submit',function(e){
		    $('.loginBtn').attr('disabled',true);
		    $('.animated').show();
		    $('.fa-sign-in').hide();
		});

    })
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>