<html>
    <head>
    	<title>SALE N° : <?php echo $this->data['Salepoint']['reference']; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket', ['societe' => $societe]); ?>
    </head>
    <body>

<style>
body, .DivIdToPrint {
    margin: 0;
    padding: 0;
    font-size: 13px;
    font-weight: bold;
    background-color: #fff;
    font-family: Calibri Light !important;
    border:none !important;
}

.print-ticket, .print-ticket-impr{
	background: #4ccf3d;
    font-weight: 600;
    color: white;
}
</style>

<script>
$('#edit').on('click','.print-ticket-impr',function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
      url: url,
      success: function(dt){
        $('#edit').modal('hide');
        var divToPrint=document.getElementById('DivIdToPrint');
        divToPrint.style.border = 'none';
        divToPrint.style.padding = '0';
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},10);
      }
    });
});
</script>

<div class="paragraph">
    <br />
    <center>
        <input type='button' class='btn btn-default btn-lg print-ticket-impr' value='Print receipt' href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'printed', $this->data['Salepoint']['id']]); ?>">
    </center>
    <br />
</div>

<div id='DivIdToPrint'>
    <?php echo $this->element('pos-ticket-style', ['societe' => $societe]); ?>
    <div class="col-md-12">
        <div id='printbox' class="printme">
            <?php echo $this->element('header-ticket', ['societe' => $societe, 'title' => 'RECEIPT']); ?>
            <div>RECEIPT N° : <?php echo $this->data['Salepoint']['reference']; ?></div>
            <div>CUSTOMER :
                <?php 
                    if ($societe['Societe']['id'] == 2) {
                        $client = $this->requestAction(['controller' => 'pos', 'action' => 'GetClient', 2]);
                        if (!empty($client)) {
                            echo $client['Client']['designation'];
                            if (!empty($client['Client']['adresse'])) {
                                echo $client['Client']['adresse'];
                            }
                        }
                    } else {
                        echo $this->data['Client']['designation']; 
                        echo $this->data['Client']['adresse']; 
                    }
                ?>
                <br/>
                <?php if (isset($this->data['Client']['telmobile']) && !empty($this->data['Client']['telmobile'])): ?>
                PHONE : <?php echo $this->data['Client']['telmobile']; ?>
                <?php endif; ?>
            </div>
            <br/>
            <table id="products" cellspacing="0" cellpadding="0">
                <tr>
                    <th nowrap="" width="80px">Product Name</th>
                    <th nowrap="">Qty</th>
                    <th nowrap="">Price</th>
                    <th nowrap="">Discount (%)</th>
                    <th nowrap="">Total</th>
                </tr>
                <?php foreach ($details as $tache): ?>
                <tr>
                    <td style="text-align: left;"><?php echo $tache['Produit']['libelle']; ?></td>
                    <td nowrap=""><?php echo $tache['Salepointdetail']['qte']; ?></td>
                    <td nowrap="" style="text-align: right;">
                        <?php echo number_format(isset($this->data['Salepoint']['ecommerce_id']) ? $tache['Salepointdetail']['unit_price'] : $tache['Salepointdetail']['prix_vente'], 2, ',', ' ') . ' AED'; ?>
                    </td>
                    <td nowrap="" style="text-align: right;"><?php echo (int) $tache['Salepointdetail']['remise']; ?>%</td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') . ' AED'; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <?php if (isset($this->data['Salepoint']['glovo_id'])) : ?>
            <div class="list_valeurs_ticket">Glovo order : <?php echo $this->data['Commandeglovo']['order_code'] ?></div>
            <?php endif ?>

            <div class="list_valeurs_ticket">Amount : <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'], 2, ',', ' ') . ' AED'; ?></div>

            <div class="list_valeurs_ticket">
                <?php if ($this->data['Salepoint']['etat'] == 3) : ?>
                    Payment method :
                <?php else : ?>
                    <?php if (strpos($modes, "Bon d'achat") !== false) {
                        echo  $ref_bon_achat;
                    } elseif (strpos($modes, 'Chèque cadeau') !== false) {
                        echo   $ref_cheque_cad;
                    } ?>
                <?php endif; ?>
            </div>

            <div class="list_valeurs_ticket">Fees : <?php echo number_format($this->data['Salepoint']['fee'], 2, ',', ' ') . ' AED'; ?></div>

            <div class="list_valeurs_ticket">
                Discount : <?php echo number_format(($this->data['Salepoint']['etat'] == 3 ? 0 : $this->data['Salepoint']['total_a_payer_ttc'] - $this->data['Salepoint']['total_paye']), 2, ',', ' ') . ' AED'; ?>
            </div>

            <div class="list_valeurs_ticket">
                AMOUNT DUE : <?php echo number_format(($this->data['Salepoint']['etat'] == 3 ? $this->data['Salepoint']['total_apres_reduction'] : $this->data['Salepoint']['total_paye'] + $this->data['Salepoint']['fee']), 2, ',', ' ') . ' AED'; ?>
            </div>

            <?php if (isset($this->data['Salepoint']['check_cad']) && !empty($this->data['Salepoint']['check_cad'])) :  ?>
            <div class="list_valeurs_ticket">
                Please collect your gift voucher of <?php echo $this->data['Chequecadeau']['montant']; ?> AED, number : <?php echo $this->data['Chequecadeau']['reference']; ?>
            </div>
            <?php endif; ?>

            <?php if (isset($this->data['Salepoint']['client_id']) && $this->data['Salepoint']['client_id'] != 1) : ?>
            <div class="list_valeurs_ticket">Loyalty Points : <?php echo $this->data['Client']['points_fidelite']; ?></div>
            <?php endif; ?>

            <?php echo $this->element('footer-ticket', ['details_tva' => $details_tva, 'societe' => $societe, 'avances' => $avances]); ?>
        </div>
    </div>
</div>

<div class="modal-footer no-printme">
    <button type="button" class="btn btn-default btn-lg print-ticket" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'printed', $this->data['Salepoint']['id']]); ?>">Finish & Close</button>
</div>

</body>
</html>
