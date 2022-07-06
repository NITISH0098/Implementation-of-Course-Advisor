function getAssignedStudents(studentList)

{
    let html = "";
    let colorCode;
    let sta;
    for (let i = 0; i < studentList.length; i++) {
        if (studentList[i].status == "Y") {
            colorCode = "verified";
            sta = "Verified";
        } else {
            colorCode = "notverified";
            sta = "Not Verified";
        }
        html = html + `<div class=" col border border-warning myStudent ${colorCode} studentCard" style="padding:2%;"  id=${studentList[i]['sid']} data-studentname=${studentList[i]['senroll']}>
                       <div> SL NO : ${i+1} </div> 
                       <div>${studentList[i]['senroll']}</div>
                       <div>${studentList[i]['sname']}</div>
                       <div>${sta}</div>
      </div>`;
    }

    return html;
}

// function getColumns() {
//     let html = `<div class="REPLACE" style="display:flex;">`;

//     // html = html + getAssignedStudents(studentList);
//     html = html + `</div>`;

//     html = html + `
//       <div class="col-6 " id="studentDetails">
//       </div>
//       </div></div>`;

//     $("#divMainContainer").html(html);
// }

function loadStudents(lv, termYear, termType) {

    // document.getElementById("#termYear").value=$termYear;
    $("#termYear").val(termYear);
    $("#termType").val(termType);
    facId = $("#facultyId").val();
    $.ajax({
        url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
        type: "POST",
        dataType: "json",
        data: { termYear: termYear, termType: termType, facultyId: facId, listValue: lv, action: "loadAssignedStudents" },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            $("#overlay").fadeOut();
            // alert(JSON.stringify(result));
            console.log(result);
            let html = getAssignedStudents(result);
            $("#divMainContainer").html(html);


        },
        error: function(e) {
            alert("something went wrong");
            console.log(e);
            $("#overlay").fadeOut();
        },
    });

}

function getddlSessionHTML(r) {
    let html = `<select name="selectDiv" id="divSelect" style="width: 50%;">`;
    html = html + `<option value=-1>Please Select</option>`;
    for (let i = r.length - 1; i >= 0; i--) {
        html = html + `<option value="${r[i].sessionID}">`;
        html = html + `${r[i].termYear}` + ` ` +
            `${r[i].termType}`;
        html = html + ` </option>`;
    }

    html = html + `</select>`;
    return html;
}

function loadSession() {
    $.ajax({
        url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getSessionHTML" },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            $("#overlay").fadeOut();
            // console.log(result);
            html = getddlSessionHTML(result);
            $("#ddlSelectSession").html(html);

        },
        error: function(e) {
            console.log(e);
            alert("something went wrong");
            $("#overlay").fadeOut();
        },
    });
}
$(function(e) {
    // loadStudents();
   // getColumns();
    loadSession();
    $(document).on("click", ".myStudent", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = this.id;
        $("#studentId").val(studentId);
        let data = $(this).data('studentname');
        console.log(data);
        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, studentId: studentId, studentName: data, action: "setSessionVariable" },
            beforeSend: function() {},
            success: function(result) {

            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
            },
        });

        document.location.replace("/workspace/CourseAdvisor/showStudentdetails.php")


        // $.ajax({
        //     url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
        //     type: "POST",
        //     dataType: "json",
        //     data: { termYear: termYear, termType: termType, studentId: studentId, action: "getStudentDetails" },
        //     beforeSend: function() {
        //         $("#overlay").fadeIn();
        //     },
        //     success: function(result) {
        //         $("#overlay").fadeOut();
        //         // alert(studentId);
        //         console.log(result);
        //         let html = getStudentDetails(result, data);
        //         $("#studentDetails").html(html);
        //     },
        //     error: function(e) {
        //         console.log(e);
        //         alert("something went wrong");
        //         $("#overlay").fadeOut();
        //     },
        // });

    });

    $(document).on("change", "#divSelect", function() {
        let e = document.getElementById("divSelect");
        let optionValue = e.options[e.selectedIndex].text;
        let termType = optionValue.slice(5);
        let termYear = optionValue.slice(0, 4);

        let lv = $("#divSelect").val();

        if ($("#divSelect").val() != "-1") {
            loadStudents(lv, termYear, termType);
            $("#studentDetails").html("");
            $("#studentId").val("");
            //  console.log($("#studentId").val());
        }
        if ($("#divSelect").val() == "-1") {

            $("#studentDetails").html("");
            $(".REPLACE").html("");
            $("#studentId").val("");
        }
    })

    $(document).on("click", "#btnLogOut", function() {
        document.location.replace("/workspace/CourseAdvisor/logout.php")
    });

    $(document).on("click", "#btnBack", function() {
        document.location.replace("/workspace/CourseAdvisor/dashboard.php")
    });
});