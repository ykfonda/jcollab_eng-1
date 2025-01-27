<h1>Liste des Registres de Passation</h1>

<!-- Bouton pour ajouter un nouveau registre -->
<p>
    <?= $this->Html->link('Ajouter un nouveau registre', ['action' => 'add'], ['class' => 'btn btn-success']) ?>
</p>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Référence</th>
            <th>Objectif</th>
            <th>Pilote</th>
            <th>CoPilote</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Fréquence</th>
            <th>Manager</th>
            <th>Plage Horaire</th>
            <th>Responsable Qualité</th>
            <th>Jour</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($registrepassations)): ?>
            <?php foreach ($registrepassations as $key => $registre): ?>
                <tr>
                    <td><?= h($key + 1) ?></td>
                    <td><?= h($registre['Registrepassation']['reference']) ?></td>
                    <td><?= h($registre['Registrepassation']['Objectif']) ?></td>
                    <td><?= h($registre['Registrepassation']['Pilote']) ?></td>
                    <td><?= h($registre['Registrepassation']['CoPilote']) ?></td>
                    <td><?= h($registre['Registrepassation']['date']) ?></td>
                    <td>
                        <?= $registre['Registrepassation']['statut'] == -1 ? 'Inactif' : 'Actif' ?>
                    </td>
                    <td><?= h($registre['Registrepassation']['Frequence']) ?></td>
                    <td><?= h($registre['Registrepassation']['Manager']) ?></td>
                    <td><?= h($registre['Registrepassation']['Plage_Horaire']) ?></td>
                    <td><?= h($registre['Registrepassation']['Responsable_Qualite']) ?></td>
                    <td><?= h($registre['Registrepassation']['Jour']) ?></td>
                    <td>
                        <?= $this->Html->link('Voir', ['action' => 'view', $registre['Registrepassation']['id']], ['class' => 'btn btn-info btn-sm']) ?>
                        <?= $this->Html->link('Éditer', ['action' => 'edit', $registre['Registrepassation']['id']], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $registre['Registrepassation']['id']], ['class' => 'btn btn-danger btn-sm', 'confirm' => 'Êtes-vous sûr de vouloir supprimer cet enregistrement ?']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="13" class="text-center">Aucun registre de passation trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
