<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SdWorkflowActivity[]|\Cake\Collection\CollectionInterface $sdWorkflowActivities
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sd Workflow Activity'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Workflows'), ['controller' => 'SdWorkflows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Workflow'), ['controller' => 'SdWorkflows', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sd Cases'), ['controller' => 'SdCases', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sd Case'), ['controller' => 'SdCases', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sdWorkflowActivities index large-9 medium-8 columns content">
    <h3><?= __('Sd Workflow Activities') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sd_workflow_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('step_forward') ?></th>
                <th scope="col"><?= $this->Paginator->sort('step_backward') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sdWorkflowActivities as $sdWorkflowActivity): ?>
            <tr>
                <td><?= $this->Number->format($sdWorkflowActivity->id) ?></td>
                <td><?= $sdWorkflowActivity->has('sd_workflow') ? $this->Html->link($sdWorkflowActivity->sd_workflow->name, ['controller' => 'SdWorkflows', 'action' => 'view', $sdWorkflowActivity->sd_workflow->id]) : '' ?></td>
                <td><?= $this->Number->format($sdWorkflowActivity->order_no) ?></td>
                <td><?= $this->Number->format($sdWorkflowActivity->step_forward) ?></td>
                <td><?= $this->Number->format($sdWorkflowActivity->step_backward) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sdWorkflowActivity->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sdWorkflowActivity->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sdWorkflowActivity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sdWorkflowActivity->id)]) ?>
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
