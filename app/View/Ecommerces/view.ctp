<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset($this->data['Ecommerce']['id']) AND !empty( $this->data['Ecommerce']['id'] ) ): ?>

<?php if ( !empty( $this->data['Ecommerce']['etat'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatCommandeColor( $this->data['Ecommerce']['etat'] ) ?>;padding: 10px;border-color: <?php echo $this->App->getEtatCommandeColor( $this->data['Ecommerce']['etat'] ) ?>">
        <strong>Statut commande &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatCommande( $this->data['Ecommerce']['etat'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    <?php if ( $this->data['Ecommerce']['etat'] != 4 ): ?>
    <a href="<?php echo $this->Html->url(['action' => 'MotifsAbandon',$this->data['Ecommerce']['barcode'],$this->data['Ecommerce']['id']]) ?>" id="abondon" class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i> Abandonner </a>
    <?php endif ?>

    <?php if ( $this->data['Ecommerce']['etat'] != 3 ): ?>
      <a href="<?php echo $this->Html->url(['action'=>'mail',$this->data['Ecommerce']['id']]) ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php endif ?>
    
    <?php if ( $globalPermission['Permission']['i'] AND $this->data['Ecommerce']['etat'] != 3 ): ?>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'ticket',$this->data['Ecommerce']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer Ticket</a>
      <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Ecommerce']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif ?>
    
  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information commande
    </div>
    <div class="actions">
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-scrollable">
          <table class="table table-bordered ">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">No Commande</td>
                <td nowrap="">
                  <?php echo $this->data['Ecommerce']['barcode'] ?>
                </td>
                <td class="tableHead" nowrap="">Date commande</td>
                <td nowrap=""> 
                  <?php echo $this->data['Ecommerce']['date'] ?>
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
                  <?php echo number_format($this->data['Ecommerce']['montant_tva'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Ecommerce']['remise'], 2, ',', ' '); ?> %
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Ecommerce']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Ecommerce']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Ecommerce']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Net à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Ecommerce']['fee'] + $this->data['Ecommerce']['total_apres_reduction'], 2, ',', ' '); ?>
                </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Frais de livraison</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Ecommerce']['fee'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap=""></td>
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
    <div style="position: relative; float : right; color: #666; 
    padding: 10px 0;"><button id="buttonSelect" href="<?php echo $this->Html->url(['action' => 'AnnulerProduits',$this->data['Ecommerce']['id']]) ?>" class="btn btn-primary btn-sm" >Annuler la sélection</button></div>
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
                <th nowrap="">Désignation</th>
                <th nowrap="">Qté cmd</th>
                <th nowrap="">Qté livré</th>
                <th nowrap="">Prix</th>
                <th nowrap="">Remise (%)</th>
                <th nowrap="">Total</th>
                <th nowrap="" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Ecommercedetail']['qte_cmd']); ?></td>
                  <td nowrap="" style="width : 13rem"><input class="form-control qtelivre" style="height: 2rem;"   type="number" value="<?php echo h($tache['Ecommercedetail']['qte']); ?>"> </td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Ecommercedetail']['unit_price'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo (int)$tache['Ecommercedetail']['remise']; ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Ecommercedetail']['ttc'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-center">
                  <?php if($tache['Ecommercedetail']['ttc'] == 0) : ?>
                  &nbsp&nbsp<label class="badge badge-pill badge-danger" for="scales">Annulé</label></td>                
                    
                    <?php else : ?>
                      <input class="checkboxselect" type='checkbox' name='checkboxvar' value='<?php echo $tache['Ecommercedetail']['id'] ?>'>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

  <?php if(isset($error) and ($error == false)) : ?>
    
  Swal.fire(
  'Good !',
  '<?php echo $message ?>',
  'success'
).then(function() {
  window.location = "<?php echo $this->Html->url(['action' => 'view',$this->data['Ecommerce']['id']]) ?>";
});
/* var url = window.location.href;
url = url.slice(0, -1);
window.history.replaceState({}, document.title, "/" + url); */

<?php endif ?>
<?php if(isset($error) and ($error == true)) : ?>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '<?php echo $message ?>',
  footer: ''
}).then(function() {
    window.location = "<?php echo $this->Html->url(['action' => 'view',$this->data['Ecommerce']['id']]) ?>";
});

/* var url = refineURL();
alert(url);
url = url.slice(0, -1);
window.history.replaceState({}, document.title, "/" + url); */
<?php endif ?>
  $('#abondon').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
        $.ajax({
          url: url,
          success: function(dt){
            $('#edit .modal-content').html(dt);
            $('#edit').modal('show');
            $('.select2').select2();
          },
          error: function(dt){
            toastr.error("Il y a un problème");
          }
        });
   
  });
  $(document).ready(function() {
    $('#buttonSelect').on('click',function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      //var qte = $("#qtelivre").val();
      var qte = [];
          
      var favorite = [];
          $.each($("input[name='checkboxvar']:checked"), function(){
                favorite.push($(this).val());
                qte.push($(this).parent().prev().prev().prev().prev().find(".qtelivre").val());
                
          });
          var product_ids =  favorite.join(",");
          qte =  qte.join(",");

      
      url = url + "/" + product_ids + "/" + qte;
     
      bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
          
          
          window.location = url;
        }
    });
  });
});
  

    

</script>
<?php $this->end() ?>