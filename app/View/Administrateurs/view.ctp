<?php echo $this->Html->css('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css', array('inline' => false)); ?>

<div class="hr"></div>

<div class="tab-pane active" id="tab_1_3">
	<div class="row profile-account">
		<div class="col-md-3">
			<ul class="ver-inline-menu tabbable margin-bottom-10">
				<li>
					<?php if ( empty($this->data['User']['avatar']) ): ?>
						<img src="http://www.placehold.it/300x150/EFEFEF/AAAAAA&amp;text=no+image" class="img-responsive" alt="" style="width: 100%;">
					<?php else: ?>
						<img src="<?php echo $this->Html->url('/uploads/avatar/user/'.$this->data['User']['avatar']) ?>" class="img-responsive" alt="" style="width: 100%;">
					<?php endif ?>
				</li>
				<li class="active">
					<a data-toggle="tab" href="#tab_1-1" aria-expanded="true">
					<i class="fa fa-address-card"></i> Information </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_2-2" aria-expanded="true">
					<i class="fa fa-picture-o"></i> Modifier photo </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#password" aria-expanded="true">
					<i class="fa fa-lock"></i> Modifier mot de passe </a>
				</li>
			</ul>
		</div>
		<div class="col-md-9">
			<div class="tab-content">
				<div id="tab_1-1" class="tab-pane active">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								Information
							</div>
							<div class="actions">
								<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
							</div>
						</div>
						<div class="portlet-body">
						    <div class="row ">
						    	<div class="col-lg-12">
									<?php echo $this->Form->create('User',['class' => 'form-horizontal','autocomplete'=>'off']); ?>
										<?php echo $this->Form->input('id',['id'=>'UserID']); ?>
										<div class="form-group row">
											<label class="control-label col-md-2">Nom</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('nom',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
											<label class="control-label col-md-2">Prénom</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('prenom',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Email</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('email',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
											<label class="control-label col-md-2">Tél</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('tel',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Role</label>
											<div class="col-md-10">
												<?php echo $this->Form->input('role_id',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Username</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('username',['class' => 'form-control','label'=>false]); ?>
											</div>
											<label class="control-label col-md-2">Code accès</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('code_bouchier',['class' => 'form-control','label'=>false]) ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Pays de naissance</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('pay_id',['class' => 'payId form-control','label'=>false,'empty'=>'--']); ?>
											</div>
											<label class="control-label col-md-2">Ville de naissance</label>
											<div class="col-md-4">
												<?php echo $this->Form->input('ville_id',['class' => 'villeId form-control','label'=>false,'empty'=>'--']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Adresse</label>
											<div class="col-md-10">
												<?php echo $this->Form->input('adresse',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Site par default</label>
											<div class="col-md-10">
												<?php echo $this->Form->input('store_id',['class' => 'select2 form-control','label'=>false]); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Site</label>
											<div class="col-md-10">
												<?php echo $this->Form->input('Store',['class' => 'select2 form-control','label'=>false]); ?>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="control-label col-md-2"></label>
											<div class="col-md-10">
												<button type="submit" class="btn green"> Enregistrer </button>
											</div>
										</div>
									<?php echo $this->Form->end(); ?>
						    	</div>
							</div>
					  	</div>
				  	</div>
				</div>
				
				<div id="tab_2-2" class="tab-pane">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								Avatar
							</div>
							<div class="actions">
								<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
							</div>
						</div>
						<div class="portlet-body">
						    <div class="row">
								<?php echo $this->Form->create('User',['action' => 'saveImage','type' => 'file','class' => 'form-horizontal','autocomplete'=>'off']); ?>
								<?php echo $this->Form->input('id',['id'=>'UserID3']); ?>
									<div class="col-lg-6">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<?php echo $this->Form->input('avatar',array('type' => 'file','label' => false,'div' => false,'class' => 'form-control')) ?>
												</span>
												<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
											<br>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100%;"></div>
											<br>
										</div>
									</div>
									<div class="col-lg-6">
										<button type="submit" class="btn green"> Enregistrer </button>
									</div>
								<?php echo $this->Form->end(); ?>
						    </div>
					    </div>
				    </div>
			    </div>
				<div id="password" class="tab-pane pass">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								Mot de passe
							</div>
							<div class="actions">
								<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row ">
								<div class="col-lg-12">
									<?php echo $this->Form->create('User',['action' => 'changepassword','class' => 'form-horizontal','autocomplete'=>'off']); ?>
										<?php echo $this->Form->input('id',['id'=>'UserID2']); ?>
										<div class="form-group row">
											<label class="control-label col-md-4">Ancien mot de passe</label>
											<div class="col-md-4">
												<?php echo $this->Form->password('Oldpassword',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Nouveau Mot de passe</label>
											<div class="col-md-4">
												<?php echo $this->Form->password('Newpassword',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Confirmer le Mot de passe</label>
											<div class="col-md-4">
												<?php echo $this->Form->password('Newpassword2',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="col-md-10">
											<br>
											<div class="control-label">
												<button type="submit" class="btn green"> Enregistrer </button>
											</div>
										</div>
									<?php echo $this->Form->end(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') ?>
<script>
  var Init = function(){
  	$('.select2').select2();
  	$('.uniform').uniform();
    $('.date-picker').flatpickr({
    	altFormat: "DD-MM-YYYY",
    	dateFormat: "d-m-Y",
    	allowInput: true,
      	locale: "fr",
    });
  }

</script>
<?php echo $this->element('page-script'); ?>
<?php $this->end() ?>