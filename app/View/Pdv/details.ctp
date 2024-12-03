<!-- Details -->
<div class="col-md-12">
  <div class="table-responsive" style="max-height: 350px;min-height: 350px;overflow-y: scroll;overflow-x: scroll;">
    <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th nowrap="">Produit</th>
          <th nowrap="">Qte</th>
          <th nowrap="">Prix</th>
          <th nowrap="">Total</th>
          <th nowrap=""></th>
        </tr>
      </thead>
      <tbody id="tbodyParent">
        <?php $total = 0; ?>
        <?php foreach ($details as $k => $v): ?>
        <?php $total = $total+$v['Salepointdetail']['ttc']; ?>
        <tr class="rowParent">
          <td nowrap="" style="width: 35%;"><?php echo $this->Text->truncate($v['Produit']['libelle'],25) ?></td>
          <td nowrap="" class="smallFormView" style="width: 10%;">
            <?php echo $v['Salepointdetail']['qte'] ?>
            <!-- <div class="input-group">
              <div class="input-group-append">
                <button class="btn btn-primary btn-circle change-quantity"  type="button"><i class="fa fa-minus"></i></button>
              </div>
              <input type="text" class="form-control text-center" value="<?php echo $v['Salepointdetail']['qte'] ?>"/>
              <div class="input-group-append">
                <button class="btn btn-primary btn-circle change-quantity"  type="button"><i class="fa fa-plus"></i></button>
              </div>
            </div> -->
          </td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['prix_vente'], 2, ',', ' ') ?></td>
          <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['ttc'], 2, ',', ' ') ?></td>
          <td nowrap="" style="width: 5%;">
            <a href="<?php echo $this->Html->url(['action'=>'deleteline',$v['Salepointdetail']['id']]); ?>" class="btn btn-danger btn-xs btn-circle btn-delete"><i class="fa fa-ban"></i> Annuler</a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<!-- Details -->

<!-- Totals -->
<div class="col-md-12">
  <div class="table-responsive" style="max-height: 90px;min-height: 90px;">
    <table class="table table-bordered ">
      <tbody>
        <tr>
          <td class="tableHead" nowrap="">Net à payer</td>
          <td nowrap="" class="text-right bold"><?php echo number_format($total, 2, ',', ' ') ?></td>
        </tr>
        <tr>
          <td class="tableHead" nowrap="">Date</td>
          <td nowrap="" class="text-right bold"><?php echo date('d-m-Y') ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- Totals -->

<!-- Actions -->
<div class="col-md-12">
  <div class="row mb-1">
    <div class="col-lg-6 col-md-12">
      <a href="<?php echo $this->Html->url(['action'=>'holdon']); ?>" class="btn btn-warning btn-block waves-effect waves-float waves-light btn-lg btn-holdon"><i class="fa fa-hand-paper-o"></i> Hold</a>
    </div>
    <div class="col-lg-6 col-md-12">
      <a href="<?php echo $this->Html->url(['action'=>'onhold']); ?>" class="btn btn-secondary btn-block waves-effect waves-float waves-light btn-lg btn-onhold"><i class="fa fa-list-ol"></i> Hold list (<?php echo $onhold ?>) </a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 col-md-12">
      <a href="<?php echo $this->Html->url(['action'=>'cancel']); ?>" class="btn btn-danger btn-block waves-effect waves-float waves-light btn-lg btn-cancel"><i class="fa fa-ban"></i> Annuler</a>
    </div>
    <div class="col-lg-6 col-md-12">
      <a href="<?php echo $this->Html->url(['action'=>'paiement']); ?>" class="btn btn-success btn-block waves-effect waves-float waves-light btn-lg btn-payment"><i class="fa fa-dollar"></i> Paiement</a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 height-50"></div>
  </div>
</div>
<!-- Actions -->