<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SdProduct $sdProduct
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sd Products'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sd Product Types'), ['controller' => 'SdProductTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Product Type'), ['controller' => 'SdProductTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Sponsor Companies'), ['controller' => 'SdSponsorCompanies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Sponsor Company'), ['controller' => 'SdSponsorCompanies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Product Workflows'), ['controller' => 'SdProductWorkflows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Product Workflow'), ['controller' => 'SdProductWorkflows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sdProducts form large-9 medium-8 columns content">
    <?= $this->Form->create($sdProduct) ?>
    <fieldset>
        <legend><?= __('Add Sd Product') ?></legend>
        <?php
            echo $this->Form->control('product_name');
            echo $this->Form->control('sd_product_type_id', ['options' => $sdProductTypes]);
            echo $this->Form->control('study_no');
            echo $this->Form->control('sd_sponsor_company_id', ['options' => $sdSponsorCompanies]);
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
