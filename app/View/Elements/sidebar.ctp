<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
    <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Menu principale</span><i data-feather="more-horizontal"></i></li>
    <?php $active = ( isset( $this->request->params['controller'] ) AND $this->request->params['controller'] == 'pages' ) ? 'active' : '' ; ?>
    
    <li class="nav-item <?php echo $active ?>">
    	<a class="d-flex align-items-center" href="<?php echo $this->Html->url('/') ?>">
    		<i class="fa fa-line-chart"></i>
    		<span class="menu-title text-truncate" data-i18n="Tableau de bord">Tableau de bord</span>
    	</a>
    </li>

    <?php $modules = $this->requestAction(array('controller' => 'modules','action' => 'getSidebarMenu')); ?>
	<?php foreach ($modules as $keyy => $value): ?>
		<?php $module = ( !empty( $value['Module']['link'] ) ) ? str_replace('/', '', str_replace('annee', '', $value['Module']['link'])) : '' ; ?>
		<?php $active_module = ( $module == $this->request->params['controller'] ) ? 'active' : '' ; ?>

		<?php if (!empty($value['children'])): ?>
	    	<li class="nav-item <?php echo $active_module ?>">
		    	<a class="d-flex align-items-center" href="#">
		    		<i class="fa <?php echo $value['Module']['icon'] ?>"></i>
		    		<span class="menu-title text-truncate" data-i18n="<?php echo $value['Module']['libelle'] ?>"><?php echo $value['Module']['libelle'] ?></span>
		    	</a>
		        <ul class="menu-content">
		        	<?php foreach ($value['children'] as $key => $val): ?>
		        		<?php $module = ( !empty( $val['Module']['link'] ) ) ? str_replace('/', '', str_replace('annee', '', $val['Module']['link'])) : '' ; ?>
						<?php $active_menu = ( $module == $this->request->params['controller'] ) ? 'active' : '' ; ?>
		            	<li class="<?php echo $active_menu ?>">
		            		<?php $link = ( empty($val['Module']['link']) ) ? '#' : $this->Html->url($val['Module']['link']) ; ?>
		            		<a class="d-flex align-items-center" href="<?php echo $link ?>">
		            			<i class="fa <?php echo $val['Module']['icon'] ?>"></i>
		            			<span class="menu-item text-truncate" data-i18n="<?php echo $val['Module']['libelle'] ?>"><?php echo $val['Module']['libelle'] ?></span>
		            		</a>
		            	</li>
		        	<?php endforeach ?>
		        </ul>
		    </li>
		<?php else: ?>
	    	<li class="nav-item <?php echo $active_module ?>">
				<?php $link = ( empty($value['Module']['link']) ) ? '#' : $this->Html->url($value['Module']['link']) ; ?>
				<a class="d-flex align-items-center" href="<?php echo $link ?>">
	    			<i class="fa <?php echo $value['Module']['icon'] ?>"></i>
	    			<span class="menu-title text-truncate" data-i18n="<?php echo $value['Module']['libelle'] ?>"><?php echo $value['Module']['libelle'] ?></span>
	    		</a>
	    	</li>
		<?php endif ?>

	<?php endforeach ?>
</ul>