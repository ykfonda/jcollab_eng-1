<?php echo $this->Html->css('/app-assets/plugins/fullcalendar/fullcalendar.min.css') ?>
<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<style type="text/css">
  table div div { white-space: normal !important; }
  td.fc-event-container> .tooltip{ 
    position: fixed;
      display: inline-block;
    z-index:9999 !important; 
  }
</style>
<div class="hr"></div>
<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Calendrier
    </div>
    <div class="actions">
    </div>
  </div>
  <div class="portlet-body ">
    <div class="row">
      <div class="col-lg-12">
        <div id="calendrier"></div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/fullcalendar/moment.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/fullcalendar/fullcalendar.min.js'); ?>
<?php echo $this->Html->script('/app-assets/plugins/fullcalendar/lang/fr.js'); ?>
<script>
$(function(){

  $('#calendrier').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    navLinks: false, 
    editable: false,
    eventLimit: true,
    lang: 'fr',
    views: {
      listDay: { buttonText: 'Jour' },
      listWeek: { buttonText: 'Semaine' }
    },
    selectable: false,
    selectHelper: false,
    events: <?php echo json_encode( $events ) ?>,
    eventRender: function(event, element) {
      $(element).tooltip({
          url : event.dataUrl,
          title: event.tip,
          placement:'top',
          html: true,
      });             
    },
    eventClick: function(calEvent, jsEvent, view) {
      if(calEvent.dataUrl){
        var url = calEvent.dataUrl;
        window.open(url ,'_blank' );
      }else{
        return false;
      }
    }
  });
});
</script>
<?php $this->end() ?>
