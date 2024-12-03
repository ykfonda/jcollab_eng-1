<script type="text/javascript">
	var _ecommerce_element = "#barcode";
	var _output_ecommerce = ".easy-numpad-output";
	var salepoint_id = parseInt("<?php echo $salepoint_id ?>");

  	$('#edit').on('submit','#ScanCodeForm',function(e){
	    e.preventDefault();
	    var barcode = $(_ecommerce_element).val();
	    ecommerces(salepoint_id,barcode);
  	});

  	$('.btn-ecommerce').on('click',function(e){
	    e.preventDefault();
	    $.ajax({
	      url: $(this).attr('href'),
	      success: function(dt){
	        $('#edit .modal-content').html(dt);
	        $('#edit').modal('show');
	      },
	      error: function(dt){
	        toastr.error("Il y a un probleme");
	      },
	      complete: function(){
	      }
	    });
  	});

	async function ecommerces(salepoint_id,barcode) {
		$('.btn-reset-ecommerce').attr('disabled',true);
		$('.btn-scan-ecommerce').attr('disabled',true);
		$('.scan-loading-ecommerce').show();
	    await $.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'ecommerces']) ?>/"+salepoint_id+'/'+barcode,
	      success: function(dt){
	      	$('#EcommerceList').html(dt)
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(dt){
			$('.btn-reset-ecommerce').attr('disabled',false);
			$('.btn-scan-ecommerce').attr('disabled',false);
	      	$('.scan-loading-ecommerce').hide();
	      }
	    });
	}

	$('#edit').on('click','.btn-reset-ecommerce',function(e){
		e.preventDefault(); 
		$(_ecommerce_element).val('');
		ecommerces(salepoint_id,'');
	});

	$('#edit').on('click','.btn-input-barcode',function(e) {
	    e.preventDefault(); show_ecommerce_numpad();
	});

	$(document).on('click','.numberClick',function(e) {
	    e.preventDefault();
	    console.log('number clicked')
	    var currentValue = $(_output_ecommerce).html();
	    var _ecommerce_elementValue = $(this).attr('href');
	    // OutPut
	    var output = currentValue+_ecommerce_elementValue;
	    $(_output_ecommerce).html(output);
	});

	$(document).on('click','.ecommerce_numpad_del',function(e) {
	    e.preventDefault();
	    var ecommerce_numpad_output_ecommerce_val = $(_output_ecommerce).html();
	    if(ecommerce_numpad_output_ecommerce_val.slice(-2) !== "0." && ecommerce_numpad_output_ecommerce_val.slice(-3) !== "-0."){
	        var ecommerce_numpad_output_ecommerce_val_deleted = ecommerce_numpad_output_ecommerce_val.slice(0, -1);
	        $(_output_ecommerce).html(ecommerce_numpad_output_ecommerce_val_deleted);
	    }
	});

	$(document).on('click','.ecommerce_numpad_clear',function(e) {
	    e.preventDefault(); $(_output_ecommerce).html('');
	});

	$(document).on('click','.ecommerce_numpad_close',function(e) {
	    e.preventDefault(); ecommerce_numpad_close();
	});

	$(document).on('click','.ecommerce_numpad_done',function(e) {
	    e.preventDefault();
	    var ecommerce_numpad_output_ecommerce_val = $(".easy-numpad-output").html();
	    $(_ecommerce_element).val(ecommerce_numpad_output_ecommerce_val);
	    $('#ScanCodeForm').trigger('submit');
	    ecommerce_numpad_close();
	});

	function ecommerce_numpad_close() {
	    $(".easy-numpad-frame").remove();
	}

	function show_ecommerce_numpad(){
	    var ecommerce_numpad = document.createElement("div");
	    ecommerce_numpad.id = "easy-numpad-frame";
	    ecommerce_numpad.className = "easy-numpad-frame";
	    ecommerce_numpad.innerHTML = `
	        <div class="easy-numpad-container" style="max-width: 390px;">
	            <div class="easy-numpad-output-container">
	                <p class="easy-numpad-output" id="easy-numpad-output" style="min-height: 45px;"></p>
	            </div>
	            <div class="easy-numpad-number-container">
	                <table style="width:100%;">
	                    <tr>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="7" >7</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="8" >8</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="9" >9</button></td>
	                    </tr>
	                    <tr>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="4" >4</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="5" >5</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="6" >6</button></td>
	                    </tr>
	                    <tr>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="1" >1</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="2" >2</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="3" >3</button></td>
	                    </tr>
	                    <tr>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="±" disabled="disabled">±</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="0">0</button></td>
	                        <td><button class="btn btn-primary btn-block numberClick" type="button" href="." disabled="disabled">.</button></td>
	                    </tr>
	                </table>
	                <table style="width:100%;">
	                    <tr>
	                        <td/><button class="btn btn-warning btn-block btn-lg ecommerce_numpad_del" type="button"><i class="fa fa-eraser"></i> Supprimer</button><td>
	                        <td/><button class="btn btn-danger btn-block btn-lg ecommerce_numpad_clear" type="button"><i class="fa fa-eraser"></i> Vider</button><td>
	                    </tr>
	                    <tr>
	                        <td/><button class="btn btn-danger btn-block btn-lg ecommerce_numpad_close" type="button"><i class="fa fa-reply"></i> Annuler</button><td>
	                        <td/><button class="btn btn-success btn-block btn-lg ecommerce_numpad_done" type="button"><i class="fa fa-check"></i> Terminer</button><td>
	                    </tr>
	                </table>
	            </div>
	        </div>
	    `;

	    $('body').append(ecommerce_numpad);
	    $(".easy-numpad-output").html('');
	}
</script>