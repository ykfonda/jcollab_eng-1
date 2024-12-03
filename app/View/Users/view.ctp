<?php echo $this->Html->css('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css', array('inline' => false)); ?>
<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">

		</div>
	</div>
</div>
<?php $this->end() ?>
<div class="page-bar">
  <ul class="page-breadcrumb breadcrumb">
    <li>
      <i class="fa fa-home"></i>
      <a href="<?php echo $this->Html->url('/') ?>">Accueil</a>
      <i class="fa fa-angle-right"></i>
    </li>
    <li>
      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>">Gestion des utilisateurs</a>
    </li>
  </ul>
</div>
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
					<i class="fa fa-cog"></i> Information </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_5-6" aria-expanded="true">
					<i class="fa fa-picture-o"></i> Paramétrage </a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#tab_5-5" aria-expanded="true">
					<i class="fa fa-picture-o"></i> Modifier l'Avatar </a>
				</li>
			</ul>
		</div>
		<div class="col-md-9">
			<div class="tab-content">
				<div id="tab_1-1" class="tab-pane active">
				<h3 class="h3">Information</h3>
					<div class="row ">
					<?php echo $this->Form->create('User',['class' => 'form-horizontal']); ?>
						<?php echo $this->Form->input('id'); ?>
						<div class="form-group row">
							<label class="control-label col-md-2">Nom</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('nom',['class' => 'form-control','label'=>false,'required'=>true]); ?>
							</div>
							<label class="control-label col-md-1">Prénom</label>
							<div class="col-md-3">
								<?php echo $this->Form->input('prenom',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2">Email</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('email',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2">Username</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('username',['class' => 'form-control','label'=>false,'type'=>'text','required'=>true]); ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2">Role</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('role',['class'=>'form-control','label'=>false,'required'=>true,'options'=>$this->App->getRole(),'empty'=>'--Role']); ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="control-label col-md-2">Téléphone</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('tel',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
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
				<div id="tab_5-5" class="tab-pane">
				<h3 class="h3">Avatar</h3>
					<?php echo $this->Form->create('User',['action' => 'saveImage','type' => 'file','class' => 'form-horizontal']); ?>
					<?php echo $this->Form->input('id'); ?>
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
						<button type="submit" href="#" class="btn btn-xs green"> Enregistrer </button>
						<button type="reset" href="#" class="btn btn-xs default"> Annuler </button>
					</div>

					<?php echo $this->Form->end(); ?>
				</div>
				<div id="tab_5-6" class="tab-pane ">
					<h3 class="h3">Paramétrage</h3>
					<?php echo $this->Form->create('User',['class' => 'form-horizontal']); ?>
					<?php echo $this->Form->input('id'); ?>
					<div class="col-md-12">
						<div class="form-group row">
							<label class="control-label col-md-2">Hotel</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('hotel_id',['class' => 'form-control','label'=>false,'empty'=>'--Hotel']); ?>
							</div>
						</div>
						<?php if (isset( $this->data['User']['role'] ) AND $this->data['User']['role'] != 4): ?>
						<div class="form-group row">
							<label class="control-label col-md-2">Réstaurant</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('restaurant_id',['class' => 'form-control','label'=>false,'empty'=>'--Réstaurant']); ?>
							</div>
						</div>
						<?php endif ?>
						<?php if (isset( $this->data['User']['role'] ) AND $this->data['User']['role'] != 3): ?>
						<div class="form-group row">
							<label class="control-label col-md-2">Café</label>
							<div class="col-md-7">
								<?php echo $this->Form->input('cafe_id',['class' => 'form-control','label'=>false,'empty'=>'--Café']); ?>
							</div>
						</div>
						<?php endif ?>
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
		<!--end col-md-9-->
	</div>
</div>


<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') ?>

<script>
	$(function(){

		$('#contactAjax').on('click','.edit',function(e){
		    e.preventDefault();
		    $.ajax({
		      //type: 'POST',
		      url: $(this).attr('href'),
		      success: function(dt){
		        $('#edit .modal-content').html(dt);
		        $('#edit').modal('show');
		      },
		      error: function(dt){
		        toastr.error("Il y a un problème");
		      },
		      complete: function(){
		        Init();
		      }
		    });
		  });
		  
		  $('.edit').on('click',function(e){
		    e.preventDefault();
		    $.ajax({
		      url: $(this).attr('href'),
		      success: function(dt){
		        $('#edit .modal-content').html(dt);
		        $('#edit').modal('show');
		      },
		      error: function(dt){
		        toastr.error("Il y a un probleme");
		      },
		      complete: function(){
		        Init();
		      }
		    });
		  });

		  $('#indexAjax').on('click','.btnFlagDelete',function(e){
		    e.preventDefault();
		    var url = $(this).prop('href');
		    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
		      if( result ){
		        $.ajax({
		          url: url,
		          success: function(dt){
		            //console.log(dt);
		            toastr.success("La suppression a été effectué avec succès.");
		            loadIndexAjaxFilter( dataFilter, false );
		          },
		          error: function(dt){
		            toastr.error("Il y a un problème")
		          }
		        });
		      }
		    });
		  });
	});
</script>

<?php $this->end() ?>