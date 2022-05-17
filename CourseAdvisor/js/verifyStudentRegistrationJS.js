
function getAssignedStudents(studentList) 
 
 {
    let html = `<div>`;
    let colorCode;
    let sta;
    for (let i = 0; i < studentList.length; i++)
      {
        if (studentList[i].status == "Y") {
            colorCode = "verified";
            sta = "Verified";
        } else {
            colorCode = "notverified";
            sta = "Not Verified";
        }
        html = html + `<div class="border border-warning myStudent ${colorCode} studentCard" style="padding:2%;"  id=${studentList[i]['sid']} data-studentname=${studentList[i]['senroll']}>
                       <div> SL NO : ${i+1} </div> 
                       <div>${studentList[i]['senroll']}</div>
                       <div>${studentList[i]['sname']}</div>
                       <div>${sta}</div>
      </div>`;
      }
    html = html + `</div>`;
    return html;
}


function getColumns()
 {
    let html = `<div class="container"><div class="row"><div class="col-2 REPLACE" style="padding:inherit">`;

    //html = html + getAssignedStudents(studentList);
    html = html + `</div>`;

    html = html + `
  <div class="col-10 " id="studentDetails">
  </div></div></div>`;

    $("#divMainContainer").html(html);
 }

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
            // console.log(result);
            let html = getAssignedStudents(result);
            $(".REPLACE").html(html);


        },
        error: function() {
            alert("something went wrong");
            $("#overlay").fadeOut();
        },
    });

}

function getStudentDetails(r,data) {

    // FOR THE STATISTICS
    let html = `<div class="container" style="margin-top:2%;">`;
    html = html + `<div><b>Details of</b> : <B>${data}</B></div>`;
    html = html + `<div class="row" style="margin-bottom:1%;"><div class="col-12 text-center "><div class="btn btn-success">STATISTICS</div></div></div>`;

    let cgpa;
    let credit;
    if (r.length == 0) {
        cgpa = 0;
        credit = 0;
    } else {
        cgpa = r[0];
        credit = r[1];
    }
    html = html + `<div class="row "><div class="col-12"><div class="container border-top border-bottom"><div class="row">
     <div class="col ">
     <span class="d-flex align-items-center justify-content-left">
     <span class="d-flex flex-column" style="margin-left:3%; margin-right:3%">
       <span  class = "firstHeader">CGPA</span>
       <span  class = "secondHeader">${cgpa}</span>
     </span></span></div>
     
     
     <div class="col ">
     <span class="d-flex align-items-center justify-content-left">
     <span class="d-flex flex-column" style="margin-left:3%; margin-right:3%">
       <span  class = "firstHeader">COMPLETED CREDIT</span>
       <span class = "secondHeader">${credit}</span>
     </span></span></div>
                    </div></div></div></div>`;

    // FOR THE COMPLETED COURSES
    html = html + `<div class="row" style="margin-top:2%;"><div class="col-12 text-center"><div class="btn btn-success" id="btnCompleted">COMPLETED COURSES</div></div></div>
                     <div class="row divCompleted" style="margin-top:1%;">
                     
                     </div>`;

    // FOR THE UNSUCCESSFUL COURSES
    html = html + `<div class="row" style="margin-top:2%;"><div class="col-12 text-center"><div class="btn btn-success" id="btnUnsuccessful">UNSUCCESSFUL COURSES</div></div></div>
                     <div class="row divUnsuccessful" style="margin-top:1%;"></div>`;

    //FOR THE CURRENT COURSES
    html = html + `<div class="row" style="margin-top:2%;"><div class="col-12 text-center"><div class="btn btn-success" id="btnCurrent">CURRENT COURSES</div></div></div>
                     <div class="row divCurrent" style="margin-top:1%;"></div>`;

    html = html + `<div class="row d-flex justify-content-end" style="margin-top:5%;"><div class="btn btn-success" id="btnAccept">ACCEPT</div>`;
    html = html + `</div>`;

    return html;

}

function getCompletedHTML(r) {

    html = `<div class="col-12">
     <div class="container  border-top border-bottom">
     <div class="row" style="margin:1%">
            <div class="col-12 text-center"><div class="btn btn-danger btnCompHide">X</div></div>
     </div>`;
    if (r.length == 0) {
        html = html + `<div class="row border-top border-bottom"><div class="col"><b>NO DATA FOUND</b></div></div>`;
    }

    for (let i = 0; i < r.length; i++) {

        html = html + ` <div class="row border-top border-bottom">
         <div class="col-lg-5 col-md-12 col-sm-12 ">
                            <div>
                                <span class="d-flex flex-column align-items-start">
                                <span class="d-flex firstHeader"><span>${i+1}. </span>
                                <span> ${r[i].ccode}</span>
                                </span>
                                <span class="d-flex text-left align-items-start secondHeader">${r[i].cname}</span></span>
                            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-12 ">
         <div>
            <span class="d-flex align-items-center justify-content-left">
              <span class="d-flex flex-column" style="margin-left:3%; margin-right:3%">
                <span  class = "firstHeader">L</span>
                <span class = "secondHeader">${r[i].l}</span>
              </span>
              <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
                <span  class = "firstHeader">T</span>
                <span  class = "secondHeader">${r[i].t}</span>
              </span>
              <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
                <span  class = "firstHeader">P</span>
                <span  class = "secondHeader">${r[i].p}</span>
              </span>
              <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
                <span  class = "firstHeader">S</span>
                <span  class = "secondHeader">${r[i].s}</span>
              </span>
              <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
                <span  class = "firstHeader">CR</span>
                <span  class = "secondHeader">${r[i].cr}</span>
              </span>
            </span>
         </div>
         </div>
         <div class="col-lg-2 col-md-6 col-sm-12">
         <div>
         <span class="d-flex align-items-center justify-content-left">
         <span class="d-flex flex-column" style=" margin-right:7%">
           <span  class = "firstHeader">CATEGORY</span>
           <span  class = "secondHeader">${r[i].category}</span>
         </span>
         </span>
         </div>
         </div>

         <div class="col-lg-2 col-md-6 col-sm-12">
         <div>
         <span class="d-flex align-items-center justify-content-left">
         <span class="d-flex flex-column" style=" margin-right:7%">
           <span  class = "firstHeader">GRADE</span>
           <span  class = "secondHeader">${r[i].grade}</span>
         </span>
         </span>
         </div>
         </div>
         </div>`;
    }
    html = html + `</div></div>`;
    return html;

}

function getUnsuccessfulHTML(r) {

    html = `<div class="col-12"><div class="container  border-top border-bottom"><div class="row" style="margin:1%"><div class="col-12 text-center"><div class="btn btn-danger btnUnHide">X</div>
     </div>
     </div>`;

    if (r.length == 0) {
        html = html + `<div class="row border-top border-bottom"><div class="col"><b>NO DATA FOUND</b></div></div>`;
    }

    for (let i = 0; i < r.length; i++) {
        html = html + ` <div class="row border-top border-bottom">
        <div class="col-lg-5 col-md-12 col-sm-12">
                           <div>
                               <span class="d-flex flex-column align-items-start">
                               <span class="d-flex firstHeader"><span>${i+1}. </span>
                               <span> ${r[i].ccode}</span>
                               </span>
                               <span class="d-flex text-left align-items-start secondHeader">${r[i].cname}</span></span>
                           </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
        <div>
           <span class="d-flex align-items-center justify-content-left">
             <span class="d-flex flex-column" style="margin-left:3%; margin-right:3%">
               <span  class = "firstHeader">L</span>
               <span class = "secondHeader">${r[i].l}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">T</span>
               <span  class = "secondHeader">${r[i].t}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">P</span>
               <span  class = "secondHeader">${r[i].p}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">S</span>
               <span  class = "secondHeader">${r[i].s}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">CR</span>
               <span  class = "secondHeader">${r[i].cr}</span>
             </span>
           </span>
        </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12">
        <div>
        <span class="d-flex align-items-center justify-content-left">
        <span class="d-flex flex-column" style=" margin-right:7%">
          <span  class = "firstHeader">CATEGORY</span>
          <span  class = "secondHeader">${r[i].category}</span>
        </span>
        </span>
        </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-12">
        <div>
        <span class="d-flex align-items-center justify-content-left">
        <span class="d-flex flex-column" style=" margin-right:7%">
          <span  class = "firstHeader">GRADE</span>
          <span  class = "secondHeader">${r[i].grade}</span>
        </span>
        </span>
        </div>
        </div>
        </div>`;

    }
    html = html + `</div></div>`;
    return html;

}

function getCurrentHTML(r) {

    html = `<div class="col-12"><div class="container border-top border-bottom"><div class="row" style="margin:1%"><div class="col-12 text-center"><div class="btn btn-danger btnCurHide">X</div></div></div>`;
    if (r.length == 0) {
        html = html + `<div class="row border-top border-bottom"><div class="col"><b>NO DATA FOUND</b></div></div>`;
    }

    for (let i = 0; i < r.length; i++) {
        html = html + ` <div class="row border-top border-bottom">
        <div class="col-lg-3 col-md-12 col-sm-12">
                           <div>
                               <span class="d-flex flex-column align-items-start">
                               <span class="d-flex firstHeader"><span>${i+1}. </span>
                               <span> ${r[i].ccode}</span>
                               </span>
                               <span class="d-flex text-left align-items-start secondHeader">${r[i].cname}</span></span>
                           </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
        <div>
           <span class="d-flex align-items-center justify-content-left">
             <span class="d-flex flex-column" style="margin-left:3%; margin-right:3%">
               <span  class = "firstHeader">L</span>
               <span class = "secondHeader">${r[i].l}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">T</span>
               <span  class = "secondHeader">${r[i].t}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">P</span>
               <span  class = "secondHeader">${r[i].p}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">S</span>
               <span  class = "secondHeader">${r[i].s}</span>
             </span>
             <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
               <span  class = "firstHeader">CR</span>
               <span  class = "secondHeader">${r[i].cr}</span>
             </span>
           </span>
        </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12">
        <div>
        <span class="d-flex align-items-center justify-content-left">
        <span class="d-flex flex-column" style=" margin-right:7%">
          <span  class = "firstHeader">CATEGORY</span>
          <span  class = "secondHeader">${r[i].category}</span>
        </span>
        </span>
        </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-12">
        <div>
        <span class="d-flex align-items-center justify-content-left">
        <span class="d-flex flex-column" style="margin-right:7%">
          <span  class = "firstHeader">GRADE</span>
          <span  class = "secondHeader">${r[i].grade}</span>
        </span>
        </span>
        </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 mt-1">
        <button class="btn btn-danger btnRemove" id="${r[i].cid}">REMOVE</button>
        </div>
        </div>`;

    }
    html = html + `<div class="row" style="margin-top:2%"><div class="col-12 text-center"><b>OPEN ELECTIVE</b></div></div>`;
    // for (let j = 0; j < r.OEList.length; j++) {
    //     html = html + `<div class="row" style="margin-top:2%"><div class="col-12"><b>OPEN ELECTIVE ${j+1}</b></div></div>`;
    //     for (let k = 0; k < r.OEList[j].priorityList.length; k++) {

    //         html = html + ` <div class="row border-top border-bottom">
    //     <div class="col-lg-6 col-md-12 col-sm-12">
    //                        <div>
    //                            <span class="d-flex flex-column align-items-start">
    //                            <span class="d-flex firstHeader"><span>PRIORITY ${k+1}: </span>
    //                            <span> ${r.OEList[j].priorityList[k].code}</span>
    //                            </span>
    //                            <span class="d-flex text-left align-items-start secondHeader">${r.OEList[j].priorityList[k].name}</span></span>
    //                        </div>
    //     </div>
    //     <div class="col-lg-4 col-md-6 col-sm-12">
    //     <div>
    //        <span class="d-flex align-items-center justify-content-left">
    //          <span class="d-flex flex-column" style="margin-left:3%; margin-right:3%">
    //            <span  class = "firstHeader">L</span>
    //            <span class = "secondHeader">${r.OEList[j].priorityList[k].l}</span>
    //          </span>
    //          <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
    //            <span  class = "firstHeader">T</span>
    //            <span  class = "secondHeader">${r.OEList[j].priorityList[k].t}</span>
    //          </span>
    //          <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
    //            <span  class = "firstHeader">P</span>
    //            <span  class = "secondHeader">${r.OEList[j].priorityList[k].p}</span>
    //          </span>
    //          <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
    //            <span  class = "firstHeader">S</span>
    //            <span  class = "secondHeader">${r.OEList[j].priorityList[k].s}</span>
    //          </span>
    //          <span class="d-flex flex-column" style="margin-left:7%; margin-right:7%">
    //            <span  class = "firstHeader">CR</span>
    //            <span  class = "secondHeader">${r.OEList[j].priorityList[k].cr}</span>
    //          </span>
    //        </span>
    //     </div>
    //     </div>
    //     <div class="col-lg-2 col-md-6 col-sm-12">
    //     <div>
    //     <span class="d-flex align-items-center justify-content-left">
    //     <span class="d-flex flex-column" style=" margin-right:7%">
    //       <span  class = "firstHeader">CATEGORY</span>
    //       <span  class = "secondHeader">${r.OEList[j].priorityList[k].category}</span>
    //     </span>
    //     </span>
    //     </div>
    //     </div>
    //     </div>`;
    //     }
    // }
    html = html + `</div></div>`;
    return html;

}

function getddlSessionHTML(r) {
    let html = `<select name="selectDiv" id="divSelect" style="width: 100%;">`;
    html = html + `<option value=-1>Please Select</option>`;
    for (let i = 0; i < r.length; i++) {
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
    getColumns();
    loadSession();
    $(document).on("click", ".myStudent", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = this.id;
        $("#studentId").val(studentId);
        let data=$(this).data('studentname');


        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, studentId: studentId, action: "getStudentDetails" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                // alert(studentId);
                console.log(result);
                let html = getStudentDetails(result,data);
                $("#studentDetails").html(html);

                $.ajax({
                    url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
                    type: "POST",
                    dataType: "json",
                    data: { termYear: termYear, termType: termType, studentId: studentId, action: "getCompletedCourses" },
                    beforeSend: function() {
                    },
                    success: function(result) {
                        $("#overlay").fadeOut();
                        console.log(result);
                        let html = getCompletedHTML(result);
                        $(".divCompleted").html(html);
                    },
                    error: function(e) {
                        console.log(e);
                        alert("something went wrong");
                        $("#overlay").fadeOut();
                    },
                });

                $.ajax({
                    url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
                    type: "POST",
                    dataType: "json",
                    data: { termYear: termYear, termType: termType, studentId: studentId, action: "getUnsuccessfulCourses" },
                    beforeSend: function() {
                    },
                    success: function(result) {
                        $("#overlay").fadeOut();
                        console.log(result);
                        let html = getUnsuccessfulHTML(result);
                        $(".divUnsuccessful").html(html);


                    },
                    error: function(e) {
                        console.log(e);
                        alert("something went wrong");
                        $("#overlay").fadeOut();
                    },
                });

                $.ajax({
                    url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
                    type: "POST",
                    dataType: "json",
                    data: { termYear: termYear, termType: termType, studentId: studentId, action: "getCurrentCourses" },
                    beforeSend: function() {
                      
                    },
                    success: function(result) {
                        $("#overlay").fadeOut();
                        let html = getCurrentHTML(result);
                        $(".divCurrent").html(html);
                    },
                    error: function(e) {
                        console.log(e);
                        alert("something went wrong");
                        $("#overlay").fadeOut();
                    },
                });
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });

    });

    // AJAX CALL FOR THE BUTTON COMPLETED COURSES 
    $(document).on("click", "#btnCompleted", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, studentId: studentId, action: "getCompletedCourses" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                //alert(result);
                console.log(result);
                let html = getCompletedHTML(result);
                $(".divCompleted").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
    });
    $(document).on("click", ".btnCompHide", function() {
        $(".divCompleted").html("");

    });

    // AJAX CALL FOR BUTTON UNSUCCESSFUL COURSES
    $(document).on("click", "#btnUnsuccessful", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, studentId: studentId, action: "getUnsuccessfulCourses" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                let html = getUnsuccessfulHTML(result);
                $(".divUnsuccessful").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
    });

    $(document).on("click", ".btnUnHide", function() {
        $(".divUnsuccessful").html("");

    });

    // AJAX CALL FOR BUTTON Current COURSES
    $(document).on("click", "#btnCurrent", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, studentId: studentId, action: "getCurrentCourses" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                let html = getCurrentHTML(result);
                $(".divCurrent").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
    });

    $(document).on("click", ".btnCurHide", function() {
        $(".divCurrent").html("");

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

    //ON CLICK OF THE ACTION BUTTON
    $(document).on("click", "#btnAccept", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();
        facultyId = $("#facultyId").val();

        swal({
            title: "Are you sure?",
            text: "Once Accepted, Email will be sent to the student!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Successfully Accepted,Email has been sent to the student", {
                icon: "success",
              });
              $.ajax({
                url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
                type: "POST",
                dataType: "json",
                data: { termYear: termYear, termType: termType, studentId: studentId, facultyId: facultyId, action: "onClickAccept" },
                beforeSend: function() {
                   
                },
                success: function(result) {
                 
                },
                error: function(e) {
                    console.log(e);
                    alert("Network not found");
                    $("#overlay").fadeOut();
                },
            });
            } else {
              swal("Not Accepted");
            }
          });
    })

    $(document).on("click", ".btnRemove", function() {
        courseId = this.id;
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: { termYear: termYear, termType: termType, studentId: studentId, courseId: courseId, action: "onClickRemove" },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                // console.log(studentId);
                alert(result);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
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
});