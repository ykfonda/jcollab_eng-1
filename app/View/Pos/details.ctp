<!-- Details -->
<?php echo $this->Session->flash(); ?>
<div class="col-md-12">
  <div class="table-responsive " style="max-height: 400px;min-height: 400px;overflow-y: scroll;overflow-x: scroll;">
    <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th nowrap="">Produit</th>
          <th nowrap="">Qté Livrée</th>
          <th nowrap="">Qté Cdée</th>
          <?php if (!empty($this->data['Salepoint']['ecommerce_id'])) : ?>
            <th nowrap="">Prix Unitaire</th>
          <?php else: ?>
            <th nowrap="">Prix vente</th>
          <?php endif; ?>
          <th nowrap="">Remise(%)</th>
          <th nowrap="">Total</th>
          <th nowrap=""></th>
        </tr>
      </thead>
      <tbody id="tbodyParent">
        <?php foreach ($details as $k => $v): ?>
          <?php $total_livree = $v['Salepointdetail']['qte'] * $v['Salepointdetail']['prix_vente']; ?>
          <tr class="rowParent">

          <td nowrap="" style="width: 35%; color: blue !important;">
                      <?php 
                        if (!empty($v['Salepointdetail']['nom_produit_ean13'])) {
                          echo $this->Text->truncate($v['Salepointdetail']['nom_produit_ean13'], 50);
                        } else {
                          echo $this->Text->truncate($v['Produit']['libelle'], 50);
                        }
                      ?>
          </td>

            <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['qte'], 3, ',', ' '); ?></td>
            <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['qte_cmd'], 3, ',', ' '); ?></td>

              <?php if (!empty($this->data['Salepoint']['ecommerce_id'])) : ?>
              <td nowrap="" class="text-right" style="width: 15%;">
                <?php echo number_format($v['Salepointdetail']['unit_price'], 2, ',', ' '); ?>
              </td>

              <?php else: ?>
                <td nowrap="" class="text-right" style="width: 15%;">
                  <?php echo number_format($v['Salepointdetail']['prix_vente'], 2, ',', ' '); ?>
                </td>
              <?php endif; ?>


            <td nowrap="" style="width: 15%;text-align: left;">
              <?php if (!empty($this->data['Salepoint']['commande_id']) or !empty($this->data['Salepoint']['ecommerce_id']) or !empty($this->data['Salepoint']['glovo_id'])): ?>
                <?php echo number_format($v['Salepointdetail']['remise'], 2, ',', ' '); ?>%</span>
              <?php else: ?>
                <a href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'editline', $v['Salepointdetail']['id'], $v['Salepointdetail']['salepoint_id']]); ?>" class="btn-edit-remise btn btn-primary btn-xs"><i class="fa fa-edit"></i> Modifier</a>  
                <?php echo number_format($v['Salepointdetail']['remise'], 2, ',', ' '); ?>%</span>
              <?php endif; ?>
            </td>
            
            
            <td nowrap="" class="text-right" style="width: 15%;">
              <?php
                echo number_format($v['Salepointdetail']['ttc'], 2, ',', ' '); 
                  // echo number_format($v['Salepointdetail']['unit_price'] * $v['Salepointdetail']['qte'], 2, ',', ' ');
              ?>
            </td>

            


            <td nowrap="" style="width: 5%;">
              <?php if (!empty($this->data['Salepoint']['commande_id']) or !empty($this->data['Salepoint']['ecommerce_id']) or !empty($this->data['Salepoint']['glovo_id'])): ?>
                <a href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'cancelline', $v['Salepointdetail']['id'], $v['Salepointdetail']['salepoint_id']]); ?>" class="btn btn-danger btn-xs btn-circle btn-delete"><i class="fa fa-ban"></i> Annuler</a>
              <?php else: ?>
                <a href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'deleteline', $v['Salepointdetail']['id'], $v['Salepointdetail']['salepoint_id']]); ?>" class="btn btn-danger btn-xs btn-circle btn-delete"><i class="fa fa-ban"></i> Annuler</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- Details -->

<!-- Totals -->
<div class="col-md-12">
  <div class="table-responsive" style="min-height: 100px;">
    <table class="table table-bordered ">
      <tbody>
        <tr>
          <td class="tableHead" nowrap="">Net à payer</td>
          <?php $total_apres_reduction = (isset($this->data['Salepoint']['total_apres_reduction']) and !empty($this->data['Salepoint']['total_apres_reduction'])) ? $this->data['Salepoint']['total_apres_reduction'] : 0; ?>
          <td nowrap="" class="text-right bold"><?php echo number_format($total_apres_reduction, 2, ',', ' '); ?></td>
        </tr>
        <tr>
          <td class="tableHead" nowrap="">Total Cdé</td>
          <?php $total_cmd = (isset($this->data['Salepoint']['total_cmd']) and !empty($this->data['Salepoint']['total_cmd'])) ? $this->data['Salepoint']['total_cmd'] : 0; ?>
          <td nowrap="" class="text-right bold"><?php echo number_format($total_cmd, 2, ',', ' '); ?></td>
        </tr>
        <tr>
          <td class="tableHead" nowrap="">Remise ticket (%)</td>
          <?php $remise = (isset($this->data['Salepoint']['remise']) and !empty($this->data['Salepoint']['remise'])) ? $this->data['Salepoint']['remise'] : 0; ?>
          <td nowrap="" class="text-right bold"><?php echo number_format($remise, 2, ',', ' '); ?>%</td>
        </tr>
        <tr>
          <td class="tableHead" nowrap="">Remise ticket (Dhs)</td>
          <?php $montant_remise = (isset($this->data['Salepoint']['montant_remise']) and !empty($this->data['Salepoint']['montant_remise'])) ? $this->data['Salepoint']['montant_remise'] : 0; ?>
          <td nowrap="" class="text-right bold"><?php echo number_format($montant_remise, 2, ',', ' '); ?></td>
        </tr>
        <tr>
          <td class="tableHead" nowrap="">Frais (Dhs)</td>
          <td nowrap="" class="text-right bold">
            <?php echo $this->data['Salepoint']['fee']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- Totals -->