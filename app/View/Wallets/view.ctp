<?php $this->start('modal'); ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php $this->end(); ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
 
				<a class="btn btn-primary edit btn-sm" href="<?php echo $this->Html->url(['action' => 'rechargerwallet', $this->data['Wallet']['id']]); ?>"><i class="fa fa-plus"></i> Recharger wallet</a>
			

  </div>
</div>


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
                  <?php echo $this->data['Client']['designation']; ?>
                </td>
                <td class="tableHead" nowrap="">Montant</td>
                <td nowrap="" class="text-right"> 
                  <?php echo number_format($this->data['Wallet']['montant'], 2, ',', ' '); ?>
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
      Historique des paiements
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
								<th nowrap="">Mode</th>
								<th nowrap="">Montant</th>
								<th nowrap="">Num cheque</th>
                <th nowrap="">Date</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details_paiement as $tache): ?>
								<tr>
									<td nowrap=""><?php echo h($tache['PaiementWallet']['reference']); ?></td>
									<td nowrap=""><?php echo h($tache['PaiementWallet']['mode']); ?></td>
									<td nowrap="" class="text-right"><?php echo h(number_format($tache['PaiementWallet']['montant'], 2, ',', ' ')); ?></td>
									<td nowrap=""><?php echo h($tache['PaiementWallet']['num_cheque']); ?></td>
                  <td nowrap=""><?php echo h($tache['PaiementWallet']['date_c']); ?></td>
								
								</tr>
							<?php endforeach; ?>
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
									<td nowrap="" class="text-right"><?php echo h(number_format($tache['Walletdetail']['montant'], 2, ',', ' ')); ?></td>
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

    <?php $this->start('js'); ?>
<script>
   var Init = function(){
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
   
    $('.uniform').uniform();
  }
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
</script>

<?php $this->end(); ?>














