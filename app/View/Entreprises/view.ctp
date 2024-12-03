<?php echo $this->Html->css('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css', array('inline' => false)); ?>
<div class="hr"></div>
<div class="tab-pane active" id="tab_1_3">
	<div class="row profile-account">
		<div class="col-md-3">
			<ul class="ver-inline-menu tabbable margin-bottom-10">
				<li>
					<?php if ( isset($this->request->data['Societe']['avatar']) AND file_exists(WWW_ROOT.$this->request->data['Societe']['avatar']) ): ?>
						<img src="<?php echo $this->Html->url($this->request->data['Societe']['avatar']) ?>" class="img-responsive" alt="" style="width: 100%;">
					<?php else: ?>
						<img src="<?php echo $this->Html->url('/img/no-image.png') ?>" class="img-responsive" alt="" style="width: 100%;">
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
								<a href="<?php echo $this->Html->url(['action'=>'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste</a>
								<button type="submit" class="btn btn-xs green" form="FormSociete"> Enregistrer </button>
							</div>
						</div>
						<div class="portlet-body">
						    <div class="row">
						      	<div class="col-md-12">

						      		<?php echo $this->Form->create('Societe',['class' => 'form-horizontal','id'=>'FormSociete']); ?>
										<?php echo $this->Form->input('id'); ?>
										<div class="form-group row">
											<label class="control-label col-md-2">Designation</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('designation',['label' => false,'class' => 'form-control','required'=>true]); ?>
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
											<div class="col-md-3">
												<?php echo $this->Form->input('dg',['label' => false,'class' => 'form-control']); ?>
											</div>
											<label class="control-label col-md-1">Modèle</label>
											<div class="col-md-3">
												<?php echo $this->Form->input('pdfmodele_id',['label' => false,'class' => 'form-control','empty'=>'--Modèle','required'=>true]); ?>
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

							<div class="row">
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

							<div class="row smallFormView">
						      	<div class="col-md-12">

						      		<?php echo $this->Form->create('Societe',['url'=>['controller'=>'entreprises','action' => 'saveImage'],'type' => 'file','class' => 'form-horizontal','id'=>'FormLogo']); ?>
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
													<img src="<?php echo $this->Html->url('/img/no-image.png') ?>" style="width: 250px;" />
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
  var Init = function(){
    $('.date-picker').flatpickr({
    	altFormat: "DD-MM-YYYY",
    	dateFormat: "d-m-Y",
    	allowInput: true,
      	locale: "fr",
    });
  }

  Init();
  
</script>
<?php $this->end() ?>
