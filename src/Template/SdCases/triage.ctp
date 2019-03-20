<title>Triage</title>
<head>
<?= $this->Html->script('cases/triage.js') ?>
<head>
<script>
    var userId = <?= $this->request->getSession()->read('Auth.User.id')?>;
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    var caseNo = "<?= $caseNo ?>";
    var versionNo = <?= $versionNo?>;
    var dayZero = "<?= $field_value_set['225']['field_value']?>";
</script>
<div class="card text-center w-75 mx-auto my-3">
  <div class="card-header text-center"><h3>Create New Case</h3></div>
  <div class="card-body">
    <div class="alert alert-primary w-50 mx-auto" role="alert"><h4>New Case Number: <?= $caseNo ?></h4></div>
    <hr class="my-3">
    <?= $this->Form->create($caseNo,['id'=>"triageForm"]) ?>
    <!-- Basic Info Fields Set -->
    <div id="basicInfo" class="form-group">
        <h4 class="text-left">Product</h4>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label>Product Name (B.4.k.2.1)<i class="fas fa-asterisk reqField"></i></label>
                <p><b><?= $field_value_set['176']['field_value'] ?></b><p>
            </div>
        </div>
        <h4 class="text-left mt-3">Patient</h4>
        <div id="patientInfo" class="form-row bg-light">
            <div class="form-group col-md-3">
                <label>Patient ID (B.1.1)</label>
                <input type="text" class="form-control" id="patientField_id" name="field_value[79]" placeholder="" value="<?= $field_value_set['79']['field_value'] ?>">
            </div>
            <div class="form-group col-md-3">
                <label>Sex (B.1.5)</label>
                <select class="custom-select" id="patientField_sex" name="field_value[93]" placeholder="">
                    <option value="">Select Sex</option>
                    <option value="1" <?php echo ($field_value_set['93']['field_value']=='1')?"selected":null?>>Male</option>
                    <option value="2" <?php echo ($field_value_set['93']['field_value']=='2')?"selected":null?>>Female</option>
                    <option value="3" <?php echo ($field_value_set['93']['field_value']=='3')?"selected":null?>>Unknown</option>
                    <option value="4" <?php echo ($field_value_set['93']['field_value']=='4')?"selected":null?>>Not Specified</option>
                </select>
            </div>
        </div>
        <div id="patientInfo" class="form-row bg-light">
            <div class="form-group col-md-3">
                <label>Date of birth (B.1.2.1b)</label>
                <div class="form-row">
                    <div class="col-sm-4">
                        <select class="custom-select js-example-basic-single" placeholder="Day" id="patientField_dob_day" name="field_value[85]">
                        <?php
                        echo "<option value=\"00\">Day</option>";
                        for($i=1;$i<32;$i++){
                            echo "<option value=\"".sprintf("%02d",$i)."\"";
                            if (array_key_exists('85',$field_value_set)&&(substr($field_value_set['85']['field_value'],0,2)==sprintf("%02d",$i))) echo "selected";
                            echo ">".$i."</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="custom-select js-example-basic-single"  name="field_value[85]" placeholder="Month" id="patientField_dob_month">
                        <?php
                        $month_str = ['Jan-1','Feb-2','Mar-3','Apr-4','May-5','Jun-6','Jul-7','Aug-8','Sep-9','Oct-10','Nov-11','Dec-12'];
                        echo "<option value=\"00\">Month</option>";
                        foreach($month_str as $i => $month){
                            echo "<option value=\"".sprintf("%02d",$i+1)."\"";
                            if (array_key_exists('85',$field_value_set)&&(substr($field_value_set['85']['field_value'],2,2)==sprintf("%02d",$i+1))) echo "selected";
                            echo ">".$month."</option>";
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="custom-select js-example-basic-single yearSelect" placeholder="Year" id="patientField_dob_year" name="field_value[85]">
                        <?php
                        echo "<option value=\"00\">Day</option>";
                        for($i=1900;$i<=2050;$i++){
                            echo "<option value=\"".sprintf("%04d",$i)."\"";
                            if (array_key_exists('85',$field_value_set)&&(substr($field_value_set['85']['field_value'],4,4)==sprintf("%02d",$i))) echo "selected";
                            echo ">".$i."</option>";
                        }
                        ?>
                            <option value="0000">Year</option>
                        </select>
                    </div>
                    <?php 
                    echo "<input id=\"patientField_dob\" name=\"field_value[85]\"";
                    if($field_value_set['85']['field_value']!=null) echo "value=\"".$field_value_set['85']['field_value']."\"";
                    echo "type=\"hidden\">";
                    ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label>Age at time of onset reaction (B.1.2.2a)</label>
                <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Field Helper" data-content="Age at time of onset of reaction or event"><i class="qco fas fa-info-circle"></i></a>
                <input type="text" class="form-control" id="patientField_age" name="field_value[86]" placeholder="" value="<?= $field_value_set['86']['field_value'] ?>">
            </div>
            <!-- <div class="form-group col-md-3">
                <label>Age at the time of event (B.1.2.2a)</label>
                <input type="text" class="form-control" id="" placeholder="">
            </div> -->
            <div class="form-group col-md-3">
                <label>Age Unit (B.1.2.2b)</label>
                <select class="custom-select" name="field_value[87]" id="patientField_ageunit">
                    <option value="">Select Age Unit</option>
                    <option value="800" <?php echo ($field_value_set['87']['field_value']=='800')?"selected":null?> >Decade</option>
                    <option value="801" <?php echo ($field_value_set['87']['field_value']=='801')?"selected":null?>>Year</option>
                    <option value="802" <?php echo ($field_value_set['87']['field_value']=='802')?"selected":null?>>Month</option>
                    <option value="803" <?php echo ($field_value_set['87']['field_value']=='803')?"selected":null?>>Week</option>
                    <option value="804" <?php echo ($field_value_set['87']['field_value']=='804')?"selected":null?>>Day</option>
                    <option value="805" <?php echo ($field_value_set['87']['field_value']=='805')?"selected":null?>>Hour</option>
                </select>
            </div>
        </div>
        <h4 class="text-left mt-3">Reporter</h4>
        <div id="reporterInfo" class="form-row">
            <div class="form-group col-md-3">
                <label>First Name (A.2.1.1b)</label>
                <input type="text" class="form-control" name="field_value[26]" id="reporterField_firstname" placeholder="" value="<?= $field_value_set['26']['field_value'] ?>">
            </div>
            <div class="form-group col-md-3">
                <label>Last Name (A.2.1.1d)</label>
                <input type="text" class="form-control" name="field_value[28]" id="reporterField_lastname" placeholder="" value="<?= $field_value_set['28']['field_value'] ?>">
            </div>
        </div>
        <h4 class="text-left mt-3">Event</h4>
        <div class="form-row bg-light">
            <div class="form-group col-md-4">
                <label>Reported term (B.2.i.0) <i class="fas fa-asterisk reqField"></i></label>
                <input type="text" class="form-control" name="field_value[149]" id="eventField_term" placeholder="" value="<?= $field_value_set['149']['field_value'] ?>">
            </div>
            <div class="form-group col-md-2">
                <label>MedDra Browser</label>
                <div>
                    <?php
                    $meddraCell = $this->cell('Meddra');
                    echo $meddraCell;?>
                </div>
            </div>
        </div>
        <div class="form-row bg-light">
            <div class="form-group col-md-3">
                <label>LLT Name</label>
                <input type="text" class="form-control" name="field_value[394]" id="eventField_meddralltname" value="<?= $field_value_set['394']['field_value'] ?>" placeholder="">
            </div>
            <div class="form-group col-md-3">
                <label>PT Name</label>
                <input type="text" class="form-control" name="field_value[392]" id="eventField_meddraptname" value="<?= $field_value_set['392']['field_value'] ?>" placeholder="">
            </div>
            <div class="form-group col-md-3">
                <label>HLT Name</label>
                <input type="text" class="form-control" name="field_value[395]" id="eventField_meddrahltname" value="<?= $field_value_set['395']['field_value'] ?>" placeholder="">
            </div>
        </div>

        <!-- Attachment -->
        <h4 class="text-left mt-3">Attach Documents </h4>
        <div class="form-row">
            <div class="form-group col-md-4">
                <!-- <input type="file" class="form-control-file" id=""> -->
            </div>
        </div>

        <button type="button" id="confirmElements" class="btn btn-primary m-auto w-25">Countinue</button>
        <button type="submit" class="btn btn-primary m-auto w-25">Save And Exit</div>
    </div>

    <hr class="my-2">

    <!-- If invalid then choose YES, Select Reasons -->
    <div id="selRea" class="card w-50 mx-auto my-3" style="display:none;">
        <div class="card-header text-center"><h5>Please Select Reasons For Continuing</h5></div>
        <div class="card-body">
            <div class="mx-auto w-50">
                <div class="form-check my-2 text-left">
                    <input class="form-check-input" type="checkbox" value="1" id="reason-1" disabled="true" name="field_value[417]">
                    <label class="form-check-label" for="reason-1">Reporter is Reliable </label>
                </div>
                <div class="form-check my-2 text-left">
                    <input class="form-check-input" type="checkbox" value="2" id="reason-2" disabled="true" name="field_value[417]">
                    <label class="form-check-label" for="reason-2">Important Event </label>
                </div>
                <div class="form-check my-2 text-left">
                    <input class="form-check-input" type="checkbox" value="3" id="reason-3" disabled="true" name="field_value[417]">
                    <label class="form-check-label" for="reason-3">Others </label>
                    <textarea class="form-control" id="otherReason" rows="3" style="display:none;" disabled name="field_value[420]"></textarea>
                </div>
            </div>
            <button type="button" id="selReaBack" class="btn btn-outline-warning my-2 mx-2 w-25">Back</button>
            <button type="button" id="confirmRea" class="btn btn-primary my-2 mx-2 w-50">Confirm</button>
        </div>
    </div>

    <!-- If Valid then choose NO, Prioritize -->
    <div id="prioritize" class="card mx-auto my-3 w-50" style="display:none;">
        <div class="card-header text-center"><h5>Prioritize</h5></div>
        <div class="card-body">
            <div class="row my-2">
                <legend class="col-form-label col-sm-4 pt-0 text-right">Seriousness</legend>
                <div class="col-sm-8 text-left">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="prioritize-seriousness-1" value="1" name="field_value[421]" disabled>
                        <label class="form-check-label" for="prioritize-seriousness-1">Fatal / Life Threatening</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="prioritize-seriousness-2" value="2" name="field_value[421]" disabled>
                        <label class="form-check-label" for="prioritize-seriousness-2">Other Serious</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="prioritize-seriousness-3" value="3" name="field_value[421]" disabled>
                        <label class="form-check-label" for="prioritize-seriousness-3">Serious / Spontaneous</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gridRadios" id="prioritize-seriousness-4" value="4" name="field_value[421]" disabled>
                        <label class="form-check-label" for="prioritize-seriousness-4">Non Serious</label>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <legend class="col-form-label col-sm-4 pt-0 text-right">Related</legend>
                <div class="col-sm-8 text-left">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="qwe" id="prioritize-related-1" value="1" name="field_value[422]" disabled>
                        <label class="form-check-label" for="prioritize-related-1">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="qwe" id="prioritize-related-2" value="2" name="field_value[422]" disabled>
                        <label class="form-check-label" for="prioritize-related-2">No</label>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <legend class="col-form-label col-sm-4 pt-0 text-right">Unlabelled</legend>
                <div class="col-sm-8 text-left">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ert" id="prioritize-unlabelled-1" value="1" name="field_value[423]" disabled>
                        <label class="form-check-label" for="prioritize-unlabelled-1">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ert" id="prioritize-unlabelled-2" value="1" name="field_value[423]" disabled>
                        <label class="form-check-label" for="prioritize-unlabelled-2">No</label>
                    </div>
                </div>
            </div>
            <?= $this->Form->end();?>
            <div id="prioritizeType"></div>
            <button type="button" id="prioritizeBack" class="btn btn-outline-warning my-2 mx-2 w-25">Back</button>
            <a class="btn btn-light text-success mx-1" title="Sign Off" role="button" data-toggle="modal" data-target=".signOff" onclick="endTriage()"><i class="fas fa-share-square"></i>End Triage</a>
        </div>
    </div>
    <div class="modal fade signOff" tabindex="-1" role="dialog" aria-labelledby="signOff" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="action-text-hint"></div>
            </div>
        </div>
    </div>
  </div>
</div>
