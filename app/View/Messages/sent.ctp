<?php echo $this->Html->css('/assets/admin/pages/css/inbox.css', array('inline' => false)); ?>
<style>
	.btn.btn-sm.blue a{
		color: #fff;
	}
	.btn.btn-sm.blue a:hover{
		 text-decoration: none;
	}
</style>
<?php $this->start('page-bar') ?>
<div class="page-bar">
  <ul class="page-breadcrumb breadcrumb">
    <li>
      <i class="fa fa-home"></i>
      <a href="<?php echo $this->Html->url('/') ?>">Accueil</a>
      <i class="fa fa-angle-right"></i>
    </li>
    <li>
      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>">Mes message</a>
    </li>
  </ul>
</div>
<?php $this->end() ?>
<div class="hr"></div>

<div class="row inbox">
	<div class="col-md-2">
		<ul class="inbox-nav margin-bottom-10">
			<li class="compose-btn">
				<a href="<?php echo $this->Html->url(['action' => 'add']) ?>" data-title="Compose" class="btn green">
				<i class="fa fa-edit"></i> Ecrire </a>
			</li>
			<li class="inbox">
				<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn" data-title="Inbox">
				Boîte de réception
				</a>
				<b></b>
			</li>
			<li class="sent active">
				<a class="btn" href="<?php echo $this->Html->url(['action' => 'sent']) ?>" data-title="Sent">
				Envoyé </a>
				<b></b>
			</li>
<!-- 			<li class="draft">
	<a class="btn" href="javascript:;" data-title="Draft">
	Draft </a>
	<b></b>
</li> -->
			<li class="trash">
				<a class="btn" href="<?php echo $this->Html->url(['action' => 'trash']) ?>" data-title="Trash">
				Corbeille
				</a>
				<b></b>
			</li>
		</ul>
	</div>
	<div class="col-md-10">
		<div class="inbox-header">
			<h1 class="pull-left">Envoyé</h1>
			<!-- <form class="form-inline pull-right" action="index.html">
				<div class="input-group input-medium">
					<input type="text" class="form-control" placeholder="Keyword">
					<span class="input-group-btn">
					<button type="submit" class="btn green"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form> -->
		</div>
		<div class="inbox-loading">
			loading ..
		</div>
		<div class="inbox-content">

<table class="table table-striped table-advance table-hover">
<thead>
<tr>
	<th colspan="2">
<!-- 		<input type="checkbox" class="mail-checkbox mail-group-checkbox">
<div class="btn-group">
	<a class="btn btn-sm blue dropdown-toggle" href="#" data-toggle="dropdown">
	More <i class="fa fa-angle-down"></i>
	</a>
	<ul class="dropdown-menu">
		<li>
			<a href="#">
			<i class="fa fa-pencil"></i> Mark as Read </a>
		</li>
		<li>
			<a href="#">
			<i class="fa fa-ban"></i> Spam </a>
		</li>
		<li class="divider">
		</li>
		<li>
			<a href="#">
			<i class="fa fa-trash-o"></i> Delete </a>
		</li>
	</ul>
</div> -->
	</th>
	<th class="pagination-control" colspan="3">
		<span class="pagination-info">
		<?php
	echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.')
	)); ?> </span>

<?php 
echo $this->Paginator->prev( 
	'<', array( 'class' => 'btn btn-sm blue', 'tag' => 'i' ),
	null, array( 'class' => 'btn btn-sm blue disabled', 'tag' => 'i','disabledTag' => 'i' )
);
echo $this->Paginator->next( 
	'>', array( 'class' => 'btn btn-sm blue', 'tag' => 'i' ),
	null, array( 'class' => 'btn btn-sm blue disabled', 'tag' => 'i','disabledTag' => 'i' )
);
?>

	</th>
</tr>
</thead>
<tbody>

<?php foreach ($messages as $key => $message): ?>

		<tr data-messageid="1" data-id="<?php echo $message['Message']['id'] ?>">

	<!-- <td class="inbox-small-cells">
		<input type="checkbox" class="mail-checkbox">
	</td> -->
	<td class="inbox-small-cells">
		<i class="fa fa-star"></i>
	</td>
	<td class="view-message hidden-xs">
		<?php echo String::truncate($message['Message']['subject'],35) ?>
	</td>
	<td class="view-message ">
		<?php $mess = preg_replace('/<[^>]*>/', '', $message['Message']['message']) ?>
		<?php echo String::truncate($mess,75) ?>
	</td>
	<td class="view-message inbox-small-cells">
		<i class="fa fa-paperclip"></i>
	</td>
	<td class="view-message text-right">
		<?php echo date("F j, H:i",strtotime($message['Message']['date_c'])); ?>
	</td>
</tr>
<?php endforeach ?>

</tbody>
</table>

<!--

<tr class="unread" data-messageid="18">
	<td class="inbox-small-cells">
		<input type="checkbox" class="mail-checkbox">
	</td>
	<td class="inbox-small-cells">
		<i class="fa fa-star"></i>
	</td>
	<td class="view-message hidden-xs">
		 Facebook
	</td>
	<td class="view-message view-message">
		 Dolor sit amet, consectetuer adipiscing
	</td>
	<td class="view-message inbox-small-cells">
		<i class="fa fa-paperclip"></i>
	</td>
	<td class="view-message text-right">
		 March 14
	</td>
</tr>
<tr data-messageid="19">
	<td class="inbox-small-cells">
		<input type="checkbox" class="mail-checkbox">
	</td>
	<td class="inbox-small-cells">
		<i class="fa fa-star"></i>
	</td>
	<td class="view-message hidden-xs">
		 John Doe
	</td>
	<td class="view-message">
		 Lorem ipsum dolor sit amet
	</td>
	<td class="view-message inbox-small-cells">
		<i class="fa fa-paperclip"></i>
	</td>
	<td class="view-message text-right">
		 March 15
	</td>
</tr>

-->

<!-- ------------------------------------------------------------------------------------------ -->

		</div>
	</div>
</div>

<?php $this->start('js') ?>
<script>
	$(function(){
		$('.inbox-content table tbody tr').on('click',function(e){
			window.location.href = "<?php echo $this->Html->url(['action' => 'view']) ?>/" + $(this).attr('data-id');
		});
	});
</script>
<?php $this->end() ?>