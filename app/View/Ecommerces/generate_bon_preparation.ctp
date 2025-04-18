<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .info { margin-bottom: 20px; }
        .info td { padding: 5px; }
        .title { font-size: 20px; text-align: center; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

    <table width="100%">
        <tr>
            <td style="width: 30%;">
                <img src="<?php echo Router::url('/img/LOGO_JCOLLAB.jpg', true); ?>" style="height: 60px;" />
            </td>
            <td style="width: 40%;" class="title">
                BON DE PRÉPARATION
            </td>
            <td style="width: 30%; text-align: right;">
                Date de commande : <?php echo date('d/m/Y', strtotime($data['Ecommerce']['date'])); ?>
            </td>
        </tr>
    </table>

    <hr>

<h4 style="margin-top: 30px; font-size: 16px; font-weight: bold; text-decoration: underline;">
    Informations de la commande
</h4>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
        <th style="text-align: center; border: 1px solid #000; padding: 8px;">Référence JCOLLAB</th>
        <th style="text-align: center; border: 1px solid #000; padding: 8px;">Référence ECOM</th>
        <th style="text-align: center; border: 1px solid #000; padding: 8px;">Méthode de livraison</th>
    </tr>
    <tr>
        <td style="text-align: center; border: 1px solid #000; padding: 8px;"><?php echo h($data['Ecommerce']['reference']); ?></td>
        <td style="text-align: center; border: 1px solid #000; padding: 8px;"><?php echo h($data['Ecommerce']['barcode']); ?></td>
        <td style="text-align: center; border: 1px solid #000; padding: 8px;"><?php echo h($data['Ecommerce']['shipment']); ?></td>
    </tr>
</table>


<h4 style="margin-top: 30px; font-size: 16px; font-weight: bold; text-decoration: underline;">
    Détails des produits à préparer
</h4>

<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 8px;">Libellé</th>
            <th style="border: 1px solid #000; padding: 8px; text-align: center;">Quantité commandée</th>
            <th style="border: 1px solid #000; padding: 8px; text-align: center;">Conditionnement</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $detail): ?>
            <tr>
                <td style="border: 1px solid #000; padding: 8px;">
                    <?php echo h($detail['Produit']['libelle']); ?>
                </td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    <?php echo h($detail['Ecommercedetail']['qte_cmd']); ?>
                </td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    <?php echo h($detail['Ecommercedetail']['qte_ordered']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



</body>
</html>
