<div class="hr"></div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Statistique : Consolidation des données</h4>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?php
                // Inclure les fichiers CSS et JS de Flatpickr
                echo $this->Html->css('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
                echo $this->Html->script('https://cdn.jsdelivr.net/npm/flatpickr');
                ?>

                <?php
                echo $this->Form->create('Event', array('url' => array('controller' => 'Statistique', 'action' => 'index')));

                ?>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('start_date', array(
                        'label' => 'Date Début',
                        'type' => 'text',
                        'class' => 'date-picker form-control',
                        'div' => array('class' => 'col-md-6')
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->input('end_date', array(
                        'label' => 'Date Fin',
                        'type' => 'text',
                        'class' => 'date-picker form-control',
                        'div' => array('class' => 'col-md-6')
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $this->Form->submit('Submit', array('class' => 'btn btn-primary'));
                    ?>
                </div>
                <?php
                echo $this->Form->end();
                ?>

                <?php $this->start('js'); ?>
                <script>
                    $(document).ready(function(){
                        $('.date-picker').flatpickr({
                            altFormat: "d-m-Y",
                            dateFormat: "d-m-Y",
                            allowInput: true,
                            locale: "fr"
                        });
                    });
                </script>
                <?php $this->end(); ?>
            </div>
        </div>


        <?php if (!empty($results)): ?>
    <div class="row">
        <div class="col-md-12">
            <h5>Résultats de la consolidation des données</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Magasin</th>
                        <th>Totalht</th>
                        <th>Totalttc</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $result): ?>
    <tr>
        <td><?php echo isset($result[0]['magasin']) ? h($result[0]['magasin']) : ''; ?></td>
        <td><?php echo isset($result[0]['Totalht']) ? h($result[0]['Totalht']) : ''; ?></td>
        <td><?php echo isset($result[0]['Totalttc']) ? h($result[0]['Totalttc']) : ''; ?></td>
    </tr>
<?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>





    </div>
</div>
