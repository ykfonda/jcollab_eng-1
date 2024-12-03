<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>

<?php if ( isset( $this->data['Vente']['id'] ) AND !empty( $this->data['Vente']['id'] ) ): ?>

  <?php if ( !empty( $this->data['Vente']['etat'] ) ): ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Vente']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Vente']['etat'] ) ?>">
          <strong>Statut vente &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Vente']['etat'] ) ?>
        </div>
      </div>
    </div>
  <?php endif ?>

  <div class="row" style="margin-bottom: 10px;text-align: right;">
    <div class="col-lg-12">
      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
      
      <?php if ( isset( $this->data['Vente']['id'] ) AND $globalPermission['Permission']['i'] ): ?>
        <?php if ( $MOBILE ): ?>
          <a href="<?php echo $this->Html->url(['action'=>'generatepdf',$this->data['Vente']['id']]) ?>" class="PrintThisPage btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
        <?php else: ?>
          <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Vente']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
        <?php endif ?>
      <?php endif ?>
      
      <?php if ( isset( $this->data['Vente']['id'] ) AND $this->data['Vente']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Vente']['id'],1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
      <?php endif ?>

      <?php if ( isset( $this->data['Vente']['id'] ) AND $this->data['Vente']['etat'] == 1 ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Vente']['id'],2 ]) ?>" class="changestate btn btn-success btn-sm"><i class="fa fa-refresh"></i> Valider la vente</a>
      <?php endif ?>

      <?php if ( isset( $this->data['Vente']['id'] ) AND ( $this->data['Vente']['etat'] == 1 OR $this->data['Vente']['etat'] == 2 ) ): ?>
        <?php if ( empty( $this->data['Vente']['facture_id'] ) ): ?>
          <a href="<?php echo $this->Html->url(['action'=>'facture',$this->data['Vente']['id'] ]) ?>" class="changestate btn btn-danger btn-sm"><i class="fa fa-file"></i> Générer une facture</a>
        <?php else: ?>
          <a href="<?php echo $this->Html->url(['controller'=>'factures','action'=>'view',$this->data['Vente']['facture_id'] ]) ?>" class="btn btn-danger btn-sm"><i class="fa fa-file"></i> Voir la facture</a>
        <?php endif ?>
      <?php endif ?>

    </div>
  </div>

  <div class="portlet light bordered">
    <div class="portlet-title">
      <div class="caption">
        Information vente
      </div>
      <div class="actions">
        <!-- <?php if ( $globalPermission['Permission']['m1'] AND isset( $this->data['Vente']['id'] ) AND $this->data['Vente']['etat'] == 1 ): ?>
          <a href="<?php echo $this->Html->url(['action' => 'reduction',$this->data['Vente']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-money"></i> Réduction</a>
        <?php endif ?> -->
      </div>
    </div>
    <div class="portlet-body">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive" style="min-height: auto;">
            <table class="table table-bordered tableHeadInformation">
              <tbody>
                <tr>
                  <td class="tableHead" nowrap="">Référence</td>
                  <td nowrap="">
                    <?php echo $this->data['Vente']['reference'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Date vente</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Vente']['date'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Vendeur</td>
                  <td nowrap="" >
                    <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
                  </td>
                </tr>
                <tr>
                  <td class="tableHead" nowrap="">Client</td>
                  <td nowrap="" >
                    <?php echo $this->data['Client']['designation'] ?>
                  </td>
                  <td class="tableHead" nowrap="">Total à payer</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Vente']['total_a_payer']; ?>
                  </td>
                  <td class="tableHead" nowrap="">Total payé</td>
                  <td nowrap="">
                    <?php echo h($this->data['Vente']['total_paye']) ?>  
                  </td>
                </tr>
                <tr>
                  <td class="tableHead" nowrap="">Le reste à payer</td>
                  <td nowrap="" colspan="5"> 
                    <?php echo $this->data['Vente']['reste_a_payer'] ?>
                  </td>
                </tr>
               <!--  <tr>
                  <td class="tableHead" nowrap="">Réduction</td>
                  <td nowrap="">
                    <?php echo h($this->data['Vente']['reduction']) ?>  
                  </td>
                  <td class="tableHead" nowrap="">Net à payer</td>
                  <td nowrap=""> 
                    <?php echo $this->data['Vente']['total_apres_reduction'] ?>
                  </td>
                </tr> -->
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
      <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Vente']['id'] ) AND $this->data['Vente']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Vente']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter</a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Désignation</th>
                <th nowrap="">Prix HT</th>
                <th nowrap="">TVA</th>
                <th nowrap="">Quantité</th>
                <th nowrap="">Total HT</th>
                <th nowrap="">Total TTC</th>
                <?php if ( $this->data['Vente']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php $total = 0;$total_ttc = 0;$total_qte = 0; ?>
              <?php foreach ($details as $tache): ?>
                <?php $total = $total + $tache['Ventedetail']['total']; ?>
                <?php $total_ttc = $total_ttc + $tache['Ventedetail']['ttc']; ?>
                <?php $total_qte = $total_qte + $tache['Ventedetail']['qte']; ?>
                <?php $cssClass = '' ?>
                <?php if ( $tache['Depotproduit']['quantite'] <= $tache['Produit']['stock_min'] ): ?>
                <?php $cssClass = 'background-color:#f0c9c9;' ?>
                <?php endif ?>
                <tr style="<?php //echo $cssClass ?>">
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?> 
                    <?php if ( $tache['Depotproduit']['quantite'] <= $tache['Produit']['stock_min'] ): ?>
                    <span class="badge badge-danger"> Stock épuisé </span> 
                    <?php endif ?>
                  </td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Ventedetail']['prixachat'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Produit']['tva']); ?>%</td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Ventedetail']['qte']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Ventedetail']['total'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Ventedetail']['ttc'], 2, ',', ' '); ?></td>
                  <?php if ( $this->data['Vente']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Ventedetail']['id'], $tache['Ventedetail']['vente_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Ventedetail']['id'], $tache['Ventedetail']['vente_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
                      <?php endif ?>
                  </td>
                  <?php endif ?>
                </tr>
              <?php endforeach; ?>
              <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"><strong><?php echo $total_qte ?></strong></td>
                <td class="text-right"><strong><?php echo number_format($total, 2, ',', ' ') ?></strong></td>
                <td class="text-right"><strong><?php echo number_format($total_ttc, 2, ',', ' ') ?></strong></td>
                <?php if ( $this->data['Vente']['etat'] == -1 ): ?>
                <td class="actions"></td>
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
        <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Vente']['id'] ) AND ($this->data['Vente']['etat'] == 1 OR $this->data['Vente']['etat'] == 2) ): ?>
          <a href="<?php echo $this->Html->url(['action' => 'editavance',0,$this->data['Vente']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter</a>
        <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Référence</th>
                <th nowrap="">Date</th>
                <th nowrap="">Mode paiment</th>
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
                <td nowrap=""><?php echo ( !empty( $value['Avance']['mode'] ) ) ? $this->App->getModePaiment($value['Avance']['mode']) : '' ; ?></td>
                <td nowrap="" class="text-right"><?php echo number_format($value['Avance']['montant'], 2, ',', ' ') ?></td>
                <td nowrap="" class="actions">
                  <?php if ( $globalPermission['Permission']['s'] AND $value['Avance']['etat'] == -1 ): ?>
                    <a href="<?php echo $this->Html->url(['action' => 'deleteavance', $value['Avance']['id'], $value['Avance']['vente_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i> Supprimer</a>
                  <?php endif ?>
                </td>
              </tr>
              <?php endforeach ?>
              <tr class="total">
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
  var dataFilter = null;
  var dataPage = 1;
  var categorieclient_id = <?php echo ( isset( $this->data['Client']['categorieclient_id'] ) AND !empty( $this->data['Client']['categorieclient_id'] ) ) ? (int) $this->data['Client']['categorieclient_id'] : 1 ; ?>;

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

  var loadIndexAjax = function(url){
    $.ajax({
      url: url,
      success : function(dt){
        $('#PieceJointes').html(dt);
      }
    });
  }
  
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });

    var depot_id = 1;
    var detail_id = $('#DetailID').val();
    if ( typeof detail_id != 'undefined' && detail_id != '' ) {
      var categorieproduit_id = $('#CategorieproduitID').val();
      if( typeof categorieproduit_id != 'undefined' && categorieproduit_id != '' ) getProduitByDepot(depot_id,categorieproduit_id);
      var produit_id = $("#ArticleID").val();
      if( typeof produit_id != 'undefined' && produit_id != '' ) getProduit(produit_id,depot_id);
    }
    
  }

  Init();

  function getProduitByDepot(depot_id,categorieproduit_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'getProduitByDepot',$this->data['Vente']['id'] ]) ?>/"+depot_id+"/"+categorieproduit_id,
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
  }

  $('#edit').on('change','#CategorieproduitID',function(e){
    var categorieproduit_id = $('#CategorieproduitID').val();
    var depot_id = 1;
    getProduitByDepot(depot_id,categorieproduit_id);
  });
  
  $('#edit').on('change','#DepotID',function(e){
    var depot_id = $(this).val();
    $('#Total').val(0);
    $('#TotalTVA').val(0);
    $('#PrixAchat').val(0);
    getProduitByDepot(depot_id);
  });

  $('#edit').on('input','#QteChange',function(e){
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
    var qte = $('#QteChange').val();
    var prix_vente = $('#PrixAchat').val();
    var tva = $('#TVA').val();;
    if( qte == '' ) qte = 0; 
    if( prix_vente == '' ) prix_vente = 0; 
    if( tva == '' ) tva = 1;

    var total = qte * prix_vente;
    $('#Total').val( total.toFixed(2) );
    var totaltva =  total * ( 1 + 20/100 );
    $('#TotalTVA').val( totaltva.toFixed(2) );

  }

  $('#edit').on('change','#ArticleID',function(e){
    var depot_id = 1;
    var produit_id = $(this).val();
    if ( produit_id == '' ) {
      $('#Total').val(0);
      $('#TotalTVA').val(0);
      $('#PrixAchat').val(0);
    }
    getProduit(produit_id,depot_id,categorieclient_id);
  });

  function getProduit(produit_id,depot_id,categorieclient_id) {
      $.ajax({
        dataType:'JSON',
        url: "<?php echo $this->Html->url(['action' => 'getProduit']) ?>/"+produit_id+'/'+depot_id+'/'+categorieclient_id,
        success: function(dt){
            var prix_vente = parseFloat(dt.prix_vente);
            var max = parseInt(dt.quantite);
            var tva = parseFloat(dt.tva);
            $('#Total').val(0);
            $('#TotalTVA').val(0);
            if ( $('#PrixVente').val() == '' ) $('#PrixVente').val(prix_vente);
            $('#TVA').val(tva);
            $('#QteChange').attr('max',max);
            calculeTotal();
        },
        error: function(dt){
          $('#Total').val('');
          $('#PrixAchat').val('');
          toastr.error("Il y a un probléme");
        },
        complete: function(){

        }
      });
  }

  $('#edit').on('submit','form',function(e){
    $('.saveBtn').attr('disabled',true);
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

});
</script>
<?php $this->end() ?>