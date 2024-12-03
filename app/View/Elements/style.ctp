<style>
    @page {
        margin: 0px 0px 0px 0px;
    }
    body{
        font-size:11px;
        margin-top: 3cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-bottom: 5cm;
    }
    table.info td{
        margin:5px;
        padding:5px;
    }
    table.details{
        border-spacing: 0;
        margin:4px;
        padding:4px;
    }
    table.details td,th{
        margin:8px;
        padding:8px;
        border:1px solid black;
    }
    .total{
        font-size:12px;
        font-weight:bold;
        text-align:right;
    }
    .container{
        padding:8px;
        margin-bottom:0px;
        border:1px solid black;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2.5cm;
        text-align: center;
    }

    footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 1.5cm;
        font-size:14px;
        text-align: center;
        border-top:2px solid black;
    }

    <?php if ( isset( $societe['Societe']['show_ht'] ) AND $societe['Societe']['show_ht'] == -1 ): ?> 
    tr.hide_total{
        border: none !important;
        color: white !important;
    }
    td.hide_total{
        border: none !important;
        color: white !important;
    }
    <?php else:; ?>
    .hide_total{
        font-size:12px;
        font-weight:bold;
        text-align:right;
    }
    <?php endif ?>
</style>