<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SdActivityLog $sdActivityLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sd Activity Log'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sd Users'), ['controller' => 'SdUsers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd User'), ['controller' => 'SdUsers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Section Values'), ['controller' => 'SdSectionValues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Section Value'), ['controller' => 'SdSectionValues', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sdActivityLog form large-9 medium-8 columns content">
    <?= $this->Form->create($sdActivityLog) ?>
    <fieldset>
        <legend><?= __('Add Sd Activity Log') ?></legend>
        <?php
            echo $this->Form->control('sd_user_id', ['options' => $sdUsers]);
            echo $this->Form->control('controller');
            echo $this->Form->control('action');
            echo $this->Form->control('sd_section_value_id', ['options' => $sdSectionValues]);
            echo $this->Form->control('data_changed');
            echo $this->Form->control('updated_time');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>