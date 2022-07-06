function getddlProgramHTML(r) {
    let html = `<select name="selectDivProg"  id="divSelectProg" style="width: 100%;">`;
    html = html + `<option value=-1>Please Select</option>`;
    for (let i = 0; i < r.length; i++) {
        html = html + `<option value="${r[i].pid}">`;
        html = html + `${r[i].pname}`;
        html = html + ` </option>`;
    }

    html = html + `</select>`;
    return html;
}


function getddlSessionHTML(r) {
    let html = `<select name="selectDiv"  id="divSelect"   style="width: 100%;">`;
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


function loadProgram() {
    $.ajax({
        url: "/workspace/businessAjax/courseAdvisorAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getProgramHTML" },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            $("#overlay").fadeOut();
            html = getddlProgramHTML(result);
            $("#ddlSelectProgram").html(html);

        },
        error: function(e) {
            console.log(e);
            alert("something went wrong");
            $("#overlay").fadeOut();
        },
    });
}


function loadSession() {
    $.ajax({
        url: "/workspace/businessAjax/courseAdvisorAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getSessionHTML" },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            $("#overlay").fadeOut();
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

function getSemester(r, termType) {
    let html = `<div class="col-12" id="semesterShow">`;
    if (termType == "AUTUMN") {
        for (let i = 1; i < r; i += 2) {
            html = html + `<div class="semStyle selectSemValue" id="${i}">${i}</div>`;
        }
        html = html + `</div>`;
    }
    if (termType == "SPRING") {
        for (let i = 2; i <= r; i += 2) {
            html = html + `<div class="semStyle selectSemValue" id="${i}">${i}</div>`;
        }
        html = html + `</div>`;
    }
    return html;
}

function studentDisp(r) {
    let val = 5;
    let html = `<div class="row" style="padding-top:10px;">
        <div class="col ">
             <b>SL NO</b>
        </div>
        <div class="col ">
            <b>NAME</b>
        </div>
        <div class="col ">
           <b>FACULTY</b>
        </div>
        </div>`;
    for ($i = 0; $i < r["student"].length; $i++) {

        html = html + `<div class="row" style="padding-top:5px;" >
              <div class="col  ">
                   ${$i+1}
              </div>  
              <div class="col  ">
                 ${r["student"][$i]}
              </div>
              <div class="col" id="FacultyList">`;
        if (r.currentSession == val) {
            html = html + `<select name="selectFaculty" class="divSelectFacultyClass" id="divSelectFaculty${$i}" data-studentid= ${r["sid"][$i]} style="width: 100%;">
                <option value=-1 disabled selected>`;
        } else {
            html = html + `<select name="selectFaculty" class="divSelectFacultyClass" id="divSelectFaculty${$i}" data-studentid= ${r["sid"][$i]} style="width: 100%;" disabled>
                <option value=-1 disabled selected>`;
        }


        if (r["facultyName"][$i] != -1) {
            $string = r["facultyName"][$i];
        } else {
            $string = "Please Select";
        }
        html = html + `${$string}</option>`;
        for (let $j = 0; $j < r["faculty"].length; $j++) {
            html = html + `<option value="${r["fid"][$j]}">`;
            html = html + `${r["faculty"][$j]}`;
            html = html + ` </option>`;
        }
        html = html + `</select>`

        html = html + `</div>
          </div>`;
    }
    return html;
}

//entry point
$(function(e) {
    loadProgram();
    loadSession();
    $(document).on("change", "#divSelect", function() {

        let e = document.getElementById("divSelect");
        let optionValue = e.options[e.selectedIndex].text;
        let termType = optionValue.slice(5);
        let termYear = optionValue.slice(0, 4);
        $("#termYear").val(termYear);
        $("#termType").val(termType);
    })

    $(document).on("change", "#divSelectProg", function() {

        let e = document.getElementById("divSelectProg");
        let optionValue = e.options[e.selectedIndex].value;
        $("#programId").val(optionValue);

    })

    $(document).on("click", "#selectSem", function() {
        let termYear = $("#termYear").val();
        let termType = $("#termType").val();
        let progId = $("#programId").val();
        $.ajax({
            url: "/workspace/businessAjax/courseAdvisorAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, progId: progId, action: "loadSemester" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                $("#showStudents").html(" ");
                let html = getSemester(result, termType);
                $("#showSem").html(html);
            },
            error: function(e) {
                console.log(e);
                $("#showSem").html(`<div style="margin-left:450px"> <b>PLEASE SELECT SOMETHING </b></div>`);
                $("#overlay").fadeOut();
            },
        });
    })


    // FOR DISPLAYING THE STUDENTS
    $(document).on("click", ".selectSemValue", function() {

        let termYear = $("#termYear").val();
        let termType = $("#termType").val();
        let progId = $("#programId").val();
        let semId = this.id;
        $.ajax({
            url: "/workspace/businessAjax/courseAdvisorAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, progId: progId, semId: semId, action: "loadStudent" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                if (result.length == 0) {
                    $("#showStudents").html(`<div style="display:flex;justify-content:center"> <b>NO DATA FOUND </b></div>`);
                } else {
                    html = studentDisp(result);
                    $("#showStudents").html(html);
                }




            },
            error: function(e) {
                alert(e);
                console.log(e);
                $("#overlay").fadeOut();
            },
        });
    });

    $(document).on("change", ".divSelectFacultyClass", function() {
        let id = this.id;
        let e = document.getElementById(`${id}`);
        let data = $(this).data('studentid');
        let optionValue = e.options[e.selectedIndex].value; // $(`#${id}`).val();
        let facultyId = optionValue;
        let studentId = data;
        $.ajax({
            url: "/workspace/businessAjax/courseAdvisorAJAX.php",
            type: "POST",
            dataType: "json",
            data: { facultyId: facultyId, studentId: studentId, action: "assignFaculty" },
            beforeSend: function() {},
            success: function(result) {
                console.log(result);

            },
            error: function(e) {
                console.log(e);
                alert("something went wronghereeeeeeeeeeeeeeeeeeeeeeeeeeeee");
                $("#overlay").fadeOut();
            },
        });

    })

    $(document).on("click", "#btnLogOut", function() {
        document.location.replace("/workspace/CourseAdvisor/logout.php")
    });

    $(document).on("click", "#btnBack", function() {
        document.location.replace("/workspace/CourseAdvisor/HodDashboard.php")
    });
});