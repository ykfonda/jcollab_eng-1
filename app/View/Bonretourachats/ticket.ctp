<html>
    <head>
    	<title>BON DE RETOUR N° : <?php echo $this->data['Bonretourachat']['reference'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket',['societe' => $societe]) ?>
    </head>
    <body>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'BON DE RETOUR']) ?>
            
            <div class="line">
                BON DE RETOUR N° : <?php echo $this->data['Bonretourachat']['reference'] ?>
            </div>

            <br/>

            <table id="products" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Qte</th>
                    <th>Désignation</th>
                    <th>Prix</th>
                    <th>R(%)</th>
                    <th>Total</th>
                </tr>
                <?php foreach ($details as $tache): ?>
                <tr>
                    <td nowrap=""><?php echo $tache['Bonretourachatdetail']['qte'] ?></td>
                    <td nowrap=""><?php echo $this->Text->truncate($tache['Produit']['libelle'], 15) ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonretourachatdetail']['prix_vente'], 2, ',', ' ') ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo (int)$tache['Bonretourachatdetail']['remise'] ?>%</td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonretourachatdetail']['total'], 2, ',', ' ') ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>

            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
                NET A PAYER : <?php echo number_format($this->data['Bonretourachat']['total_apres_reduction'], 2, ',', ' ') ?>
            </p>

            <?php echo $this->element('footer-ticket',['societe' => $societe]) ?>

        </div>
    </body>
</html>
<script>
   window.print();
</script>