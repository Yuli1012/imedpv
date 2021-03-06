$(document).ready(function(){
    /*
     Attachment source selections
     Added by Chloe Wang Mar 23, 2019
    */
    $('[id^=doc_source]').each(function(s,v){
        //console.log($(this));
        $(this)
        .change(function () {
            if ($( "#doc_source_"+s+" option:selected" ).val() == 'File Attachment')
            {
                $('#doc_attachment_'+s).show();
                $('#doc_path_'+s).hide();
            }
            else if ($( "#doc_source_"+s+" option:selected" ).val() == 'URL Reference')
            {
                $('#doc_attachment_'+s).hide();
                $('#doc_path_'+s).show();
            }
            
        })
    });
    $('[id^=add_attachment]').click(function(){
        var text="";
        var set_number = $(this).attr('id').split('-')[1];
        set_number ++;
        text +="<div class=\"form-row\">";
            text +="<div class=\"form-group col-md-3\">";
                text +="<label>Classification<i class=\"fas fa-asterisk reqField\"></i></label>";
                text +="<input type=\"text\" class=\"form-control\" name=\"document["+set_number+"][doc_classification]\" id=\"doc_classification_"+set_number+"\" value=\"\">";
            text +="</div>"
            text +="<div class=\"form-group col-md-3\">";
                text +="<label>Description<i class=\"fas fa-asterisk reqField\"></i></label>";
                text +="<input type=\"text\" class=\"form-control\" name=\"document["+set_number+"][doc_description]\" id=\"doc_description_"+set_number+"\" value=\"\">";
            text +="</div>";
            text +="<div class=\"form-group col-md-3\">";
                text +="<label>File/Reference</label>";
                text +="<input type=\"text\" class=\"form-control\" name=\"document["+set_number+"][doc_path]\" id=\"doc_path_"+set_number+"\" value=\"\" style=\"display:none\">";
                text +="<input name=\"document["+set_number+"][doc_attachment]\" id=\"doc_attachment_"+set_number+"\" type=\"file\"/>";
            text +="</div>";
            text +="<div class=\"form-group col-md-3\">";
            text +="<label>&nbsp;</label>";
            text +="<select name=\"document["+set_number+"][doc_source]\" id=\"doc_source_"+set_number+"\">";
            text +="<option value=\"File Attachment\">File Attachment</option>";
            text +="<option value=\"URL Reference\">URL Reference</option>";
            text +="</select>";
            text +="</div>";
            text +="<button type=\"button\" onclick=\"$(this).closest('.form-row').remove()\">Delete</button>"
        text +="</div>";
        $(this).attr('id','add_attachment-'+set_number);
        $('#attachmentField').append(text);
    })

        // IF invalid case
        var validCase = 0;
    $("#confirmElements").click(function(){
        var patient_element = 0;
        var reporter_element = 0;
        var event_element = 0;
        $('#patientInfo :input').each(function(){
            if(($(this).val()!=null)&&($(this).val()!= ""))
            patient_element = 1;
        });
        $('[id^=reporterField]').each(function(){
            if(($(this).val()!=null)&&($(this).val()!= ""))
            reporter_element = 1;
        });
        $('[id^=eventField]').each(function(){
            if(($(this).val()!=null)&&($(this).val()!= ""))
            event_element = 1;
        });
        validCase = patient_element + reporter_element + event_element;
        if (validCase <= 1) {
            $('#validcase').val('2');
            swal("This is an invalid case and it will be inactivated. Are you sure you want to continue?","","warning", {
                buttons: {
                    continue: true,
                    cancel: "Cancel"
                },
            })
            .then((value) => {
                if (value) {
                    var request ={};
                    var form = new FormData(document.getElementById("triageForm"));
                    $("[name^=field_value]").each(function(){
                        request[$(this).attr('name')] = $(this).val();
                    });
                    $("[name^=doc_]").each(function(){
                        request[$(this).attr('name')] = $(this).val();
                    });
                    console.log(request);
                    $.ajax({
                        headers: {
                            'X-CSRF-Token': csrfToken
                        },
                        type:'POST',
                        url:'/sd-cases/deactivate/'+caseNo+'/'+versionNo,
                        cache:false,
                        data:form,
                        contentType:false,
                        processData:false,
                        success:function(response){
                            console.log(response);
                            swal("Your case has been inactivated","", "warning",{
                                buttons: {
                                    continue: true,
                                },
                            }).then((value) => {
                                if (value) {
                                    window.location.href = "/sd-cases/caselist";
                                }
                            });
                        },
                        error:function(response){
                            console.log(response);
                        }
                    });
                }
            });
        }else if(validCase == 2) {
            swal("This is an invalid case. Do you want to continue this case?","","warning", {
                buttons: {
                    Yes: true,
                    No: true,
                    cancel: "Cancel"
                },
            })
            .then((value) => {
                switch (value) {
                    case "Yes":
                        $('#validcase').val('2');
                        swal("Please Select Reasons in following step","", "success");
                        $("#basicInfo :input").each(function(){
                            $(this).prop("readonly", true);
                        });
                        $('#confirmElements').hide();
                        $('#selRea').show();
                        $("#savenexitbtn").appendTo("#selectReasonContent");
                        $('[id^=reason]').each(function(){
                            $(this).prop('disabled',false)
                        });
                        $("select").each(function(){
                            $(this).prop("disabled", true);
                        });
                        break;
                    case "No":
                        $('#validcase').val('1');
                        var request ={};
                        $("[name^=field_value]").each(function(){
                            request[$(this).attr('name')] = $(this).val();
                        });
                        console.log(request);
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': csrfToken
                            },
                            type:'POST',
                            url:'/sd-cases/deactivate/'+caseNo+'/'+versionNo,
                            data:request,
                            success:function(response){
                                swal("Your case has been inactivated","", "warning");
                                window.location.href = "/sd-cases/caselist";
                            },
                            error:function(response){

                            }
                        });
                        break;
                }
            });
        }
        // ELSE valid case
        else {
            $('#validcase').val('1');
            $("#savenexitbtn").appendTo("#prioritizeContent");
            $("#basicInfo :input").each(function(){
                $(this).prop("readonly", true);
            });
            $("select").each(function(){
                $(this).prop("disabled", true);
            });
            $('#confirmElements').hide();
            $('#prioritize').show();
            $('#prioritize :input').prop('disabled',false);
        }
    });



    $("#reason-3").change(function(){
        if($(this).prop('checked')){
            $('#otherReason').prop('disabled',false);
            $('#otherReason').show();
        }

        if(!$(this).prop('checked')){
            $('#otherReason').prop('disabled',true);
            $('#otherReason').hide();
        }
    });
    $('[id^=reason]').change(function(){
        $('#reason_value').prop('diasbled',false);
        var text ="";
        if($('#reason-1').prop('checked')==0) text +="0"; else text +="1";
        if($('#reason-2').prop('checked')==0) text +="0"; else text +="1";
        if($('#reason-3').prop('checked')==0) text +="0"; else text +="1";
        $('#reason_value').val(text);
    });
    $('[id^=patientField_dob]').change(function(){
        var day = $('[id=patientField_dob_day]').val();
        var month = $('[id=patientField_dob_month]').val();
        var year = $('[id=patientField_dob_year]').val();
        var dob_string = day + month + year;
        $('#patientField_dob').val(dob_string);
    });
    $("#selReaBack").click(function(){
        $("#savenexitbtn").appendTo("#basicInfo");
        $('[id^=reason]').each(function(){
            $(this).prop('disabled',true)
        });
        $('select').each(function(){$(this).prop('disabled',false);})
        $('#selRea').hide();
        $('#confirmElements').show();
        $("#basicInfo :input").each(function(){
            $(this).prop("readonly", false);
        });
    });
    $("#confirmRea").click(function(){
        $(this).hide();
        $("#savenexitbtn").appendTo("#prioritizeContent");
        $('#selReaBack').hide();
        $('#prioritize').show();
        $('#prioritize :input').prop('disabled',false);
    });
    $("#prioritizeBack").click(function(){
        if(validCase == 2) {
            $('#selReaBack').show();
            $('#confirmRea').show();
            $("#savenexitbtn").appendTo("#selectReasonContent");
        }else{
            $('#confirmElements').show();
            $("#basicInfo :input").each(function(){
                $(this).prop("readonly", false);
            });
            $("select").each(function(){
                $(this).prop("disabled", false);
            });
            $("#savenexitbtn").appendTo("#basicInfo");
        }
        $('#prioritize').hide();
        $('#prioritize :input').prop('disabled',true);
    });

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        prioritizeDate();
    });

    $('[id^=prioritize]').change(function(){prioritizeDate()});
});
function prioritizeDate(){
    var text="";    
    var dueType = 0;
    var submitType = 0
    if($('#prioritize-seriousness-1').prop('checked')) dueType = 1;
    if($('#prioritize-related-1').prop('checked')&&$('#prioritize-unlabelled-1').prop('checked')) submitType = 1;
    var formatDayZero = new Date(dayZero.substring(2,4)+" "+dayZero.substring(0,2)+" "+dayZero.substring(4,8));
    var formatDueDay = new Date();
    if(dueType == 1){
        formatDueDay.setDate(formatDayZero.getDate()+8);
        text +="Priority: High, 7 Days";
    }else{
        formatDueDay.setDate(formatDayZero.getDate()+16);
        text +="Priority: Normal, 15 Days";
    }
    if(submitType == 1){
        text +=" Report ";
    }else{
        text +=" Case ";
    }  
    text+='Due Date:';    
    var yearText =formatDueDay.getFullYear();
    var monthText =(Number(formatDueDay.getMonth())+1);
    var dayText =formatDueDay.getDate();
    if(dayText<10){dayText="0"+dayText;}
    if(monthText<10){monthText="0"+monthText;}
    text += yearText+'/'+monthText+'/'+dayText;
    $('#submissionDate_value').val(dayText+monthText+yearText);
    $('#prioritizeType').text();
    $('#prioritizeType').text(text);
}
function endTriage(){
    var request ={};
    $("[name^=field_value]").each(function(){
        if($(this).val()!="")
        {
            console.log($(this).attr('name'));
            request[$(this).attr('name')] = $(this).val();
        }
    });
    request['endTriage'] = 1;
    console.log(request);
    $.ajax({
        headers: {
            'X-CSRF-Token': csrfToken
        },
        type:'POST',
        url:'/sd-cases/triage/'+caseNo+'/'+versionNo,
        data:request,
        success:function(response){

            console.log(response);
        },
        error:function(response){
            console.log(response);
        },
    });
    var text ="";
    $.ajax({
        headers: {
            'X-CSRF-Token': csrfToken
        },
        type:'POST',
        url:'/sd-users/searchNextAvailable/'+caseNo+'/'+versionNo,
        success:function(response){
            response = JSON.parse(response);
            console.log(response);
            text +="<div class=\"modal-header\">";
            text +="<h3 class=\"modal-title text-center w-100\" id=\"exampleModalLabel\">Sign Off</h3>";
            text +="<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
            text +="<span aria-hidden=\"true\">&times;</span>";
            text +="</button>";
            text +="</div>";
            text +="<div class=\"modal-body text-center m-3\">";
            text +="<p class=\"lead\">Next activity is: "+response['actvity']['activity_name']+"</p>";
            text +="<input type=\"hidden\" id=\"next-activity-id\" value=\""+response['actvity']['id']+"\">";
            text +="<div class=\"form-group\">";
            text +="<label><h5>Comment</h5></label>";
            text +="<textarea class=\"form-control\" id=\"query-content\" rows=\"3\"></textarea>";
            text +="</div>";
            text +="<hr class=\"my-4\">";
            if(response['previousUserOnNextActivity'].length > 0){
                text +="<div><h6>Previous User On This Case On Next Activity: </h6>";
                $.each(response['previousUserOnNextActivity'],function(k,v){
                    text +=v['user']['firstname']+" "+v['user']['lastname']+"("+v['company']['company_name']+"), ";
                });
                text +="</div>";
                text +="<hr class=\"my-4\">";
            }
            //add function to chose most avaiable person
            text +="<div class=\"form-group\">";
            text +="<label><h6>Select person you want to send to:</h6></label><select class=\"form-control\" id=\"receiverId\">";
            $.each(response['users'],function(k,v){
                text +="<option value="+v['id']+">"+v['firstname']+" "+v['lastname'];
                if(v['sd_cases'].length > 0)
                    text +="(currently working on "+v['sd_cases']['0']['casesCount']+" cases)";
                else text +="(currently working on 0 case)";
                text +="</option>";
            });
            text +="</select>";
            text +="</div>";
            text +="<div class=\"text-center\"><div class=\"btn btn-primary w-25\" onclick=\"confirmEndTriage()\">Confirm</div></div>";
            text +="</div>";
            $('#action-text-hint').html(text);
        },
        error:function(response){
            console.log(response.responseText);
        },
    });
}
function confirmEndTriage(){
    var request ={
        'senderId':userId,
        'next-activity-id':$('#next-activity-id').val(),
        'receiverId':$('#receiverId').val(),
        'content':$('#query-content').val()
    }
    console.log(request);
    $.ajax({
        headers: {
            'X-CSRF-Token': csrfToken
        },
        type:'POST',
        url:'/sd-cases/forward/'+caseNo+'/'+versionNo+'/0',
        data:request,
        success:function(response){
            console.log(response);
            window.location.href = "/sd-cases/caselist";
        },
        error:function(response){
            console.log(response.responseText);
            }
        });
}
function savenexit(){
    $("select").each(function(){
        $(this).prop("disabled", false);
    });
    document.getElementById("triageForm").submit();
}