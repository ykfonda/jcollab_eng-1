<html>
    <head>
        <title>BON DE COMMANDE N° : <?php echo $this->data['Commande']['reference'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket',['societe' => $societe]) ?>
    </head>
    <body>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'BON DE COMMANDE']) ?>
            
            <div class="line">
                BON DE COMMANDE N° : <?php echo $this->data['Commande']['reference'] ?>
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
                    <td nowrap=""><?php echo $tache['Commandedetail']['qte'] ?></td>
                    <td nowrap="" style="text-align: left;"><?php echo $this->Text->truncate($tache['Produit']['libelle'], 15) ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Commandedetail']['prix_vente'], 2, ',', ' ') ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo (int)$tache['Commandedetail']['remise'] ?>%</td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Commandedetail']['total'], 2, ',', ' ') ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>

            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
                NET A PAYER : <?php echo number_format($this->data['Commande']['total_apres_reduction'], 2, ',', ' ') ?>
            </p>

            <?php echo $this->element('footer-ticket',['societe' => $societe]) ?>

        </div>
    </body>
</html>
<script>
   window.print();
</script>