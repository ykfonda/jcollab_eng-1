<html>
    <head>
    	<title>JOURNAL DU VENTE</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket',['societe' => $societe]) ?>
        <style type="text/css">
            #products tr td {
                font-size: 10px !important;
            }
        </style>
    </head>
    <body>
        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket',['societe' => $societe,'title' => 'JOURNAL DU VENTE']) ?>

            <div class="line">
                JOURNAL DU VENTE DU : <?php echo $date ?>
            </div>

            <br/>

            <div class="line">
                LISTE DES PRODUITS
            </div>

            <br/>
            
            <table id="products" cellspacing="0" cellpadding="0" >
                <tr>
                    <th nowrap="">Qte</th>
                    <th nowrap="">Désignation</th>
                    <th nowrap="">Prix</th>
                    <th nowrap="">Total</th>
                </tr>
                <?php $total  = 0; ?>
                <?php foreach ($details as $tache): ?>
                <?php $total  = $total + $tache['Bonlivraisondetail']['total']; ?>
                <tr>
                    <td nowrap="" style="text-align: left;"><?php echo $tache['Bonlivraisondetail']['qte'] ?></td>
                    <td style="text-align: left;"><?php echo $tache['Produit']['libelle'] ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraisondetail']['prix_vente'], 2, ',', ' ') ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraisondetail']['total'], 2, ',', ' ') ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>

            <table id="products" cellspacing="0" cellpadding="0" >
                <tr>
                    <td>Total payé</td>
                    <td><?php echo number_format($total_paye, 2, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Reste à payer</td>
                    <td><?php echo number_format($reste_a_payer, 2, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Net à payer</td>
                    <td><?php echo number_format($total_apres_reduction, 2, ',', ' ') ?></td>
                </tr>
            </table><br/>

            <div class="line">
                LISTE DES BL
            </div>

            <br/>

            <table id="products" cellspacing="0" cellpadding="0" >
                <tr>
                    <th nowrap="">Réf</th>
                    <th nowrap="">Client</th>
                    <th nowrap="">TTL Payé</th>
                    <th nowrap="">TTL Reste</th>
                    <th nowrap="">TTL Net</th>
                </tr>
                <?php foreach ($bonlivraisons as $tache): ?>
                <tr>
                    <td nowrap="" style="text-align: left;"><?php echo $tache['Bonlivraison']['reference'] ?></td>
                    <td style="text-align: left;width: 100px;"><?php echo $tache['Client']['designation'] ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraison']['total_paye'], 2, ',', ' '); ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraison']['reste_a_payer'], 2, ',', ' '); ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Bonlivraison']['total_apres_reduction'], 2, ',', ' '); ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>

            <table id="products" cellspacing="0" cellpadding="0" >
                <tr>
                    <td>Total payé</td>
                    <td><?php echo number_format($total_paye, 2, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Reste à payer</td>
                    <td><?php echo number_format($reste_a_payer, 2, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Net à payer</td>
                    <td><?php echo number_format($total_apres_reduction, 2, ',', ' ') ?></td>
                </tr>
            </table><br/>

            <div class="line">
                LISTE DES AVANCES
            </div>

            <br/>
            
            <table id="products" cellspacing="0" cellpadding="0" >
                <tr>
                    <th nowrap="">Réf</th>
                    <th nowrap="">Montant</th>
                    <th nowrap="">Mode paiment</th>
                </tr>
                <?php $total_avance  = 0; ?>
                <?php foreach ($avances as $tache): ?>
                <?php $total_avance  = $total_avance + $tache['Avance']['montant']; ?>
                <tr>
                    <td nowrap="" style="text-align: left;"><?php echo $tache['Avance']['reference'] ?></td>
                    <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Avance']['montant'], 2, ',', ' ') ?></td>
                    <td nowrap="" style="text-align: left;"><?php echo ( !empty( $tache['Avance']['mode'] ) ) ? $this->App->getModePaiment($tache['Avance']['mode']) : '' ; ?></td>
                </tr>
                <?php endforeach ?>
            </table><br/>

            <table id="products" cellspacing="0" cellpadding="0" >
                <?php foreach ($groupements as $tache): ?>
                    <tr>
                        <td>Total <?php echo $tache['mode'] ?></td>
                        <td><?php echo number_format($tache['montant'], 2, ',', ' ') ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td>Total des avances</td>
                    <td><?php echo number_format($total_avance, 2, ',', ' ') ?></td>
                </tr>
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