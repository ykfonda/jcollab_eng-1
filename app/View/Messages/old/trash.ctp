<link href="/assets/admin/pages/css/inbox.css" rel="stylesheet" type="text/css"/>

<div class="hr"></div>

<div class="row inbox">
	<div class="col-md-2">
		<ul class="inbox-nav margin-bottom-10">
			<li class="compose-btn">
				<a href="<?php echo $this->Html->url(['action' => 'add']) ?>" data-title="Compose" class="btn green">
				<i class="fa fa-edit"></i> Compose </a>
			</li>
			<li class="inbox">
				<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn" data-title="Inbox">
				Inbox <?php echo ($inbox > 0)? '('.$inbox.')' : ''; ?>
				</a>
				<b></b>
			</li>
			<li class="sent">
				<a class="btn" href="<?php echo $this->Html->url(['action' => 'sent']) ?>" data-title="Sent">
				Sent </a>
				<b></b>
			</li>
<!-- 			<li class="draft">
	<a class="btn" href="javascript:;" data-title="Draft">
	Draft </a>
	<b></b>
</li> -->
			<li class="trash active">
				<a class="btn" href="<?php echo $this->Html->url(['action' => 'sent']) ?>" data-title="Trash">
				Trash <?php echo ($trash > 0)? '('.$trash.')' : ''; ?>
				</a>
				<b></b>
			</li>
		</ul>
	</div>
	<div class="col-md-10">
		<div class="inbox-header">
			<h1 class="pull-left">Inbox</h1>
			<form class="form-inline pull-right" action="index.html">
				<div class="input-group input-medium">
					<input type="text" class="form-control" placeholder="Password">
					<span class="input-group-btn">
					<button type="submit" class="btn green"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>
		</div>
		<div class="inbox-loading">
			loading ..
		</div>
		<div class="inbox-content">

<!-- ------------------------------------------------------------------------------------------- -->


<table class="table table-striped table-advance table-hover">
<thead>
<tr>
	<th colspan="3">
		<input type="checkbox" class="mail-checkbox mail-group-checkbox">
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
		</div>
	</th>
	<th class="pagination-control" colspan="3">
		<span class="pagination-info">
		1-30 of 789 </span>
		<a class="btn btn-sm blue">
		<i class="fa fa-angle-left"></i>
		</a>
		<a class="btn btn-sm blue">
		<i class="fa fa-angle-right"></i>
		</a>
	</th>
</tr>
</thead>
<tbody>

<?php foreach ($messages as $key => $message): ?>
	<?php if ($message['Message']['isread'] == '0'): ?>
		<tr data-messageid="1" class="unread" data-id="<?php echo $message['Message']['id'] ?>">
	<?php else: ?>
		<tr data-messageid="1" data-id="<?php echo $message['Message']['id'] ?>">
	<?php endif ?>
	<td class="inbox-small-cells">
		<input type="checkbox" class="mail-checkbox">
	</td>
	<td class="inbox-small-cells">
		<i class="fa fa-star"></i>
	</td>
	<td class="view-message hidden-xs">
		<?php echo String::truncate($message['Message']['subject'],35) ?>
	</td>
	<td class="view-message ">
		<?php echo String::truncate($message['Message']['message'],75) ?>
	</td>
	<td class="view-message inbox-small-cells">
		<i class="fa fa-paperclip"></i>
	</td>
	<td class="view-message text-right">
		<?php echo date("F j, H:i",strtotime($message['Message']['created'])); ?>
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
		Aa
	</td>
	<td class="view-message inbox-small-cells">
		<i class="fa fa-paperclip"></i>
	</td>
	<td class="view-message text-right">
		 March 15
	</td>
</tr>

-->

<!-- ------------------------------------------------------------------------------------------- -->

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