<div class="table-scrollable" style="height: auto;">
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="">Magasin</th>
				<th nowrap="">Total HT</th>
				<th nowrap="">Total TTC</th>
				<th nowrap="">Especes</th>
				
				<th nowrap="">Ecommerce</th>
				<th nowrap="">Wallet</th>
				<th nowrap="">Carte</th>
				<th nowrap="">Chèque</th>
				<th nowrap="">Bon d'achat</th>
				<th nowrap="">Chèque cadeau</th>
				<th nowrap="">Offert</th>
				<th nowrap="">Virement</th>
				<th nowrap="">Crédit</th>
				<th nowrap="">Remise</th>
				<th nowrap="">Montant Annulés</th>
				
			</tr>
		</thead>
		<tbody>

			<?php foreach ($results as $dossier): ?>
			<tr>
				<td nowrap="" style="
    color: #7367F0;
    text-decoration: none;
    background-color: transparent;    text-shadow: none;
    font-size: 14px;
    font-weight: 500;">
					
						<?php echo h($dossier[0]['magasin']); ?>
				
				</td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Totalht'])) ? (number_format($dossier[0]['Totalht'],2,","," ")) :  "0.00"  ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Totalttc'])) ? (number_format($dossier[0]['Totalttc'],2,","," ")) :  "0.00" ; ?></td>
				<td nowrap=""class="text-right total_number"><?php echo h (!empty($dossier[0]['Especes'])) ? (number_format($dossier[0]['Especes'],2,","," ")) :  "0.00" ?></td>
			
				
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Ecommerce'])) ? (number_format($dossier[0]['Ecommerce'],2,","," ")) :  "0.00"  ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Wallet'])) ? (number_format($dossier[0]['Wallet'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Carte'])) ? (number_format($dossier[0]['Carte'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Cheque'])) ? (number_format($dossier[0]['Cheque'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Bon_achat'])) ? (number_format($dossier[0]['Bon_achat'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['cheque_cadeau'])) ? (number_format($dossier[0]['cheque_cadeau'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['offert'])) ? (number_format($dossier[0]['offert'],2,","," ")) :  "0.00" ?></td>
				
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['virement'])) ? (number_format($dossier[0]['virement'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['Credit'])) ? (number_format($dossier[0]['Credit'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['remise'])) ? (number_format($dossier[0]['remise'],2,","," ")) :  "0.00" ?></td>
				<td nowrap="" class="text-right total_number"><?php echo h (!empty($dossier[0]['mntAnnule'])) ? (number_format($dossier[0]['mntAnnule'],2,","," ")) :  "0.00" ?></td>
				
			</tr>
			
			<?php endforeach; ?>
		</tbody>
	</table>
</div><div class="row">
	<div class="col-md-5 col-sm-12">
		<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
			<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.'))); ?>
		</div>
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
<div class="row">
	      	<div class="col-md-12">

	      		<div class="table-scrollable">
		          <table class="table table-bordered tableHeadInformation">
		            <tbody>
					
		              <tr>
		                <td class="tableHead" nowrap="">Total HT</td>
		                <td nowrap="" class="text-right total_number">
		                  <?php echo number_format($totalht,2,","," ") ?> 
		                </td>
		                <td class="tableHead" nowrap="">Total TTC</td>
		                <td nowrap=""  class="text-right total_number"> 
		                  <?php echo number_format($totalttc,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Especes</td>
		                <td nowrap="" class="text-right total_number">
		                  <?php echo number_format($especes,2,","," ") ?>
		                </td>
		              </tr>
		              <tr>
		               
						
						<td class="tableHead" nowrap="">Ecommerce</td>
		                <td nowrap=""  class="text-right total_number"> 
		                  <?php echo number_format($Ecommerce,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Wallet</td>
		                <td nowrap="" class="text-right total_number">
		                  <?php echo number_format($Wallet,2,","," ") ?>
		                </td>
						
		                <td class="tableHead" nowrap="">Carte</td>
		                <td nowrap="" class="text-right total_number">
		                  <?php echo number_format($Carte,2,","," ") ; ?>
		                </td>
		              </tr>
		              <tr>
		                
		                
		              </tr>
		              <tr>
		                
						<td class="tableHead" nowrap="">Chèque</td>
		                <td nowrap=""  class="text-right total_number">
		                  <?php echo number_format($Cheque,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Bon d'achat</td>
		                <td class="text-right total_number">
		                  <?php echo number_format($Bon_achat,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Chèque cadeau</td>
		                <td class="text-right total_number">
		                  <?php echo number_format($cheque_cadeau,2,","," ") ?>
		                </td>
		              </tr>
		              <tr>
					  
						<td class="tableHead" nowrap="">Offert</td>
		                <td  class="text-right total_number">
		                  <?php echo number_format($offert,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Virement</td>
		                <td class="text-right total_number">
		                  <?php echo number_format($virement,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Credit</td>
		                <td class="text-right total_number">
		                  <?php echo number_format($Credit,2,","," ") ?>
		                </td>
		              </tr>
		              <tr>
		               
						<td class="tableHead" nowrap="">Remise</td>
		                <td class="text-right total_number">
		                  <?php echo number_format($remise,2,","," ") ?>
		                </td>
						<td class="tableHead" nowrap="">Montant Annullés</td>
		                <td class="text-right total_number">
		                  <?php echo number_format($mntAnnule,2,","," ") ?>
		                </td>
		              </tr>
					 
		            </tbody>
		          </table>
		        </div>

	      	</div>
	  	</div>
