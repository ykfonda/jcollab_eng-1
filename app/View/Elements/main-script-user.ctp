<?php $form = ( isset( $form ) ) ? '#'.$form : 'form' ; ?>
<?php $ajax = ( isset( $ajax ) ) ? $ajax : true ; ?>
<script type="text/javascript">
	var dataFilter = null;
  	var dataPage = 1;

	Init();

	<?php if ( $ajax ): ?>
	  	$('#editOFFF').on('submit','<?php echo $form ?>',function(e){
	      e.preventDefault();
	      var formData = new FormData( this );
	      var form = $(this);
	      $('.saveBtn').attr("disabled", true);
	      $.ajax({
	        cache: false,
	        contentType: false,
	        processData: false,
	        type: 'POST',
	        url: form.attr('action'),
	        data:formData,
	        success : function(dt){
	          loadIndexAjaxFilter( dataFilter , true);
	          toastr.success("L'enregistrement a été effectué avec succès.");
	          $('#edit').modal('hide');
	        },
	        error: function(dt){
	          toastr.error("Il y a un problème");
	        },
	        complete : function(){
	          $('.saveBtn').attr("disabled", false);
	        },
	      });
	  	});
	<?php else: ?>
	  	$('#edit').on('submit','<?php echo $form ?>',function(e){
	      $('.saveBtn').attr("disabled", true);
	  	});
	<?php endif ?>

  	$('#indexAjax').on('click','.edit',function(e){
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

	  

  	// ----------------------- Filtre & Pagination ------------------------ //

	var loadIndexAjax = function(url){
	    $.ajax({
	      url: url,
	      success : function(dt){
	        $('#indexAjax').html(dt);
	      },
	      complete: function(){
	        Init();
	      }
	    });
	}

  	var loadIndexAjaxFilter = function(data,load){
	    if(load !== true) dataPage = 1;

	    $.ajax({
	      type: 'POST',
	      url: "<?php echo $this->Html->url(['action' => 'callIndexAjax']) ?>/" + dataPage,
	      data: data,
	      success : function(dt){
	        $('#indexAjax').html(dt);
	      },
	      complete: function(){
	        Init();
	      }
	    });
  	}

  	loadIndexAjaxFilter( dataFilter , false);

  	$('#indexAjax').on('click','.pagination li:not(.disabled,.active) a',function(e){
	    e.preventDefault();
	    loadIndexAjax( $(this).attr('href') );
	    dataPage = 1;

	    SplitArr = $(this).attr('href').split('/');
	    for (var i = 0; i < SplitArr.length; i++) {
	      if(SplitArr[i].split(':')[0] == "page"){
	        dataPage = SplitArr[i].split(':')[1];
	      }
	    };
  	});

  	$('#indexAjax').on('click','.btnFlagDelete',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
	      if( result ){
	        $.ajax({
	          url: url,
	          success: function(dt){
	            toastr.success("La suppression a été effectué avec succès.");
	            loadIndexAjaxFilter( dataFilter, false );
	          },
	          error: function(dt){
	            toastr.error("Il y a un problème")
	          }
	        });
	      }
	    });
  	});

  	$('.action').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
	      if( result ){
	      	window.location = url;
	      }
	    });
  	});

	$('#ExcelBtn').on('click',function(e){
		e.preventDefault();
		dataFilter = $('#FilterIndexForm').serialize();
		loadExcelFilter( dataFilter, false );
	});

	var loadExcelFilter = function(data,load){
		if(load !== true)
		  dataPage = 1;

		$.ajax({
		  type: 'POST',
		  url: "<?php echo $this->Html->url(['action' => 'callIndexAjaxExcel']) ?>/" + dataPage,
		  data: data,
		  success : function(dt){
		    window.open(dt ,'_blank' );
		  }
		});
	}

  	$('.key').on('input',function(e){
	    e.preventDefault();
	    dataFilter = $('#FilterIndexForm').serialize();
	    loadIndexAjaxFilter( dataFilter, false );
	});

  	$('#FilterIndexForm').on('submit',function(e){
	    e.preventDefault();
	    dataFilter = $(this).serialize();
	    loadIndexAjaxFilter( dataFilter, false );
  	});

  	$('.btnResetFilter').on('click',function(e){
	    dataFilter = null;
	    $('.select2').val('').trigger('change');
	    loadIndexAjaxFilter( dataFilter, false );
  	});
</script>