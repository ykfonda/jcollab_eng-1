<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset( $this->data['Visite']['id'] ) ): ?>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				Information visite
			</div>
			<div class="actions">
				<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
				<?php if ($globalPermission['Permission']['m1'] ): ?>
					<a href="<?php echo $this->Html->url(['action' => 'edit', $this->data['Visite']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier</a>
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
					                  <?php echo $this->data['Visite']['reference'] ?>
					                </td>
					                <td class="tableHead" nowrap="">Date</td>
					                <td nowrap=""> 
					                  <?php echo $this->data['Visite']['date'] ?>
					                </td>
				              	</tr>
				              	<tr>
					                <td class="tableHead" nowrap="">Vendeur</td>
					                <td nowrap=""> 
					                  <?php echo $this->data['User']['nom']; ?> <?php echo $this->data['User']['prenom']; ?>
					                </td>
					                <td class="tableHead" nowrap="">Client</td>
					                <td nowrap="" >
					                  <?php echo $this->data['Client']['designation'] ?>
					                </td>
				              	</tr>
				            </tbody>
			          	</table>
			        </div>
		      	</div>
		    </div>
	  	</div>
	</div>
<?php endif ?>

<?php if ( !empty( $this->data['Visite']['image'] ) ): ?>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				Image visite
			</div>
			<div class="actions">
			</div>
		</div>
		<div class="portlet-body ">
			<div class="row">
				<div class="col-lg-12 text-center">
					<h5>Date prise photo : <?php echo $this->data['Client']['date_c'] ?></h5>
					<img class="img-thumbnail" src="<?php echo $this->data['Visite']['image'] ?>" style="width: 50%;" />
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

	$('#edit').on('submit','form',function(e){
	    $('.saveBtn').attr("disabled", true);
	});

});
</script>
<?php $this->end() ?>
