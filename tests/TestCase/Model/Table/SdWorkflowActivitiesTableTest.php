<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SdWorkflowActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SdWorkflowActivitiesTable Test Case
 */
class SdWorkflowActivitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SdWorkflowActivitiesTable
     */
    public $SdWorkflowActivities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sd_workflow_activities',
        'app.sd_workflows',
        'app.sd_activity_section_permissions',
        'app.sd_cases',
        'app.sd_user_assignments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SdWorkflowActivities') ? [] : ['className' => SdWorkflowActivitiesTable::class];
        $this->SdWorkflowActivities = TableRegistry::getTableLocator()->get('SdWorkflowActivities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SdWorkflowActivities);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
