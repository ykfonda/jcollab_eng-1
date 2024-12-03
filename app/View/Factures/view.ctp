<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<style type="text/css">
  .red{
    color: white;
    background-color: #e67e22;
  }
</style>

<?php if ( isset( $this->data['Facture']['id'] ) AND !empty( $this->data['Facture']['id'] ) ): ?>

<?php if ( !empty( $this->data['Facture']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Facture']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Facture']['etat'] ) ?>">
        <strong>Statut de la facture &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Facture']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
    <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Facture']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php if ( isset( $this->data['Facture']['id'] ) AND $globalPermission['Permission']['i'] ): ?>
      <?php if ( $MOBILE ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'generatepdf',$this->data['Facture']['id']]) ?>" class="PrintThisPage btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
      <?php else: ?>
        <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Facture']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
        <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Facture']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
      <?php endif ?>
    <?php endif ?>

    <?php if ( isset( $this->data['Facture']['id'] ) AND $this->data['Facture']['etat'] == -1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Facture']['id'],1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
    <?php endif ?>

    <?php if ( isset( $this->data['Facture']['id'] ) AND $this->data['Facture']['etat'] == 1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Facture']['id'],2 ]) ?>" class="changestate btn btn-success btn-sm"><i class="fa fa-check-square-o"></i> Valider </a>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Facture']['id'],-1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-edit"></i> Modifier </a>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Facture']['id'],3 ]) ?>" class="changestate btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler </a>
    <?php endif ?>

    <?php if ( isset( $this->data['Facture']['id'] ) AND isset( $this->data['Facture']['bonlivraison_id'] ) ): ?>
      <a href="<?php echo $this->Html->url(['controller'=>'bonlivraisons','action'=>'view',$this->data['Facture']['bonlivraison_id']]) ?>" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> Voir le bon de livraison</a>
    <?php endif ?>
    
  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information facture
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['m1'] AND isset( $this->data['Facture']['id'] ) AND ($this->data['Facture']['etat'] == 1 OR $this->data['Facture']['etat'] == -1) ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Facture']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier remise </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-bordered">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Facture']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date facture</td>
                <td nowrap=""> 
                  <?php echo $this->data['Facture']['date'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="">
                  <?php echo $this->data['Client']['designation'] ?>
                </td>
                <td class="tableHead" nowrap="">Depot</td>
                <td nowrap="">
                  <?php echo $this->data['Depot']['libelle'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Vendeur</td>
                <td nowrap="" >
                  <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
                </td>
                <td class="tableHead" nowrap="">Statut</td>
                <td nowrap="" >
                  <?php if ( $globalPermission['Permission']['m1'] ): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($this->data['Facture']['paye']); ?>">
                      <a style="text-decoration: none;color: white;" class="edit" href="<?php echo $this->Html->url(['action'=>'editstatut',$this->data['Facture']['id']]) ?>"><i class="fa fa-refresh"></i> <?php echo $this->App->getStatutPayment($this->data['Facture']['paye']); ?></a>
                    </span>
                  <?php else: ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($this->data['Facture']['paye']); ?>">
                      <?php echo $this->App->getStatutPayment($this->data['Facture']['paye']); ?>
                    </span>
                  <?php endif ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Montant TVA</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Facture']['montant_tva'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Facture']['remise'], 2, ',', ' '); ?> %
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Facture']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Facture']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Facture']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Total payé</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Facture']['total_paye'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Le reste à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Facture']['reste_a_payer'], 2, ',', ' '); ?>
                </td>
                  <td class="tableHead" nowrap="">Net à payer</td>
                  <td nowrap="" class="text-right total_number"> 
                    <?php echo number_format($this->data['Facture']['total_apres_reduction'], 2, ',', ' '); ?>
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
      <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Facture']['id'] ) AND $this->data['Facture']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Facture']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter produit </a>
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
                <th nowrap="">Quantité</th>
                <th nowrap="">Prix TTC</th>
                <th nowrap="">Remise(%)</th>
                <th nowrap="">Total TTC</th>
                <?php if ( $this->data['Facture']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php $total = 0; ?>
              <?php foreach ($details as $tache): ?>
                <?php $total = $total + $tache['Facturedetail']['ttc']; ?>
                <tr >
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  
                  <td nowrap="" class="text-right"><?php echo h($tache['Facturedetail']['qte']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Facturedetail']['prix_vente'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo (int)$tache['Facturedetail']['remise']; ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Facturedetail']['ttc'], 2, ',', ' '); ?></td>
                  <?php if ( $this->data['Facture']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Facturedetail']['id'], $tache['Facturedetail']['facture_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Facturedetail']['id'], $tache['Facturedetail']['facture_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
                      <?php endif ?>
                  </td>
                  <?php endif ?>
                </tr>
              <?php endforeach; ?>
              <tr class="total">
                <td nowrap=""></td>
                <td nowrap=""></td>
                <td nowrap=""></td>
                <td nowrap=""></td>
                <td nowrap=""></td>
                <td nowrap="" class="text-right"><strong><?php echo number_format($total, 2, ',', ' ') ?></strong></td>
                <?php if ( $this->data['Facture']['etat'] == -1 ): ?>
                <td nowrap="" class="actions"></td>
                <?php endif ?>
              </tr>
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
      Paiement
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Facture']['id'] ) AND ($this->data['Facture']['etat'] == 1 OR $this->data['Facture']['etat'] == 2) ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editavance',0,$this->data['Facture']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Effectuer un paiement</a>
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
                <th nowrap="">Référence</th>
                <th nowrap="">Date de délivrance</th>
                <th nowrap="">Date échéance</th>
                <th nowrap="">Mode paiment</th>
                <th nowrap="">N° pièce</th>
                <th nowrap="">Emeteur</th>
                <th nowrap="">Statut</th>
                <th nowrap="">Montant</th>
                <th class="actions">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $total_montant = 0; ?>
              <?php foreach ($avances as $key => $value): ?>
              <?php $total_montant = $total_montant + $value['Avance']['montant']; ?>
              <tr>
                <td nowrap=""><?php echo h($value['Avance']['reference']) ?></td>
                <td nowrap=""><?php echo h($value['Avance']['date']) ?></td>
                <td nowrap=""><?php echo h($value['Avance']['date_echeance']) ?></td>
                <td nowrap=""><?php echo ( !empty( $value['Avance']['mode'] ) ) ? $this->App->getModePaiment($value['Avance']['mode']) : '' ; ?></td>
                <td nowrap=""><?php echo h($value['Avance']['numero_piece']) ?></td>
                <td nowrap=""><?php echo h($value['Avance']['emeteur']) ?></td>
                <td nowrap="">
                  <?php if ( !empty( $value['Avance']['etat'] ) ): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getStatutAvanceColor($value['Avance']['etat']); ?>">
                      <?php echo $this->App->getStatutAvance($value['Avance']['etat']); ?>
                    </span>
                  <?php endif ?>
                </td>
                <td nowrap="" class="text-right"><?php echo number_format($value['Avance']['montant'], 2, ',', ' ') ?></td>
                <td nowrap="" class="actions">
                  <?php if ( $globalPermission['Permission']['s'] AND $value['Avance']['etat'] == -1 ): ?>
                    <a href="<?php echo $this->Html->url(['action' => 'deleteavance', $value['Avance']['id'], $value['Avance']['facture_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i> Supprimer</a>
                  <?php endif ?>
                </td>
              </tr>
              <?php endforeach ?>
              <tr class="total">
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap=""  class="text-right"><strong><?php echo number_format($total_montant, 2, ',', ' ') ?></strong></td>
                <td nowrap="" class="actions"></td>
              </tr>
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
  var depot_id = parseInt("<?php echo $this->data['Facture']['depot_id'] ?>");
  var client_id = parseInt("<?php echo $this->data['Facture']['client_id'] ?>");
  var dataFilter = null;
  var dataPage = 1;

  $('.PrintThisPage').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    toastr.error("Pour imprimer ce document veuillez se connectez via un ordinateur ! ");
    /*$.ajax({
      url: url,
      dataType:'JSON',
      success : function(dt){
        var lien = dt.url;
        window.open('https://docs.google.com/viewer?url='+lien+'&embedded=true', '_blank', 'location=yes'); 
      }
    });*/
  });

  var Init = function(){
    $('.uniform').uniform();
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });

   /*  var detail_id = $('#DetailID').val();
    if ( typeof detail_id != 'undefined' && detail_id != '' ) { */
      /*  var categorieproduit_id = $('#CategorieproduitID').val();
      if( typeof categorieproduit_id != 'undefined' && categorieproduit_id != '' )  */
      /* var produit_id = $("#ArticleID").val();
      if( typeof produit_id != 'undefined' && produit_id != '' ) getProduit(produit_id,depot_id,client_id); */ 
     /* }  */
     /* getProduitByDepot(depot_id,categorieproduit_id); */
  }

  Init();

  /*  function getProduitByDepot(depot_id,categorieproduit_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'getProduitByDepot',$this->data['Facture']['id'] ]) ?>/"+depot_id+"/"+categorieproduit_id,
      success: function(dt){
        var value = $('#ArticleID').val();
        $('#ArticleID').empty();
        $('#ArticleID').append($('<option>').text('-- Votre choix').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#ArticleID').append($('<option>').text(obj).attr('value', i));
        });
        $('#ArticleID').val( value ).trigger('change');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }  */

  /* $('#edit').on('change','#CategorieproduitID',function(e){
    var categorieproduit_id = $('#CategorieproduitID').val();
    getProduitByDepot(depot_id,categorieproduit_id);
  }); */

  


  $('#edit').on('input','#QteChange,#Remise,#PrixVente',function(e){
    calculeTotal();
  });

  $('#edit').on('input','#Reduction',function(e){
    var total_before = $('#TotalBefore').val();
    var reste_a_payer = $('#RestePayer').data('reste');
    var reduction = $(this).val();
    var total_after = total_before-reduction;
    if ( total_after <= 0 ) total_after = 0;
    $('#TotalAfter').val(total_after);
    $('#RestePayer').val(total_after);
  });

  function calculeTotal() {
    var tva = $('#TVA').val();;
    var quantite = $('#QteChange').val();
    var paquet = $('#PaquetChange').val();
    var prix_vente = $('#PrixVente').val();
    var remise = $('#Remise').val();

    if( tva == '' ) tva = 0;
    if( paquet == '' ) paquet = 1;
    if( remise == '' ) remise = 0; 
    if( quantite == '' ) quantite = 0; 
    if( prix_vente == '' ) prix_vente = 0; 

    var total_quantite = quantite*paquet;
    $('#TotalUnitaire').val(total_quantite);

    var total = (total_quantite * prix_vente);
    $('#Total').val( total.toFixed(2) );

    var discounted_price = (total.toFixed(2) * remise / 100);
    $('#MontantRemise').val(discounted_price.toFixed(2));
    var montant_remise = $('#MontantRemise').val();
    var final_result = total.toFixed(2)-montant_remise;
    $('#Total').val( final_result.toFixed(2) );

    var totaltva =  total * ( 1 + tva/100 );
    $('#TotalTVA').val( totaltva.toFixed(2) );
  }

  $('#edit').on('change','#ArticleID',function(e){
    var produit_id = $('#ArticleID').val();
    if ( produit_id == '' ) {
      $('#Total').val(0);
      $('#TotalTVA').val(0);
      $('#PrixVente').val(0);
      $('#MessageContent').html('');
      $('#MessageContainer').hide();
      $('#TotalUnitaire').removeAttr('max');
      $('#QteChange').removeAttr('max');
    } else {
      getProduit(produit_id,depot_id,client_id);
    }
  });

  function getProduit(produit_id,depot_id,client_id) {
    $.ajax({
      dataType:'JSON',
      url: "<?php echo $this->Html->url(['action' => 'getProduit']) ?>/"+produit_id+'/'+depot_id+'/'+client_id,
      success: function(dt){
        if (produit_id != ''){
          var prix_vente = parseFloat(dt.Produit.prix_vente);
          var tva = parseFloat(dt.Produit.tva);
         /*  var quantite = dt.Depotproduit.quantite;
          var max_paquet = dt.Depotproduit.paquet;
          var total_piece = dt.Depotproduit.total; */
          var remise = parseFloat(dt.remise);
          
        /*   var message = "La quantité disponible dans le dépot est : <b>"+quantite+" unité(s). </b>"; */
          $('#Total').val(0);
          $('#TotalTVA').val(0);
          $('#PrixVente').val(prix_vente);
          $('#TVA').val(tva);
          $('#Remise').val(remise);
          /* $('#TotalUnitaire').attr('max',quantite);
          $('#QteChange').attr('max',quantite); */
          //$('#MessageContent').html(message);
          $('#MessageContainer').show();
        }else{
          $('#TotalUnitaire').removeAttr('max');
          $('#QteChange').removeAttr('max');
          $('#MessageContent').html('');
          $('#MessageContainer').hide();
        }
      },
      error: function(dt){
        $('#Total').val('');
        $('#PrixVente').val('');
        toastr.error("Il y a un probléme");
      },
      complete: function(){
        calculeTotal();
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
  $('#edit').on('submit','#ScanForm',function(e){
    
    //e.preventDefault();
    alert("ok");
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
          $("#Total").val(prix*quantite_sortie);
          
        
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