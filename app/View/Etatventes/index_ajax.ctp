<?php $total_achat = 0; $total_vente = 0; $total_marge = 0; ?>
<?php foreach ($details as $value): ?>
	<?php $valeur_achat = $value['Bonlivraisondetail']['qte']*$value['Produit']['prixachat']; ?>
	<?php $total_achat = $total_achat + $valeur_achat; ?>
	<?php $total_vente = $total_vente + $value['Bonlivraisondetail']['total']; ?>
	<?php $marge_binificaire = $value['Bonlivraisondetail']['total']-$valeur_achat; ?>
	<?php $total_marge = $total_marge + $marge_binificaire; ?>
<?php endforeach; ?>
<br/>
<div class="row">
    <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    	<div class="dashboard-stat dashboard-stat-v2 blue">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo count( $details ) ?>"><?php echo count( $details ) ?> vente(s)</span>
                </div>
                <div class="desc"> Nombre total </div>
            </div>
        </div>
    </div> -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    	<div class="dashboard-stat dashboard-stat-v2 blue">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $remise ?>"><?php echo number_format($remise, 2, ',', ' '); ?></span>
                </div>
                <div class="desc"> Total des remise </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 red">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $total_achat ?>"><?php echo number_format($total_achat, 2, ',', ' '); ?></span>
                </div>
                <div class="desc"> Total des achats </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 green">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $total_vente ?>"><?php echo number_format($total_vente-$remise, 2, ',', ' '); ?></span>
                </div>
                <div class="desc"> Total des ventes </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 purple">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $total_marge ?>"><?php echo number_format($total_marge, 2, ',', ' '); ?></span>
                </div>
                <div class="desc"> Marge total </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive" style="min-height: auto;">
			<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th nowrap="">Date</th>
						<th nowrap="">Bon de livraison</th>
						<th nowrap="">Remise (%)</th>
						<th nowrap="">Code à barre</th>
						<th nowrap="">Libelle</th>
						<th nowrap="">Qté</th>
						<th nowrap="">Prix d'achat</th>
						<th nowrap="">Total prix d'achat</th>
						<th nowrap="">Prix de vente</th>
						<th nowrap="">Total prix vente</th>
						<th nowrap="">Marge bénéficiaire</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($taches as $tache): ?>
					<tr>
						<td nowrap=""><?php echo h($tache['Bonlivraison']['date']); ?></td>
						<td nowrap="">
							<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'bonlivraisons','action' => 'view', $tache['Bonlivraison']['id']]) ?>"><?php echo h($tache['Bonlivraison']['reference']); ?></a>
						</td>
						<td nowrap=""><span style="color: red">(<?php echo (int)$tache['Bonlivraison']['remise'] ?>%)</span></td>
						<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller'=>'produits','action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['code_barre']); ?></a></td>
						<td nowrap=""><a target="_blank" href="<?php echo $this->Html->url(['controller'=>'produits','action' => 'view', $tache['Produit']['id']]) ?>"><?php echo h($tache['Produit']['libelle']); ?></a></td>
						<td nowrap=""><?php echo h($tache['Bonlivraisondetail']['qte']); ?></td>
						<td nowrap="" class="text-right"><?php echo number_format($tache['Produit']['prixachat'], 2, ',', ' '); ?></td>
						<?php $valeur_achat = $tache['Bonlivraisondetail']['qte']*$tache['Produit']['prixachat']; ?>
						<td nowrap="" class="text-right"><?php echo number_format($valeur_achat, 2, ',', ' '); ?></td>
						<td nowrap="" class="text-right"><?php echo number_format($tache['Bonlivraisondetail']['prix_vente'], 2, ',', ' '); ?></td>
						<td nowrap="" class="text-right"><?php echo number_format($tache['Bonlivraisondetail']['total'], 2, ',', ' '); ?></td>
						<?php $marge_binificaire = $tache['Bonlivraisondetail']['total']-$valeur_achat; ?>
						<?php $class = ( $marge_binificaire < 0 ) ? 'red' : 'green' ; ?>
						<td nowrap="" class="text-right <?php echo $class ?>"><?php echo number_format($marge_binificaire, 2, ',', ' '); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row" style="font-weight: bold;">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite"><?php
		echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.')
		)); ?></div>
	</div>
	<div class="col-md-7 col-sm-12">
		<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
			<ul class="pagination">
				<?php 
				    echo $this->Paginator->prev( '<', array( 'class' => 'page-link', 'tag' => 'li' ), null,  array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				    echo $this->Paginator->numbers( array( 'class' => 'page-link', 'tag' => 'li', 'separator' => '', 'currentClass' => 'page-link active', 'currentTag' => 'a' ) );
				    echo $this->Paginator->next( '>', array( 'class' => 'page-link', 'tag' => 'li' ), null, array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				?>
			</ul>
		</div>
	</div>
</div>