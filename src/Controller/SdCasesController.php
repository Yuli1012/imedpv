<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * SdCases Controller
 *
 * @property \App\Model\Table\SdCasesTable $SdCases
 *
 * @method \App\Model\Entity\SdCase[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SdCasesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SdProductWorkflows', 'SdActivities', 'SdUsers']
        ];
        $sdCases = $this->paginate($this->SdCases);

        $this->set(compact('sdCases'));
    }

    /**
     * View method
     *
     * @param string|null $id Sd Case id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sdCase = $this->SdCases->get($id, [
            'contain' => ['SdProductWorkflows', 'SdActivities', 'SdUsers', 'SdCaseGeneralInfos', 'SdFieldValues']
        ]);

        $this->set('sdCase', $sdCase);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sdCase = $this->SdCases->newEntity();
        if ($this->request->is('post')) {
            $sdCase = $this->SdCases->patchEntity($sdCase, $this->request->getData());
            if ($this->SdCases->save($sdCase)) {
                $this->Flash->success(__('The sd case has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sd case could not be saved. Please, try again.'));
        }
        $sdProductWorkflows = $this->SdCases->SdProductWorkflows->find('list', ['limit' => 200]);
        $sdActivities = $this->SdCases->SdActivities->find('list', ['limit' => 200]);
        $sdUsers = $this->SdCases->SdUsers->find('list', ['limit' => 200]);
        $this->set(compact('sdCase', 'sdProductWorkflows', 'sdActivities', 'sdUsers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sd Case id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sdCase = $this->SdCases->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sdCase = $this->SdCases->patchEntity($sdCase, $this->request->getData());
            if ($this->SdCases->save($sdCase)) {
                $this->Flash->success(__('The sd case has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sd case could not be saved. Please, try again.'));
        }
        $sdProductWorkflows = $this->SdCases->SdProductWorkflows->find('list', ['limit' => 200]);
        $sdActivities = $this->SdCases->SdActivities->find('list', ['limit' => 200]);
        $sdUsers = $this->SdCases->SdUsers->find('list', ['limit' => 200]);
        $this->set(compact('sdCase', 'sdProductWorkflows', 'sdActivities', 'sdUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sd Case id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sdCase = $this->SdCases->get($id);
        if ($this->SdCases->delete($sdCase)) {
            $this->Flash->success(__('The sd case has been deleted.'));
        } else {
            $this->Flash->error(__('The sd case could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Register SAE method / Add case
     * 
     * 
     */
    public function saeregistration()
    {   
        $this->viewBuilder()->layout('main_layout');
        $userinfo = $this->request->session()->read('Auth.user');
        //TODO Permission related
        $productInfo = TableRegistry::get('SdProducts')
            ->find()
            ->select(['id','study_no'])    
            ->contain(['SdProductWorkflows.SdWorkflows'=>['fields'=>['SdWorkflows.name']]])
            ->group(['SdProducts.id']);
        $randNo = $this->caseNoGenerator();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $sdFieldValueTable = TableRegistry::get('SdFieldValues');
            $requestDataField = $requestData['field_value'];
            /**
             * save case
             */
            $requestDataCase = $requestData['case'];
            foreach($requestDataCase['caseNo'] as $key =>$value){
                $sdCase = $this->SdCases->newEntity();
                $savedData = $requestDataCase;
                $savedData['caseNo'] = $value;
                $savedData['status'] = "1";
                $sdCase = $this->SdCases->patchEntity($sdCase, $savedData);
                $savedCase=$this->SdCases->save($sdCase);
                if (!$savedCase) {
                    echo"problem in saving sdCase";
                    return null;
                }
                foreach($requestDataField as $field_id =>$field_value)
                {
                    $sdFieldValueEntity = $sdFieldValueTable->newEntity();
                    $dataSet = [
                        'sd_case_id' => $savedCase->id,
                        'version_no' => '1',
                        'sd_field_id' => $field_id,
                        'set_number' => '1',
                        'created_time' =>date("Y-m-d H:i:s"),
                        'field_value' =>$field_value,
                        'status' =>'1',
                    ];
                    $sdFieldValueEntity = $sdFieldValueTable->patchEntity($sdFieldValueEntity, $dataSet);
                    if(!$sdFieldValueTable->save($sdFieldValueEntity)) echo "problem in saving sdfields";
                }
            }
            /**
             * 
             * save field into these cases
             */
        }
        $this->set(compact('productInfo','randNo'));  
    }

     /**
     * Case number generator function
     *
     * @return string case number
     *
     */
    private function caseNoGenerator(){
        do{$rand_str = rand(0, 99999);
        }while($this->SdCases->find()->where(['caseNo LIKE '=>'%'.$rand_str.'%'])->first()!=null);
        return $rand_str;
    }
}
