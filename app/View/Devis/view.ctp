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
  .total{
    
  }
</style>
<?php if ( isset( $this->data['Devi']['id'] ) AND !empty( $this->data['Devi']['id'] ) ): ?>

<?php if ( !empty( $this->data['Devi']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Devi']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Devi']['etat'] ) ?>">
        <strong>Statut devis &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Devi']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
    <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Devi']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    
    <?php if ( $globalPermission['Permission']['i'] ): ?>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Devi']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Devi']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif ?>
    
    <?php if ( $this->data['Devi']['etat'] == -1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Devi']['id'],1 ]) ?>" class="action btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
    <?php endif ?>

    <?php if ( $this->data['Devi']['etat'] == 1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Devi']['id'],2 ]) ?>" class="action btn btn-success btn-sm"><i class="fa fa-refresh"></i> Valider devis </a>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Devi']['id'],-1 ]) ?>" class="action btn btn-warning btn-sm"><i class="fa fa-edit"></i> Continuer la saisie </a>
    <?php endif ?>

     <?php if ( $this->data['Devi']['etat'] == 2 ): ?>
      <?php if ( empty( $this->data['Devi']['bonlivraison_id'] ) ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'bonlivraison',$this->data['Devi']['id'] ]) ?>" class="action btn btn-success btn-sm"><i class="fa fa-file"></i> Générer bon de livraison </a>
      <?php else: ?>
        <a href="<?php echo $this->Html->url(['controller'=>'bonlivraisons','action'=>'view',$this->data['Devi']['bonlivraison_id'] ]) ?>" class="btn btn-danger btn-sm"><i class="fa fa-file"></i> Voir le bon de livraison</a>
      <?php endif ?>
    <?php endif ?> 

  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['m1'] AND empty( $this->data['Devi']['bonlivraison_id'] ) ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Devi']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-bordered tableHeadInformation">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Devi']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap=""> 
                  <?php echo $this->data['Devi']['date'] ?>
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
                  <?php echo number_format($this->data['Devi']['montant_tva'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Devi']['remise'], 2, ',', ' '); ?> %
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Devi']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Devi']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Devi']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Net à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Devi']['total_apres_reduction'], 2, ',', ' '); ?>
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
      <?php if ( $globalPermission['Permission']['a'] AND $this->data['Devi']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Devi']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter produit </a>
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
                <th nowrap="">Remise (%)</th>
                <th nowrap="">Total TTC</th>
                <?php if ( $this->data['Devi']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Devidetail']['qte']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Devidetail']['prix_vente'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo $tache['Devidetail']['remise']; ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Devidetail']['ttc'], 2, ',', ' '); ?></td>
                  <?php if ( $this->data['Devi']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Devidetail']['id'], $tache['Devidetail']['devi_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Devidetail']['id'], $tache['Devidetail']['devi_id']]) ?>" class="action"><i class="fa fa-trash-o"></i></a>
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
</script>
<?php echo $this->element('view-script',['client_id' => $this->data['Devi']['client_id'] ] ); ?>
<?php $this->end() ?>