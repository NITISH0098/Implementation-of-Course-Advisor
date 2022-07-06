$(function(e) {
    //getCourses();
    getSession();
    $(document).on("click", ".selectCourseValue", function() {
        //let e = document.getElementById(this.id);
        //console.log(e.id);
        $("#courseId").val(this.id);

    })

    $(document).on("change", "#divSelect", function() {

        let e = document.getElementById("divSelect");
        let optionValue = e.options[e.selectedIndex].text;
        let termType = optionValue.slice(5);
        let termYear = optionValue.slice(0, 4);
        $("#termYear").val(termYear);
        $("#termType").val(termType);

        //console.log("courseId" + courseId);
        // console.log("Type :" + termType);
        // console.log("year :" + termYear);

        $.ajax({
            url: "/workspace/businessAjax/gradeEntryAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, action: "loadCourses" },
            beforeSend: function() {},
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                $("#showStudents").html('');
                if (result.length == 0) {
                    $("#showCourse").html(`<div class ="col text-center"><b>NO DATA FOUND </b></div>`);

                } else {
                    html = CourseDisplay(result);
                    $("#showCourse").html(html);
                }

            },
            error: function(e) {
                console.log(e);
                $("#showCourse").html('');
                $("#showStudents").html(`<div style="display:flex;justify-content:center;"> <b>NO DATA FOUND </b></div>`);
                $("#overlay").fadeOut();
            },
        });

    })

    $(document).on("click", ".selectCourseValue", function() {
        let e = document.getElementById("divSelect");
        let optionValue = e.options[e.selectedIndex].text;
        let termType = optionValue.slice(5);
        let termYear = optionValue.slice(0, 4);
        $("#termYear").val(termYear);
        $("#termType").val(termType);
        let courseId = $("#courseId").val();
        //console.log("courseID: " + courseId);

        $.ajax({
            url: "/workspace/businessAjax/gradeEntryAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, courseId: courseId, action: "loadStudents" },
            beforeSend: function() {},
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                let html = studentDisplay(result);
                $("#showStudents").html(html);
            },
            error: function(e) {
                console.log(e);
                // alert("something went load");
                $("#showStudents").html(`<div style="display:flex;justify-content:center;"> <b>NO DATA FOUND </b></div>`);
                $("#overlay").fadeOut();
            },
        });
    })

    $(document).on("change", ".divSelectGradeClass", function() {
        let id = this.id;
        let e = document.getElementById(`${id}`);
        let data = $(this).data('studentid');
        let optionValue = e.options[e.selectedIndex].value; // $(`#${id}`).val();
        let grade = optionValue;
        let studentId = data;
        let courseId = $("#courseId").val();
        $.ajax({
            url: "/workspace/businessAjax/gradeEntryAJAX.php",
            type: "POST",
            dataType: "json",
            data: { courseId: courseId, grade: grade, studentId: studentId, action: "assignGrade" },
            beforeSend: function() {
               // alert(grade + " " + courseId + " " + studentId);
            },
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
        document.location.replace("/workspace/CourseAdvisor/dashboard.php")
    });
})

function studentDisplay(r) {
    if (r["numberOfStudent"][0] == '0') {
        let html = `<div style="display:flex;justify-content:center;"> <b>NO DATA FOUND </b></div>`;
        return html;
    } else {
        let html = `<div class="row" style="padding-top:10px;">
        <div class="col ">
             <b>SL NO</b>
        </div>
        <div class="col ">
            <b>NAME</b>
        </div>
        <div class="col ">
           <b>GRADE </b>
        </div>
        </div>`;
        for (let i = 0; i < r["sname"].length; i++) {

            html = html + `<div class="row" style="padding-top:5px;" >
              <div class="col  ">
                   ${i+1}
              </div>  
              <div class="col  ">
                 ${r["sname"][i]}
              </div>

              <div class="col" id="gradeList">
              `;

            if (r['sessionID'][0] != r['totalSessionId'][0]) {
                html = html + `<select name="selectGrade" class="divSelectGradeClass" id="divSelectGrade${i}" data-studentid= ${r["sid"][i]} style="width: 100%;" selected disabled>
           <option value=-1>`;
                html = html + `${r["grade"][i]}</option></select>`;
            } else if (r['sessionID'][0] == r['totalSessionId'][0]) {

                html = html + `<select name="selectGrade" class="divSelectGradeClass" id="divSelectGrade${i}" data-studentid= ${r["sid"][i]} style="width: 100%;">`;
                let value;
                let isDisabled;
                if(r["grade"][i]=="NA")
                   {
                        value = "Please select";
                        isDisabled='';
                   }
                else
                  {
                       value = (r["grade"][i]);
                       isDisabled='disabled';
                  }
             html = html +`<option value=-1 >${value}</option> <!--EDITED DISABLED BY ARINDAM-->

                        <option value='O'>O</option>
                        <option value='A+'>A+</option>
                        <option value='A'>A</option>
                        <option value='B+'>B+</option>
                        <option value='B'>B</option>
                        <option value='C'>C</option>
                        <option value='P'>P</option>
                        <option value='F'>F</option>
                        </select>
            `;
            }
            html = html + `</div>
         </div>`;
        }
        return html;
    }

}

function CourseDisplay(r) {

    let course = Object.values(r);
    //console.log(course[0]);
    let html = `<div class="col text-center mb-3"><b> All courses offered by the respective department to the faculty, in that semester: </b></div>`;
    html = html + `<div class="col-12" id="courseShow">`;

    for (let i = 0; i < course[1].length; i++) {
        html = html + `<div class="courseStyle selectCourseValue" id="${course[0][i]}">${course[1][i]}</div>`;
    }
    html = html + `</div>`;
    return html;
}

function getSessionHTML(r) {
    let html = `<div class ="col-2"></div>`;
    html = html + `<div class="col-4" style="display:flex;justify-content:center; align-items:center;" >
    <b>SESSION</b> 
  </div>`;
    html = html + `<div class="col-4" id="ddlSelectSession" >
    <select name="selectDiv"  id="divSelect"   style="width: 100%; height: 2em; border-radius: 1em;">`;
    html = html + `<option value=-1>Please Select</option>`;
    for (let i = r.length - 1; i >= 0; i--) {
        html = html + `<option value="${r[i].sessionID}">`;
        html = html + `${r[i].termYear}` + ` ` +
            `${r[i].termType}`;
        html = html + ` </option>`;
    }

    html = html + `</select> </div><div class="col-2"></div>`;
    return html;
}

// function getCourses() {

//     $.ajax({
//         url: "/workspace/businessAjax/gradeEntryAJAX.php",
//         type: "POST",
//         dataType: "json",
//         data: { action: "getCourses" },
//         beforeSend: function() {},
//         success: function(result) {
//             $("#overlay").fadeOut();
//             // console.log(result);
//             let html = getFacultyCourses(result);
//             $("#showCourse").html(html);
//         },
//         error: function(e) {
//             console.log(e);
//             alert("something went wrong");
//             $("#overlay").fadeOut();
//         },
//     });
// }

function getSession() {
    $.ajax({
        url: "/workspace/businessAjax/gradeEntryAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getSessionHTML" },
        beforeSend: function() {},
        success: function(result) {
            //console.log("SessionId" + result);
            let html = getSessionHTML(result);
            $("#session").html(html);
        },
        error: function(e) {
            // console.log(e);
            alert("something went wronghereeeeeeeeeeeeeeeeeeeeeeeeeeeee");
            $("#overlay").fadeOut();
        },
    });
}