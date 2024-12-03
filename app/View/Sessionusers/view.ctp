
<div class="hr"></div>


<div class="row" style="margin-bottom: 10px;text-align: right;">
  <div class="col-lg-12">
    
    <a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm" ><i class="fa fa-reply"></i> Vers la liste </a>
  
  </div>
</div>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Informations de journal
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
                <td class="tableHead" nowrap="">référence</td>
                <td nowrap="">
                  <?php echo $sessionuser['Sessionuser']['reference'] ?>
                </td>
                <td class="tableHead" nowrap="">Site</td>
                <td nowrap="">
                  <?php echo $sessionuser['Site']['libelle'] ?>
                </td>
                
              </tr>
              <tr>
                
                <td class="tableHead" nowrap="">Caisse</td>
                <td nowrap="">
                  <?php echo $sessionuser['Caisse']['libelle'] ?> 
                </td>
                <td class="tableHead" nowrap="">Date debut</td>
                <td nowrap=""> 
                  <?php echo $sessionuser['Sessionuser']['date_debut'] ?>
                </td>
              </tr>
              <tr>
                <td class="tableHead" nowrap="">Date fin</td>
                <td nowrap="">
                  <?php echo $sessionuser['Sessionuser']['date_fin'] ?>
                </td>
                <td class="tableHead" nowrap="">Vendeur</td>
                <td nowrap="">
                  <?php echo $sessionuser['User']['nom'] . " " . $sessionuser['User']['prenom'] ?>
                </td>
              </tr>

              

              <tr>
                <td class="tableHead" nowrap="">Chiffre d'affaire</td>
                <td nowrap="" class="text-right total_number"> 
                  <?php echo number_format($chiffre_affaire, 2, ',', ' '); ?>
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


<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Detail des ventes
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
                <th nowrap="">Référence</th>
                <th nowrap="">Caisse</th>
                <th nowrap="">Vendeur</th>
                <th nowrap="">Mode de paiement</th>
                <th nowrap="">Montant</th>
                
  
              </tr>
            </thead>
            <tbody>
              <?php $i = 0 ?>
              <?php foreach ($payment_methods as $payment_method): ?>
                <tr>
                  <td nowrap=""><?php echo h($salepoints[$i]['Salepoint']['reference']); ?></td>
                  <td nowrap="" class="text-left"><?php echo h($sessionuser['Caisse']['libelle']); ?></td>
                  <td nowrap="" class="text-left"><?php echo h($sessionuser['User']['nom'] . " " . $sessionuser['User']['prenom']); ?></td>
                  <td nowrap="" class="text-left"><?php echo array_keys($payment_method)[0] ?></td>
                  <td nowrap="" class="text-right"><?php echo number_format($payment_method[array_keys($payment_method)[0]], 2, ',', ' ') ?></td>
                  
                </tr>
                <?php $i = $i+1 ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
