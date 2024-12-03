<script type="text/javascript">

	Init();

	function loadVilles(pay_id){
		$.ajax({
			url: "<?php echo $this->Html->url(['controller' => 'villes','action' => 'getVilles']) ?>/" + pay_id,
			success: function(dt){
				var ville = $('.villeId').val();
				$('.villeId').empty();
				$('.villeId').append('<option value="">-- Votre choix</option>');
				$.each(dt,function(index,text){
					$('.villeId').append('<option value="'+index+'">'+text+'</option>');
				});
				$('.villeId').val( ville );
			}
		});
	}

	if ( typeof $('.payId').val() != 'undefined' ) loadVilles( $('.payId').val() );

	$('.payId').on('change',function(){
		loadVilles( $(this).val() );
	});

  	$('.edit').on('click',function(e){
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
	        Init();
	      }
	    });
  	});

	function loadAjaxPage(url,element){
	    $.ajax({
	      url: url,
	      success : function(dt){
	        $(element).html(dt);
	      },
          error: function(dt){
            toastr.error("Erreur de chargement de la page !")
          },
	      complete: function(){
	        Init();
	      }
	    });
	}

  	$('.action').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
	      if( result ){
	      	window.location = url;
	      }
	    });
  	});

</script>