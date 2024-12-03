<?php echo $this->Html->css('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css', array('inline' => false)); ?>

<div class="hr"></div>

<div class="tab-pane active" id="tab_1_3">
	<div class="row profile-account">
		<div class="col-md-3">
			<ul class="ver-inline-menu tabbable margin-bottom-10">
				<li>
				<?php if ( empty($this->data['User']['avatar']) ): ?>
					<img src="http://www.placehold.it/300x150/EFEFEF/AAAAAA&amp;text=no+image" class="img-responsive" alt="">
				<?php else: ?>
					<img src="<?php echo $this->Html->url('/uploads/avatar/user/'.$this->data['User']['avatar'].'?'.time()) ?>" class="img-responsive" alt="">
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
								<?php echo $this->Form->create('User',['class' => 'form-horizontal']); ?>
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
										<div class="col-md-4">
											<?php echo $this->Form->input('role_id',['class' => 'form-control','label'=>false,'required' => true]); ?>
										</div>
										<label class="control-label col-md-2">Date naissance</label>
										<div class="col-md-4">
											<?php echo $this->Form->input('date_naissance',['class' => 'date-picker form-control','label'=>false,'type'=>'text']); ?>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-2">Username</label>
										<div class="col-md-4">
											<?php echo $this->Form->input('username',['class' => 'form-control','label'=>false]); ?>
										</div>
										<label class="control-label col-md-2">Sexe</label>
										<div class="col-md-4">
											<?php echo $this->Form->input('sexe',['class' => 'form-control','label'=>false,'options' => $this->App->getSexe()]); ?>
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
										<label class="control-label col-md-2">Dépôt</label>
										<div class="col-md-4">
											<?php echo $this->Form->input('depot_id',['class' => 'form-control','label'=>false,'required' => false,'empty'=>'--Dépôt']); ?>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-2">Adresse</label>
										<div class="col-md-10">
											<?php echo $this->Form->input('adresse',['class' => 'form-control','label'=>false,'rows'=>2]); ?>
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
						    <div class="row ">
								<?php echo $this->Form->create('User',['action' => 'saveImage','type' => 'file','class' => 'form-horizontal']); ?>
								<?php echo $this->Form->input('id',['id'=>'UserID3']); ?>
								<div class="col-md-6">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div>
											<span class="btn default btn-file">
											<span class="fileinput-new">
											Select image </span>
											<span class="fileinput-exists">
											Change </span>
											<?php echo $this->Form->input('avatar',array('type' => 'file','label' => false,'div' => false,'class' => 'form-control')) ?>
											</span>
											<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
											Remove </a>
										</div>
										<br>
										<div class="fileinput-new thumbnail" style="width: 100%;">
											<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100%;">
										</div>
									</div>
								</div>
								<div class="col-md-6">
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
							<?php echo $this->Form->create('User',['action' => 'changepassword','class' => 'form-horizontal']); ?>
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


<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') ?>
<script type="text/javascript">
	$(function(){

		var Init = function(){
		    $('.uniform').uniform();
		    $('.date-picker').datepicker({
		          orientation: "left",
		          autoclose: true,
		          format: "dd-mm-yyyy"
		    });
		}
		Init();
		
		var loadVilles = function(thisElement){
			$.ajax({
				url: "<?php echo $this->Html->url(['controller' => 'villes','action' => 'getVilles']) ?>/" + thisElement.val(),
				success: function(dt){
					var v = $('.villeId').val();
					$('.villeId').replaceOptions(dt);
					if( $(".villeId option[value='" + v + "']").length > 0 )
						$('.villeId').val( v );
				}
			});
		}
		loadVilles( $('.payId') );

		$('.payId').on('change',function(){
			loadVilles( $(this) );
		});
	});
</script>
<?php $this->end() ?>