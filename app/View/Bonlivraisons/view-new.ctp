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
  .TotalLabel{
    width: 80%;
    text-align: right;
    font-weight: bold;
    padding: 10px;
  }
  .TotalValue{
    width: 20%;
    text-align: right;
    font-weight: bold;
    padding: 10px;
  }
</style>
<?php if ( isset( $this->data['Bonlivraison']['id'] ) AND !empty( $this->data['Bonlivraison']['id'] ) ): ?>

<?php if ( !empty( $this->data['Bonlivraison']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Bonlivraison']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Bonlivraison']['etat'] ) ?>">
        <strong>Statut bon de livraison &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Bonlivraison']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      <i class="icon-paper-plane"></i>
      <span class="caption-subject bold uppercase"> Bon de livraison N° : <?php echo $this->data['Bonlivraison']['reference'] ?> </span>
    </div>
    <div class="actions">

      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
      <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $globalPermission['Permission']['i'] AND $this->data['Bonlivraison']['etat'] != 3 ): ?>
        <?php if ( $MOBILE ): ?>
          <a href="<?php echo $this->Html->url(['action'=>'generatepdf',$this->data['Bonlivraison']['id']]) ?>" class="PrintThisPage btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
        <?php else: ?>
          <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Bonlivraison']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
        <?php endif ?>
      <?php endif ?>
      
      <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $this->data['Bonlivraison']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
      <?php endif ?>

      <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $this->data['Bonlivraison']['etat'] == 1 ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],2 ]) ?>" class="changestate btn btn-success btn-sm"><i class="fa fa-check-square-o"></i> Clôturer </a>
        <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],3 ]) ?>" class="changestate btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler </a>
      <?php endif ?>

      <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $this->data['Bonlivraison']['etat'] == 2 ): ?>
        <?php if ( empty( $this->data['Bonlivraison']['facture_id'] ) ): ?>
          <a href="<?php echo $this->Html->url(['action'=>'facture',$this->data['Bonlivraison']['id'] ]) ?>" class="changestate btn btn-success btn-sm"><i class="fa fa-file"></i> Générer une facture</a>
        <?php else: ?>
          <a href="<?php echo $this->Html->url(['controller'=>'factures','action'=>'view',$this->data['Bonlivraison']['facture_id'] ]) ?>" class="btn btn-danger btn-sm"><i class="fa fa-file"></i> Voir la facture</a>
        <?php endif ?>
      <?php endif ?>

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
                  <?php echo $this->data['Bonlivraison']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date bon de livraison</td>
                <td nowrap=""> 
                  <?php echo $this->data['Bonlivraison']['date'] ?>
                </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="" colspan="3">
                  <?php echo $this->data['Client']['designation'] ?>
                </td>
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
      <i class="fa fa-cubes"></i>
      <span class="caption-subject bold uppercase"> Liste des produits </span>
    </div>
    <div class="actions">
      <?php if ($globalPermission['Permission']['a'] AND $this->data['Bonlivraison']['etat'] != 3 ): ?>
        <button href="<?php echo $this->Html->url(['action' => 'row']) ?>" class="addRow btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Ajouter une ligne</button>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">

        <div class="table-scrollable ">
          <!-- DETAILS -->
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th width="20%">Désignation</th>
                <th width="11%">Stock actuel</th>
                <th width="11%">Prix de vente</th>
                <th width="11%">Paquet </th>
                <th width="11%">Quantité</th>
                <th width="11%">Total pièce</th>
                <th width="11%">Total HT</th>
                <th width="11%">Total TTC</th>
                <th width="11%" class="actions">Actions</th>
              </tr>
            </thead>

            <?php $url = ['controller'=>'bonlivraisons','action'=>'savedetails',$this->data['Bonlivraison']['id'] ] ?>
            <?php echo $this->Form->create('Bonlivraisondetail',['id' => 'FormMultipleRow','class' => 'form-horizontal','url'=>$url]); ?>
            <tbody id="Main">
              <?php $total = 0;$total_ttc = 0;$total_qte = 0;$total_paquet = 0;$total_piece = 0; ?>
              <?php foreach ($details as $k => $tache): ?>

                <?php $total_qte = $total_qte + $tache['Bonlivraisondetail']['qte']; ?>
                <?php $total_paquet = $total_paquet + $tache['Bonlivraisondetail']['paquet']; ?>
                <?php $total = $total + $tache['Bonlivraisondetail']['total']; ?>
                <?php $total_ttc = $total_ttc + $tache['Bonlivraisondetail']['ttc']; ?>
                <?php $total_piece = $total_piece + $tache['Bonlivraisondetail']['total_unitaire']; ?>

                <tr class="child">
                  <td nowrap="" width="20%">
                    <?php echo $this->Form->hidden('Detail.'.$k.'.id',['value'=>$tache['Bonlivraisondetail']['id'],'form' => 'FormMultipleRow']); ?>
                    <?php echo $this->Form->input('Detail.'.$k.'.produit_id',['class' => 'produit_id form-control','label'=>false,'disabled' => true,'empty'=>'-- Votre choix','form' => 'FormMultipleRow','options'=>$produits,'value'=>$tache['Bonlivraisondetail']['produit_id'] ]); ?>
                    <?php echo $this->Form->hidden('Detail.'.$k.'.produit_id',['value'=>$tache['Bonlivraisondetail']['produit_id'],'form' => 'FormMultipleRow']); ?>
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php echo $this->Form->input('Detail.'.$k.'.stock_source',['class' => 'stock_source form-control','label'=>false,'disabled' => true,'value'=>$tache['Depotproduit']['quantite'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php echo $this->Form->input('Detail.'.$k.'.prix_vente',['class' => 'prix_vente form-control','label'=>false,'readonly' => true,'value'=>$tache['Bonlivraisondetail']['prix_vente'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php if ( $this->data['Bonlivraison']['etat'] == 3 OR $this->data['Bonlivraison']['etat'] == 2 ): ?>
                      <?php echo $this->Form->input('Detail.'.$k.'.paquet',['class' => 'paquet form-control','label'=>false,'readonly' => true,'value'=>$tache['Bonlivraisondetail']['paquet'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                    <?php else: ?>
                      <?php echo $this->Form->input('Detail.'.$k.'.paquet',['class' => 'paquet form-control','label'=>false,'required' => true,'value'=>$tache['Bonlivraisondetail']['paquet'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                    <?php endif ?>
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php if ( $this->data['Bonlivraison']['etat'] == 3 OR $this->data['Bonlivraison']['etat'] == 2 ): ?>
                      <?php echo $this->Form->input('Detail.'.$k.'.qte',['class' => 'qte form-control','label'=>false,'readonly' => true,'value'=>$tache['Bonlivraisondetail']['qte'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                    <?php else: ?>
                      <?php echo $this->Form->input('Detail.'.$k.'.qte',['class' => 'qte form-control','label'=>false,'required' => true,'value'=>$tache['Bonlivraisondetail']['qte'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                    <?php endif ?>
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php echo $this->Form->input('Detail.'.$k.'.total_unitaire',['class' => 'total_unitaire form-control','label'=>false,'readonly' => true,'value'=>$tache['Bonlivraisondetail']['total_unitaire'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php echo $this->Form->input('Detail.'.$k.'.total',['class' => 'total form-control','label'=>false,'readonly' => true,'value'=>$tache['Bonlivraisondetail']['total'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                  </td>
                  <td nowrap="" width="11%" class="text-right">
                    <?php echo $this->Form->input('Detail.'.$k.'.ttc',['class' => 'ttc form-control','label'=>false,'readonly' => true,'value'=>$tache['Bonlivraisondetail']['ttc'] ,'form' => 'FormMultipleRow','type'=>'number','style'=>'text-align:right','min'=>1,'default'=>0]); ?>    
                  </td>
                  <td nowrap="" width="11%" class="actions">
                    <?php if ( $this->data['Bonlivraison']['etat'] == -1 ): ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Bonlivraisondetail']['id'], $tache['Bonlivraisondetail']['bonlivraison_id']]) ?>" class="btnFlagDelete btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
                      <?php endif ?>
                    <?php endif ?>
                  </td>
                </tr>

              <?php endforeach; ?>
            </tbody>
            <?php echo $this->Form->end(); ?>
          </table>
          <!-- DETAILS -->
        </div><hr/>
        <div class="table-responsive" style="min-height: auto;">
          <!-- TOTAL -->
          <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0" width="100%">
            <tbody class="">
              <tr>
                <td class="TotalLabel">Total HT</td>
                <td class="TotalValue">
                  <?php echo $this->Form->hidden('Bonlivraison.id',['form' => 'FormMultipleRow']); ?>
                  <?php echo $this->Form->input('Bonlivraison.total_a_payer_ht',['class' => 'total_a_payer_ht form-control','label'=>false,'readonly' => true ,'form' => 'FormMultipleRow','style'=>'text-align:right']); ?>  
                </td>
              </tr>
              <tr>
                <td class="TotalLabel">% TVA</td>
                <td class="TotalValue">
                  <?php echo $this->Form->input('Bonlivraison.tva',['class' => 'tva form-control','label'=>false,'readonly' => true ,'form' => 'FormMultipleRow','default'=>'20.00','style'=>'text-align:right','type'=>'number']); ?>  
                </td>
              </tr>
              <tr>
                <td class="TotalLabel">Total TTC</td>
                <td class="TotalValue">
                  <?php echo $this->Form->input('Bonlivraison.total_a_payer_ttc',['class' => 'total_a_payer_ttc form-control','label'=>false,'readonly' => true ,'form' => 'FormMultipleRow','style'=>'text-align:right']); ?>  
                </td>
              </tr>
              <tr>
                <td class="TotalLabel">Réduction (Dhs)</td>
                <td class="TotalValue">
                  <?php if ( $this->data['Bonlivraison']['etat'] == 3 OR $this->data['Bonlivraison']['etat'] == 2 ): ?>
                    <?php echo $this->Form->input('Bonlivraison.reduction',['class' => 'reduction form-control','label'=>false,'readonly' => true ,'form' => 'FormMultipleRow','style'=>'text-align:right','min'=>0,'default'=>0,'step'=>1]); ?>  
                  <?php else: ?>
                    <?php echo $this->Form->input('Bonlivraison.reduction',['class' => 'reduction form-control','label'=>false,'required' => false ,'form' => 'FormMultipleRow','style'=>'text-align:right','min'=>0,'default'=>0,'step'=>1]); ?>  
                  <?php endif ?>
                </td>
              </tr>
              <tr>
                <td class="TotalLabel">Total TTC aprés réduction</td>
                <td class="TotalValue">
                  <?php echo $this->Form->input('Bonlivraison.total_apres_reduction',['class' => 'total_apres_reduction form-control','label'=>false,'readonly' => true ,'form' => 'FormMultipleRow','style'=>'text-align:right']); ?>  
                </td>
              </tr>
            </tbody>
            <?php if ( $this->data['Bonlivraison']['etat'] == 3 OR $this->data['Bonlivraison']['etat'] == 2 ): ?>
            <?php else: ?>
            <tbody>
              <tr>
                <td nowrap="" width="100%" style="text-align: right;" colspan="9">
                  <?php echo $this->Form->input('<i class="fa fa-floppy-o"></i> Valider & Terminer',array('label'=>false,'div'=>false,'form' => 'FormMultipleRow','class' => 'saveBtn btn btn-success btn-md','type'=>'button','escape'=>false,'disabled'=>true)) ?>
                </td>
              </tr>
            </tbody>
            <?php endif ?>
          </table>
          <!-- TOTAL -->
        </div>

      </div>
    </div>
  </div>
</div>

<!-- AVANCES -->
<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Paiement
    </div>
    <div class="actions">
        <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Bonlivraison']['id'] ) AND ($this->data['Bonlivraison']['etat'] == 1 OR $this->data['Bonlivraison']['etat'] == 2) ): ?>
          <a href="<?php echo $this->Html->url(['action' => 'editavance',0,$this->data['Bonlivraison']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Effectuer un paiement</a>
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
                <th nowrap="">Date de délivrance</th>
                <th nowrap="">Date échéance</th>
                <th nowrap="">Mode paiment</th>
                <th nowrap="">N° pièce</th>
                <th nowrap="">Statut</th>
                <th nowrap="">Montant</th>
                <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $this->data['Bonlivraison']['etat'] == 1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
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
                <td nowrap="">
                  <?php if ( !empty( $value['Avance']['etat'] ) ): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getStatutAvanceColor($value['Avance']['etat']); ?>">
                      <?php echo $this->App->getStatutAvance($value['Avance']['etat']); ?>
                    </span>
                  <?php endif ?>
                </td>
                <td nowrap="" class="text-right"><?php echo number_format($value['Avance']['montant'], 2, ',', ' ') ?></td>
                <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $this->data['Bonlivraison']['etat'] == 1 ): ?>
                <td nowrap="" class="actions">
                  <?php if ( $globalPermission['Permission']['s'] AND $value['Avance']['etat'] == -1 ): ?>
                    <a href="<?php echo $this->Html->url(['action' => 'deleteavance', $value['Avance']['id'], $value['Avance']['bonlivraison_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i> Supprimer</a>
                  <?php endif ?>
                </td>
                <?php endif ?>
              </tr>
              <?php endforeach ?>
              <tr class="total">
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap="" ></td>
                <td nowrap=""  class="text-right"><strong><?php echo number_format($total_montant, 2, ',', ' ') ?></strong></td>
                <?php if ( isset( $this->data['Bonlivraison']['id'] ) AND $this->data['Bonlivraison']['etat'] == 1 ): ?>
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
<!-- AVANCES -->

<?php endif ?>

<?php $this->start('js') ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;

  var count = $('tbody#Main .child').length;
  if( count > 0 ) $('.saveBtn').attr('disabled',false);
  else $('.saveBtn').attr('disabled',true);

  $('.PrintThisPage').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    toastr.error("Pour imprimer ce document veuillez se connectez via un ordinateur ! ");
  });
  
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').datepicker({ 
      format: "dd-mm-yyyy",
      orientation: "left",
      autoclose: true,
      language: 'fr',
    });
  }

  Init();

  /* Multiple rows V 2.0 */

  $('#FormMultipleRow').on('submit',function(e){
    $('.saveBtn').attr('disabled',true);
  });

  $('.addRow').on('click',function(e){
    e.preventDefault();
      var count = $('tbody#Main .child').length;
      var depot_id = 1;
      if( count >= 0 ) $('.saveBtn').attr('disabled',false);
      else $('.saveBtn').attr('disabled',true);

    $.ajax({
      url: $(this).attr('href')+'/'+count+'/'+depot_id,
      success: function(dt){
        $('tbody#Main').append(dt);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });

  $('#Main').on('change','.produit_id',function(e){
    var depot_id = 1;
    var produit_id = $(this).val();
    var element =  $(this).closest('.child');
    loadQuatite(depot_id,produit_id,element);
  });

  $('#Main').on('click','.deleteRow',function(e){
    e.preventDefault();
    var element = $(this);
    element.closest('.child').remove();
    var count = $('tbody#Main .child').length;
    if( count == 0 ) $('.saveBtn').attr('disabled',true);
    else $('.saveBtn').attr('disabled',false);

    var count = $('tbody#Main .child').length;
    calculetotal(count);
  });

  $('#Main').on('input','.paquet',function(e){
    var element = $(this).closest('.child');
    calcul(element);
  });

  $('#Main').on('input','.qte',function(e){
    var element = $(this).closest('.child');
    calcul(element);
  });

  function calcul(element) {
    var prix_vente = element.find('.prix_vente').val();
    var paquet = element.find('.paquet').val();
    var qte = element.find('.qte').val();
    if( prix_vente == '' ) prix_vente = 0;
    if( paquet == '' ) paquet = 0;
    if( qte == '' ) qte = 0;

    var total_unitaire =  parseInt(paquet)*parseInt(qte);
    element.find('.total_unitaire').val( total_unitaire.toFixed(2) );

    var total = parseInt(total_unitaire)*parseInt(prix_vente);
    element.find('.total').val( total.toFixed(2) );

    var ttc = total * ( 1 + 20/100 );
    element.find('.ttc').val( ttc.toFixed(2) );

    var count = $('tbody#Main .child').length;
    calculetotal(count);
  }

  function calculetotal(count) {
    var total_a_payer_ht = 0;
    for (i = 0; i < count; i++) {
      total_a_payer_ht = parseInt( total_a_payer_ht ) + parseInt( $("input[name='data[Detail]["+i+"][total]']").val() );
    }

    $('.total_a_payer_ht').val(total_a_payer_ht.toFixed(2));
    var total_a_payer_ttc = parseInt( total_a_payer_ht ) * ( 1 + 20/100 );
    $('.total_a_payer_ttc').val(total_a_payer_ttc.toFixed(2));
    var reduction = $('.reduction').val();
    var total_apres_reduction = parseInt(total_a_payer_ttc)-parseInt(reduction);
    $('.total_apres_reduction').val(total_apres_reduction.toFixed(2));

  }

  $('.reduction').on('input',function(){
    var count = $('tbody#Main .child').length;
    calculetotal(count);
  });

  function loadQuatite(depot_id,produit_id,element) {
      $.ajax({
        dataType: "json",
        url: "<?php echo $this->Html->url(['action' => 'loadquatite']) ?>/"+depot_id+"/"+produit_id,
        success: function(dt){
          if ( dt.quantite >= 0 ) {
            element.find('.stock_source').val( dt.total );
            element.find('.prix_vente').val( dt.prix_vente );
            element.find('.qte').attr({ "max" : dt.quantite });
            element.find('.paquet').attr({ "max" : dt.paquet });
          }
        },
        error: function(dt){
          toastr.error("Il y a un problème");
        }
      }); 
  }

  /* Multiple rows V 2.0 */

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

    if( tva == '' ) tva = 0;
    if( paquet == '' ) paquet = 1;
    if( quantite == '' ) quantite = 0; 
    if( prix_vente == '' ) prix_vente = 0; 

    var total_quantite = quantite*paquet;
    $('#TotalUnitaire').val(total_quantite);

    var total = total_quantite * prix_vente;
    $('#Total').val( total.toFixed(2) );

    var totaltva =  total * ( 1 + tva/100 );
    $('#TotalTVA').val( totaltva.toFixed(2) );

  }

  function getProduit(produit_id,depot_id) {
      $.ajax({
        dataType:'JSON',
        url: "<?php echo $this->Html->url(['action' => 'getProduit']) ?>/"+produit_id+'/'+depot_id,
        success: function(dt){
          if (typeof(dt.Produit) != 'undefined'){
            var prix_vente = parseFloat(dt.Produit.prix_vente);
            var tva = parseFloat(dt.Produit.tva);
            var max_quantite = dt.Depotproduit.quantite;
            var max_paquet = dt.Depotproduit.paquet;
            $('#Total').val(0);
            $('#TotalTVA').val(0);
            $('#PrixVente').val(prix_vente);
            $('#TVA').val(tva);
            $('#QteChange').attr('max',max_quantite);
            $('#PaquetChange').attr('max',max_paquet);
            calculeTotal();
          }
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