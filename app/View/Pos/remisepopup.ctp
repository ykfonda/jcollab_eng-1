<div class="modal-header">
	<h4 class="modal-title">	
		Liste des remises client 

		
</div>
<div class="modal-body ">
	<div class="row">
		
		
			<div class="col-md-12" style="border:1px solid #e5e5e5;">
		        
			<form id="live-search" action="" class="styled" method="post">
				<fieldset>
					<input type="text" class="form-control text-input" id="filter" value="" />
					<span id="filter-count"></span>
				</fieldset>
			</form>

			

				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
							<th style="width: 40%;" class="actions"></th>
					
								<th nowrap="">Client</th>
								<th style="display : none" nowrap="">Code</th>
							
								
							</tr>
						</thead>
						<tbody id="EcommerceList">
							<?php foreach ($remises as $remise): ?>
								<tr >
								<td nowrap=""><a style="width: 40%;" class="traitercommande btn btn-primary btn-sm btn-block" attrUrl="" href="<?php echo $this->Html->url(['action' => 'traiterRemise', $remise['Client']['id'], $id]); ?>"><i class="fa fa-reply"></i> Choisir</a></td>
									<td  class="nom" nowrap=""><?php echo $remise['Client']['designation']; ?> </td>
									<td style="display : none"><?php echo $remise['Client']['code_client']; ?></td>
								
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			
		
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
<script>

$(document).ready(function(){
    $("#filter").keyup(function(){
 
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