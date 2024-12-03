<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php $this->end() ?>



	<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Informations Wallet
    </div>
    <div class="actions">
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable" >
          <table class="table table-bordered tableHeadInformation">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="">
                  <?php echo $this->data['Client']['designation'] ?>
                </td>
                <td class="tableHead" nowrap="">Montant</td>
                <td nowrap=""> 
                  <?php echo $this->data['Wallet']['montant'] ?>
                </td>
              </tr>

              <!-- <tr>
                <td class="tableHead" nowrap="">NOMBRE DE PRODUIT(S)</td>
                <td nowrap="">
                  
                </td>
                <td class="tableHead" nowrap="">Type de sortie</td>
                <td nowrap="">
                  
                </td>
              </tr>
            -->
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Historique des transactions
    </div>
    <div class="actions">

    </div>
  </div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12">

	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Référence</th>
								<th nowrap="">Ref ticket</th>
								<th nowrap="">Montant</th>
								<th nowrap="">Date</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details as $tache): ?>
								<tr>
									<td nowrap=""><?php echo h($tache['Walletdetail']['reference']); ?></td>
									<td nowrap=""><?php echo h($tache['Walletdetail']['ref_ticket']); ?></td>
									<td nowrap=""><?php echo h($tache['Walletdetail']['montant']); ?></td>
                  <td nowrap=""><?php echo h($tache['Walletdetail']['date_c']); ?></td>
								
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

	      	</div>
	    </div>
  	</div>
	  </div>



















