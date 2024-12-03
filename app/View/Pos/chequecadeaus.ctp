<div class="modal-header">
	<h4 class="modal-title">	
		Liste des chèques cadeaux
	</h4>
		
</div>
<div class="modal-body ">
	<div class="row">
		
    <?php if ( empty( $chequecadeaus ) ): ?>
			<div class="col-md-12">
				<div class="alert alert-danger text-center p-2" style="font-weight: bold;font-size: 20px;">Liste des chèques est vide !</div>
			</div>
		<?php else: ?>
			<div class="col-md-12" style="border:1px solid #e5e5e5;">
		        
			<form id="live-search" action="" class="styled" method="post">
				<fieldset>
					<input  type="hidden" class="form-control text-input" id="filter" value="" />
					<span id="filter-count"></span>
				</fieldset>
			</form>

			

				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
							<th style="width: 20%;" class="actions"></th>
					
								<th nowrap="">référence</th>
								<th nowrap="">montant</th>
								<th nowrap="">Numero</th>
								<th nowrap="">Validté</th>
								
							</tr>
						</thead>
						<tbody id="EcommerceList">
							<?php foreach ($chequecadeaus as $chequecadeau): ?>
								<tr >
								<td nowrap="">
									<a style="width: 300px;height: 50px;line-height: 47px;text-align: center !important;" class="traitercommande btn btn-primary btn-sm btn-block" attrUrl="" href="<?php echo $this->Html->url(['action'=>'activerChequecadeau',$chequecadeau["Chequecadeau"]["montant"],$salepoint_id,$chequecadeau["Chequecadeau"]["id"]]) ?>"><i class="fa fa-hand-o-right"></i> Choisir</a></td>
									<td  class="nom" nowrap=""><?php echo $chequecadeau["Chequecadeau"]["reference"] ?> </td>
									<td nowrap=""><?php echo $chequecadeau["Chequecadeau"]["montant"] ?></td>
									<td nowrap=""><?php echo $chequecadeau["Chequecadeau"]["numero"] ?></td>
									<td nowrap=""><?php echo $chequecadeau["Chequecadeau"]["date_fin"] ?></td>
							
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php endif ?>
		
	</div>
</div>
<div class="modal-footer">
	<a type="button" class="btn btn-primary btn-lg active" data-dismiss="modal">Fermer</a>
</div>
<script>
 $(document).ready(function() {
  $(window).keydown(function(event){
    
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
}); 
$(document).ready(function(){
    $("#filter").keyup(function(){
 
        //alert(event.keycode);
            // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
 
        // Loop through the comment list
        $("#EcommerceList tr").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            /* alert($(this).children("td:first").text()); */
			if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
 
    
   
    });
});
</script>