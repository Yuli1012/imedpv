jQuery(function($) {
    $(document).ready(searchProd());
});
function searchProd(){
    var request = {
        'searchName': $("#key_word").val(),
        'productName':$("#product_name").val(),
        'studyName':$("#study_no").val(),
        'userId':userId
    };
    console.log(request);
    $.ajax({
        headers: {
            'X-CSRF-Token': csrfToken
        },
        type:'POST',
        url:'/sd-products/search',
        data:request,
        success:function(response){
            console.log(response);
            var result = $.parseJSON(response);
            var text = "";
            text +="<h3>Product List</h3>";
            text +="<table class=\"table table-hover table-striped table-bordered\" id=\"search_result\">";
            text += "<thead>";
            text +="<tr class=\"table-secondary\">";
            text +="<th scope=\"col\">Product Name</th>";
            text +="<th scope=\"col\">Study Number</th>";
            text +="<th scope=\"col\">Study Type</th>";
            text +="<th scope=\"col\">Sponsor</th>";
            text +="<th scope=\"col\">mfr name</th>";
            text +="<th scope=\"col\">Status</th>";
            text +="<th scope=\"col\">Workflows / Country</th>";
            text +="<th scope=\"col\">Product Detail</th>";
            text +="</tr>";
            text +="</thead>";
            text +="<tbody>";
            var study_type=["","clinical trials", "individual patient use","other studies"];
            $.each(result, function(k,caseDetail){
                text += "<tr>";
                text += "<td>" + caseDetail.product_name + "</td>";
                text += "<td>" + caseDetail.study_no +"</td>";
                text += "<td>" + study_type[caseDetail.study_type]+ "</td>";
                text += "<td>"+caseDetail.sd_company.company_name+"</td>";
                text += "<td>"+caseDetail.mfr_name+"</td>";
                text += "<td>new</td>";
                text += "<td>";
                $.each(caseDetail.sd_product_workflows, function(k,product_workflowdetail){
                    text += "<div class=\"btn btn-sm btn-outline-info mx-1\" data-toggle=\"modal\" onclick=\"view_workflow("+product_workflowdetail.id+")\" data-target=\".WFlistView\">"+product_workflowdetail.sd_workflow.name+" / "+product_workflowdetail.sd_workflow.country+"</div>";                });
                text += "</td>";
                text += "<td><div class=\"btn btn-sm btn-outline-info\" data-toggle=\"modal\" onclick=\"view_product("+caseDetail.id+")\" data-target=\".product_detail\">View Detail</div></td>";
                text +="<div id=\"product_"+caseDetail.id+"\" style=\"display:none\">"+JSON.stringify(caseDetail)+"</div>";
                text += "</tr>";
            });
            text +="</tbody>";
            text +="</table>";
            $("#searchProductlist").html(text);
            $('#search_result').DataTable();
        },
        error:function(response){
                console.log(response.responseText);
            $("#textHint").html("Sorry, no case matches");

        }
    });
}
function view_product(product_id){
    var study_type=["","Clinical trials", "Endividual patient use","Other studies"];
    var status = ["","Active",'Close'];
    var blinding_tech = ["","Single blind", "Open-label"]
    var product_flag = ["","Suspect","Concomitant","Interacting"];
    product_detail = $.parseJSON($('#product_'+product_id).text());
    $('#detail_product_name').val(product_detail['product_name']);
    $('#detail_sponsor_company').val(product_detail['sd_company']['company_name']);
    $('#detail_sd_product_flag').val(product_flag[product_detail['sd_product_flag']]);
    $('#detail_blinding_tech').val(blinding_tech[product_detail['blinding_tech']]);
    $('#detail_study_name').val(product_detail['study_name']);
    $('#detail_study_no').val(product_detail['study_no']);
    $('#detail_mfr_name').val(product_detail['mfr_name']);
    $('#detail_study_type').val(study_type[product_detail['study_type']]);
    $('#detail_whodracode').val(product_detail['WHODD_code']);
    $('#detail_whodraname').val(product_detail['WHODD_name']);
    $('#detail_WHODD_decode').val(product_detail['WHODD_decode']);
    $('#detail_start_date').val(product_detail['start_date']);
    $('#detail_end_date').val(product_detail['end_date']);
    $('#detail_status').val(status[product_detail['status']]);
    $('#detail_short_desc').val(product_detail['short_desc']);
    $('#detail_product_desc').val(product_detail['product_desc']);

}
function view_workflow(workflow_k){
    $.ajax({
        headers: {
            'X-CSRF-Token': csrfToken
        },
        type:'POST',
        url:'/sd-product-workflows/view/'+workflow_k,
        success:function(response){
            console.log(response);
            var result=$.parseJSON(response);
            var workflow_info = result['sd_workflow'];
            $('#viewWFname').text(workflow_info['name']);
            $('#viewCC').text(result['sd_company']['company_name']);
            $('#viewCountry').text(workflow_info['country']);
            $('#viewDesc').text(workflow_info['description']);
            $('#allocate_workflow').attr('href','/sd-product-workflows/allocateWorkflow/'+workflow_k);
            $('#viewMan').html("<b>"+result['sd_user']['firstname']+" "+result['sd_user']['lastname']+"</b> FROM "+result['sd_user']['sd_company']['company_name']);
            var team_resources_text="";
            $.each(result['sd_user_assignments'], function(k, v){
                    console.log(v);
                    team_resources_text += "<div><b>"+v['sd_user']['firstname']+" "+v['sd_user']['lastname']+"</b> From"+v['sd_user']['sd_company']['company_name']+"</div>";
            });
            $('#viewRes').html(team_resources_text);
            var activities_text="";
            $(workflow_info['sd_workflow_activities']).each(function(k,activity_detail){
                activities_text +="<span class=\"badge badge-info px-5 py-3 m-3\"><h5>"+activity_detail['activity_name']+"</h5><h8>"+activity_detail['description']+"</h8></span><i class=\"fas fa-long-arrow-alt-right\"></i>";
            });
            activities_text+="<span class=\"badge badge-info px-5 py-3 m-3\"><h5>Complete</h5><h8>End of the case</h8></span>"
            $('#view_activities').html(activities_text);
        },
        error:function(response){
                console.log(response.responseText);

            $("#textHint").html("Sorry, no case matches");

        }
    });
}