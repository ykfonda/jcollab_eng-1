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

<?php if ( isset($this->data['Bonlivraison']['id']) AND !empty( $this->data['Bonlivraison']['id'] ) ): ?>

<?php if ( !empty( $this->data['Bonlivraison']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Bonlivraison']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Bonlivraison']['etat'] ) ?>">
        <strong>Statut bon de livraison &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Bonlivraison']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
    <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Bonlivraison']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php if ( $globalPermission['Permission']['i'] AND $this->data['Bonlivraison']['etat'] != 3 ): ?>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Bonlivraison']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Bonlivraison']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif ?>
    
    <?php if ( $this->data['Bonlivraison']['etat'] == -1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],1 ]) ?>" class="action btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
    <?php endif ?>

    <?php if ( $this->data['Bonlivraison']['etat'] == 1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],2 ]) ?>" class="action btn btn-success btn-sm"><i class="fa fa-check-square-o"></i> Valider </a>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],-1 ]) ?>" class="action btn btn-warning btn-sm"><i class="fa fa-edit"></i> Continuer la saisie </a>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Bonlivraison']['id'],3 ]) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-ban"></i> Annuler </a>
    <?php endif ?>

    <?php if ( $this->data['Bonlivraison']['etat'] == 2 ): ?>
      <?php if ( empty( $this->data['Bonlivraison']['facture_id'] ) ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'facture',$this->data['Bonlivraison']['id'] ]) ?>" class="action btn btn-success btn-sm"><i class="fa fa-file"></i> Générer une facture</a>
      <?php else: ?>
        <a href="<?php echo $this->Html->url(['controller'=>'factures','action'=>'view',$this->data['Bonlivraison']['facture_id'] ]) ?>" class="btn btn-danger btn-sm"><i class="fa fa-file"></i> Voir la facture</a>
      <?php endif ?>
    <?php endif ?>

  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information bon de livraison
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['m1'] AND ($this->data['Bonlivraison']['etat'] == 1 OR $this->data['Bonlivraison']['etat'] == -1) ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Bonlivraison']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable" >
          <table class="table table-bordered">
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
                  <?php if ( !empty($this->data['Bonlivraison']['paye']) ): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($this->data['Bonlivraison']['paye']); ?>">
                      <?php echo $this->App->getStatutPayment($this->data['Bonlivraison']['paye']); ?>
                    </span>
                  <?php endif ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Bonlivraison']['remise'], 2, ',', ' '); ?> %
                </td>
                
                <td class="tableHead" nowrap="">Montant TVA</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Bonlivraison']['montant_tva'], 2, ',', ' '); ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Bonlivraison']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Bonlivraison']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Bonlivraison']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Total payé</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Bonlivraison']['total_paye'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Le reste à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Bonlivraison']['reste_a_payer'], 2, ',', ' '); ?>
                </td>
                  <td class="tableHead" nowrap="">Net à payer</td>
                  <td nowrap="" class="text-right total_number"> 
                    <?php echo number_format($this->data['Bonlivraison']['total_apres_reduction'], 2, ',', ' '); ?>
                  </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Fournisseur</td>
                <td nowrap="" > 
                  <?php echo $this->data['Fournisseur']['designation'] ?>
                </td>
                <td class="tableHead" nowrap=""></td>
                <td nowrap="" > 
                  
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
      <?php if ( $globalPermission['Permission']['a'] AND $this->data['Bonlivraison']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Bonlivraison']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter produit </a>
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
                <th nowrap="">Désignation</th>
               
                <th nowrap="">Prix TTC</th>
                <th nowrap="">Quantité</th>
                <th nowrap="">Remise (%)</th>
                <th nowrap="">Total TTC</th>
                <?php if ( $this->data['Bonlivraison']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Bonlivraisondetail']['prix_vente'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Bonlivraisondetail']['qte']); ?></td>
                  <td nowrap="" class="text-right"><?php echo $tache['Bonlivraisondetail']['remise']; ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Bonlivraisondetail']['ttc'], 2, ',', ' '); ?></td>
                  <?php if ( $this->data['Bonlivraison']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Bonlivraisondetail']['id'], $tache['Bonlivraisondetail']['bonlivraison_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Bonlivraisondetail']['id'], $tache['Bonlivraisondetail']['bonlivraison_id']]) ?>" class="action"><i class="fa fa-trash-o"></i></a>
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

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Paiement
    </div>
    <div class="actions">
        <?php if ( $globalPermission['Permission']['a'] AND ($this->data['Bonlivraison']['etat'] == 1 OR $this->data['Bonlivraison']['etat'] == 2) ): ?>
          <a href="<?php echo $this->Html->url(['action' => 'editavance',0,$this->data['Bonlivraison']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Effectuer un paiement</a>
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
                <th nowrap="">Statut</th>
                <th nowrap="">Montant</th>
                <?php if ( ($this->data['Bonlivraison']['etat'] == 1 OR $this->data['Bonlivraison']['etat'] == 2) ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($avances as $key => $value): ?>
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
                  <?php if ( ($this->data['Bonlivraison']['etat'] == 1 OR $this->data['Bonlivraison']['etat'] == 2) ): ?>
                  <td nowrap="" class="actions">
                    <?php if ( $globalPermission['Permission']['s'] AND $value['Avance']['etat'] == -1 ): ?>
                      <a href="<?php echo $this->Html->url(['action' => 'deleteavance', $value['Avance']['id'], $value['Avance']['bonlivraison_id']]) ?>" class="action"><i class="fa fa-trash-o"></i> Supprimer</a>
                    <?php endif ?>
                  </td>
                  <?php endif ?>
                </tr>
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
<?php if ( isset($this->data['Bonlivraison']['depot_id']) AND !empty( $this->data['Bonlivraison']['depot_id'] ) ): ?>
<?php echo $this->element('view-script-stock',['depot_id' => $this->data['Bonlivraison']['depot_id'],'client_id' => $this->data['Bonlivraison']['client_id'] ]); ?>
<?php endif ?>
<script>
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
    </script>
<?php $this->end() ?>