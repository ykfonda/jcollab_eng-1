<h1>Ajouter un nouveau Registre de Passation</h1>

<?= $this->Form->create('Registrepassation', ['type' => 'post', 'class' => 'form-horizontal']) ?>

<div class="form-group">
    <?= $this->Form->input('reference', [
        'label' => 'Référence',
        'class' => 'form-control',
        'placeholder' => 'Entrez la référence'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Objectif', [
        'label' => 'Objectif',
        'class' => 'form-control',
        'placeholder' => 'Entrez l’objectif'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Pilote', [
        'label' => 'Pilote',
        'class' => 'form-control',
        'placeholder' => 'Entrez le nom du pilote'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('CoPilote', [
        'label' => 'CoPilote',
        'class' => 'form-control',
        'placeholder' => 'Entrez le nom du copilote'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('user_id', [
        'label' => 'Utilisateur',
        'class' => 'form-control',
        'options' => $users,
        'empty' => 'Sélectionnez un utilisateur'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('depot_id', [
        'label' => 'Dépôt',
        'class' => 'form-control',
        'options' => $depots,
        'empty' => 'Sélectionnez un dépôt'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('date', [
        'label' => 'Date',
        'type' => 'date',
        'class' => 'form-control'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('numlot', [
        'label' => 'Numéro de lot',
        'class' => 'form-control',
        'placeholder' => 'Entrez le numéro de lot'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('statut', [
        'label' => 'Statut',
        'class' => 'form-control',
        'type' => 'select',
        'options' => [-1 => 'Inactif', 1 => 'Actif']
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Frequence', [
        'label' => 'Fréquence',
        'class' => 'form-control',
        'placeholder' => 'Entrez la fréquence (ex. : Quotidienne, Hebdomadaire)'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Manager', [
        'label' => 'Manager',
        'class' => 'form-control',
        'placeholder' => 'Entrez le nom du manager'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Plage_Horaire', [
        'label' => 'Plage Horaire',
        'class' => 'form-control',
        'placeholder' => 'Entrez la plage horaire (ex. : 08:00-12:00)'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Responsable_Qualite', [
        'label' => 'Responsable Qualité',
        'class' => 'form-control',
        'placeholder' => 'Entrez le nom du responsable qualité'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->input('Jour', [
        'label' => 'Jour',
        'class' => 'form-control',
        'placeholder' => 'Entrez le jour (ex. : Lundi, Mardi)'
    ]) ?>
</div>

<div class="form-group">
    <?= $this->Form->button('Ajouter', ['class' => 'btn btn-success']) ?>
</div>

<?= $this->Form->end() ?>
