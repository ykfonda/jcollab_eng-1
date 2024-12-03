<h4 style="font-weight: bold;">N° de commande : <?php echo ( isset($this->data['Ecommerce']['barcode']) AND !empty($this->data['Ecommerce']['barcode']) ) ? $this->data['Ecommerce']['barcode'] : $this->data['Ecommerce']['online_id'] ; ?></h4>
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
          <td nowrap="" style="width: 35%;"><?php echo $this->Text->truncate($v['Produit']['libelle'],25) ?></td>
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
