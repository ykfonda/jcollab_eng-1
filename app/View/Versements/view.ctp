<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<style type="text/css">
	.checkbox input[type=checkbox]{
		margin-left: -10px !important;
	}
</style>
<div class="hr"></div>
<?php if ( isset( $this->data['Versement']['id'] ) ): ?>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				Information versement
			</div>
			<div class="actions">
				<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
				<?php if ($globalPermission['Permission']['m1'] AND $this->data['Versement']['etat'] == -1 ): ?>
					<a href="<?php echo $this->Html->url(['action' => 'edit', $this->data['Versement']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier</a>
				<?php endif ?>
				<?php if ( $this->data['Versement']['etat'] == 1 ): ?>
					<a href="<?php echo $this->Html->url(['action' => 'changestate', $this->data['Versement']['id'],-1 ]) ?>" class="btnFlagDelete btn btn-success btn-sm"><i class="fa fa-unlock-alt"></i> Ouvrir</a>
				<?php else: ?>
					<a href="<?php echo $this->Html->url(['action' => 'changestate', $this->data['Versement']['id'],1 ]) ?>" class="btnFlagDelete btn btn-danger btn-sm"><i class="fa fa-lock"></i> Clôturer</a>
				<?php endif ?>
			</div>
		</div>
		<div class="portlet-body ">
			<div class="row">
		      	<div class="col-md-12">
			        <div class="table-responsive" style="min-height: auto;">
			          	<table class="table table-bordered tableHeadInformation">
				            <tbody>
				              	<tr>
					                <td class="tableHead" nowrap="">Référence</td>
					                <td nowrap="">
					                  <?php echo $this->data['Versement']['reference'] ?>
					                </td>
					                <td class="tableHead" nowrap="">Date</td>
					                <td nowrap=""> 
					                  <?php echo $this->data['Versement']['date'] ?>
					                </td>
				              	</tr>
				              	<tr>
					                <td class="tableHead" nowrap="">Vendeur</td>
					                <td nowrap=""> 
					                  <?php echo $this->data['User']['nom']; ?> <?php echo $this->data['User']['prenom']; ?>
					                </td>
					                <td class="tableHead" nowrap="">Mode paiment</td>
					                <td nowrap="">
					                  <?php echo ( !empty( $this->data['Versement']['mode_paiement'] ) ) ? $this->App->getModePaiment($this->data['Versement']['mode_paiement']) : '' ; ?>  
					                </td>
				              	</tr>
				              	<tr>
					                <td class="tableHead" nowrap="">Agence</td>
					                <td nowrap=""> 
					                  <?php echo $this->data['Agence']['libelle'] ?>
					                </td>
					                <td class="tableHead" nowrap=""><!-- Client --></td>
					                <td nowrap="" >
					                  <?php //echo $this->data['Client']['designation'] ?>
					                </td>
				              	</tr>
				            </tbody>
			          	</table>
			        </div>
		      	</div>
		    </div>
			<div class="row">
        		<div class="col-lg-6 text-left"></div>
        		<div class="col-lg-2 text-left">
        			<div class="alert alert-danger"><strong>Total dépensé  : </strong> <?php echo $this->data['Versement']['total_expenses'] ?> </div>
        		</div>
        		<div class="col-lg-2 text-left">
        			<div class="alert alert-info"><strong>Total versé  : </strong> <?php echo $this->data['Versement']['total_verse'] ?> </div>
        		</div>
        		<div class="col-lg-2 text-left">
        			<div class="alert alert-success"><strong>Total générale  : </strong> <?php echo $this->data['Versement']['total_verse']-$this->data['Versement']['total_expenses'] ?> </div>
        		</div>
		    </div>
	  	</div>
	</div>
<?php endif ?>

<?php if ( isset( $this->data['Versement']['id'] ) AND !empty( $ventes ) ): ?>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Paiement
            </div>
            <div class="actions">
            	<?php if ( $this->data['Versement']['etat'] == -1 ): ?>
            	<?php echo $this->Form->submit('Valider les versements',array('div' => false,'form' => 'AvanceForm','class' => 'saveBtn btn btn-success')) ?>
            	<?php endif ?>
            </div>
        </div>
        <div class="portlet-body">
			<div class="row">
				<?php $base_url = array('controller' => 'versements', 'action' => 'viewAjax'); ?>
				<?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal','id'=>'ViewForm')) ?>
				<div class="col-md-12 smallForm formFilter">
					<div class="form-group row">
						<div class="col-md-2">
							<?php echo $this->Form->input('Filter.Avance.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
						</div>
						<div class="col-md-2">
							<?php echo $this->Form->input('Filter.Vente.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
						</div>
						<div class="col-md-2">
							<?php echo $this->Form->input('Filter.Avance.vente_id',array('label'=>false,'empty'=>'--Vente','class'=>'select2 form-control')) ?>
						</div>
						<div class="col-md-3">
							<div class="d-flex align-items-end">
								<?php echo $this->Form->input('Filter.Avance.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
								<span class="input-group-addon">&nbsp;à&nbsp;</span>
								<?php echo $this->Form->input('Filter.Avance.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
							</div>
						</div>
						<div class="col-md-3">
							<?php echo $this->Form->submit('Rechercher',array('class' => 'btn btn-primary','div' => false)) ?>
							<?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>
						</div>
					</div>
				</div>
				<?php echo $this->Form->end() ?>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php $base_url_2 = array('controller' => 'versements', 'action' => 'calculate'); ?>
				    <?php echo $this->Form->create("Versement",array('url' => $base_url_2, 'class' => 'form-horizontal','id'=>'AvanceForm')) ?>
				    <?php echo $this->Form->input('id'); ?>
					<div id="ViewAjax"></div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
        </div>
    </div>

<?php endif ?>

<?php if ( isset( $this->data['Versement']['id'] ) ): ?>
	<div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Liste des dépenses
            </div>
            <div class="actions">
            	<?php if ( $this->data['Versement']['etat'] == -1 ): ?>
	            	<?php if ($globalPermission['Permission']['a']): ?>
					 	<a href="<?php echo $this->Html->url(['action' => 'editexpense',0,$this->data['Versement']['id'] ]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter dépense </a>
					<?php endif ?>
				<?php endif ?>
            </div>
        </div>
        <div class="portlet-body">
        	<div class="row">
        		<div class="col-lg-12">

        			<div class="table-responsive" style="min-height: auto;">
						<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th nowrap="">Libellé</th>
									<th nowrap="">Date</th>
									<th nowrap="">Référence</th>
									<th nowrap="">Montant</th>
									<?php if ( $this->data['Versement']['etat'] == -1 ): ?>
									<th class="actions" nowrap="">
									<?php endif ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($depenses as $tache): ?>
									<tr>
										<td nowrap=""><?php echo h($tache['Expense']['libelle']); ?></td>
										<td nowrap=""><?php echo h($tache['Expense']['date']); ?></td>
										<td nowrap=""><?php echo h($tache['Expense']['reference']); ?></td>
										<td nowrap=""><?php echo h($tache['Expense']['montant']); ?></td>
										<?php if ( $this->data['Versement']['etat'] == -1 ): ?>
										<td class="actions">
											<?php if ($globalPermission['Permission']['m1']): ?>
												<a href="<?php echo $this->Html->url(['action' => 'editexpense', $tache['Expense']['id'], $tache['Expense']['versement_id'] ]) ?>" class="edit"><i class="fa fa-edit"></i></a>
											<?php endif ?>
											<?php if ($globalPermission['Permission']['s']): ?>
												<a href="<?php echo $this->Html->url(['action' => 'deleteexpense', $tache['Expense']['id'], $tache['Expense']['versement_id'] ]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
											<?php endif ?>
										</td>
										<?php endif ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

        		</div>
    		</div>
		</div>
	</div>
<?php endif ?>

<?php if ( !empty( $this->data['Versement']['image'] ) ): ?>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				Image versement
			</div>
			<div class="actions">
			</div>
		</div>
		<div class="portlet-body ">
			<div class="row">
				<div class="col-lg-12 text-center">
					<img class="img-thumbnail" src="<?php echo $this->data['Versement']['image'] ?>" style="width: 50%;" />
				</div>
			</div>
		</div>
	</div>
<?php endif ?>

<?php $this->start('js') ?>
<script>
$(function(){

var dataFilter = null;
var dataPage = 1;

var Init = function(){
    $('.select2').select2();
    $('.mt-checkbox').uniform();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
}

Init();

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

$('.btnFlagDelete').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
      	window.location = url;
      }
    });
});


$('#edit').on('change','#user_id,#client_id',function(e){
    var client_id = $('#client_id').val();
    var user_id = $('#user_id').val();
    loadventes(user_id,client_id);
});

function loadventes(user_id,client_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadventes']) ?>/"+user_id+"/"+client_id,
      success: function(dt){
        $('#ventes').empty();
        $.each(dt, function(i, obj){
          $('#ventes').append($('<option>').text(obj).attr('value', i));
        });
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
}

$('#edit').on('submit','form',function(e){
    $('.saveBtn').attr("disabled", true);
});

/* Pagination */
	
var loadIndexAjax = function(url){
	$.ajax({
	  url: url,
	  success : function(dt){
	    $('#ViewAjax').html(dt);
	  },
	  complete : function(dt){
	    Init();
	  }
	});
}

var loadIndexAjaxFilter = function(data,load){
	if(load !== true) dataPage = 1;

	$.ajax({
	  type: 'POST',
	  <?php if ( isset( $this->data['Versement']['id'] ) ): ?>
	  url: "<?php echo $this->Html->url(['action' => 'callViewAjax',$this->data['Versement']['id']]) ?>/" + dataPage,
	  <?php else: ?>	
	  url: "<?php echo $this->Html->url(['action' => 'callViewAjax',1]) ?>/" + dataPage,
	  <?php endif ?>
	  data: data,
	  success : function(dt){
	    $('#ViewAjax').html(dt);
	  },
	  complete : function(dt){
	    Init();
	  }
	});
}

loadIndexAjaxFilter( dataFilter , false);

$('#ViewAjax').on('click','.pagination li:not(.disabled,.active) a',function(e){
	e.preventDefault();
	loadIndexAjax( $(this).attr('href') );
	dataPage = 1;

	SplitArr = $(this).attr('href').split('/');
	for (var i = 0; i < SplitArr.length; i++) {
	  if(SplitArr[i].split(':')[0] == "page"){
	    dataPage = SplitArr[i].split(':')[1];
	  }
	};
});

$('#ViewAjax').on('click','.btnFlagDelete',function(e){
	e.preventDefault();
	var url = $(this).prop('href');
	bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
	  if( result ){
	    $.ajax({
	      url: url,
	      success: function(dt){
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

$('#ViewForm').on('submit',function(e){
	e.preventDefault();
	dataFilter = $(this).serialize();
	loadIndexAjaxFilter( dataFilter, false );
});

$('.btnResetFilter').on('click',function(e){
	dataFilter = null;
	loadIndexAjaxFilter( dataFilter, false );
});

/* Pagination */

});
</script>
<?php $this->end() ?>
