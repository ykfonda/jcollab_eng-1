<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset( $this->data['Boncommande']['id'] ) AND !empty( $this->data['Boncommande']['id'] ) ): ?>

<?php if ( !empty( $this->data['Boncommande']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatFicheColor( $this->data['Boncommande']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatFicheColor( $this->data['Boncommande']['etat'] ) ?>">
        <strong>Statut bon de commande &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatFiche( $this->data['Boncommande']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    
    <?php if ( $this->data['Boncommande']['etat'] != 3 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Boncommande']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php endif ?>
   
    <?php if ( $globalPermission['Permission']['i'] ): ?>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Boncommande']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Boncommande']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif ?>
    
    <?php if ( $this->data['Boncommande']['etat'] == -1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Boncommande']['id'],1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-check-square-o"></i> Terminer la saisie</a>
    <?php endif ?>

    <?php if ( $this->data['Boncommande']['etat'] == 1 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Boncommande']['id'],2 ]) ?>" class="changestate btn btn-success btn-sm"><i class="fa fa-refresh"></i> Valider le bon</a>
      <a href="<?php echo $this->Html->url(['action'=>'changestate',$this->data['Boncommande']['id'],-1 ]) ?>" class="changestate btn btn-warning btn-sm"><i class="fa fa-edit"></i> Continuer la saisie</a>
    <?php endif ?>

  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information commande
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['m1'] AND $this->data['Boncommande']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Boncommande']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier</a>
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
                  <?php echo $this->data['Boncommande']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap=""> 
                  <?php echo $this->data['Boncommande']['date'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Fournisseur</td>
                <td nowrap="">
                  <?php echo $this->data['Fournisseur']['designation'] ?>
                </td>
                <td class="tableHead" nowrap="">Dépot</td>
                <td nowrap="">
                  <?php echo $this->data['Depot']['libelle'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Montant TVA</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Boncommande']['montant_tva'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Statut</td>
                <td nowrap="" >
                  <?php if ( !empty($this->data['Boncommande']['paye']) ): ?>
                    <span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getColorPayment($this->data['Boncommande']['paye']); ?>">
                      <?php echo $this->App->getStatutPayment($this->data['Boncommande']['paye']); ?>
                    </span>
                  <?php endif ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Boncommande']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Boncommande']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total payé</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Boncommande']['total_paye'], 2, ',', ' '); ?>  
                </td>
                <td class="tableHead" nowrap="">Le reste à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Boncommande']['reste_a_payer'], 2, ',', ' '); ?>
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
      Liste des produits
    </div>
    <div class="actions">
      <?php if ( $globalPermission['Permission']['a'] AND $this->data['Boncommande']['etat'] == -1 ): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editdetail',0,$this->data['Boncommande']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter produit </a>
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
                <th nowrap="">Prix d'achat </th>
                <th nowrap="">Total </th>
                <?php if ( $this->data['Boncommande']['etat'] == -1 ): ?>
                <th class="actions">Actions</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Boncommandedetail']['qte'], 3, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Boncommandedetail']['prix_vente'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Boncommandedetail']['total'], 2, ',', ' '); ?></td>
                  <?php if ( $this->data['Boncommande']['etat'] == -1 ): ?>
                  <td nowrap="" class="actions">
                      <?php if ( $globalPermission['Permission']['m1'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'editdetail', $tache['Boncommandedetail']['id'], $tache['Boncommandedetail']['boncommande_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ( $globalPermission['Permission']['s'] ): ?>
                        <a href="<?php echo $this->Html->url(['action' => 'deletedetail', $tache['Boncommandedetail']['id'], $tache['Boncommandedetail']['boncommande_id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
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



<?php endif ?>

<?php $this->start('js') ?>
<script>
$(function(){
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  Init();

  $('#edit').on('input','#QteChange,#PrixVente',function(e){
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
    getProduit(produit_id,depot_id);
  });

  function getProduit(produit_id,depot_id) {
      $.ajax({
        dataType:'JSON',
        url: "<?php echo $this->Html->url(['action' => 'getProduit']) ?>/"+produit_id+'/'+depot_id,
        success: function(dt){
          var prix_vente = parseFloat(dt.prix_vente);
          var tva = parseFloat(dt.tva);
          $('#Total').val(0);
          $('#TotalTVA').val(0);
          if( $('#PrixVente').val() == '' ) $('#PrixVente').val(prix_vente);
          $('#TVA').val(tva);
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

  $('.changestate,.btnFlagDelete').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
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