<?php $this->start('js'); ?>
<script>
$.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'impression']); ?>",
	      success: function(dt){
	        $('#edit .modal-content').html(dt);
	        $('#edit').modal('show');
          $(document).off('focusin.modal');
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	        //Init();
	      }
	    });
        $('#edit').on('submit','#ScanForm',function(e){
    
    e.preventDefault();
        var code_barre = $('#code_barre').val();
        $('.code_barre').val(code_barre);
        scaning(code_barre);
      });
  
    function scaning(code_barre) {
      if ( code_barre == '' || code_barre == '#' ) { toastr.error("Aucun code barre saisie !"); return; }
  
      
  
        $.ajax({
          url: "<?php echo $this->Html->url(['action' => 'scan']); ?>/"+code_barre,
          success: function(result){
            if ( result.error == true ) toastr.error(result.message);
            else{
              	var libelle = result.data.libelle;
              	var dlc = result.data.dlc;
              
          $("#Produit").val(libelle); 
          $(".dlc").val(dlc); 
          
          
          
  
            } 
          },
          error: function(dt){
            toastr.error("Il y a un problème");
          },
          complete: function(dt){
        $('#code_barre').val('');
          }
        });
    }
    
      $('#edit').on('submit','#ProduitEditForm',function(evt){
      evt.preventDefault();
      var code_barre = $('.code_barre').val();
      var libelle = $("#Produit").val();
      var dlc = $(".dlc").val();
      var quantite = $(".quantite").val();
      var num_lot = $(".num_lot").val();
      
      var url =  "<?php echo $this->Html->url(['action' => 'etiquette']); ?>/"+code_barre+"/"+libelle+"/"+dlc+"/"+quantite+"/"+num_lot;
      
      $.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'etiquette']); ?>/"+code_barre+"/"+libelle+"/"+quantite+"/"+num_lot,
	      type : "POST",
        data: {dlc : dlc},
        success: function(dt){
	        $('#edit .modal-content').html(dt);
	        $('#edit').modal('show');
          
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	        //Init();
	      }
	    });

    });
  </script>
<?php $this->end(); ?>