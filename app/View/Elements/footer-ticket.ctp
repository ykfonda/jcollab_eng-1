<style>
    .img-responsive {
        text-align: center;
    }

    .footer-ticket {
        font-size: 12px;
    }

    .text-center {
        text-align: center !important;
    }
</style>

<div class="footer-ticket">
    <br />
    <?php  
    // Retrieve register info
    echo 'Register N°: ' . $caisse_data['Caisse']['libelle'];

    // Retrieve user info
    if (isset($users_data) AND !empty($users_data)) {
        $caissier_nom = $users_data['User']['nom'];
        $caissier_prenom = $users_data['User']['prenom'];
    } else {
        $caissier_nom = $this->Session->read('Auth.User.nom');
        $caissier_prenom = $this->Session->read('Auth.User.prenom');
    }

    echo "<br />";
    echo 'Cashier: ' . $caissier_nom . " " . $caissier_prenom;
    echo "<br />";

    // Show butcher
    if (isset($salepoints_data) AND !empty($salepoints_data)) {
        $boucher = $salepoints_data['Salepoint']['boucher'];
    } else {
        $boucher = $this->data['Salepoint']['boucher'];
    }
    echo "Prepared by: ";
    echo $boucher;
    ?>

<div id='printbox' class="printme">
    <?php echo "<br>VAT Breakdown:<br>" ?>
    <table id="products" cellspacing="0" cellpadding="0">
        <tr>
            <th nowrap="" width="80px">VAT</th>
            <th nowrap="">AMT(Excl.)</th>
            <th nowrap="">TAX</th>
            <th nowrap="">AMT(Incl.)</th>
        </tr>
        <?php foreach ($details_tva as $detail): ?>
        <tr>
            <td style="text-align: right;"><?php echo number_format($detail['Tmps']['tva'], 2, ',', ' '); ?>%</td>
            <td style="text-align: right;"><?php echo number_format($detail[0]['ht'], 2, ',', ' ') . ' AED'; ?></td>
            <td style="text-align: right;"><?php echo number_format($detail[0]['tax'], 2, ',', ' ') . ' AED'; ?></td>
            <td style="text-align: right;"><?php echo number_format($detail[0]['ttc'], 2, ',', ' ') . ' AED'; ?></td>
        </tr>
        <?php endforeach ?>
    </table>

    <?php echo "<br>Payment Methods:<br>" ?>

    <table id="products" cellspacing="0" cellpadding="0">
        <tr>
            <th nowrap="" class="text-center">Method</th>
            <th nowrap="" class="text-center">Amount</th>
        </tr>
        <?php foreach ($avances as $detail): ?>
            <?php if ($detail["Avance"]["montant"] != 0) : ?>
        <tr>
            <td class="text-center"><?php echo $this->App->getModePaiment($detail["Avance"]['mode']); ?></td>
            <td class="text-right"><?php echo number_format($detail["Avance"]['montant'], 2, ',', ' ') . ' AED'; ?></td>
        </tr>
        <?php endif ?>
        <?php endforeach ?>
    </table>
</div>
</div>

<?php 
// Show date and time
    echo "Date and Time: ";
    echo date('d/m/Y') . ' - ' . date('H:i');
?>

<hr />
<p style="text-align: center;margin-top: 5px;padding-bottom: 2px;font-weight: bold;">
    Thank you for your visit<br/> **See You After**
</p>

<p style="text-align: center;margin-top: 5px;padding-bottom: 2px;font-weight: bold;">
    For hygiene and safety reasons, our products are non-exchangeable once paid.
    <br />
    Thank you for your understanding.
</p>

<div class="text-center">
    <?php
        echo $this->Html->image('POS/qr_ticket.png', [
            'alt' => 'QR Ticket',
            'class' => 'img-responsive',
            'width' => '150',
            'height' => '150'
        ]);
    ?>
    <p class="sous-footer text-center">
        Maison de qualité<br />
        دار التميّز
    </p>
</div>
