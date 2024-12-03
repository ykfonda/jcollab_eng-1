<html>
    <head>
    	<title>TICKET N° : <?php echo $this->data['Salepoint']['reference'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket',['societe' => $societe]) ?>
    </head>
    <body>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'VENTE']) ?>
            
            <div>
                TICKET N° : <?php echo $this->data['Salepoint']['reference'] ?>
            </div>

            <br/>
            
            <div>
                CLIENT : <?php echo $nom ?><br/>
                <?php echo $adresse ?><br/>    
                ICE : <?php echo $ice ?><br/>
                 <?php if ( isset( $this->data['Client']['telmobile'] ) AND !empty( $this->data['Client']['telmobile'] ) ): ?>
                TEL : <?php echo $this->data['Client']['telmobile'] ?>
                <?php endif ?>
            </div>

            <br/>

            <table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="" width="80px">Désignation</th>
                        <th nowrap="">Qte</th>
                        <th nowrap="">Prix</th>
                        <th nowrap="">R(%)</th>
                        <th nowrap="">Total</th>
                    </tr>
                    <?php foreach ($details as $tache): ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $tache['Produit']['libelle'] ?></td>
                        <td nowrap=""><?php echo $tache['Salepointdetail']['qte'] ?></td>
                        <?php if ( isset( $this->data['Salepoint']['ecommerce_id'] ) AND !empty( $this->data['Salepoint']['ecommerce_id'] ) ): ?>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['unit_price'], 2, ',', ' ') ?></td>
                        <?php else : ?>
                            <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' ') ?></td>
                        <?php endif ?>    
                        <td nowrap="" style="text-align: right;"><?php echo (int)$tache['Salepointdetail']['remise'] ?>%</td>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') /* echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') */ ?></td>
                    </tr>
                    <?php endforeach ?>
                </table><br/>

            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Montant : <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'], 2, ',', ' ')   ?>
            </p>
            <?php if($this->data['Salepoint']['etat'] != 3) :  ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Mode de paiement : <?php echo $modes   ?>
            </p>
            <?php endif ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Frais : <?php echo number_format($this->data['Salepoint']['fee'], 2, ',', ' ') ?>
            </p>
            <?php if($this->data['Salepoint']['etat'] == 3) :  ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Remise : <?php echo number_format(0, 2, ',', ' ') ?>
            </p>
            <?php else : ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Remise : <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc']-$this->data['Salepoint']['total_paye'], 2, ',', ' ') ?>
            </p>
            <?php endif ?>
            <?php if($this->data['Salepoint']['etat'] == 3) :  ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            NET A PAYER : <?php echo number_format($this->data['Salepoint']['total_apres_reduction'], 2, ',', ' ') ?>
            </p>
            <?php else : ?>
                <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
                NET A PAYER : <?php echo number_format($this->data['Salepoint']['total_paye'] + $this->data['Salepoint']['fee'], 2, ',', ' ') ?>
            </p>
            <?php endif ?>
            <?php echo $this->element('footer-ticket',['societe' => $societe]) ?>
        </div>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
    </body>
</html>
<script>
   window.print();
</script>