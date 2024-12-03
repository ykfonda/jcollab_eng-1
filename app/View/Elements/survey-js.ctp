<?php //echo $this->Html->script('/app-assets/plugins/icheck/icheck.min.js') ?>

<script>
	$(function(){

		var SurveyJS = function(urlSurvey){
			var loadSurveyBody = function(){
				$.ajax({
					//url: "<?php echo $this->Html->url(['controller' => 'global', 'action' => 'survey', 1, 'candidatetape_id', 2]) ?>",
					url: urlSurvey,
					success: function(dt){
						$('#SurveyBody').html(dt);
					},
					complete: function(){
						$( "#sortable" ).sortable();
						$( "#sortable" ).disableSelection();
					}
				});
			}
			loadSurveyBody();

			$('#SurveyBody').on('submit','#SurveyForm',function(e){
				e.preventDefault();
				$.ajax({
					type: 'Post',
					url: $(this).attr( 'action' ),
					data: $(this).serialize(),
					success: function(dt){
						toastr.success("L'enregistrement a été effectué avec succès.");
						loadSurveyBody();
					},
					error: function(){
						toastr.error("Il y a un probleme !");
					}
				});
			});
		}
		SurveyJS("<?php echo $urlSurvey ?>");

		

	});
</script>