/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var parsed_data;

//$("select#incident_type").on("change", function () {
//    var incident_type = $("#incident_type").val();
//
////    console.log(incident_type);
//
//    var url_path = 'http://csocims.localhost/index.php/Incident/getIncidentTemplateArtifact/' + incident_type;
//    var url_path2 = 'http://csocims.localhost/index.php/Incident/getIncidentTemplateArtifact2/' + incident_type;
//    $.ajax({
//        type: 'GET',
//        url: url_path,
//        success: function (response) {
//
//            $("#change_div").html(response);
//
//            $.ajax({
//                type: 'GET',
//                url: url_path2,
//                success: function (data) {
//                    parsed_data = JSON.parse(data);
//                    myFunction();
//                }
//            });
//        }
//    });
//});

//function myFunction() {
//    console.log(parsed_data);

//    for (x in parsed_data) {
//        console.log(parsed_data[x]);
//    }
//}

//$("button#submit_btn").on("click", function () {
//    var temp_array = [];
//    for (x in parsed_data) {
//        var value = $("input[name=" + parsed_data[x] + "]").val();
//        console.log(value);
//        temp_array.push(value);
//    }
//
//    console.log(temp_array);
//
//});

$("button#add-artifact").on("click", function () {
    var artifact = $("#artifact").val();
    $("tbody#artifact_table").append('<tr><td class="center">' + artifact + '</td><td><input type="text" class="form-control" placeholder="Value"></td><td class="center"><button type="button" class="btn btn-outline-danger btn-circle" data-toggle="tooltip" data-placement="right" title="Remove"><span class="fa fa-trash"></span></button></td></tr>');
    console.log(artifact);
});

$("#remove_artifact").on("click", function () {
    var artifact_id = $(this).val();

    console.log(artifact_id);
});
