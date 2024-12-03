<style>
  .select2-dropdown {
  z-index: 9001;
}
</style>
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

<?php echo $this->Form->create('Avance',['id' => 'AvancePaiement','class' => 'form-horizontal','autocomplete'=>'off','url' => ['controller' => 'Pos','action' => 'updateAvance']]); ?>

<?php echo $this->Form->hidden('Salepoint.id'); ?>


<div class="row">
		
		<div class="col-md-12">
			<div class="form-group row">
      <?php echo $this->Form->hidden('Avance.0.id',['default' => $this->data["Avance"][0]["id"]]); ?>

				<label class="control-label col-md-3">Montant 1</label>
				<div class="col-md-3">
        
        <?php echo $this->Form->input('Avance.0.montant',['class' => 'form-control','default' => $this->data["Avance"][0]["montant"] ,'label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Mode 1</label>
				<div class="col-md-4">
        <?php echo $this->Form->input('Avance.0.mode',['class' => 'select2 form-control','empty'=>'--Fournisseur','default' => $this->data["Avance"][0]["mode"] ,'label'=>false,'required' => false]); ?>
				</div>
			</div>
      <div class="form-group row">
      <?php echo $this->Form->hidden('Avance.1.id',['default' => $this->data["Avance"][1]["id"]]); ?>

				<label class="control-label col-md-3">Montant 2</label>
				<div class="col-md-3">
        
        <?php echo $this->Form->input('Avance.1.montant',['class' => 'form-control','default' => $this->data["Avance"][1]["montant"] ,'label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Mode 2</label>
				<div class="col-md-4">
        <?php echo $this->Form->input('Avance.1.mode',['class' => 'select2 form-control','options' => $modes,'empty'=>'--Fournisseur','default' => $this->data["Avance"][1]["mode"] ,'label'=>false,'required' => false]); ?>
				</div>
			</div>
      </div>
      </div>
      <?php echo $this->Form->end() ?>
