<h4 style="font-weight: bold;">N° de la vente : <?php echo ( isset($this->data['Salepoint']['id']) AND !empty($this->data['Salepoint']['id']) ) ? $this->data['Salepoint']['reference'] : '' ; ?></h4>
<div class="table-responsive " style="overflow-y: scroll;overflow-x: hidden;">
  <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th nowrap="">Produit</th>
        <th nowrap="">Qté cmd</th>
        <th nowrap="">Prix</th>
        <th nowrap="">Remise(%)</th>
        <th nowrap="">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $montant_total = 0; ?>
      <?php foreach ($details as $k => $v): ?>
        <?php $montant_total = $montant_total+$v['Salepointdetail']['ttc']; ?>
        <tr class="rowParent">
          <td  style="width: 35%;"><?php echo $v['Produit']['libelle']?></td>
          <td nowrap="" class="text-right" style="width: 10%;"><?php echo number_format($v['Salepointdetail']['qte'], 3, ',', ' ') ?></td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['prix_vente'], 2, ',', ' ') ?></td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['remise'], 2, ',', ' ') ?>%</td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['ttc'], 2, ',', ' ') ?></td>
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
