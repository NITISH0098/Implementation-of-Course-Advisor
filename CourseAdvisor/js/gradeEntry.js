$(function(e) {
    getCourses();
    $(document).on("click", ".selectCourseValue", function() {
        $("#courseId").val(this.id);
        $.ajax({
            url: "/workspace/businessAjax/gradeEntryAJAX.php",
            type: "POST",
            dataType: "json",
            data: { action: "getSessionHTML1" },
            beforeSend: function() {},
            success: function(result) {
                //console.log("SessionId" + result);
                let html = getddlSessionHTML1(result);
                $("#showStudents").html('');
                $("#session").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wronghereeeeeeeeeeeeeeeeeeeeeeeeeeeee");
                $("#overlay").fadeOut();
            },
        });
    })

    /* $(document).on("click", ".selectCourseValue", function() {
        //let e = document.getElementById(this.id);
        //console.log(e.id);
        $("#courseId").val(this.id);

    }) */

    $(document).on("change", "#divSelect", function() {

        let e = document.getElementById("divSelect");
        let optionValue = e.options[e.selectedIndex].text;
        let termType = optionValue.slice(5);
        let termYear = optionValue.slice(0, 4);
        $("#termYear").val(termYear);
        $("#termType").val(termType);
        let courseId = $("#courseId").val();
        console.log("courseId" + courseId);

        $.ajax({
            url: "/workspace/businessAjax/gradeEntryAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, courseId: courseId, action: "loadStudent" },
            beforeSend: function() {},
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                html = studentDisp1(result);
                $("#showStudents").html(html);
            },
            error: function(e) {
                console.log(e);
                $("#showStudents").html(`<div style="display:flex;justify-content:center"> <b>NO DATA FOUND </b></div>`);
                $("#overlay").fadeOut();
            },
        });

    })

    $(document).on("change", ".divSelectGradeClass", function() {
        let id =this.id;
        let e = document.getElementById(`${id}`);
        let data=$(this).data('studentid');
        let optionValue = e.options[e.selectedIndex].value;  // $(`#${id}`).val();
         let grade = optionValue;
         let studentId = data;
         let courseId = $("#courseId").val();
        $.ajax({
            url: "/workspace/businessAjax/gradeEntryAJAX.php",
            type: "POST",
            dataType: "json",
            data: { courseId:courseId,grade:grade,studentId:studentId, action: "assignGrade" },
            beforeSend: function() {
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

function studentDisp1(r) {
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
              <select name="selectGrade" class="divSelectGradeClass" id="divSelectGrade${i}" data-studentid= ${r["sid"][i]} style="width: 100%;">
              <option value=-1 selected disabled >`;

        if (r["grade"][i] != -1) {
            $string = r["grade"][i];
        } else {
            $string = "Please Select";
        }
        html = html + `${$string}</option>`;
       /*  for (let $j = 0; $j < r["grade"].length; $j++) {
            html = html + `<option value="${r["grade"][$j]}">`;

            html = html + `${r["grade"][$j]}`;
            //alert(r["grade"][$j])
            html = html + ` </option>`;
        } */
        html = html + `<option value='O'>O</option>
                        <option value='A+'>A+</option>
                        <option value='A'>A</option>
                        <option value='B+'>B+</option>
                        <option value='B'>B</option>
                        <option value='C'>C</option>
                        <option value='P'>P</option>
                        <option value='F'>F</option>`
        html = html + `</select>
              </div>
          </div>`;
    }

    return html;
}

function getFacultyCourses(r) {

    let course = Object.values(r);
    //console.log(course[0]);
    let html = `<div class="col-12" id="courseShow">`;

    for (let i = 0; i < course[1].length; i++) {
        html = html + `<div class="courseStyle selectCourseValue" id="${course[0][i]}">${course[1][i]}</div>`;
    }
    html = html + `</div>`;
    return html;
}

function getddlSessionHTML1(r) {
    let html = `<div class ="col-2"></div>`;
    html = html + `<div class="col-4" style="display:flex;justify-content:center; align-items:center;" >
    <b>SESSION</b> 
  </div>`;
    html = html + `<div class="col-4" id="ddlSelectSession" >
    <select name="selectDiv"  id="divSelect"   style="width: 100%; height: 2em; border-radius: 1em;">`;
    html = html + `<option value=-1>Please Select</option>`;
    for (let i = 0; i < r.length; i++) {
        html = html + `<option value="${r[i].sessionID}">`;
        html = html + `${r[i].termYear}` + ` ` +
            `${r[i].termType}`;
        html = html + ` </option>`;
    }

    html = html + `</select> </div><div class="col-2"></div>`;
    return html;
}

function getCourses() {

    $.ajax({
        url: "/workspace/businessAjax/gradeEntryAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getCourses" },
        beforeSend: function() {},
        success: function(result) {
            $("#overlay").fadeOut();
            // console.log(result);
            let html = getFacultyCourses(result);
            $("#showCourse").html(html);
        },
        error: function(e) {
            console.log(e);
            alert("something went wrong");
            $("#overlay").fadeOut();
        },
    });
}