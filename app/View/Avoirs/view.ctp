<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset( $this->data['Avoir']['id'] ) AND !empty( $this->data['Avoir']['id'] ) ): ?>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information avoir
    </div>
    <div class="actions">
      <?php if ( isset( $this->data['Avoir']['id'] ) AND $globalPermission['Permission']['i'] ): ?>
        <a target="_blank" href="<?php echo $this->Html->url(['action'=>'pdf',$this->data['Avoir']['id']]) ?>" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i> Imprimer</a>
      <?php endif ?>
      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;">
          <table class="table table-bordered tableHeadInformation">
            <tbody>
              <tr>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap="">
                  <?php echo $this->data['Avoir']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap=""> 
                  <?php echo $this->data['Avoir']['date'] ?>
                </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Client</td>
                <td nowrap="" >
                  <?php echo $this->data['Client']['designation'] ?>
                </td>
                <td class="tableHead" nowrap="">Vendeur</td>
                <td nowrap="">
                  <?php if ( isset( $this->data['User']['id'] ) ): ?>
                    <?php echo $this->data['User']['nom'] ?> <?php echo $this->data['User']['prenom'] ?>
                  <?php endif ?>
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
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive" style="min-height: auto;">
          <table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
            <thead>
              <tr>
                <th nowrap="">Désignation</th>
                <th nowrap="">Prix HT</th>
                <th nowrap="">TVA</th>
                <th nowrap="">Quantité</th>
                <th nowrap="">Total HT</th>
                <th nowrap="">Total TTC</th>
              </tr>
            </thead>
            <tbody>
              <?php $total = 0;$total_ttc = 0;$total_qte = 0; ?>
              <?php foreach ($details as $tache): ?>
                <?php $total = $total + $tache['Avoirdetail']['total']; ?>
                <?php $total_ttc = $total_ttc + $tache['Avoirdetail']['ttc']; ?>
                <?php $total_qte = $total_qte + $tache['Avoirdetail']['qte']; ?>
                <tr>
                  <td nowrap=""><?php echo h($tache['Produit']['libelle']); ?> </td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Avoirdetail']['prixachat'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Produit']['tva']); ?>%</td>
                  <td nowrap="" class="text-right"><?php echo h($tache['Avoirdetail']['qte']); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Avoirdetail']['total'], 2, ',', ' '); ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($tache['Avoirdetail']['ttc'], 2, ',', ' '); ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"><strong><?php echo $total_qte ?></strong></td>
                <td class="text-right"><strong><?php echo number_format($total, 2, ',', ' ') ?></strong></td>
                <td class="text-right"><strong><?php echo number_format($total_ttc, 2, ',', ' ') ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;

  $('.PrintThisPage').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      dataType:'JSON',
      success : function(dt){
        var lien = dt.url;
        window.open('https://docs.google.com/viewer?url='+lien+'&embedded=true', '_blank', 'location=yes'); 
      }
    });
  });

});
</script>
<?php $this->end() ?>