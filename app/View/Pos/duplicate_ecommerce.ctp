<?php echo $this->Html->css('/app-assets/css/bootstrap-extended.css'); ?>
<div id="myModal1" class="modal fade" role="dialog">
<div class="modal-header">
	<h4 class="modal-title">
		Liste des commandes client 
	</h4>
</div>
<div class="modal-body ">
	<div class="row">
		
			<div class="col-md-6" style="border:1px solid #e5e5e5;">
				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th class="actions"></th>
								<th nowrap="">Référence</th>
								<th nowrap="">Date</th>
								<th nowrap="">Client</th>
								<th nowrap="">Remise(%)</th>
								<th nowrap="">Net à payer</th>
								<th class="actions"></th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6" style="border:1px solid #e5e5e5;">
				<div id="showdetail"></div>
			</div>
	
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
</div>