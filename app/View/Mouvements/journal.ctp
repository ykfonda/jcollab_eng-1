<html>
    <head>
    	<title>JOURNAL DES ENTREES</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket',['societe' => $societe]) ?>
        <style type="text/css">
            #products tr td {
                //font-size: 10px !important;
            }
        </style>
    </head>
    <body>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'JOURNAL DES ENTREES']) ?>

            <div class="line">
                JOURNAL DES ENTREES <br/>DU : <?php echo date('d-m-Y') ?>
            </div>

            <br/>

            <table id="products" cellspacing="0" cellpadding="0" >
                <tr>
                    <th nowrap="">Réf</th>
                    <th nowrap="">Produit</th>
                    <th nowrap="">Date</th>
                    <th nowrap="">Qte</th>
                </tr>
                <?php foreach ($mouvements as $tache): ?>
                <tr>
                    <td nowrap=""><?php echo h($tache['Mouvement']['reference']); ?></td>
                    <td style="text-align: left;"><?php echo h($tache['Produit']['libelle']); ?></td>
                    <td nowrap=""><?php echo h($tache['Mouvement']['date']); ?></td>
                    <td nowrap=""><?php echo h($tache['Mouvement']['stock_source']); ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>
            
            <div class="line">Le : <?php echo date('d/m/Y').' - '.date('H:i'); ?></div>

        </div>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
    </body>
</html>
<script>
   window.print();
</script>