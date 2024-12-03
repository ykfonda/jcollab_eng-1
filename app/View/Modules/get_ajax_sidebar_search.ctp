<ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="margin-top:0px;">
	<li class="start">
		<a href="<?php echo $this->Html->url('/') ?>">
		<i class="icon-home"></i>
		<span class="title">Accueil</span>
		</a>
	</li>
	<?php foreach ($menus as $keyy => $value): ?>
	<?php $cssClass = ''; $menu_name = ( !empty( $value['Module']['link'] ) ) ? str_replace('/', '', str_replace('annee', '', $value['Module']['link'])) : '' ; ?>
	<?php if ( $menu_name == $this->request->params['controller'] ): ?>
		<?php $cssClass = 'active' ?>
	<?php endif ?>
	<?php if(isset($menus[$keyy+1])): ?>
		<li class="<?php echo $cssClass ?>">
	<?php else: ?>
		<li class="last <?php echo $cssClass ?>">
	<?php endif ?>
	<?php if (empty($value['Module']['link'])): ?>
		<a href="javascript:;">
	<?php else: ?>
		<a href="<?php echo $this->Html->url($value['Module']['link']) ?>">
	<?php endif ?>
	  <i class="fa <?php echo $value['Module']['icon'] ?>"></i>
	  <span class="title"><?php echo $value['Module']['libelle'] ?></span>
	  <?php if (!empty($value['children'])): ?><span class="arrow"></span><?php endif ?>
	</a>
	<?php if (!empty($value['children'])): ?>
		<ul class="sub-menu">
		<?php foreach ($value['children'] as $key => $val): ?>
			<?php $cssChild = ''; $sub_menu = (!empty( $val['Module']['link'])) ? str_replace('/', '', $val['Module']['link']) : '' ; ?>
			<?php if ( $sub_menu == $this->request->params['controller'] ): ?>
				<?php $cssChild = 'style="background-color: #03A9F5;color:#fff;"' ?>
			<?php endif ?>
			<li <?php echo $cssChild ?>>
				<?php if (empty($val['Module']['link'])): ?>
					<a href="javascript:;" <?php echo $cssChild ?> >
				<?php else: ?>
					<a href="<?php echo $this->Html->url($val['Module']['link']) ?>" <?php echo $cssChild ?> >
				<?php endif ?>
				<?php echo $val['Module']['libelle'] ?>
				<?php if (!empty($val['children'])): ?><span class="arrow"></span><?php endif ?>
	  			</a>

				<?php if (!empty($val['children'])): ?>
					<ul class="sub-menu">
						<?php foreach ($val['children'] as $ke => $va): ?>
							<li>
							<?php if (empty($va['Module']['link'])): ?>
								<a href="javascript:;">
							<?php else: ?>
								<a href="<?php echo $this->Html->url($va['Module']['link']) ?>">
							<?php endif ?>
							<?php echo $va['Module']['libelle'] ?>
							<?php if (!empty($va['children'])): ?><span class="arrow"></span><?php endif ?>
							</a>
							<?php if (!empty($va['children'])): ?>
								<ul class="sub-menu">
								<?php foreach ($va['children'] as $k => $v): ?>
									<li>
							 			<?php echo $this->Html->link($v['Module']['libelle'],$v['Module']['link']) ?>
							 		</li>
							 	<?php endforeach ?>
							 	</ul>
							<?php endif ?>
							</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>	
			</li>
		<?php endforeach ?>
		</ul>
	<?php endif ?>
	</li>
<?php endforeach ?>
</ul>