<style>
img.logo-style {
    float: right;
}
</style>

<div class="portlet light bordered">
	<div class="portlet-title">
        <h1 class="display-6">Installation JCOLLAB
        <?php 
            echo $this->Html->image(
                '/img/LOGO_JCOLLAB.jpg',
                array('alt' => 'Logo JCOLLAB', 'class' => 'logo-style')
            );
        ?>
        </h1>
	</div>

    <div class="container">

        
            <?php
                //echo $this->Form->create('Config');
                echo $this->Form->create('Config');

                // Champ hidden pour stocker l'ID de la configuration
                echo $this->Form->create('Config', array('url' => array('action' => 'edit', $details['Config']['id'])));


                foreach ($details['Config'] as $key => $value) {
                    echo '<div class="mb-1">';
                    if ($key === 'caisse_id') {
                        echo $this->Form->input(
                            'Config.'.$key,
                            array(
                                'value' => $value,
                                'class' => 'form-control',
                                'label' => array('class' => 'lead'),
                                'options' => $caisseOptions
                            )
                        );
                    } elseif ($key === 'store_id') {
                        echo $this->Form->input(
                            'Config.'.$key,
                            array(
                                'value' => $value,
                                'class' => 'form-control',
                                'label' => array('class' => 'lead'),
                                'options' => $storeOptions
                            )
                        );
                    } elseif ($key === 'type_app') {
                        $options = array(
                            '1' => 'Client administration',
                            '2' => 'POS',
                            '3' => 'Serveur'
                        );
                        echo '<label for="ConfigTypeApp" class="lead">Type d\'instance</label>';
                        echo $this->Form->select(
                            'Config.'.$key,
                            $options,
                            array(
                                'value' => $value,
                                'class' => 'form-control',
                                'label' => array('class' => 'lead')
                            )
                        );
                    } else {
                        echo $this->Form->input(
                            'Config.'.$key,
                            array(
                                'value' => $value,
                                'class' => 'form-control',
                                'label' => array('class' => 'lead')
                            )
                        );
                    }
                    echo '</div>';
                }
                
                echo $this->Form->end(['label' => 'Enregistrer', 'class' => 'btn btn-primary']);
            ?>
    </div>
  
</div>

