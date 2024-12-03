<?php $total_paye = 0.00; $reste_a_payer = 0.00; $total_a_payer = 0.00 ?>
<?php foreach ($ventes as $dossier): ?>
	<?php $total_paye = (float) $total_paye + $dossier['Vente']['total_paye']; ?>
	<?php $reste_a_payer = (float) $reste_a_payer + $dossier['Vente']['reste_a_payer']; ?>
	<?php $total_a_payer = (float) $total_a_payer + $dossier['Vente']['total_a_payer']; ?>
<?php endforeach; ?>
<br/>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    	<div class="dashboard-stat dashboard-stat-v2 blue">
            <div class="visual">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo count( $ventes ) ?>"><?php echo count( $ventes ) ?> vente(s)</span>
                </div>
                <div class="desc"> Nombre total </div>
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
                    <span data-counter="counterup" data-value="<?php echo $total_paye ?>"><?php echo $total_paye ?></span>
                </div>
                <div class="desc"> Total payé </div>
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
                    <span data-counter="counterup" data-value="<?php echo $reste_a_payer ?>"><?php echo $reste_a_payer ?></span>
                </div>
                <div class="desc"> Total restant </div>
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
                    <span data-counter="counterup" data-value="<?php echo $total_a_payer ?>"><?php echo $total_a_payer ?></span>
                </div>
                <div class="desc"> Total à payer </div>
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
						<th nowrap="">Référence</th>
						<th nowrap="">Client</th>
						<th nowrap="">Vendeur</th>
						<th nowrap="">Date vente</th>
						<th nowrap="">Etat vente</th>
						<th nowrap="">Total payé</th>
						<th nowrap="">Reste à payer</th>
						<th nowrap="">Total à payer</th>
						<th class="actions" nowrap="">
					</tr>
				</thead>
				<tbody>
					<?php foreach ($taches as $dossier): ?>
						<tr>
							<td nowrap="">
								<?php if ( $globalPermission['Permission']['m1'] ): ?>
									<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Vente']['id']]) ?>"><?php echo h($dossier['Vente']['reference']); ?></a>
								<?php else: ?>
									<?php echo h($dossier['Vente']['reference']); ?>
								<?php endif ?>
							</td>
							<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
							<td nowrap=""><?php echo h($dossier['User']['nom']); ?> <?php echo h($dossier['User']['prenom']); ?></td>
							<td nowrap=""><?php echo h($dossier['Vente']['date']); ?></td>
							<td nowrap="">
								<?php if ( !empty( $dossier['Vente']['etat'] ) ): ?>
									<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatFicheColor($dossier['Vente']['etat']); ?>">
										<?php echo $this->App->getEtatFiche($dossier['Vente']['etat']); ?>
									</span>
								<?php endif ?>
							</td>
							<td nowrap="" class="text-right"><?php echo h($dossier['Vente']['total_paye']); ?></td>
							<td nowrap="" class="text-right"><?php echo h($dossier['Vente']['reste_a_payer']); ?></td>
							<td nowrap="" class="text-right"><?php echo h($dossier['Vente']['total_a_payer']); ?></td>
							<td nowrap="" class="actions">
								<?php if ( $globalPermission['Permission']['m1'] ): ?>
									<a href="<?php echo $this->Html->url(['action'=>'view',$dossier['Vente']['id']]) ?>"><i class="fa fa-eye"></i></a>
								<?php endif ?>
								<?php if ( $globalPermission['Permission']['s'] AND $user_id == 1 ): ?>
									<a href="<?php echo $this->Html->url(['action' => 'delete', $dossier['Vente']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
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