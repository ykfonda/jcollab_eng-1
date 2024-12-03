<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset($this->data['Commande']['id']) AND !empty( $this->data['Commande']['id'] ) ): ?>

<?php if ( !empty( $this->data['Commande']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatCommandeColor( $this->data['Commande']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatCommandeColor( $this->data['Commande']['etat'] ) ?>">
        <strong>Statut de bon commande &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatCommande( $this->data['Commande']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
    <?php if ( $this->data['Commande']['etat'] != 3 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Commande']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php endif ?>
    
    <?php if ( $globalPermission['Permission']['i'] AND $this->data['Commande']['etat'] != 3 ): ?>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Commande']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Commande']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif ?>
    
    <?php if ( empty( $this->data['Commande']['bonlivraison_id'] ) ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'bonlivraison',$this->data['Commande']['id'] ]) ?>" class="action btn btn-success btn-sm"><i class="fa fa-file"></i> Générer bon de livraison </a>
      <?php else: ?>
        <a href="<?php echo $this->Html->url(['controller'=>'bonlivraisons','action'=>'view',$this->data['Commande']['bonlivraison_id'] ]) ?>" class="btn btn-danger btn-sm"><i class="fa fa-file"></i> Voir le bon de livraison</a>
      <?php endif ?>

    <?php if ( $this->data['Commande']['etat'] == -1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Commande']['id'],3 ]) ?>" class="changestate btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i> Annuler la commande </a>
    <?php endif ?>

  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information bon de commande
    </div>
    <div class="actions">
      <?php if ( $this->data['Commande']['etat'] == -1 AND $globalPermission['Permission']['m1'] ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Commande']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-bordered ">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Commande']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date commande</td>
                <td nowrap=""> 
                  <?php echo $this->data['Commande']['date'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="">
                  <?php echo $this->data['Client']['designation'] ?>
                </td>
                <td class="tableHead" nowrap="">Dépot</td>
                <td nowrap="">
                  <?php echo $this->data['Depot']['libelle'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Montant TVA</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Commande']['montant_tva'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Commande']['remise'], 2, ',', ' '); ?> %
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Commande']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Commande']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Commande']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Net à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Commande']['total_apres_reduction'], 2, ',', ' '); ?>
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

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Liste des produits
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['a'] AND $this->data['Commande']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Commande']['id'],$this->data['Commande']['client_id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter produit </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Désignation</th>
                <th nowrap="">Qté cmd</th>
                <th nowrap="">Qté livré</th>
                <th nowrap="">Prix</th>
                <th nowrap="">Remise (%)</th>
                <th nowrap="">Total</th>
                <?php if ( $this->data['Commande']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Commandedetail']['qte_cmd']); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Commandedetail']['qte']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Commandedetail']['prix_vente'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo $tache['Commandedetail']['remise']; ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Commandedetail']['ttc'], 2, ',', ' '); ?></td>
                  <?php if ( $this->data['Commande']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Commandedetail']['id'], $tache['Commandedetail']['commande_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Commandedetail']['id'], $tache['Commandedetail']['commande_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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

<?php $this->start('js') ?>
<script>
$(function(){
  var depot_id = parseInt("<?php echo ( isset($this->data['Commande']['depot_id']) AND !empty($this->data['Commande']['depot_id']) ) ? $this->data['Commande']['depot_id'] : 1 ; ?>");

  var Init = function(){
    $('.uniform').uniform();
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  Init();

  $('#edit').on('input','#QteChange,#Remise,#PrixVente',function(e){
    calculeTotal();
  });

  function calculeTotal() {
    var tva = $('#TVA').val();
    var quantite = $('#QteChange').val();
    var prix_vente = $('#PrixVente').val();
    var remise = $('#Remise').val();

    if( tva == '' ) tva = 20;
    if( remise == '' ) remise = 0; 
    if( quantite == '' ) quantite = 0; 
    if( prix_vente == '' ) prix_vente = 0; 

    var total_ttc = (quantite * prix_vente);
    $('#TotalTTC').val( total_ttc.toFixed(2) );

    var discounted_price = (total_ttc.toFixed(2) * remise / 100);
    $('#MontantRemise').val(discounted_price.toFixed(2));
    var montant_remise = $('#MontantRemise').val();
    var final_result = total_ttc.toFixed(2)-montant_remise;
    $('#Total').val( final_result.toFixed(2) );

    var division_tva = (1+tva/100);

    var total_ht =  total_ttc/division_tva;
    $('#TotalHT').val( total_ht.toFixed(2) );
    var montant_tva = total_ttc-total_ht;
    $('#MontantTVA').val(montant_tva);
  }

  $('#edit').on('change','#ArticleID',function(e){
    var depot_id = 1;
    var produit_id = $(this).val();
    if ( produit_id == '' ) {
      $('#Total').val(0);
      $('#TotalTVA').val(0);
      $('#PrixVente').val(0);
    }
    var client_id = $('#CommandedetailClientId').val();
    getProduit(produit_id,depot_id,client_id);
  });

  function getProduit(produit_id,depot_id,client_id) {
   
    $.ajax({
      dataType:'JSON',
      url: "<?php echo $this->Html->url(['action' => 'getProduit']) ?>/"+produit_id+'/'+depot_id+'/'+client_id,
      success: function(dt){
        var prix_vente = parseFloat(dt.prix_vente);
        var tva = parseFloat(dt.tva);
       
        if( $('#PrixVente').val() == '' ) $('#PrixVente').val(prix_vente);
        $('#TVA').val(tva);
        $('#Total').val(0);
        $('#TotalTVA').val(0);
        $('#Remise').val(dt.remise);
        calculeTotal();
      },
      error: function(dt){
        $('#Total').val('');
        $('#PrixVente').val('');
        toastr.error("Il y a un probléme");
      },
      complete: function(){

      }
    });
  }

  $('#edit').on('submit','form',function(e){

    $('.saveBtn').attr('disabled',true);
    $('#Loading').slideDown();
  });

  $('#indexAjax').on('click','.edit',function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });
  
  $('.edit').on('click',function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });

  $('.changestate').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });

  $('.btnFlagDelete').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });
  
  $('#edit').on('keyup','#code_barre',function(e){
    var code_barre = $('#code_barre').val();
    if (e.keyCode === 13) {
      var code_barre = $('#code_barre').val();
  		scaning(code_barre);
    }
    
  });
  $("#code_barre").keyup(function(){
    
alert('444');

});
  $('#edit').on('submit','#ScanForm',function(e){
    
	//e.preventDefault();
  		var code_barre = $('#code_barre').val();
  		scaning(code_barre);
  	});

	function scaning(code_barre) {
		if ( code_barre == '' || code_barre == '#' ) { toastr.error("Aucun code barre saisie !"); return; }

		

	    $.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'scan']) ?>/"+code_barre,
	      success: function(result){
	      	if ( result.error == true ) toastr.error(result.message);
	      	else{
	      		/* var quantite_sortie = result.data.quantite_sortie;
	      		var produit_id = result.data.produit_id;
	      		var stock = result.data.stock;

	      		var full_path = url+'/'+produit_id+'/'+stock+'/'+quantite_sortie;
	      	 */	var quantite_sortie = result.data.quantite_sortie;
	      		var prix = result.data.prix;
			    var produit_id = result.data.produit_id;
			    $("#QteChange").val(quantite_sortie);
				$("#PrixVente").val(prix);
				$("#TotalTTC").val(prix*quantite_sortie);
        
				
        $("#ArticleID").val(produit_id).trigger('change');
				

	      	} 
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(dt){
			$('#code_barre').val('');
	      }
	    });
	}

	
});
</script>
<?php $this->end() ?>