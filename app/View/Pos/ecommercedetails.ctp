<style>
.custom-btn {
    border: none;
    color: white !important;
    padding: 6px 15px;
    font-size: 14px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-preparation {
    background-color: #7a5fff; /* violet */
}

.btn-delivery {
    background-color: #28c76f; /* vert */
}

.custom-btn i {
    font-size: 16px;
}
</style>

<br />
<div style="overflow: hidden;">
    <h4 style="font-weight: bold; float: left;">
        N° de commande : 
        <?php 
            echo ( isset($this->data['Ecommerce']['barcode']) && !empty($this->data['Ecommerce']['barcode']) ) 
                ? $this->data['Ecommerce']['barcode'] 
                : $this->data['Ecommerce']['online_id'];
        ?>
    </h4>

    <div style="float: right;">

        <!-- Bouton: Générer Bon de préparation PDF -->
  <a href="<?php echo $this->Html->url(['controller' => 'ecommerces', 'action' => 'generateBonPreparation', $this->data['Ecommerce']['id']]); ?>" 
   id="btn-prep-pdf"
   class="custom-btn btn-preparation" style="margin-right: 10px;" target="_blank">
   <i class="fa fa-file-pdf-o"></i> Bon de préparation
</a>




        <!-- Bouton: Marquer comme Ready for Delivery 
          forcer l'action 
        
        <a href="<?php echo $this->Html->url(['controller' => 'ecommerces', 'action' => 'markReadyForDelivery', $this->data['Ecommerce']['id']]); ?>" 
           class="custom-btn btn-delivery" target="_blank">
            <i class="fa fa-truck"></i> Ready for delivery
        </a>
        -->
    </div>
</div>



<div class="table-responsive " style="overflow-y: scroll;overflow-x: hidden;">
  <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th nowrap="">Produit</th>
        <th nowrap="">Qté cmd</th>
        <th nowrap="">Prix unitaire</th>
        <th nowrap="">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $montant_total = 0; ?>
      <?php foreach ($details as $k => $v): ?>
        <?php $total_unitaire = $v['Ecommercedetail']['qte_ordered']*$v['Ecommercedetail']['prix_vente']; ?>
        <?php $montant_total = $montant_total+$total_unitaire; ?>
        <tr class="rowParent">
          <td nowrap="" style="width: 35%;"><?php echo $this->Text->truncate($v['Ecommercedetail']['nom_produit_ean13'],25) ?></td>
          <td nowrap="" class="text-right" style="width: 10%;"><?php echo number_format($v['Ecommercedetail']['qte_ordered'], 2, ',', ' ') ?></td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Ecommercedetail']['unit_price'], 2, ',', ' ') ?></td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($total_unitaire, 2, ',', ' ') ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
  <div class="row">
    <div class="col-lg-12">
      <h5 style="font-weight: bold;text-align: right;">Montant total : <?php echo number_format($montant_total, 2, ',', ' ') ?></h5>
    </div>
  </div>
</div>



