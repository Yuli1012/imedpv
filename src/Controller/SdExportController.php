<?php
namespace App\Controller;
use Cake\ORM\TableRegistry;


class SdExportController extends AppController
        {
            /**
            *  Generate CIOMS files
            *
            */
            // function of get direct value
            public function getCiomsDirectValue($caseId,$field_id,$set_num){
                $sdFieldValues = TableRegistry::get('sdFieldValues');
                $direct =$sdFieldValues->find()
                    ->select(['field_value'])
                    ->where(['sd_case_id='.$caseId,'sd_field_id='.$field_id,'set_number='.$set_num,'status=1'])->first();
                $directValue=$direct['field_value'];
                return $directValue;
            }

            //function of get caption value by join table sd_field_value_look_ups
            public function getCiomsLookupValue($caseId,$field_id,$set_num){
                $sdFieldValues = TableRegistry::get('sdFieldValues');
                $lookup= $sdFieldValues ->find()
                    ->select(['look.caption'])
                     ->join([
                            'look' =>[
                                'table' =>'sd_field_value_look_ups',
                                'type'=>'INNER',
                                'conditions'=>['sd_case_id='.$caseId,'look.sd_field_id = sdFieldValues.sd_field_id','set_number='.$set_num,'status=1',
                                             'sdFieldValues.sd_field_id='.$field_id,'sdFieldValues.field_value=look.value']
                                ]
                            ])->first(); 
                $lookupValue=$lookup['look']['caption'];
                return $lookupValue;
            }

            //function of convert date into dd-mmm-yyy format
            public function getCiomsDateValue($caseId,$field_id,$set_num){
                $sdFieldValues = TableRegistry::get('sdFieldValues');
                $dateFormat =$sdFieldValues->find()
                    ->select(['field_value'])
                    ->where(['sd_case_id='.$caseId,'sd_field_id='.$field_id,'set_number='.$set_num,'status=1'])->first();
                        switch(substr($dateFormat['field_value'],2,2)){
                            case '00':
                                $monthFormat="-MMM-";
                                break;
                            case '01':
                                $monthFormat="-JAN-";
                                break;
                            case '02':
                                $monthFormat="-FEB-";
                                break;
                            case '03':
                                $monthFormat="-Mar-";
                                break;
                            case '04':
                                $monthFormat="-APR-";
                                break;
                            case '05':
                                $monthFormat="-MAY-";
                                break;
                            case '06':
                                $monthFormat="-JUN-";
                                break;
                            case '07':
                                $monthFormat="-JUL-";
                                break;
                            case '08':
                                $monthFormat="-AUG-";
                                break;
                            case '09':
                                $monthFormat="-SEP-";
                                break;
                            case '10':
                                $monthFormat="-OCT-";
                                break;
                            case '11':
                                $monthFormat="-NOV-";
                                break;
                            case '12':
                                $monthFormat="-DEC-";
                                default;
                            }
                return substr($dateFormat['field_value'],0,2).$monthFormat.substr($dateFormat['field_value'],4,4);
            } 

            //function of convert month into mmm format
            public function getCiomsMonthValue($caseId,$field_id,$set_num){
                $sdFieldValues = TableRegistry::get('sdFieldValues');
                $monthFormat =$sdFieldValues->find()
                ->select(['field_value'])
                ->where(['sd_case_id='.$caseId,'sd_field_id='.$field_id,'set_number='.$set_num,'status=1'])->first();
                    switch(substr($monthFormat['field_value'],2,2)){
                        case '00':
                            $monthFormat="MMM";
                            break;
                        case '01':
                            $monthFormat="JAN";
                            break;
                        case '02':
                            $monthFormat="FEB";
                            break;
                        case '03':
                            $monthFormat="Mar";
                            break;
                        case '04':
                            $monthFormat="APR";
                            break;
                        case '05':
                            $monthFormat="MAY";
                            break;
                        case '06':
                            $monthFormat="JUN";
                            break;
                        case '07':
                            $monthFormat="JUL";
                            break;
                        case '08':
                            $monthFormat="AUG";
                            break;
                        case '09':
                            $monthFormat="SEP";
                            break;
                        case '10':
                            $monthFormat="OCT";
                            break;
                        case '11':
                            $monthFormat="NOV";
                            break;
                        case '12':
                            $monthFormat="DEC";
                            default;
                        }
                return $monthFormat;
            }

            //function of no.8-12 checkbox
            public function getCiomsSeriousValue($caseId,$field_id,$set_num){
                $choice=$this->getCiomsDirectValue($caseId,$field_id,$set_num);
                if(substr($choice,0,1)==1){
                    $this->set('patientDied','checked');
                };
                if(substr($choice,1,1)==1){
                    $this->set('lifeThreatening','checked');
                };
                if(substr($choice,2,1)==1){
                    $this->set('disability','checked');
                };
                if(substr($choice,3,1)==1){
                    $this->set('hospitalization','checked');
                };
                if(substr($choice,4,1)==1){
                    $this->set('congenital','checked');
                };
                if(substr($choice,5,1)==1){
                    $this->set('otherSerious','checked');
                };
            }
            
            //function of no.7+13 narrative
            public function getCiomsNarrativeValue($caseId,$set_num){
              
                 }

            //function of no.20 checkbox
            public function getCiomsDechallengeValue($caseId,$field_id,$set_num){
                $choice=$this->getCiomsDirectValue($caseId,$field_id,$set_num);
                switch($choice){
                    case '1':
                        $this->set('DeYes','checked');
                        break;
                    case '2':
                        $this->set('DeNo','checked');
                        break;
                    case '4':
                        $this->set('DeUnkown','checked');
                        break;
                        default;
                    }
            }

            //function of no.21 checkbox
            public function getCiomsRechallengeValue($caseId,$field_id,$set_num){
                $choice=$this->getCiomsDirectValue($caseId,$field_id,$set_num);
                switch($choice){
                    case '1':
                        $this->set('ReYes','checked');
                        break;
                    case '2':
                        $this->set('ReNo','checked');
                        break;
                    case '4':
                        $this->set('ReUnkown','checked');
                        break;
                        default;
                }
            }

            //function of no.24d checkbox
            public function getCiomsReportSourceValue($caseId,$set_num){
                $choiceOne=$this->getCiomsDirectValue($caseId,416,$set_num);
                $choiceTwo=$this->getCiomsDirectValue($caseId,342,$set_num);
                $choiceThree=$this->getCiomsDirectValue($caseId,416,$set_num);
                if(substr($choiceOne,1,1)==1){
                    $this->set('study','checked');
                };
                if($choiceTwo==1){
                    $this->set('healthProfessional','checked');
                };
                if(substr($choiceThree,2,1)==1){
                    $this->set('literature','checked');
                };
            }
        
            // Call the previous function by $caseId,$field_id and $set_num
            public function genCIOMS ($caseId) {
                $this->viewBuilder()->layout('CIOMS');
                //1.
                $this->set('patientInitial', $this->getCiomsDirectValue($caseId,79,1));//B.1.1  patientinitial
                //1a.
                $this->set('country', $this->getCiomsLookupValue($caseId,3,1));// A.1.2 occurcountry
                //2.
                $this->set('birth', $this->getCiomsDirectValue($caseId,85,1));// A.1.2.1b patientbirthdate
                $this->set('birthMonth', $this->getCiomsMonthValue($caseId,85,1));// A.1.2.1b patientbirthdate
                //2a.
                $this->set('age', $this->getCiomsDirectValue($caseId,86,1));//B.1.2.2a patientonsetage
                $this->set('ageUnit',$this->getCiomsLookupValue($caseId,87,1));//B.1.2.2b  patientonsetageunit
                //4-6
                $this->set('reaction', $this->getCiomsDirectValue($caseId,156,1));//B.2.i.4b  reactionstartdate
                $this->set('reactionMonth', $this->getCiomsMonthValue($caseId,156,1));//B.2.i.4b  reactionstartdate
                //3
                $this->set('sex',$this->getCiomsLookupValue($caseId,93,1));//B.1.5  sex
                //7
                $this->set('primarySourceReaction', $this->getCiomsDirectValue($caseId,149,1));//B.2.i.0  primarysourcereaction
                $this->set('reactionOutcome ', $this->getCiomsDirectValue($caseId,165,1));//B.2.i.8  reactionoutcome
                $this->set('actionDrug', $this->getCiomsDirectValue($caseId,208,1));// B.4.K.16  actiondrug
                $this->set('narrativeIncludeClinical', $this->getCiomsDirectValue($caseId,218,1));//B.5.1  narrativeincludeclinical
               
                //8-12
                $this->getCiomsSeriousValue($caseId,354,1);
                //13
                $this->set('resultsTestsProcedures', $this->getCiomsDirectValue($caseId,174,1));//B.3.2 resultstestsprocedures
                //14
                $this->set('drugone', $this->getCiomsDirectValue($caseId,177,1));//B.4.K.2+B.4.K.3  activesubstancename+obtaindrugcountry
                $this->set('genericOne', $this->getCiomsDirectValue($caseId,178,1));//B.4.K.3   obtaindrugcountry
                $this->set('drugtwo', $this->getCiomsDirectValue($caseId,177,2));//B.4.K.2+B.4.K.3  activesubstancename+obtaindrugcountry
                $this->set('genericTwo', $this->getCiomsDirectValue($caseId,178,2));//B.4.K.3   obtaindrugcountry
                //15
                $this->set('doseOne', $this->getCiomsDirectValue($caseId,183,1));//B.4.k.5.1Dose(number)
                $this->set('doseUnitOne', $this->getCiomsLookupValue($caseId,184,1));//Dose(unit) (B.4.k.5.2)
                $this->set('separateDosageOne', $this->getCiomsDirectValue($caseId,185,1));//Number Of Separate Dosages (B.4.k.5.3)
                $this->set('intervalOne', $this->getCiomsDirectValue($caseId,186,1));// Interval (B.4.k.5.4)
                $this->set('intervalUnitOne', $this->getCiomsLookupValue($caseId,187,1));//Interval Unit (B.4.k.5.5)


                $this->set('doseTwo', $this->getCiomsDirectValue($caseId,183,2));//B.4.k.5.1Dose(number)
                $this->set('doseUnitTwo', $this->getCiomsLookupValue($caseId,184,2));//Dose(unit) (B.4.k.5.2)
                $this->set('separateDosageTwo', $this->getCiomsDirectValue($caseId,185,2));//Number Of Separate Dosages (B.4.k.5.3)
                $this->set('intervalTwo', $this->getCiomsDirectValue($caseId,186,2));// Interval (B.4.k.5.4)
                $this->set('intervalUnitTwo', $this->getCiomsLookupValue($caseId,187,2));//Interval Unit (B.4.k.5.5)
                //16
                $this->set('routeone', $this->getCiomsLookupValue($caseId,192,1));//B.4.k.8    drugadministrationroute
                $this->set('routetwo', $this->getCiomsLookupValue($caseId,192,2));//B.4.k.8    drugadministrationroute
                //17
                $this->set('indicationOne', $this->getCiomsDirectValue($caseId,197,1));//B.4.k.11b   drugindication
                $this->set('indicationTwo', $this->getCiomsDirectValue($caseId,197,2));//B.4.k.11b   drugindication
                //18
                $this->set('TherapyStartOne', $this->getCiomsDateValue($caseId,199,1));//B.4.k.12b   drugstartdate
                $this->set('TherapyStartTwo', $this->getCiomsDateValue($caseId,199,2));//B.4.k.12b   drugstartdate
                $this->set('TherapyStopOne', $this->getCiomsDateValue($caseId,205,1));//B.4.k.14b    drugenddate
                $this->set('TherapyStopTwo', $this->getCiomsDateValue($caseId,205,2));//B.4.k.14b    drugenddate
                //19
                $this->set('TherapyDurationOne', $this->getCiomsDirectValue($caseId,206,1));//B.4.k.15a  drugtreatmentduration
                $this->set('TherapyDurationUnitOne', $this->getCiomsLookupValue($caseId,207,1));//B.4.k.15b  drugtreatmentdurationunit
                $this->set('TherapyDurationTwo', $this->getCiomsDirectValue($caseId,206,2));//B.4.k.15a  drugtreatmentduration
                $this->set('TherapyDurationUnitTwo', $this->getCiomsLookupValue($caseId,207,2));//B.4.k.15b  drugtreatmentdurationunit
                //20.
                $this->getCiomsDechallengeValue($caseId,381,1);//dechallenge
                //21.
                $this->getCiomsRechallengeValue($caseId,209,1);//Rechallenge
                //22. concomitant drugs and dates of administration
                $this->set('productName', $this->getCiomsDirectValue($caseId,176,2));//B.4.k.2.1medicinalproduct
                $this->set('substanceName', $this->getCiomsDirectValue($caseId,177,2));//B.4.k.2.2activesubstancename
                $this->set('countryObtain', $this->getCiomsDirectValue($caseId,178,2));//+B.4.k.2.3obtaindrugcountry
                $this->set('startDate', $this->getCiomsDirectValue($caseId,199,2));////B.4.k.12b   drugstartdate
                $this->set('stopDate', $this->getCiomsDateValue($caseId,205,2));//B.4.k.14b    drugenddate
                //23.other relevant history
                $this->set('patientEpisodeName', $this->getCiomsDirectValue($caseId,97,1));//B.1.7.1a.2  patientepisodename
                $this->set('patientMedicalStartDate', $this->getCiomsDateValue($caseId,99,1));//B.1.7.1c	patientmedicalstartdate
                $this->set('patientMedicalContinue', $this->getCiomsLooKupValue($caseId,100,1));//B.1.7.1d  patientmedicalcontinue
                $this->set('patientMedicalEndDate', $this->getCiomsDateValue($caseId,102,1));//B.1.7.1f   patientmedicalenddate
                $this->set('patientMedicalComment', $this->getCiomsDirectValue($caseId,103,1));//B.1.7.1g  patientmedicalcomment
                //24a
                $this->set('caseSource', $this->getCiomsDateValue($caseId,19,1));//A.1.11.1  Source of the case identifier 
                //24b
                $this->set('otherCaseIndentifier', $this->getCiomsDateValue($caseId,18,1));//A.1.11 Other case identifiers in previous transmissions
                //24c
                $this->set('receiptDate', $this->getCiomsDateValue($caseId,12,1));//A.1.7b  Latest received date 
                //24d
                $this->getCiomsReportSourceValue($caseId,1);

            }


            /**
            *  Generate PDF files
            *
            */
            //function include all type of fields
            public function getPositionByType($caseId,$field_id,$value_type, $set_num=null){
                $more_conditions = "";
                if (!is_null($set_num))
                {
                    $more_conditions = "fv.set_number=".$set_num;
                }
                $fv = TableRegistry::get('sdFieldValues');
                $sdMedwatchPositions = TableRegistry::get('sdMedwatchPositions');
                    switch($value_type){
                        case '1'://direct output
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                            'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id ='.$field_id,'sdMedwatchPositions.sd_field_id = fv.sd_field_id','fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=1', $more_conditions]
                                    ]
                            ])->first();
                            $text = $text." <style> p {position: absolute;}  </style>";
                            $text=$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                       .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$positions['fv']['field_value'].'</p>';
                            break;
                        case '2'://simple checkbox output
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=2','substr(sdMedwatchPositions.field_name,-1)=substr(fv.field_value,-1)']//'substr($sdMedwatchPositions.field_name,strpos(sdMedwatchPositions.field_name,_)+1)=fv.field_value']
                                ]
                            ])->first();
                            $text = $text." <style> p {position: absolute;font-size:15px;}  </style>";
                            $text = $text.'<p style="top: 203px; left: 366px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                            $text = $text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                         .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'X'.'</p>';
                            break;
                        case '3': // distinct different suspect product according to set_numbers and direct output
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.set_number','sdMedwatchPositions.sd_field_id'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=3','sdMedwatchPositions.set_number=fv.set_number',$more_conditions]
                                ]
                            ])->first();
                            //debug($positions);die();
                            $text = $text." <style> p {position: absolute;}  </style>";
                            $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                            .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$positions['fv']['field_value'].'</p>';
                            break;     
                        case '4':// convert date xxxxxxxx to dd-mmm-yyyy
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.field_name','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=4']
                                ]
                            ])->toList();
                            $text = $text." <style> p {position: absolute;font-size:15px;}  </style>";
                            foreach($positions as $position_details){
                                $date=explode('_',$position_details['field_name']);
                                    switch($date[1]){
                                        case "day":
                                            switch(substr($position_details['fv']['field_value'],0,2)){
                                                case '00':
                                                    $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                    .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'  '.'</p>';
                                                    break;
                                                default:
                                                    $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                    .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.substr($position_details['fv']['field_value'],0,2).'</p>';
                                            }
                                            continue;
                                        case "month":
                                            switch(substr($position_details['fv']['field_value'],2,2)){
                                                case '00':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'  '.'</p>';
                                                        continue;
                                                case '01':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'JAN'.'</p>';
                                                        continue;
                                                case '02':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'FEB'.'</p>';
                                                        continue;
                                                case '03':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'MAR'.'</p>';
                                                        continue;
                                                case '04':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'APR'.'</p>';
                                                        continue;
                                                case '05':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'MAY'.'</p>';
                                                        continue;
                                                case '06':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'JUN'.'</p>';
                                                        continue;
                                                case '07':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'JUL'.'</p>';
                                                        continue;
                                                case '08':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'AUG'.'</p>';
                                                        continue;
                                                case '09':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'SEP'.'</p>';
                                                        continue;
                                                case '10':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'OCT'.'</p>';
                                                        continue;
                                                case '11':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'NOV'.'</p>';
                                                        continue;
                                                case '12':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'DEC'.'</p>';
                                                        default;
                                            }
                                            continue;
                                        case "year":
                                            $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                            .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.substr($position_details['fv']['field_value'],4,4).'</p>';
                                        default;
                                    }
                            }
                            break;
                        case '5'://narrative in page one
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=5']
                                ]
                            ])->first();
                            $text = $text."<style> p {position: absolute;font-size:10px;font-family: courier;}  </style>";
                            $line = ($positions['position_height']/10)-1;
                            $count_words = $line*70;
                            $pageone=substr($positions['fv']['field_value'],0,$count_words);
                            $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                        .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$pageone.'</p>';
                        case '6'://use set_number and date convert c8
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.set_number','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=6','sdMedwatchPositions.set_number=fv.set_number',$more_conditions]
                                ]
                            ])->toList();
                            $text = $text." <style> p {position: absolute;font-size:15px;}  </style>";
                            foreach($positions as $position_details){
                                $date=explode('_',$position_details['field_name']);
                                    switch($date[1]){
                                        case "day":
                                            $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                            .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.substr($position_details['fv']['field_value'],0,2).'</p>';
                                        continue;
                                        case "month":
                                            switch(substr($position_details['fv']['field_value'],2,2)){
                                                case '01':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'JAN'.'</p>';
                                                        continue;
                                                case '02':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'FEB'.'</p>';
                                                        continue;
                                                case '03':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'MAR'.'</p>';
                                                        continue;
                                                case '04':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'APR'.'</p>';
                                                        continue;
                                                case '05':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'MAY'.'</p>';
                                                        continue;
                                                case '06':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'JUN'.'</p>';
                                                        continue;
                                                case '07':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'JUL'.'</p>';
                                                        continue;
                                                case '08':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'AUG'.'</p>';
                                                        continue;
                                                case '09':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'SEP'.'</p>';
                                                        continue;
                                                case '10':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'OCT'.'</p>';
                                                        continue;
                                                case '11':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'NOV'.'</p>';
                                                        continue;
                                                case '12':
                                                        $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                                        .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.'DEC'.'</p>';
                                                        default;
                                            }
                                        continue;
                                        case "year":
                                            $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                                            .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.substr($position_details['fv']['field_value'],4,4).'</p>';
                                        default;

                                        }
                                }
                            break;
                        case '7'://use  set_number and date convert in one field c4
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.set_number','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=7','sdMedwatchPositions.set_number=fv.set_number',$more_conditions]
                                ]
                            ])->toList();
                            foreach($positions as $position_details){
                            $startday=substr($position_details['fv']['field_value'],0,2);
                            $startmon=substr($position_details['fv']['field_value'],2,2);
                                switch($startmon){
                                    case '00':
                                        $startmon="00-";
                                        continue;
                                    case '01':
                                        $startmon="JAN-";
                                        continue;
                                    case '02':
                                        $startmon="FEB-";
                                        continue;
                                    case '03':
                                        $startmon="MAR-";
                                        continue;
                                    case '04':
                                        $startmon="APR-";
                                        continue;
                                    case '05':
                                        $startmon="MAY-";
                                        continue;
                                    case '06':
                                        $startmon="JUN-";
                                        continue;
                                    case '07':
                                        $startmon="JUL-";
                                        continue;
                                    case '10':
                                        $startmon="OCT-";
                                        continue;
                                    case '11':
                                        $startmon="NOV-";
                                        continue;
                                    case '12':
                                        $startmon="DEC-";
                                        continue;
                                    case '08':
                                        $startmon="AUG-";
                                        continue;
                                    case '09':
                                        $startmon="SEP-";
                                        continue;
                                    default:
                                    }
                            $startyear=substr($position_details['fv']['field_value'],4,4);
                            $text =$text.'<p style="top: '.$position_details['position_top'].'px; left: '.$position_details['position_left']
                            .'px; width: '.$position_details['position_width'].'px;  height: '.$position_details['position_height'].'px; color:red;">'.$startday.'-'.$startmon.$startyear.'</p>';
                                }
                            break;
                        case '8'://use set_number and checkbox
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=8','substr(sdMedwatchPositions.field_name,-1)=substr(fv.field_value,-1)',$more_conditions]//'substr($sdMedwatchPositions.field_name,strpos(sdMedwatchPositions.field_name,_)+1)=fv.field_value']
                                ]
                            ])->first();
                            $text = $text." <style> p {position: absolute;font-size:15px;}  </style>";
                            $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                        .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'X'.'</p>';
                            break; 
                        case '9': //narrative continue in page3
                            $positions= $sdMedwatchPositions ->find()
                                ->select(['sdMedwatchPositions.id','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                    'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value'])
                                ->join([
                                    'fv' =>[
                                        'table' =>'sd_field_values',
                                        'type'=>'INNER',
                                        'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=9']
                                    ]
                                ])->first();
                                $text = $text."<style> p {position: absolute;font-size:10px;font-family: courier;}  </style>";
                                $line = ($positions['position_height']/10)-1;
                                $count_words = $line*70;
                                $pagethree=substr($positions['fv']['field_value'],$count_words);
                                $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$pagethree.'</p>'; 
                        case '10'://e3 occupation convert
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=10']
                                ]
                            ])->first();
                            $text = $text." <style> p {position: absolute;font-size:15px;}  </style>";
                            switch($positions['fv']['field_value']){
                                case '1':
                                    $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                    .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'Phisician'.'</p>';
                                    break;
                                case '2':
                                    $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                    .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'Pharmacist'.'</p>';
                                    break;
                                case '3':
                                    $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                    .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'Other health professional'.'</p>';
                                    break;
                                case '4':
                                    $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                    .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'Lawyer'.'</p>';
                                    break;
                                case '5':
                                    $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                    .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.'Consumer or other non health professional'.'</p>';
                                    break;
                            }
                        case '11'://set numbers and get caption by joining table sd_field_value_look_ups c3#route
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','look.caption','sdMedwatchPositions.set_number','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=11','sdMedwatchPositions.set_number=fv.set_number',$more_conditions]
                                ]
                            ])
                            ->join([
                                'look' =>[
                                    'table' =>'sd_field_value_look_ups',
                                    'type'=>'LEFT',
                                    'conditions'=>['look.sd_field_id = fv.sd_field_id','fv.field_value=look.value']
                                ]
                            ])->first();
                            $text = $text." <style> p {position: absolute;}  </style>";
                            $text=$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                        .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$positions['look']['caption'].'</p>';
                            break;           
                        case '12'://describe event and problem in page1
                            $query1=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=218','set_number=1','status=1'])->first();
                            $query2=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=219','set_number=1','status=1'])->first();
                            $query3=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=221','set_number=1','status=1'])->first();
                            $query4=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=222','set_number=1','status=1'])->first();
                            $description=$query1['field_value']."\r\n"."\r\n".$query2['field_value']."\r\n"."\r\n".$query3['field_value']."\r\n"."\r\n".$query4['field_value'];         
                            $positions= $sdMedwatchPositions ->find()
                                ->select(['sdMedwatchPositions.id','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                    'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value'])
                                ->join([
                                    'fv' =>[
                                        'table' =>'sd_field_values',
                                        'type'=>'INNER',
                                        'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=12']
                                    ]
                                ])->first(); 
                                $text = $text."<style> p {position: absolute;font-size:10px;font-family: courier;}  </style>";
                                $pageone=substr($description,0,400);
                                $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                        .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$pageone.'</p>';
                                break;
                        case '13':  //describe event and problem in page3
                            $query1=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=218','set_number=1','status=1'])->first();
                            $query2=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=219','set_number=1','status=1'])->first();
                            $query3=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=221','set_number=1','status=1'])->first();
                            $query4=$fv->find()
                                ->select(['field_value'])
                                ->where(['sd_case_id='.$caseId,'sd_field_id=222','set_number=1','status=1'])->first();
                            $description=$query1['field_value']."\r\n"."\r\n".$query2['field_value']."\r\n"."\r\n".$query3['field_value']."\r\n"."\r\n".$query4['field_value'];         
                            $positions= $sdMedwatchPositions ->find()
                                ->select(['sdMedwatchPositions.id','sdMedwatchPositions.sd_field_id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                    'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value'])
                                ->join([
                                    'fv' =>[
                                        'table' =>'sd_field_values',
                                        'type'=>'INNER',
                                        'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=13']
                                    ]
                                ])->first(); 
                                $text = $text."<style> p {position: absolute;font-size:10px;font-family: courier;}  </style>";
                                $pagethree=substr($description,400);
                                $text =$text.'<p style="top: '.$positions['position_top'].'px; left: '.$positions['position_left']
                                        .'px; width: '.$positions['position_width'].'px;  height: '.$positions['position_height'].'px; color:red;">'.$pagethree.'</p>';    
                                break;
                        case '14': //b2 checkbox field to solve 8 digital value format
                            $positions= $sdMedwatchPositions ->find()
                            ->select(['sdMedwatchPositions.id','sdMedwatchPositions.position_top','sdMedwatchPositions.position_left',
                                'sdMedwatchPositions.position_width','sdMedwatchPositions.position_height','fv.field_value','sdMedwatchPositions.field_name'])
                            ->join([
                                'fv' =>[
                                    'table' =>'sd_field_values',
                                    'type'=>'INNER',
                                    'conditions'=>['sdMedwatchPositions.sd_field_id = fv.sd_field_id','sdMedwatchPositions.sd_field_id = '.$field_id,'fv.status = 1','fv.sd_case_id='.$caseId,'sdMedwatchPositions.value_type=14']
                                ]
                            ])->first();
                            $text = $text." <style> p {position: absolute;font-size:15px;}  </style>";
                            if(substr($positions['fv']['field_value'],0,1)==1){
                                $text = $text.'<p style="top: 336px; left: 44px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                               
                            };
                            if(substr($positions['fv']['field_value'],1,1)==1){
                                $text = $text.'<p style="top: 353px; left: 44px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                            };
                            if(substr($positions['fv']['field_value'],2,1)==1){
                                $text = $text.'<p style="top: 353px; left: 232px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                            };
                            if(substr($positions['fv']['field_value'],3,1)==1){
                                $text = $text.'<p style="top: 369px; left: 44px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                            };
                            if(substr($positions['fv']['field_value'],4,1)==1){
                                $text = $text.'<p style="top: 369px; left: 232px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                            };
                            if(substr($positions['fv']['field_value'],5,1)==1){
                                $text = $text.'<p style="top: 384px; left: 44px; width: 18px;  height: 18px; color:red;">'.'X'.'</p>';
                            };
                            break;
                       

                    }
                    
                    return $text;
                }


            public function genFDApdf($caseId)
            {  
                ////a1 patientID field
                $result=$result.$this->getPositionByType($caseId,79,1) ;
                //a2 age field  
                $result=$result.$this->getPositionByType($caseId,86,1);
                //a2 date of birth 
                $result=$result.$this->getPositionByType($caseId,85,4);
                // a2 age unit 
                $result=$result.$this->getPositionByType($caseId,87,2);
                // a3 sex 
                $result=$result.$this->getPositionByType($caseId,93,2);
                // a4 weight
                $result=$result.$this->getPositionByType($caseId,91,1);
                // a5 ethnicity
                $result=$result.$this->getPositionByType($caseId,235,2);
                // b1 adverse event
                $result=$result.$this->getPositionByType($caseId,224,2);
                // b2 serious
                $result=$result.$this->getPositionByType($caseId,354,14);
                // b2 death date
                $result=$result.$this->getPositionByType($caseId,115,4);
                // b3 date of event
                $result=$result.$this->getPositionByType($caseId,156,4);
                // b5 describe event or problem
                $result=$result.$this->getPositionByType($caseId,218,12,1);
                // b6 relevant tests/laboratory data
                $result=$result.$this->getPositionByType($caseId,174,5);
                // b7 other relevant history
                $result=$result.$this->getPositionByType($caseId,104,5);
                // c1#1 name and strength
                $result=$result.$this->getPositionByType($caseId,176,3,1);
                // c1#2 name and strength
                $result=$result.$this->getPositionByType($caseId,176,3,2);
                // c1#1 NDC or unique ID
                $result=$result.$this->getPositionByType($caseId,345,3);
                // c1#2 NDC or unique ID
                $result=$result.$this->getPositionByType($caseId,345,3);
                // c1#1 Manufacturer/compounder
                $result=$result.$this->getPositionByType($caseId,284,3);
                // c1#2 Manufacturer/compounder
                $result=$result.$this->getPositionByType($caseId,284,3,2);
                // c1#1 Lot number
                $result=$result.$this->getPositionByType($caseId,179,3);
                // c1#2 Lot number
                $result=$result.$this->getPositionByType($caseId,179,3);
                //c3#1 dose
                $result=$result.$this->getPositionByType($caseId,183,3);
                //c3#1 frequency
                $result=$result.$this->getPositionByType($caseId,185,3);
                //c3#1 route used
                $result=$result.$this->getPositionByType($caseId,192,11);
                //c3#2 dose
                $result=$result.$this->getPositionByType($caseId,183,3);
                //c3#2 frequency
                $result=$result.$this->getPositionByType($caseId,185,3);
                //c3#2 route used
                $result=$result.$this->getPositionByType($caseId,192,11);
                //c4#1 start day
                $result=$result.$this->getPositionByType($caseId,199,7,1);
                //c4#1 stop day
                $result=$result.$this->getPositionByType($caseId,205,7,1);
                //c4#2 start day
                $result=$result.$this->getPositionByType($caseId,199,7,2);
                //c4#2 stop day
                $result=$result.$this->getPositionByType($caseId,205,7,2);
                //c5#1 diagnosis for use
                $result=$result.$this->getPositionByType($caseId,197,3);
                //c5#2 diagnosis for use
                $result=$result.$this->getPositionByType($caseId,197,3);
                //c6#1 is the product compounded?
                $result=$result.$this->getPositionByType($caseId,439,8,1);
                //c6#2 is the product compounded?
                $result=$result.$this->getPositionByType($caseId,439,8,2);
                 //c7#1 Is the product over-the-counter?
                $result=$result.$this->getPositionByType($caseId,425,8,1);
                //c7#2 Is the product over-the-counter?
                $result=$result.$this->getPositionByType($caseId,425,8,2);
                // c8#1 expiration date
                $result=$result.$this->getPositionByType($caseId,298,6,1);
                // C8#2 expiration date
                $result=$result.$this->getPositionByType($caseId,298,6,2);
                //c9#1 dechallenge?
                $result=$result.$this->getPositionByType($caseId,381,8,1);
                //c9#2 dechallenge?
                $result=$result.$this->getPositionByType($caseId,381,8,2);
                //c10#1 rechallenge?
                $result=$result.$this->getPositionByType($caseId,209,8,1);
                //c10#2 rechallenge?
                $result=$result.$this->getPositionByType($caseId,209,8,2);
                // e1 last name
                $result=$result.$this->getPositionByType($caseId,28,1);
                //e1 first name
                $result=$result.$this->getPositionByType($caseId,26,1); 
                //e1 address
                $result=$result.$this->getPositionByType($caseId,31,1); 
                //e1 city
                $result=$result.$this->getPositionByType($caseId,32,1); 
                //e1 state
                $result=$result.$this->getPositionByType($caseId,33,1); 
                //e1 country
                $result=$result.$this->getPositionByType($caseId,35,1); 
                // e1 zip
                $result=$result.$this->getPositionByType($caseId,34,1);
                //e1 phone 
                $result=$result.$this->getPositionByType($caseId,229,1);
                //e1 email
                $result=$result.$this->getPositionByType($caseId,232,1);
                //e2 health professional?
                $result=$result.$this->getPositionByType($caseId,342,2);
                //e3 occuption
                $result=$result.$this->getPositionByType($caseId,36,10);
                //e4 Initial reporter also sent report to FDA?
                $result=$result.$this->getPositionByType($caseId,432,2);
                // Require composer autoload
                //require_once __DIR__ . '../vendor/autoload.php';
               // debug($positions);
                // Require composer autoload
                //require_once __DIR__ . '../vendor/autoload.php';

                $mpdf = new \Mpdf\Mpdf();

                $mpdf->CSSselectMedia='mpdf';
                $mpdf->SetTitle('FDA-MEDWATCH');

                //$medwatchdata = $this->SdTabs->find();

                $mpdf->use_kwt = true;

                $mpdf->SetImportUse();
                $mpdf->SetDocTemplate('export_template/MEDWATCH.pdf',true);

                // If needs to link external css file, uncomment the next 2 lines
                // $stylesheet = file_get_contents('css/genpdf.css');
                // $mpdf->WriteHTML($stylesheet,1);
                $mpdf->WriteHTML($result);
                $mpdf->AddPage();
                //$test2 = '<img src="img/pdficon.png" />';
                //$mpdf->WriteHTML("second page");



                $mpdf->AddPage();

                $continue=$this->getPositionByType($caseId,218,13);// b5 describe event or problem continue
                $continue=$continue.$this->getPositionByType($caseId,174,9);// b6 relevant tests continue
                $continue=$continue.$this->getPositionByType($caseId,104,9);//b7 other relevant history continue
                $mpdf->WriteHTML($continue);



                $mpdf->Output();
                // Download a PDF file directly to LOCAL, uncomment while in real useage
                //$mpdf->Output('TEST.pdf', \Mpdf\Output\Destination::DOWNLOAD);


                $this->set(compact('positions'));


            }

            /**
            *  Generate XML files
            *
            */
            //create getValue function
            public function getFieldValue($caseId,$setNumber){
                $sdFields = TableRegistry::get('sdFields');
                $ICSR = $sdFields ->find()
                ->select(['sdFields.descriptor','fv.field_value','fv.sd_field_id'])
                ->join([
                    'fv' =>[
                        'table' =>'sd_field_values',
                        'type'=>'INNER',
                        'conditions'=>['sdFields.id = fv.sd_field_id','fv.sd_case_id='.$caseId,'fv.set_number='.$setNumber ]
                    ]
                ]);
              
                return $ICSR;

            }

            public function genXML($caseId)
            {   
                $this->getFieldValue($caseId,1);
                $this->autoRender = false;
                $sdCases = TableRegistry::get('sdCases');
                $name=$sdCases->find()
                        ->select(['caseNo'])
                        ->where(['id='.$caseId,'status=1'])->first();
                $fileName=$name['caseNo'];
                $time=date("Y-m-d-H-i-s");
                $xml = "$fileName-$time";
                header("Content-Type: text/html/force-download");
                header("Content-Disposition: attachment; filename=".$xml.".xml");
                $xml = new \XMLWriter();
                $xml->openUri("php://output");
                $xml->setIndentString("\t");
                $xml->setIndent(true);
               // create xml Document start
                $xml->startDocument('1.0', 'ISO-8859-1');//FDA supports only the ISO-8859-1 character set for encoding the submission.
                    $xml->writeDtd('ichicsr','','https://www.accessdata.fda.gov/xml/icsr-xml-v2.1.dtd');
                    //A first element ichicsr
                        $xml->startElement("ichicsr");
                            // Attribute lang="en"
                            $xml->writeAttribute("lang","en");
                                $xml->startElement("ichicsrmessageheader");
                                    $example=$this->getFieldValue($caseId,1);
                                        foreach($example as $Example){
                                            $xml->writeElement($Example['descriptor'],$Example['fv']['field_value']);
                                        }
                                    
                                $xml->endElement();//ichicsrmessageheader


                                $xml->startElement("safetyreport");
                                $xml->endElement();//safetyreport
                            $xml->endAttribute();
                        $xml->endElement();//rootelement"ichicsr"
                    $xml->endDtd();
                $xml->endDocument();
                echo $xml->outputMemory(); 
                
                        

                        


            }
        }
?>
