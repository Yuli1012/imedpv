<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SdProduct[]|\Cake\Collection\CollectionInterface $sdProducts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sd Product'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Product Types'), ['controller' => 'SdProductTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Product Type'), ['controller' => 'SdProductTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Study Types'), ['controller' => 'SdStudyTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Study Type'), ['controller' => 'SdStudyTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Sponsor Companies'), ['controller' => 'SdSponsorCompanies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Sponsor Company'), ['controller' => 'SdSponsorCompanies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Product Workflows'), ['controller' => 'SdProductWorkflows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Product Workflow'), ['controller' => 'SdProductWorkflows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sdProducts index large-9 medium-8 columns content">
    <h3><?= __('Sd Products') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sd_product_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('study_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('study_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sd_sponsor_company_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('short_desc') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_desc') ?></th>
                <th scope="col"><?= $this->Paginator->sort('blinding_tech') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sd_product_flag') ?></th>
                <th scope="col"><?= $this->Paginator->sort('WHODD_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('WHODD_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mfr_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('call_center') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sdProducts as $sdProduct): ?>
            <tr>
                <td><?= $this->Number->format($sdProduct->id) ?></td>
                <td><?= h($sdProduct->product_name) ?></td>
                <td><?= $this->Number->format($sdProduct->sd_product_type_id) ?></td>
                <td><?= h($sdProduct->study_name) ?></td>
                <td><?= $this->Number->format($sdProduct->study_type) ?></td>
                <td><?= $this->Number->format($sdProduct->sd_sponsor_company_id) ?></td>
                <td><?= h($sdProduct->short_desc) ?></td>
                <td><?= h($sdProduct->product_desc) ?></td>
                <td><?= h($sdProduct->blinding_tech) ?></td>
                <td><?= $this->Number->format($sdProduct->sd_product_flag) ?></td>
                <td><?= h($sdProduct->WHODD_code) ?></td>
                <td><?= h($sdProduct->WHODD_name) ?></td>
                <td><?= h($sdProduct->mfr_name) ?></td>
                <td><?= h($sdProduct->start_date) ?></td>
                <td><?= h($sdProduct->end_date) ?></td>
                <td><?= h($sdProduct->call_center) ?></td>
                <td><?= $this->Number->format($sdProduct->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sdProduct->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sdProduct->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sdProduct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sdProduct->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
