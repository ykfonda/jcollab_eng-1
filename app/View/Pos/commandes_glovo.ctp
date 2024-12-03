<div class="modal-header">
	<h4 class="modal-title">	
		Liste des commandes glovo (<?php echo count($commandeglovos); ?>)
	
		
</div>
<div class="modal-body ">
	<div class="row">
		<?php if (empty($commandeglovos)): ?>
			<div class="col-md-12">
				<div class="alert alert-danger text-center p-2" style="font-weight: bold;font-size: 20px;">Liste des articles est vide !</div>
			</div>
		<?php else: ?>
			<div class="col-md-6" style="border:1px solid #e5e5e5;">
		         <div class="input-group mt-1">
		            <div class="input-group input-group-merge">
		                <div class="input-group-append">
		                  <button class="btn btn-default btn-reset-ecommerce" type="button"><i class="fa fa-refresh"></i>&nbspActualiser</button>
		                </div>       
		            </div>
		        </div>
				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th class="actions"></th>
								<th nowrap="">No Commande</th>
								<th nowrap="">Temps</th>
								<th nowrap="">Client</th>
								<th class="actions"></th>
							</tr>
						</thead>
						<tbody id="EcommerceList">
							<?php foreach ($commandeglovos  as $dossier): ?>
								<tr>
									<td nowrap=""><a class="traitercommande btn btn-danger btn-sm btn-block" attrUrl="<?php echo $this->Html->url(['action' => 'checkecommerce', $dossier['Commandeglovo']['id']]); ?>" href="<?php echo $this->Html->url(['action' => 'traitercommandeglovo', $dossier['Commandeglovo']['id']]); ?>"><i class="fa fa-reply"></i> Traiter</a></td>
									<td nowrap=""><a class="getdetail" href="<?php echo $this->Html->url(['action' => 'ecommercedetails', $dossier['Commandeglovo']['id']]); ?>"><?php echo h($dossier['Commandeglovo']['order_code']); ?></a></td>
									<td nowrap=""><?php echo h($dossier['Commandeglovo']['order_time']); ?></td>
									<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
									<td nowrap="" class="actions">
										<a class="getdetail btn btn-primary btn-sm btn-block" href="<?php echo $this->Html->url(['action' => 'Commandeglovodetails', $dossier['Commandeglovo']['id']]); ?>"><i class="fa fa-eye"></i> Détails</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6" style="border:1px solid #e5e5e5;">
				<div id="showdetail">
					
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
