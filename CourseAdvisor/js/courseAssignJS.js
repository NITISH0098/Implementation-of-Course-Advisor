function getddlSessionHTML1(r) {
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

function displayCoursesNFaculty1(r) {
    let html = "";
    let facultyName = [];
    let str;
    // if((Object.keys(r).indexOf('previous')) != -1)
    // {
    // for (let i = 0; i < r.previous.fname.length; i++) {
    //     facultyName[i] = r.previous.fname[i];
    // }
    //  str = facultyName.join();
    // }
    html = html + `<table class="table table-striped">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">COURSES</th>
      <th scope="col">FACULTIES</th>
      <th scope="col" style="display:flex;justify-content:center">SHOW FACULTIES</th>
    </tr>
    </thead>`;
    html = html + `<tbody>`;
    if (r.SessionCount[0] == r.currentSessionId[0]) {

        for (let i = 0; i < r.cname.length; i++) {
            // console.log("inside for");
            html = html + `<tr>
            <th scope ="row">${i+1}`;
            html = html + `</th>
            <td>
            ${r.cname[i]}
            </td>
            <td>
            <select name="selectFacultyName[]" id=selectAllFaculty${i}  class="selectAllFaculty multiple-select"data-live-search="true" style="width: 100%;" multiple>`;

            html = html + `</select></td>
            <td>`;
            
            if((Object.keys(r).indexOf('previous')) != -1)
            {
             for (let j = 0; j < r.previous.fname.length; j++) {
                if(r.cid[i] == r.previous.cid[j])
                    {
                        facultyName[j] = r.previous.fname[j];
                    } 
              }
             str = facultyName.join(' ');
            }
            if(str=='')
             {
                html = html +`NO FACULTIES CHOOSEN`;
             }
            else
            {
                
                html = html +` ${str}`;
                facultyName = [];
                str = '';
            }
            
            
           
            html = html + `</td>
            <td><button type="button" class="btn btn-success saveFacultyBtn" id="submit" data-selectid=selectAllFaculty${i} data-courseid= ${r.cid[i]} data-sessionid=${r.currentSessionId[0]}>Save</button></td>
            <td><button type="button" class="btn btn-danger deleteFacultyBtn" id="delete" data-selectid=selectAllFaculty${i} data-courseid= ${r.cid[i]} data-sessionid=${r.currentSessionId[0]}>DELETE</button></td>
           
            </tr>`;
        }

    } else {
        for (let i = 0; i < r.previous.cid.length; i++) {
            let j;
            for (j = 0; j < i; j++) {
                if (r.previous.cname[i] == r.previous.cname[j]) {
                    break;
                }
            }
            if (i == j) {
                html = html + `<tr>
            <th scope ="row">${i+1}`;
                html = html + `</th>
                <td>
                ${r.previous.cname[i]}
                </td>
                <td>
            <select name="selectFacultyName[]"  class="selectAllFaculty multiple-select"data-live-search="true" style="width: 100%;" multiple disabled>`;
                for (let i = 0; i < r.FacultyName.length; i++) {
                    html = html + `<option value="${r.fid[i]}">`;
                    html = html + `${r.FacultyName[i]}`;
                    html = html + ` </option>`;
                }
                html = html + `</select></td>
                <td style="display:flex;justify-content:center">
            <button type="button" class="btn btn-info selectDetailsBtn" data-toggle = "modal" data-target="#${r.previous.cid[i]}"  id="${r.previous.cid[i]}" data-courseid= ${r.previous.cid[i]} data-facultyid= ${r.previous.fid[i]}>SHOW</button></td>
                </tr>
                <div class="modal fade showFNC" id="${r.previous.cid[i]}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>COURSE NAME</b>: ${r.previous.cname[i]}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <b>FACULTIES NAME</b>: ${r.previous.fname[i]}`
                html = html + `</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>`
            }
        }
    }
    html = html +
        `</tbody></table>`;
    return html;
}

function getFaculty1(r) {
    let html = '';
    html = html + `<option value=-1 disabled>Please Select</option>`;
    for (let i = 0; i < r.length; i++) {
        html = html + `<option value="${r[i].fid}">`;
        html = html + `${r[i].FacultyName}`;
        html = html + ` </option>`;
    }
    return html;
}

function loadSession2() {
    $.ajax({
        url: "/workspace/businessAjax/courseAssignAJAX.php",
        type: "POST",
        dataType: "json",
        data: {
            action: "getSessionHTML"
        },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            // console.log(result);
            $("#overlay").fadeOut();
            html = getddlSessionHTML1(result);
            $("#SelectSession").html(html);

        },
        error: function(e) {
            console.log(e);
            alert("something went wrong");
            $("#overlay").fadeOut();
        },
    });
}

$(function(e) {
    loadSession2();

    $(document).on("change", "#divSelect", function() {

        let e = document.getElementById("divSelect");
        let optionValue = e.options[e.selectedIndex].text;
        let termType = optionValue.slice(5);
        let termYear = optionValue.slice(0, 4);
        $("#termYear").val(termYear);
        $("#termType").val(termType);
        $("#showDetails").html('');
        $.ajax({
            url: "/workspace/businessAjax/courseAssignAJAX.php",
            type: "POST",
            dataType: "json",
            data: {
                termYear: termYear,
                termType: termType,
                action: "loadCoursesAndFaculty"
            },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                console.log(result);
                $("#overlay").fadeOut();
                let html = displayCoursesNFaculty1(result);
                // $(".multiple-select").select2({
                //     //maximumSelectionLength: 2

                // });
                $("#showDetails").html('');
                $("#showDetails").html(html);
                $.ajax({
                    url: "/workspace/businessAjax/courseAssignAJAX.php",
                    type: "POST",
                    dataType: "json",
                    data: { action: "allFaculty" },
                    beforeSend: function() {},
                    success: function(result) {
                        console.log(result);
                        let html = getFaculty1(result);
                        $(".multiple-select").select2({
                            //maximumSelectionLength: 2

                        });
                        $(".selectAllFaculty").html(html);
                    },
                    error: function(e) {
                        console.log(e);
                        $("#overlay").fadeOut();
                    },
                });
            },
            error: function(e) {
                console.log(e);
                $("#showDetails").html(`<div style="margin-left:450px"> <b>Please Select Something</b></div>`);
                $("#overlay").fadeOut();
            },
        });
    })
   
    $(document).on("click","#submit",function(){
     
        let data=$(this).data('selectid');
        let courseID = $(this).data('courseid');
        let sessionId = $(this).data('sessionid');
        var selected = [];
        for (var option of document.getElementById(`${data}`).options)
        {
            if (option.selected) {
                selected.push(option.value);
            }
        }
      const array = Object.values(selected); 
       console.log(typeof(array));
       console.log(array);
       $.ajax({
        url: "/workspace/businessAjax/courseAssignAJAX.php",
        type: "POST",
        dataType: "json",
        data: {courseID:courseID,facultySelected:array,sessionId:sessionId,
            action: "updateFacultyCourseRelation"
        },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            console.log(result);
            $("#overlay").fadeOut();
            alert("Faculties are updated!");

        },
        error: function(e) {
            alert("YOU CAN'T SELECT SAME FACULTY FOR THE SAME COURSE! ERROR IN INSERTION");
            $("#overlay").fadeOut();
        },
    });
    })
    
    $(document).on("click","#delete",function(){
        let courseID = $(this).data('courseid');
        let sessionId = $(this).data('sessionid');
       $.ajax({
        url: "/workspace/businessAjax/courseAssignAJAX.php",
        type: "POST",
        dataType: "json",
        data: {courseID:courseID,sessionId:sessionId,
            action: "deleteFacultyCourseRelation"
        },
        beforeSend: function() {
            $("#overlay").fadeIn();
        },
        success: function(result) {
            console.log(result);
            $("#overlay").fadeOut();
            alert("Faculties are Deleted!");

        },
        error: function(e) {
            alert("YOU CAN'T SELECT SAME FACULTY FOR THE SAME COURSE! ERROR IN INSERTION");
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