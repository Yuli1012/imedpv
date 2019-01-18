<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SdProduct $sdProduct
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sd Product'), ['action' => 'edit', $sdProduct->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sd Product'), ['action' => 'delete', $sdProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sdProduct->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sd Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sd Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sd Product Types'), ['controller' => 'SdProductTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sd Product Type'), ['controller' => 'SdProductTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sd Study Types'), ['controller' => 'SdStudyTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sd Study Type'), ['controller' => 'SdStudyTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sd Sponsor Companies'), ['controller' => 'SdSponsorCompanies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sd Sponsor Company'), ['controller' => 'SdSponsorCompanies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sd Product Workflows'), ['controller' => 'SdProductWorkflows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sd Product Workflow'), ['controller' => 'SdProductWorkflows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sdProducts view large-9 medium-8 columns content">
    <h3><?= h($sdProduct->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Product Name') ?></th>
            <td><?= h($sdProduct->product_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sd Product Type') ?></th>
            <td><?= $sdProduct->has('sd_product_type') ? $this->Html->link($sdProduct->sd_product_type->id, ['controller' => 'SdProductTypes', 'action' => 'view', $sdProduct->sd_product_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Study Name') ?></th>
            <td><?= h($sdProduct->study_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sd Study Type') ?></th>
            <td><?= $sdProduct->has('sd_study_type') ? $this->Html->link($sdProduct->sd_study_type->id, ['controller' => 'SdStudyTypes', 'action' => 'view', $sdProduct->sd_study_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sd Sponsor Company') ?></th>
            <td><?= $sdProduct->has('sd_sponsor_company') ? $this->Html->link($sdProduct->sd_sponsor_company->id, ['controller' => 'SdSponsorCompanies', 'action' => 'view', $sdProduct->sd_sponsor_company->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Short Desc') ?></th>
            <td><?= h($sdProduct->short_desc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Desc') ?></th>
            <td><?= h($sdProduct->product_desc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Blinding Tech') ?></th>
            <td><?= h($sdProduct->blinding_tech) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('WHODD Code') ?></th>
            <td><?= h($sdProduct->WHODD_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('WHODD Name') ?></th>
            <td><?= h($sdProduct->WHODD_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mfr Name') ?></th>
            <td><?= h($sdProduct->mfr_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Call Center') ?></th>
            <td><?= h($sdProduct->call_center) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sdProduct->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sd Product Flag Id') ?></th>
            <td><?= $this->Number->format($sdProduct->sd_product_flag_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($sdProduct->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($sdProduct->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Date') ?></th>
            <td><?= h($sdProduct->end_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Study No') ?></h4>
        <?= $this->Text->autoParagraph(h($sdProduct->study_no)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Sd Product Workflows') ?></h4>
        <?php if (!empty($sdProduct->sd_product_workflows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Sd Product Id') ?></th>
                <th scope="col"><?= __('Sd Workflow Id') ?></th>
                <th scope="col"><?= __('Sd User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($sdProduct->sd_product_workflows as $sdProductWorkflows): ?>
            <tr>
                <td><?= h($sdProductWorkflows->id) ?></td>
                <td><?= h($sdProductWorkflows->sd_product_id) ?></td>
                <td><?= h($sdProductWorkflows->sd_workflow_id) ?></td>
                <td><?= h($sdProductWorkflows->sd_user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SdProductWorkflows', 'action' => 'view', $sdProductWorkflows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SdProductWorkflows', 'action' => 'edit', $sdProductWorkflows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SdProductWorkflows', 'action' => 'delete', $sdProductWorkflows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sdProductWorkflows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
