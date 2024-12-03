
<div class="modal-header no-printme">
    <h4 class="modal-title">
        Imprimer Session
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <?php echo $this->element('pos-ticket-style') ?>
        <div class="col-md-12">
            <p class="paragraph no-printme">
                <button type="button" onclick="window.print();" class="btn btn-primary btn-print">Imprimer ticket</button>
            </p>
            <div id='printbox' class="printme">
                <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'TICKET']) ?>
                <div class="line"> SESSION N° : <?php echo $sessionuser['Sessionuser']['reference'] ?> </div>
                <br/>
                <div class="line">
                    Journal de Caisse du <?php echo date('Y-m-d', strtotime($sessionuser['Sessionuser']['date_debut'])) ?>   <br/>
                    Caissier(e) : <?php echo $sessionuser['User']['nom'] . " " . $sessionuser['User']['prenom'] ?><br/>
                    Caisse : <?php echo $sessionuser['Caisse']['libelle']  ?><br/>
                
                </div>
                <div class="line">
                    Total especes :  <?php echo $total_especes ?>   <br/>
                    Total cod :  <?php echo $total_cod ?>   <br/>
                    Total wallet :  <?php echo $total_wallet ?>   <br/>
                    Total carte :  <?php echo $total_carte ?>   <br/>
                    Total chèque :  <?php echo $total_cheque ?>   <br/>
                    Total bon d'achat :  <?php echo $total_bon_achat ?>   <br/>
                    Total chèque cadeau :  <?php echo $total_cheque_cadeau ?>   <br/>
                    Total offerts :  <?php echo $total_offert ?>   <br/>
                    Total ecommerce : <?php if(!empty($chiffre_affaire_ecom)) echo $chiffre_affaire_ecom; else echo "0.00" ?><br/>
                                    
                </div>
                <br/>
                <table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="">Mode paiement</th>
                        <th nowrap="">Montant</th>
                        
                    </tr>
                    <?php foreach ($payment_methods as $payment_method): ?>
                    <tr>
                    <td nowrap="" class="text-center"><?php echo array_keys($payment_method)[0] ?></td>
                  <td nowrap="" class="text-center"><?php echo number_format($payment_method[array_keys($payment_method)[0]], 2, ',', ' ') ?></td>
                        
                    </tr>
                    <?php endforeach ?>
                </table>
               
            </div>
            <p class="paragraph no-printme">
                <button type="button" onclick="window.print();" class="btn btn-primary btn-print">Imprimer ticket</button>
            </p>
        </div>
    </div>
</div>
<div class="modal-footer no-printme">
    <button type="button" class="btn btn-default btn-lg print-ticket-session" href="<?php echo $this->Html->url(['controller'=>'pos','action'=>'Sessionprinted',$sessionuser['Sessionuser']['id'],$salepoint_id]); ?>">Terminer & Fermer</button>
</div>

