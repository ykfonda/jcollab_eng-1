<div class="modal-header">
	<h4 class="modal-title">	
		Liste des remises client 

		
</div>
<div class="modal-body ">
	<div class="row">
		
		
			<div class="col-md-12" style="border:1px solid #e5e5e5;">
		        
			<form id="live-search" action="" class="styled" method="post">
				<fieldset>
					<input  type="text" class="form-control text-input" id="filter" value="" />
					<span id="filter-count"></span>
				</fieldset>
			</form>

			

				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
							<th style="width: 40%;" class="actions"></th>
					
								<th nowrap="">reference</th>
								<th nowrap="">montant</th>
								<th nowrap="">Numero</th>
								
							</tr>
						</thead>
						<tbody id="EcommerceList">
							<?php foreach ($bonachats as $bonachat): ?>
								<tr >
								<td nowrap=""><a style="width: 40%;" class="traitercommande btn btn-primary btn-sm btn-block" attrUrl="" href="<?php echo $this->Html->url(['action'=>'activerBonachat',$bonachat["Bonachat"]["montant"],$salepoint_id,$bonachat["Bonachat"]["id"]]) ?>"><i class="fa fa-reply"></i> Choisir</a></td>
									<td  class="nom" nowrap=""><?php echo $bonachat["Bonachat"]["reference"] ?> </td>
									<td nowrap=""><?php echo $bonachat["Bonachat"]["montant"] ?></td>
									<td nowrap=""><?php echo $bonachat["Bonachat"]["numero"] ?></td>
								
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			
		
	</div>
</div>
<div class="modal-footer">
	<a type="button" class="btn default" data-dismiss="modal">Fermer</a>
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