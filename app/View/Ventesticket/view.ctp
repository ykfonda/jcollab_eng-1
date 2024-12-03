<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>

<?php if ( isset( $this->data['Salepoint']['id'] ) AND !empty( $this->data['Salepoint']['id'] ) ): ?>

<?php if ( !empty( $this->data['Salepoint']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Salepoint']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Salepoint']['etat'] ) ?>">
        <strong>Statut de la vente &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Salepoint']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">

    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
    <?php if ( $this->data['Salepoint']['etat'] != 3 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Salepoint']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php endif ?>

    <?php if ( $globalPermission['Permission']['i'] AND $this->data['Salepoint']['etat'] != 3 ): ?>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Salepoint']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Salepoint']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif ?>

  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information vente
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
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Salepoint']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date vente</td>
                <td nowrap=""> 
                  <?php echo $this->data['Salepoint']['date'] ?>
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
                <td class="tableHead" nowrap="">Vendeur</td>
                <td nowrap="" >
                  <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
                </td>
                <td class="tableHead" nowrap="">Statut</td>
                <td nowrap="" >
                  <?php if ( !empty($this->data['Salepoint']['paye'])): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($this->data['Salepoint']['paye']); ?>">
                      <?php echo $this->App->getStatutPayment($this->data['Salepoint']['paye']); ?>
                    </span>
                  <?php endif ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Salepoint']['remise'], 2, ',', ' '); ?> %
                </td>
                <td class="tableHead" nowrap="">Montant TVA</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Salepoint']['montant_tva'], 2, ',', ' '); ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Salepoint']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Salepoint']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Total payé</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Salepoint']['total_paye'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Le reste à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Salepoint']['reste_a_payer'], 2, ',', ' '); ?>
                </td>
                  <td class="tableHead" nowrap="">Net à payer</td>
                  <td nowrap="" class="text-right total_number"> 
                    <?php echo number_format($this->data['Salepoint']['total_apres_reduction'], 2, ',', ' '); ?>
                  </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Frais de livraison</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Salepoint']['fee'], 2, ',', ' '); ?>
                </td>
                  <td class="tableHead" nowrap="">Adresse de livraison</td>
                  <td nowrap="" class="text-right total_number"> 
                    
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

    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable" >
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Désignation</th>
                <th nowrap="">Prix TTC</th>
                <th nowrap="">Qté cmd</th>
                <th nowrap="">Qté livré</th>
                <th nowrap="">Remise (%)</th>
                <th nowrap="">Total TTC</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Salepointdetail']['qte_cmd'], 3, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Salepointdetail']['qte'], 3, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Salepointdetail']['remise'], 2, ',', ' '); ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' '); ?></td>
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
      Paiement
    </div>
    <div class="actions">
        <?php if ( $globalPermission['Permission']['a'] AND isset( $this->data['Salepoint']['id'] ) AND ($this->data['Salepoint']['etat'] == 1 OR $this->data['Salepoint']['etat'] == 2) ): ?>
          <a href="<?php echo $this->Html->url(['action' => 'editavance',0,$this->data['Salepoint']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Effectuer un paiement</a>
        <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable" >
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Référence</th>
                <th nowrap="">Date de délivrance</th>
                <th nowrap="">Date échéance</th>
                <th nowrap="">Mode paiment</th>
                <th nowrap="">N° pièce</th>
                <th nowrap="">Emeteur</th>
                <th nowrap="">Montant</th>
                <?php if ( isset( $this->data['Salepoint']['id'] ) AND ($this->data['Salepoint']['etat'] == 1 OR $this->data['Salepoint']['etat'] == 2) ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($avances as $key => $value): ?>
                <?php if($value['Avance']['montant'] != 0) : ?>
                <tr>
                  <td nowrap=""><?php echo h($value['Avance']['reference']) ?></td>
                  <td nowrap=""><?php echo h($value['Avance']['date']) ?></td>
                  <td nowrap=""><?php echo h($value['Avance']['date_echeance']) ?></td>
                  <td nowrap=""><?php echo ( !empty( $value['Avance']['mode'] ) ) ? $this->App->getModePaiment($value['Avance']['mode']) : '' ; ?></td>
                  <td nowrap=""><?php echo h($value['Avance']['numero_piece']) ?></td>
                  <td nowrap=""><?php echo h($value['Avance']['emeteur']) ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($value['Avance']['montant'], 2, ',', ' ') ?></td>
                  <?php if ( isset( $this->data['Salepoint']['id'] ) AND ($this->data['Salepoint']['etat'] == 1 OR $this->data['Salepoint']['etat'] == 2) ): ?>
                  <td nowrap="" class="actions">
                    <?php if ( $globalPermission['Permission']['s'] AND $value['Avance']['etat'] == -1 ): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'deleteavance', $value['Avance']['id'], $value['Avance']['salepoint_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i> Supprimer</a>
                    <?php endif ?>
                  </td>
                  <?php endif ?>
                </tr>
                <?php endif ?>
              <?php endforeach ?>
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
  var depot_id = 1;
  var dataFilter = null;
  var dataPage = 1;

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

  $('#edit').on('submit','form',function(e){
    $('.saveBtn').attr('disabled',true);
    $('#Loading').slideDown();
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