<html>
    <head>
    	<title>BON LIVRAISON N° : <?php echo $this->data['Bonlivraison']['reference'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket',['societe' => $societe]) ?>
    </head>
    <body>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'BON LIVRAISON']) ?>
            
            <div class="line">
                BON LIVRAISON N° : <?php echo $this->data['Bonlivraison']['reference'] ?>
            </div>

            <br/>
            
            <div class="line">
                CLIENT : <?php echo $this->data['Client']['designation'] ?><br/>
                <?php if ( isset( $this->data['Client']['adresse'] ) AND !empty( $this->data['Client']['adresse'] ) ): ?>
                <?php echo $this->data['Client']['adresse'] ?><br/>    
                <?php endif ?>
                 <?php if ( isset( $this->data['Client']['telmobile'] ) AND !empty( $this->data['Client']['telmobile'] ) ): ?>
                TEL : <?php echo $this->data['Client']['telmobile'] ?>
                <?php endif ?>
            </div>

            <br/>

            <table id="products" cellspacing="0" cellpadding="0">
                <tr>
                    <th nowrap="">Qte</th>
                    <th nowrap="">Désignation</th>
                    <th nowrap="">Prix</th>
                    <th nowrap="">R(%)</th>
                    <th nowrap="">Total</th>
                </tr>
                <?php foreach ($details as $tache): ?>
                <tr>
                    <td nowrap=""><?php echo $tache['Bonlivraisondetail']['qte'] ?></td>
                    <td style="text-align: left;"><?php echo $this->Text->truncate($tache['Produit']['libelle'], 25) ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraisondetail']['prix_vente'], 2, ',', ' ') ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo (int)$tache['Bonlivraisondetail']['remise'] ?>%</td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraisondetail']['total'], 2, ',', ' ') ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>

            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
                NET A PAYER : <?php echo number_format($this->data['Bonlivraison']['total_apres_reduction'], 2, ',', ' ') ?>
            </p>

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