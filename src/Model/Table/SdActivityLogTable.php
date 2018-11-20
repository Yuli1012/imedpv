<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SdActivityLog Model
 *
 * @property \App\Model\Table\SdUsersTable|\Cake\ORM\Association\BelongsTo $SdUsers
 * @property \App\Model\Table\SdSectionValuesTable|\Cake\ORM\Association\BelongsTo $SdSectionValues
 *
 * @method \App\Model\Entity\SdActivityLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\SdActivityLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SdActivityLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SdActivityLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SdActivityLog|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SdActivityLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SdActivityLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SdActivityLog findOrCreate($search, callable $callback = null, $options = [])
 */
class SdActivityLogTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sd_activity_log');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SdUsers', [
            'foreignKey' => 'sd_user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SdSectionValues', [
            'foreignKey' => 'sd_section_value_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 255)
            ->requirePresence('controller', 'create')
            ->notEmpty('controller');

        $validator
            ->scalar('action')
            ->maxLength('action', 255)
            ->requirePresence('action', 'create')
            ->notEmpty('action');

        $validator
            ->scalar('data_changed')
            ->requirePresence('data_changed', 'create')
            ->notEmpty('data_changed');

        $validator
            ->dateTime('updated_time')
            ->requirePresence('updated_time', 'create')
            ->notEmpty('updated_time');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['sd_user_id'], 'SdUsers'));
        $rules->add($rules->existsIn(['sd_section_value_id'], 'SdSectionValues'));

        return $rules;
    }
}