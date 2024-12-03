<?php $element = ( isset( $element ) AND !empty( $element ) ) ? '#'.$element : null ; ?>
<?php $form = ( isset( $form ) AND !empty( $form ) ) ? '#'.$form : "form" ; ?>
<?php $url = ( isset( $url ) AND !empty( $url ) ) ? $url : null ; ?>
<script type="text/javascript">

	<?php if ( !empty( $element ) AND !empty( $url ) ): ?>

	loadAjaxPage('<?php echo $url ?>','<?php echo $element ?>');
	
	$('#edit').on('submit','<?php echo $form ?>',function(e){
	    e.preventDefault();
	    var formData = $(this).serialize();
	    var form = $(this);
	    $('.saveBtn').attr("disabled", true);
	    $.ajax({
	      type: 'POST',
	      data:formData,
	      url: form.attr('action'),
	      success : function(dt){
	        $('#edit').modal('hide');
			if(dt.err == true) { toastr.error(dt.message); }
			else {
                toastr.success("L'enregistrement a été effectué avec succès.");
            }
			loadAjaxPage('<?php echo $url ?>','<?php echo $element ?>');
	      },
	      error: function(dt){
	      	toastr.error("Erreur d'enregistrement des données !")
	      },
	      complete : function(){
	        $('.saveBtn').attr("disabled", false);
	      },
	    });
	});

  	$('<?php echo $element ?>').on('click','.edit',function(e){
	    e.preventDefault();
	    $.ajax({
	      url: $(this).attr('href'),
	      success: function(dt){
	        $('#edit .modal-content').html(dt);
	        $('#edit').modal('show');
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	        Init();
	      }
	    });
  	});
  
  	$('<?php echo $element ?>').on('click','.btnFlagDelete',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
	      if( result ){
	        $.ajax({
	          url: url,
	          success: function(dt){
	            toastr.success("La suppression a été effectué avec succès.");
	            loadAjaxPage('<?php echo $url ?>','<?php echo $element ?>');
	          },
	          error: function(dt){
	          	toastr.error("Erreur de suppression !")
	          }
	        });
	      }
	    });
  	});

	<?php endif ?>

</script>