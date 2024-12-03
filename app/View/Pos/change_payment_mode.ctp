
<div class="modal-header">
	<h4 class="modal-title">
		Liste des ventes d'aujourd'hui : 
	</h4>
</div>
<div class="modal-body ">
	<div class="row">
		<?php if ( empty( $salepoints ) ): ?>
			<div class="col-md-12">
				<div class="alert alert-danger text-center p-2" style="font-weight: bold;font-size: 20px;">Liste des articles est vide !</div>
			</div>
		<?php else: ?>
			<div class="parent col-md-12" style="border:1px solid #e5e5e5;">
				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								
								<th nowrap="">Référence</th>
								<th nowrap="">Date</th>
								<th nowrap="">Client</th>
                                <th nowrap="">Remise</th>
								<th nowrap="">Mode 1</th>
								<th nowrap="">Montant</th>
								<th nowrap="">Mode 2</th>
								<th nowrap="">Montant</th>
								<th nowrap="">Net à payer</th>
                                <th nowrap="">Changer Mode de payement</th>
								<th class="actions"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($salepoints as $dossier): ?>
								<tr>
								
									<td nowrap=""><a class="getdetail" href="<?php echo $this->Html->url(['action'=>'salepointdetails',$dossier['Salepoint']['id']]) ?>"><?php echo h($dossier['Salepoint']['reference']); ?></a></td>
									<td nowrap=""><?php echo h($dossier['Salepoint']['date']); ?></td>
									<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Salepoint']['remise'], 2, ',', ' '); ?>%</td>
									<td nowrap="" class="text-center"><?php echo $dossier['Avance'][0]['mode'] ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Avance'][0]['montant'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-center"><?php echo $dossier['Avance'][1]['mode'] ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Avance'][1]['montant'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Salepoint']['total_apres_reduction'], 2, ',', ' '); ?></td>
									<td nowrap="" class="actions">
										<a class="btn-show-modal-eco-payment btn btn-primary btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'changeModes',$dossier['Salepoint']['id']]) ?>"><i class="fa fa-eye"></i> Changer</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="child" style="border:1px solid #e5e5e5;">
				<div id="showdetail"></div>
			</div>
		<?php endif ?>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	
  var Init = function(){
	
    $('#showdetail .select2').select2({ dropdownParent: $('#edit .modal-content')});
	$('#showdetail #select1').select2();
   
  }
	$('.btn-show-modal-eco-payment').on('click',function(e){
		
	    e.preventDefault();
	    var url = $(this).attr('href');
			 $.ajax({
			      url: url,
			      success: function(dt){
			        $(".parent").removeClass("col-md-12");
					$(".parent").addClass("col-md-6");
					$(".child").addClass("col-md-6");
					$('#showdetail').html(dt);
				 	$('.modal-footer').prepend('<input form="AvancePaiement" class="saveBtn btn btn-success" type="submit" value="Enregistrer">');
					 
			      },
			      error: function(dt){
			        toastr.error("Il y a un probleme");
			      },
			      complete: function(){
			       Init();
			      }
			    });
		});
</script>