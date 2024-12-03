<?php echo $this->Html->css('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css', array('inline' => false)); ?>

<div class="hr"></div>

<div class="tab-pane active" id="tab_1_3">
	<div class="row profile-account">
		<div class="col-md-3">
			<ul class="ver-inline-menu tabbable margin-bottom-10">
				<li>
					<?php if ( isset($this->request->data['Societe']['avatar']) AND file_exists(WWW_ROOT.$this->request->data['Societe']['avatar']) ): ?>
						<img src="<?php echo $this->request->data['Societe']['avatar'].'?'.time() ?>" class="img-responsive" alt="" style="width: 100%;">
					<?php else: ?>
						<img src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" class="img-responsive" alt="" style="width: 100%;">
					<?php endif ?>
				</li>
				<li class="active">
					<a data-toggle="tab" href="#tab_1-1" aria-expanded="true">
					<i class="fa fa-cog"></i> Information </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_2-2" aria-expanded="true">
					<i class="fa fa-home"></i> Adresse </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_3-3" aria-expanded="true">
					<i class="fa fa-gears"></i> Paramétrage </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_4-4" aria-expanded="true">
					<i class="fa fa-picture-o"></i> Modifier logo </a>
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
								<?php if (isset($this->data['Societe']['id']) AND $globalPermission['Permission']['i']): ?>
									<a href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Societe']['id']]) ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
								<?php endif ?>
								<button type="submit" class="btn btn-xs green" form="FormSociete"> Enregistrer </button>
							</div>
						</div>
						<div class="portlet-body ">
						    <div class="row">
						      	<div class="col-md-12">

						      		<?php echo $this->Form->create('Societe',['class' => 'form-horizontal','id'=>'FormSociete']); ?>
										<?php echo $this->Form->input('id'); ?>
										<div class="form-group row">
											<label class="control-label col-md-2">Designation</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('designation',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Date</label>
											<div class="col-md-2">
												<?php echo $this->Form->input('date',['label' => false,'type' => 'text','class' => 'date-picker form-control']); ?>
											</div>
											<label class="control-label col-md-3">ICE</label>
											<div class="col-md-2">
												<?php echo $this->Form->input('ice',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Identifiant fiscal</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('idfiscale',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Registre de commerce</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('registrecommerce',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Patent</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('patent',['label' => false,'class' => 'form-control']); ?>
											</div>
											<label class="control-label col-md-1">CNSS</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('cnss',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Directeur général</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('dg',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Nature de l'activité</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('nature',['label' => false,'class' => 'form-control']); ?>
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
								Adresse
							</div>
							<div class="actions">
								<button type="submit" class="btn btn-xs green" form="FormAdresse"> Enregistrer </button>
							</div>
						</div>
						<div class="portlet-body">

							<div class="row ">
						      	<div class="col-md-12">

						      		<?php echo $this->Form->create('Societe',['class' => 'form-horizontal','id'=>'FormAdresse']); ?>
										<?php echo $this->Form->input('id'); ?>
										<div class="form-group row">
											<label class="control-label col-md-2">Contact</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('contact',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Adresse</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('adresse',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Téléphone fixe</label>
											<div class="col-md-2">
												<?php echo $this->Form->input('telfixe',['label' => false,'class' => 'form-control']); ?>
											</div>
											<label class="control-label col-md-3">Téléphone mobile</label>
											<div class="col-md-2">
												<?php echo $this->Form->input('telmobile',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Fax</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('fax',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Email</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('email',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Website Url</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('website',['label' => false,'class' => 'form-control']); ?>
											</div>
										</div>
									<?php echo $this->Form->end(); ?>

						      	</div>
					      	</div>
								
				      	</div>
			      	</div>

				</div>

				<div id="tab_3-3" class="tab-pane">

					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								Paramétrage
							</div>
							<div class="actions">
								<button type="submit" class="btn btn-xs green" form="FormParametrage"> Enregistrer </button>
							</div>
						</div>
						<div class="portlet-body">

							<div class="row ">
						      	<div class="col-md-12">

						      		<?php echo $this->Form->create('Societe',['class' => 'form-horizontal','id'=>'FormParametrage']); ?>
										<?php echo $this->Form->input('id'); ?>

										<div class="form-group row">
											<label class="control-label col-md-2">TVA</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('tva',['label' => false,'class' => 'form-control','options'=>$this->App->getTVA(),'default'=>20,'disabled'=>true ]); ?>
												<?php echo $this->Form->hidden('tva',['value'=>20 ]); ?>
											</div>
											<label class="control-label col-md-2">Entête PDF</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('show_logo',['label' => false,'class' => 'form-control','options'=>$this->App->getEntete(),'default'=>1 ]); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Afficher entête</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('show_entete',['label' => false,'class' => 'form-control','options'=>$this->App->NonOui(),'default'=>1 ]); ?>
											</div>
											<label class="control-label col-md-2">Afficher enbas</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('show_enbas',['label' => false,'class' => 'form-control','options'=>$this->App->NonOui(),'default'=>1 ]); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Afficher HT</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('show_ht',['label' => false,'class' => 'form-control','options'=>$this->App->NonOui(),'default'=>-1 ]); ?>
											</div>
										</div>

									<?php echo $this->Form->end(); ?>

						      	</div>
					      	</div>
								
				      	</div>
			      	</div>

				</div>

				<div id="tab_4-4" class="tab-pane">

					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								Changer logo
							</div>
							<div class="actions">
								<button type="submit" class="btn btn-xs green" form="FormLogo"> Enregistrer </button>
							</div>
						</div>
						<div class="portlet-body">

							<div class="row ">
						      	<div class="col-md-12">

						      		<?php echo $this->Form->create('Societe',['action' => 'saveImage','type' => 'file','class' => 'form-horizontal','id'=>'FormLogo']); ?>
										<div class="col-md-6">
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
												<div class="fileinput-new thumbnail" style="width: 100%;">
													<img src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" alt=""/>
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100%;"></div>
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
		<!--end col-md-9-->
	</div>
</div>


<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') ?>

<script>
	$(function(){
	    $('.date-picker').flatpickr({
	      altFormat: "DD-MM-YYYY",
	      dateFormat: "d-m-Y",
	      allowInput: true,
	      locale: "fr",
	    });
	})

</script>

<?php $this->end() ?>
