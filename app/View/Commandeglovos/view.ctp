<style>
.accordion .class2:after {
    font-family: 'FontAwesome';  
    content: "\f068";
    float: right; 
}
.accordion .class1:after {
    /* symbol for "collapsed" panels */
    font-family: 'FontAwesome';  
    content: "\f067"; 
    float: right;
}
</style>
<?php $this->start('modal'); ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end(); ?>
<div class="hr"></div>
<?php if (isset($this->data['Commandeglovo']['id']) and !empty($this->data['Commandeglovo']['id'])): ?>

<?php if (!empty($this->data['Commandeglovo']['etat'])): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="color:white;background-color: <?php echo $this->App->getEtatCommandeColor($this->data['Commandeglovo']['etat']); ?>;padding: 10px;border-color: <?php echo $this->App->getEtatCommandeColor($this->data['Commandeglovo']['etat']); ?>">
        <strong>Statut commande &ensp; : &ensp;</strong>  <?php echo $this->App->getEtatCommande($this->data['Commandeglovo']['etat']); ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    
    <a href="<?php echo $this->Html->url(['action' => 'index']); ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    <?php if ($this->data['Commandeglovo']['etat'] != 4): ?>
    <a href="<?php echo $this->Html->url(['action' => 'MotifsAbandon', $this->data['Commandeglovo']['order_code'], $this->data['Commandeglovo']['id']]); ?>" id="abondon" class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i> Abandonner </a>
    <?php endif; ?>

    <?php if ($this->data['Commandeglovo']['etat'] != 3): ?>
      <a href="<?php echo $this->Html->url(['action' => 'mail', $this->data['Commandeglovo']['id']]); ?>" class="edit btn btn-warning btn-sm"><i class="fa fa-envelope-o"></i> Envoi par mail </a>
    <?php endif; ?>
    <a target="_blank" href="<?php echo $this->Html->url(['action' => 'bonPreparation', $this->data['Commandeglovo']['id']]); ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Generer le bon de preparation</a>
    <?php if ($globalPermission['Permission']['i'] and $this->data['Commandeglovo']['etat'] != 3): ?>

      <a target="_blank" href="<?php echo $this->Html->url(['action' => 'pdf', $this->data['Commandeglovo']['id']]); ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer A4</a>
    <?php endif; ?>
    
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
                <td class="tableHead" nowrap="">Code à barre</td>
                <td nowrap="">
                  <?php echo $this->data['Commandeglovo']['order_code']; ?>
                </td>
                <td class="tableHead" nowrap="">Date commande</td>
                <td nowrap=""> 
                  <?php echo $this->data['Commandeglovo']['estimated_pickup_time']; ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="">
                  <?php echo $this->data['Client']['designation']; ?>
                </td>
                <td class="tableHead" nowrap="">Store</td>
                <td nowrap="">
                  <?php echo $this->data['Store']['libelle']; ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Montant TVA</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Commandeglovo']['montant_tva'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Remise (%)</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Commandeglovo']['remise'], 2, ',', ' '); ?> %
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer HT</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Commandeglovo']['total_a_payer_ht'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Montant remise</td>
                <td nowrap="" class="text-right total_number">
                  <?php echo number_format($this->data['Commandeglovo']['montant_remise'], 2, ',', ' '); ?>  
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Total à payer TTC</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Commandeglovo']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </td>
                <td class="tableHead" nowrap="">Net à payer</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($this->data['Commandeglovo']['total_apres_reduction'], 2, ',', ' '); ?>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="portlet light bordered">

    <div id="accordion" class="accordion">
        
            <div data-toggle="collapse"  href="#collapseOne">
            <div  class="portlet-title class1 collapsed">   
            <a style="    color: #666;
       
   
    font-size: 18px;
    line-height: 18px;
    font-weight: 300;
    ">
                    Informations commande
                </a>
                
            </div></div>
            <div id="collapseOne" class="card-body collapse" data-parent="#accordion" >
                <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt
                    aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat
                    craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </p>
            </div>
            
            </div>
            </div> 


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
               
              </tr>
            </thead>
            <tbody>
              <?php foreach ($details as $tache): ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Commandeglovodetail']['quantity']); ?></td>
                  <td nowrap="" class="text-right"><?php echo isset($tache['Commandeglovodetail']['qte']) ? h($tache['Commandeglovodetail']['qte']) : '0.000'; ?> </td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Commandeglovodetail']['price'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo (int) $tache['Commandeglovodetail']['remise']; ?>%</td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Commandeglovodetail']['ttc'], 2, ',', ' '); ?></td>
                  
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->start('js'); ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

  <?php if (isset($error) and ($error == false)) : ?>
    
  Swal.fire(
  'Good !',
  '<?php echo $message; ?>',
  'success'
).then(function() {
  window.location = "<?php echo $this->Html->url(['action' => 'view', $this->data['Commandeglovo']['id']]); ?>";
});
/* var url = window.location.href;
url = url.slice(0, -1);
window.history.replaceState({}, document.title, "/" + url); */

<?php endif; ?>
<?php if (isset($error) and ($error == true)) : ?>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: '<?php echo $message; ?>',
  footer: ''
}).then(function() {
    window.location = "<?php echo $this->Html->url(['action' => 'view', $this->data['Commandeglovo']['id']]); ?>";
});

/* var url = refineURL();
alert(url);
url = url.slice(0, -1);
window.history.replaceState({}, document.title, "/" + url); */
<?php endif; ?>
 
  

$('.accordion').on('click','.class1',function(e){
          //$(this).find('i').toggleClass('fas fa-plus fas fa-minus');
          $(".portlet-title").removeClass('class1');
          $(".portlet-title").addClass('class2');
        });
        $('.accordion').on('click','.class2',function(e){
          //$(this).find('i').toggleClass('fas fa-plus fas fa-minus');
        
          $(".portlet-title").removeClass('class2');
          $(".portlet-title").addClass('class1');
        });
    
    

</script>
<?php $this->end(); ?>