<?php echo $this->Html->css('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css', array('inline' => false)); ?>

<?php $this->start('page-bar') ?>
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="<?php echo $this->Html->url('/') ?>">
                        <i class="fa fa-line-chart"></i>
                        <span class="title">Tableau de bord</span>
                      </a>
                    </li>
                    <li class="breadcrumb-item">
                    	<a href="<?php echo $this->Html->url(['action'=>'profil']) ?>">Mon profil</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>

<div class="hr"></div>

<div class="tab-pane active" id="tab_1_3">
	<div class="row profile-account">
		<div class="col-md-3">
			<ul class="ver-inline-menu tabbable margin-bottom-10">
				<li>
				<?php if ( empty($this->data['User']['avatar']) ): ?>
					<img src="http://www.placehold.it/300x150/EFEFEF/AAAAAA&amp;text=no+image" class="img-responsive" alt="" style="width: 100%;">
				<?php else: ?>
					<img src="<?php echo $this->Html->url('/uploads/avatar/user/'.$this->data['User']['avatar'].'?'.time()) ?>" class="img-responsive" alt="" style="width: 100%;">
				<?php endif ?>
				</li>
				<li class="active">
					<a data-toggle="tab" href="#tab_1-1" aria-expanded="true">
					<i class="fa fa-cog"></i> Information </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_2-2" aria-expanded="true">
					<i class="fa fa-picture-o"></i> Modifier l'Avatar </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#password" aria-expanded="true">
					<i class="fa fa-eye"></i> Modifier mot de passe </a>
				</li>
			</ul>
		</div>
		<div class="col-md-9">
			<div class="tab-content">
				<div id="tab_1-1" class="tab-pane active">

					<div class="portlet light bordered">
					    <div class="portlet-title">
					        <div class="caption">
					            <i class="fa fa-user"></i> Information
					        </div>
					        <div class="actions">
					            <?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'Information','class' => 'saveBtn btn btn-default')) ?>
					        </div>
					    </div>
					    <div class="portlet-body " >
					    	<div class="row">
					    		<div class="col-md-6">
									<?php echo $this->Form->create('User',['class' => 'form-horizontal','id'=>'Information']); ?>
										<?php echo $this->Form->input('id',['id'=>'UserID']); ?>
										<div class="form-group row">
											<label class="control-label col-md-2">Nom</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('nom',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Prénom</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('prenom',['label' => false,'required' => false,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Username</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('username',['label' => false,'readonly' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Email</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('email',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Tél</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('tel',['label' => false,'required' => true,'class' => 'form-control']); ?>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-2">Role</label>
											<div class="col-md-7">
												<?php echo $this->Form->input('role_id',['label' => false,'disabled' => true,'class' => 'form-control']); ?>
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
					            <i class="fa fa-user"></i> Avatar
					        </div>
					        <div class="actions">
					            <?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'Avatar','class' => 'saveBtn btn btn-default')) ?>
					        </div>
					    </div>
					    <div class="portlet-body " >
					    	<div class="row">
					    		<?php echo $this->Form->create('User',['action' => 'saveImage','type' => 'file','class' => 'form-horizontal','id'=>'Avatar']); ?>
								<div class="col-md-12">
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
											<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100%;"></div>
									</div>
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
					            <i class="fa fa-user"></i> Mot de passe
					        </div>
					        <div class="actions">
					            <?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'Password','class' => 'saveBtn btn btn-default')) ?>
					        </div>
					    </div>
					    <div class="portlet-body " >
					    	<div class="row">
					    		<div class="col-md-12">
									<?php echo $this->Form->create('User',['action' => 'changepassword','class' => 'form-horizontal','id'=>'Password']); ?>
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
												<button type="submit" class="btn btn-xs green"> Enregistrer </button>
												<button type="reset" class="btn btn-xs default"> Annuler </button>
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

<?php $this->end() ?>