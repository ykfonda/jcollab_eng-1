<div class="hr"></div>
<?php echo $this->Html->css('/app-assets/plugins/easy-numpad/css/easy-numpad.min.css'); ?>
<?php echo $this->element('pos-style'); ?>


<style>

  .btn > i {
      font-size: 25px;
  }

  .btn-glovo{
    background: #F8CC4A!important ;
  }

  .btn-ecom{
    background: #bdb7b7!important ;
  }

  .sous-titre {
    font-size: 14px;
    margin-top: 12px;
  }

  .sous-titre.ecom{
    margin-top: 8px;
  }

@media (min-width: 576px) {
.modal-size2 {
    max-width: 50% !important;
    margin: 1.75rem auto;
}
}
</style>


<div id="myModal2" class="modal fade" role="dialog">
<div class="modal-dialog modal-size2 modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       
      </div>
      <div class="modal-body">
      <input type="hidden" name="module" id="module">
      <input type="hidden" name="url" id="url">
        <p style="text-align: center;font-weight: bold;">Veuillez saisir votre mot de passe :</p>
        <input type="password" id="passw" class="form-control" name="password" placeholder="Mot de passe">
          <br />
            <div class="text-center">
                    <button class="btn btn-success btn-lg btn-input-barre-code" type="button" onclick="show_index_numpad2();"><i class="fa fa-key"></i> Saisir mot de passe</button>
            </div>
          <br />
      </div>
      <div class="modal-footer">
      <button type="button" onclick="return Closemodal();" class="btn btn-lg btn-danger" data-dismiss="modal">Fermer</button>
      <button type="button" class="btn btn-lg btn-success subremise">Confirmer</button>
      </div>
    </div>
   
  </div>
</div>




<div class="row no-printme" style="margin-right: 1px;margin-left: 1px;">

  <div class="col-md-7 contain">
    <?php if (isset($this->data['Salepoint']['id']) and !empty($this->data['Salepoint']['id'])): ?> 

    <div class="card-body">

        <?php echo $this->Form->create('Salepoint', ['id' => 'SalepointForm', 'autocomplete' => 'off']); ?>
        <div class="row mb-1">
          <div class="col-lg-4">
            <?php echo $this->Form->input('user_id', ['id' => 'user_id', 'class' => 'form-control', 'label' => 'Vendeur', 'required' => true, 'disabled' => true, 'type' => 'select', 'div' => false]); ?>
          </div>
          <div class="col-lg-4">
            <?php echo $this->Form->input('reference', ['id' => 'reference', 'class' => 'form-control', 'label' => 'Référence', 'required' => true, 'disabled' => true, 'div' => false, 'default' => '1234']); ?>
          </div>
          <div class="col-lg-4">
            <?php echo $this->Form->input('date', ['id' => 'date', 'class' => 'form-control', 'label' => 'Date', 'required' => true, 'disabled' => true, 'div' => false, 'type' => 'text', 'default' => date('d-m-Y')]); ?>
          </div>
        </div>
        <div class="row mb-1">
          <div class="col-lg-4">
            <?php echo $this->Form->input('depot_id', ['class' => 'form-control', 'label' => 'Dépot', 'required' => true, 'disabled' => true, 'div' => false]); ?>
            <?php echo $this->Form->hidden('depot_id', ['id' => 'depot_id', 'value' => $first_key]); ?>
            <?php echo $this->Form->hidden('commande_id', ['id' => 'commande_id']); ?>
            <?php echo $this->Form->hidden('ecommerce_id', ['id' => 'ecommerce_id']); ?>
          </div>
          <div class="col-lg-4">
            <?php echo $this->Form->input('type_vente', ['id' => 'type_vente', 'class' => 'form-control', 'label' => 'Type vente', 'required' => true, 'disabled' => true, 'type' => 'select', 'div' => false, 'options' => $this->App->getTypeVente()]); ?>
          </div>
          <div class="col-lg-4">
          




<?php echo $this->Form->input('bouchier', ['id' => 'bouchier', 'class' => 'form-control', 'label' => 'Boucher', 'required' => true, 'disabled' => false, 'type' => 'text', 'onblur' => 'getVal()', 'div' => false, 'options' => $this->App->getTypeVente()]); ?>
            




          </div>
        </div>

        <div class="row mb-1">
        
          <div class="col-lg-4">
            <label for="expedition">Expédition</label>
            <select name="data[Salepoint][expedition]" id="expedition" class="form-control" required="required" disabled="disabled">
              <option value="0"><?php echo $expedition; ?></option>
            </select>
          </div>
          <?php if (isset($this->data['Salepoint']['ecommerce_id']) and !empty($this->data['Salepoint']['ecommerce_id'])): ?> 
          <div class="col-lg-4">
            <?php echo $this->Form->input('payment_method', ['value' => $payment_method, 'class' => 'form-control', 'label' => 'Mode de payement', 'required' => true, 'disabled' => true, 'div' => false]); ?>
          </div>
          <?php endif; ?>
          
         
          <div class="col-lg-4 ">
          <label for="expedition">Remise Client</label>
          <input type="button" class="form-control btn-primary" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'remisepopup', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary" id="remise" value="Remise client"></input>
          </div>

          
          <div class="col-lg-4">
        
        <label for="bouchier">Client</label>
        <input name="data[Client][designation]" id="Client" disabled class="form-control" value="<?php echo $this->data['Client']['designation']; ?>"  type="text"> 
        </div>
          
         <!--  <div class="col-lg-4">
            <label for="SalepointDepotId">Mode de livraison</label>
            <select name="data[Salepoint][depot_id]" class="form-control" required="required" disabled="disabled" id="SalepointDepotId">
              <option value="1">Dépôt : Principale</option>
            </select>          
          </div> -->
        </div>

        <?php echo $this->Form->end(); ?>

        <!-- Inputs -->
        <div class="row mb-1">
          <div class="col-lg-12">
            <?php echo $this->Form->create('Salepoint', ['autocomplete' => 'off', 'id' => 'scan-product']); ?>
            <?php echo $this->Form->hidden('id', ['id' => 'SalepointId']); ?>
            <div class="input-group">
              <div class="input-group input-group-merge">
                <div class="input-group-append">
                  <button class="btn btn-default btn-reset" type="button"><i class="fa fa-eraser"></i></button>
                </div>
                <?php echo $this->Form->input('code_barre', ['id' => 'code_barre', 'class' => 'form-control pl-2', 'label' => false, 'required' => true, 'type' => 'text', 'placeholder' => 'Scanner code à barre...', 'div' => false, 'maxlength' => 13, 'minlength' => 13, 'autofocus' => 'autofocus']); ?>
                <div class="input-group-append scan-loading" style="display: none;">
                  <button class="btn btn-default" type="button" disabled="disabled">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  </button>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-default btn-scan" type="submit"><i class="fa fa-search"></i></button>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-default btn-input-barre-code" type="button" onclick="show_index_numpad();"><i class="fa fa-barcode"></i> Saisir code à barre</button>
                </div>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
          </div>
        </div>
        <!-- Inputs -->

        <div class="row" id="BlockDetails">

          <!-- Details -->
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
                      <td nowrap="" style="width: 35%;"><?php echo $this->Text->truncate($v['Produit']['libelle'], 50); ?></td>
                      <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['qte'], 3, ',', ' '); ?></td>
                      <td nowrap="" class="text-right qte_cmd" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['qte_cmd'], 3, ',', ' '); ?></td>
                      <?php if (!empty($this->data['Salepoint']['ecommerce_id'])) : ?>
                      <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['unit_price'], 2, ',', ' '); ?></td>
                      <?php else: ?>
                      <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['prix_vente'], 2, ',', ' '); ?></td>
                      <?php endif; ?>
                      <td nowrap="" style="width: 15%;text-align: left;">
                        <?php if (!empty($this->data['Salepoint']['commande_id']) or !empty($this->data['Salepoint']['ecommerce_id']) or !empty($this->data['Salepoint']['glovo_id'])): ?>
                          <?php echo number_format($v['Salepointdetail']['remise'], 2, ',', ' '); ?>%</span>
                        <?php else: ?>
                          <a href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'editline', $v['Salepointdetail']['id'], $v['Salepointdetail']['salepoint_id']]); ?>" class="btn-edit-remise btn btn-primary btn-xs"><i class="fa fa-edit"></i> Modifier</a>  
                          <?php echo number_format($v['Salepointdetail']['remise'], 2, ',', ' '); ?>%</span>
                        <?php endif; ?>
                      </td>
                      <td nowrap="" class="text-right" style="width: 15%;"><?php echo number_format($v['Salepointdetail']['ttc'], 2, ',', ' '); /* $v['Salepointdetail']['prix_vente'] * $v['Salepointdetail']['qte'] */ ?></td>
                      <td nowrap="" style="width: 5%;">
                        <?php if (!empty($this->data['Salepoint']['commande_id']) or !empty($this->data['Salepoint']['ecommerce_id']) or !empty($this->data['Salepoint']['glovo_id']) ): ?>
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
          <div id="getData" class="col-md-12">
            <div class="table-responsive" style="min-height: 100px;">
              <table class="table table-bordered ">
                <tbody>
                  <tr>
                    <td class="tableHead" nowrap="">Net à payer</td>
                    <?php $total_apres_reduction = (isset($this->data['Salepoint']['total_apres_reduction']) and !empty($this->data['Salepoint']['total_apres_reduction'])) ? $this->data['Salepoint']['total_apres_reduction'] : 0; ?>
                    <td nowrap="" class="text-right bold"><?php echo number_format($total_apres_reduction, 2, ',', ' '); ?></td>
                    <input type="hidden" name="net_price" value="<?php echo $total_apres_reduction; ?>">
                    
                  </tr>
                  <tr>
                    <td class="tableHead" nowrap="">Total Cdé</td>
                    <?php $total_cmd = (isset($this->data['Salepoint']['total_cmd']) and !empty($this->data['Salepoint']['total_cmd'])) ? $this->data['Salepoint']['total_cmd'] : 0; ?>
                    <td nowrap="" class="text-right bold"><?php echo number_format($total_cmd, 2, ',', ' '); ?></td>
                    <input type="hidden" name="total_cmd" value="<?php echo $total_cmd; ?>">
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
                    <?php $montant_remise = (isset($this->data['Salepoint']['montant_remise']) and !empty($this->data['Salepoint']['montant_remise'])) ? $this->data['Salepoint']['montant_remise'] : 0; ?>
                    <td nowrap="" class="text-right bold">
                      <?php echo $fee; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Totals -->

        </div>

    </div>
    <?php endif; ?>
  </div>

  <div class="col-md-5 contain">
    <?php if (isset($this->data['Salepoint']['id']) and !empty($this->data['Salepoint']['id'])): ?> 
      <div class="card-body">
        <!-- Actions -->
        <div class="col-md-12 mb-1" style="border:1px solid #e5e5e5;padding-top: 15px;">

          <div class="row mb-1">
            
            <div class="col-lg-6 col-md-12">
              <button type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'holdon', $this->data['Salepoint']['id']]); ?>" class="btn btn-warning btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center action btn-enabled" disabled="disabled">
              <i class="fa fa-hand-paper-o"></i>
              &ensp;
                Mise en attente
              </button>
            </div>

            <div class="col-lg-6 col-md-12">
              <button data-holdList="<?php echo $holdlist; ?>" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'onhold', $this->data['Salepoint']['id']]); ?>" class="btn btn-secondary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-show-hold-list btn-disabled"><i class="fa fa-list-ol"></i>&ensp;Liste d'attente (<?php echo $holdlist; ?>) </button>
            </div>

          </div>


          <div class="row mb-1">
            <div class="col-lg-12 col-md-12">
              <button type="button" id="btn_paiement" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'paiement', $this->data['Salepoint']['id']]); ?>" class="btn btn-success btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-show-modal"><i class="fa fa-dollar"></i>&ensp;Paiement</button>
            </div>
          </div>

          <!---- ECOM et GLOVO ---- start ------------------------------------>
          <div class="row mb-1">
              <!----- COMMANDES GLOVO ---- start ------>
              <div class="col-lg-6 col-md-12">
                  <button id="btn_commerce" type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'commandesGlovo', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-disabled btn-ecommerce btn-glovo">

                      <div style="text-align: center;">
                        <?php echo $this->Html->image('POS/glovo.svg', array('alt' => 'GLOVO', 'width' => '50')); ?>
                        <div class="sous-titre glovo">Commandes Glovo</div>
                      </div>

                  </button>
              </div>
              <!----- COMMANDES GLOVO ---- end ------>

              <!----- COMMANDES ECOM ---- start ------>
              <div class="col-lg-6 col-md-12">
                <span >
                  <button id="btn_commerce" <?php if ($this->data['Salepoint']['ecommerce_id']) {
                  echo "style='border-style: solid;border-width: 5px;border-color:  #cd1a1a !important;'";
                  } ?> type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'ecommerce', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-disabled btn-ecommerce btn-ecom">
                  
                  <div style="text-align: center;">
                        <?php echo $this->Html->image('POS/ecom_icon.png', array('alt' => 'ECOM', 'width' => '50')); ?>
                        <div class="sous-titre ecom">E-Commerce</div>
                  </div>
                 
                  </button>
                </span>
              </div>
              <!----- COMMANDES ECOM ---- end ------>

          </div>

          <!---- ECOM et GLOVO --- end  ------------------------------------>



          <div class="row mb-1">
            <div class="col-lg-6 col-md-12">
              <button id="btn_offer" type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'gift', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center actionAjax"><i class="fa fa-thumbs-up"></i>&ensp;Offert</button>
            </div>
            <div class="col-lg-6 col-md-12">
              <button id="btn_remise" type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'remise', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-show-modal"><i class="fa fa-minus-square-o"></i>&ensp;Remise ticket</button>
            </div>
          </div>

          


          <div class="row mb-1">


            <div class="col-lg-6 col-md-12">
              <button type="button" <?php if (isset($details[0]['Salepointdetail']['commandedetail_id'])) {
                  echo "style='border-style: solid;border-width: 5px;border-color:  #cd1a1a !important;'";
              } ?> href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'commandes', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-show-modal-eco btn-disabled">
              <i class="fa fa-cart-arrow-down"></i>
              &ensp;Commande Client
              </button>
            </div>

              <div class="col-lg-6 col-md-12">
                  <button type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'changePaymentMode']); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-show-modal-eco btn-disabled">
                  <i class="fa fa-cc-visa"></i>
                  &ensp;
                  Modifier mode de paiement
                  </button>
              </div>

          </div>



          <div class="row mb-1">
            <div class="col-lg-6 col-md-12">
              <button type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'chequecadeaus', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center btn-show-modal-reimp justify-content-center">
              
            
              <style>
                  @keyframes blink {
                      0% {
                          color: #54eb4bdd;
                      }
                      50% {
                          color: #FFFFFF;
                      }
                      100% {
                          color: #54eb4bdd;
                      }
                  }

                  .clignotant {
                      animation: blink 2s infinite;
                  }
              </style>
              <?php
                if ($this->Session->check('chequecadeauData_REF') && $this->Session->check('chequecadeauData_MNT')) {
                  echo "<div class='clignotant'>
                  ";
                    // Les variables sont présentes dans la session
                    $chequecadeauData_REF = $this->Session->read('chequecadeauData_REF');
                    $chequecadeauData_MNT = $this->Session->read('chequecadeauData_MNT');

                    echo "Chèque REF: ".$chequecadeauData_REF." | Montant : ".$chequecadeauData_MNT. " DH";
                  echo "</div>";
                } else {
                  echo " <i class='fa fa-gift'></i>&ensp;Activation chèque cadeau";
                }
              ?>
            
              </button>
            </div>
            <div class="col-lg-6 col-md-12">
              <button type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'bonachats', $this->data['Salepoint']['id']]); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center btn-show-modal-reimp justify-content-center"><i class="fa fa-money"></i>&ensp;Activation bon d'achat</button>
            </div>
          </div>
          <div class="row mb-1">
            <div class="col-lg-6 col-md-12">
              <button type="button" href="javascript:void(0)" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center"><i class="fa fa-credit-card-alt"></i>&ensp;Activation carte client</button>
            </div>
            <div class="col-lg-6 col-md-12">
              <button type="button" href="javascript:void(0)" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-disabled"><i class="fa fa-pencil-square-o"></i>&ensp;Correction mode paiement</button>
            </div>
          </div>
          <div class="row mb-1">
            
            <div class="col-lg-6 col-md-12">
              <button type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'Reimpression']); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center btn-show-modal-reimp justify-content-center btn-disabled"><i class="fa fa-print"></i>&ensp;Réimpression ticket ou facture</button>
            </div>
            <div class="col-lg-6 col-md-12">
              <button type="button" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'annulerTickets']); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-show-modal-eco btn-disabled"><i class="fa fa-reply"></i>&ensp;Retour tickets payés</button>
            </div>
          </div>

 
        </div>
        <!-- Actions -->
        <!-- Actions E-commerce -->
        <div class="col-md-12" style="border:1px solid #e5e5e5;padding-top: 15px;">
          <div class="row mb-1">
            <div class="col-lg-4 col-md-12">
              <button href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'cancel', $this->data['Salepoint']['id']]); ?>" class="btn btn-danger btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center action" id="cancel"><i class="fa fa-times"></i>&ensp;Annuler Ticket</button>
            </div>
            <div class="col-lg-4 col-md-12">
              <button href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'close', $this->data['Salepoint']['id']]); ?>" class="btn btn-danger btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-quit"><i class="fa fa-power-off"></i>&ensp;Quitter la caisse</button>
            </div>
            <div class="col-lg-4 col-md-12">
              <button href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'closeSession', $this->data['Salepoint']['id']]); ?>" class="btn btn-warning btn-block waves-effect waves-float waves-light rounded text-white height-btn d-flex align-items-center justify-content-center btn-quit" id="closeSession"><i class="fa fa-sign-out"></i>&ensp;Fermer la session</button>
            </div>
          </div>
        </div>
        <!-- Actions E-commerce -->
      </div>
    <?php endif; ?>
  </div>

</div>


<?php $this->start('js'); ?>

<script>



function getVal() {
  const bouchier = document.querySelector('#bouchier').value;
  const bibish = document.querySelector('#bibish').value;
}






  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  
  

  $('#remise').on('click',function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
      }
    });
  });
 
  <?php if (isset($last_ticket['Salepoint']['id']) and !empty($last_ticket['Salepoint']['id'])): ?>
    var salepoint_ticket = parseInt("<?php echo $last_ticket['Salepoint']['id']; ?>");
    $.ajax({
      url: "<?php echo $this->Html->url(['action' => 'ticket']); ?>/"+salepoint_ticket,
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    });
  <?php endif; ?>

  <?php if (isset($sessionclose['Sessionuser']['id']) and !empty($sessionclose['Sessionuser']['id'])): ?>
   
    var session_id = parseInt("<?php echo $sessionclose['Sessionuser']['id']; ?>");
    var salepoint_id = parseInt("<?php echo $this->data['Salepoint']['id']; ?>");
    $.ajax({
      url: "<?php echo $this->Html->url(['action' => 'closeSessionTicket']); ?>/"+session_id + "/"+salepoint_id ,
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    });
   
  <?php endif; ?>
  
  

/** Disable Offert And Remise When Ecommerce Is selected*/
/** Qté livrée peut dépasser la qté commandée (Commande client) */
    var typeVente = document.querySelector("#type_vente");
    if (typeVente.value == 2) {
      document.querySelector("#btn_offer").disabled = true;
      document.querySelector("#btn_remise").disabled = true;
      // Si le le net a payer est > qte cmd
      var net_price = document.querySelector("input[name=net_price]");
      var total_cmd = document.querySelector("input[name=total_cmd]");
      if (net_price > total_cmd) {
        toastr.error("Le montant net à payer est supérieur que la quantité commandée");
      }
    } else if (typeVente.value == 1) {
      document.querySelector("#btn_offer").disabled = true;
      document.querySelector("#btn_remise").disabled = true;
    }
/** Check la qte si = 0 */
var qtes = Array.prototype.slice(document.querySelectorAll('.qte_cmd'));
var filtred = qtes.map(qte => Number(qte.innerHTML.replace(',', '.')))
    .filter(qte => qte === 0);
if (filtred.length > 0) {
  toastr.error("Une des qte est egal à zéro");
}

</script>
<?php if (isset($this->data['Salepoint']['id']) and !empty($this->data['Salepoint']['id'])): ?> 
<?php echo $this->element('pos-script', ['salepoint_id' => $this->data['Salepoint']['id'], 'commande_id' => $this->data['Salepoint']['commande_id'], 'ecommerce_id' => $this->data['Salepoint']['ecommerce_id'], 'glovo_id' => $this->data['Salepoint']['glovo_id'], 'perm' => $perm]); ?>
<?php echo $this->element('code-barre-pos', ['output' => 'easy-numpad-output', 'element' => 'code_barre']); ?>
<?php echo $this->element('password-pos', ['output' => 'easy-numpad-output', 'element' => 'passw']); ?>
<?php echo $this->element('ecom-script', ['salepoint_id' => $this->data['Salepoint']['id']]); ?>
<?php echo $this->element('num-pad-remise-ligne'); ?>
<?php echo $this->element('num-pad-montant-1'); ?>
<?php echo $this->element('num-pad-montant-2'); ?>
<?php echo $this->element('num-pad-remise'); ?>
<?php endif; ?>

<?php $this->end(); ?>
