<html>
    <head>
    	<?php echo $this->element('style-ticket'); ?>
    </head>
    <body>

<style>
.print-ticket, .print-ticket-impr{
	background: #4ccf3d;
    font-weight: 600;
    color: white;
}


</style>


<script>
	
    $('#edit').on('click','.print-ticket-impr',function(e){
			
		      	$('#edit').modal('hide');
                var divToPrint=document.getElementById('DivIdToPrint');
                var newWin=window.open('','Print-Window');
                newWin.document.open();
                newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                newWin.document.close();
                setTimeout(function(){newWin.close();},10);
             
		
	});
</script>

    <div class="paragraph">
    	<br />
    		<center>
       			 <input type='button' class='btn btn-default btn-lg print-ticket-impr' id='btn' value='Imprimer ticket' href="<?php echo $this->Html->url(['controller' => 'impressions', 'action' => 'printed']); ?>">
    	    </center>
    	<br />
    </div>


<div id='DivIdToPrint'>
        <div class="col-md-12">
            <style>
                #printbox {
        width: 450px;
        margin: 0px auto;
        padding: 6px;
        text-align: justify;
        border: 1px solid none;
        border: 1px solid grey;
    }
    @media print{    
        .no-print, .no-print *{
            display: none !important;
        }
    }
            </style>
            <div id='printbox' class="printme">
          
                
                <h2 style="text-align: center"> <?php echo $libelle; ?> : 
                	 
</h2>           <br>
                
                <div style="text-align: center">
                <div>
                    <?php require '../../vendor/autoload.php';
                   /*  $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                    $impr_codebar = $generator->getBarcode($code_barre, $generator::TYPE_CODE_128);
 */

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
echo '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($code_barre, $generator::TYPE_CODE_128)).'">'; ?>
                </div>
                    <h3 style="text-align: center"> <?php
                    echo $code_barre; ?> 
                	 
                     </h3>

                </div>
                <br/>
              <style>
                .list_valeurs_ticket{
		text-align: center;
		margin-top: 2px;
        /*margin-left: 3rem;*/
		padding-bottom: 2px;
		font-weight: bold;
    }
              </style>
                <div class="list_valeurs_ticket"> 
                    Produit le : <?php echo date('Y-m-d H:i:s'); ?>
                </div>
                
                <div class="list_valeurs_ticket"> 
                    Exp : <?php echo $dlc; ?>
                </div>
               
                
                <div class="list_valeurs_ticket"> 
                    Lot : <?php echo $lot; ?>
                </div>
                <div class="list_valeurs_ticket"> 
                    Poids : <?php echo($quantite / 1000).'Kgs'; ?>
                </div>
               
                   
            </div>
        </div>
           
 </div>


 <div class="modal-footer no-printme">
    <button type="button" class="btn btn-primary print-ticket btn-default btn-lg" data-dismiss="modal" >Terminer & Fermer</button>
</div>


    </body>
</html>