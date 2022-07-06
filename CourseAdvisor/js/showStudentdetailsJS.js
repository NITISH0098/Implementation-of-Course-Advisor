function getStudentDetails(r) {

    // FOR THE STATISTICS
    let html = `<div class="container" style="margin-top:1%;">`;
    html = html + `<div class="row" style="margin-bottom:1%; color:#007200; font-size:20px; font-weight: bold;"><div class="col-12 text-center "><div>STATISTICS</div></div></div>`;

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
    html = html + `</div>`;

    return html;

}

function getCompletedHTML(r) {
    let html = `<div class="container" style="margin-top:1%;">`;
    html = html + `<div class="row" style="margin-bottom:1%; color:#007200; font-size:20px; font-weight: bold;"><div class="col-12 text-center "><div>COMPLETED COURSES</div></div></div>`;
    if (r.length == 0) {
        html = html + `<div class="row border-top border-bottom">
        <div class="col text-center"><b>NO DATA FOUND</b></div>
        </div>`;
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
         <div class="col-lg-2 col-md-6 col-sm-6">
         <div>
         <span class="d-flex align-items-center justify-content-left">
         <span class="d-flex flex-column" style=" margin-right:7%">
           <span  class = "firstHeader">CATEGORY</span>
           <span  class = "secondHeader">${r[i].category}</span>
         </span>
         </span>
         </div>
         </div>

         <div class="col-lg-2 col-md-6 col-sm-6">
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

    let html = `<div class="container" style="margin-top:1%;">`;
    html = html + `<div class="row" style="margin-bottom:1%; color:#007200; font-size:20px; font-weight: bold;"><div class="col-12 text-center "><div>CURRENT COURSES</div></div></div><br>`;
    if (r.length == 0) {
        html = html + `<div class="row border-top border-bottom">
        <div class="col text-center"><b>NO DATA FOUND</b></div>
        </div>`;
    } else {
        for (let i = 0; i < r.length; i++) {
            html = html + ` <div class="row border-top border-bottom" id="row${r[i].cid}">
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
            <div class="col-lg-2 col-md-6 col-sm-4">
            <div>
            <span class="d-flex align-items-center justify-content-left">
            <span class="d-flex flex-column" style=" margin-right:7%">
              <span  class = "firstHeader">CATEGORY</span>
              <span  class = "secondHeader">${r[i].category}</span>
            </span>
            </span>
            </div>
            </div>
    
            <div class="col-lg-2 col-md-6 col-sm-4">
            <div>
            <span class="d-flex align-items-center justify-content-left">
            <span class="d-flex flex-column" style="margin-right:7%">
              <span  class = "firstHeader">GRADE</span>
              <span  class = "secondHeader">${r[i].grade}</span>
            </span>
            </span>
            </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-4 mt-1">`;
            if (r[0]["totalSessionCount"] == "Yes") {
                html = html + `<button class="btn btn-danger btnRemove" id="${r[i].cid}">REMOVE</button>`


            }
            html = html + `</div></div>`;
        }
        html = html + `</div></div>`;
        if (r[0]["totalSessionCount"] == "Yes") {
            html = html + `<div class="row d-flex justify-content-end" style="margin-top:5%;"><div class="btn btn-success" id="btnAccept">ACCEPT</div>`;
        }
    }


    html = html + `</div>`;

    return html;

}

function getUnsuccessfulHTML(r) {

    let html = `<div class="container" style="margin-top:1%;">`;
    html = html + `<div class="row" style="margin-bottom:1%; color:#e01e37; font-size:20px; font-weight: bold;"><div class="col-12 text-center "><div>INCOMPLETED COURSES</div></div></div>`;
    if (r.length == 0) {
        html = html + `<div class="row border-top border-bottom">
        <div class="col text-center"><b>NO DATA FOUND</b></div>
        </div>`;
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
        <div class="col-lg-2 col-md-6 col-sm-6">
        <div>
        <span class="d-flex align-items-center justify-content-left">
        <span class="d-flex flex-column" style=" margin-right:7%">
          <span  class = "firstHeader">CATEGORY</span>
          <span  class = "secondHeader">${r[i].category}</span>
        </span>
        </span>
        </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
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

$(function(e) {
    $(document).on("click", ".Statistics", function() {
        let termType = $("#termType").val();
        let termYear = $("#termYear").val();
        let studentId = $("#studentId").val();
        let data = $("#studentName").val();
        // alert(studentId);
        // alert("c")
        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: {
                termYear: termYear,
                termType: termType,
                studentId: studentId,
                action: "getStudentDetails"
            },
            beforeSend: function() {
                // alert("before");
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                // alert(studentId);
                console.log(result);
                let html = getStudentDetails(result, data);
                $(".mainContent").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
    });

    // AJAX CALL FOR THE BUTTON COMPLETED COURSES 
    $(document).on("click", ".CompletedCourse", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: {
                termYear: termYear,
                termType: termType,
                studentId: studentId,
                action: "getCompletedCourses"
            },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                //alert(result);
                console.log(result);
                let html = getCompletedHTML(result);
                $(".mainContent").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
    });

    // AJAX CALL FOR BUTTON UNSUCCESSFUL COURSES
    $(document).on("click", ".IncompletedCourses", function() {
        termYear = $("#termYear").val();
        termType = $("#termType").val();
        studentId = $("#studentId").val();

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: {
                termYear: termYear,
                termType: termType,
                studentId: studentId,
                action: "getUnsuccessfulCourses"
            },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                let html = getUnsuccessfulHTML(result);
                $(".mainContent").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
    });

    // AJAX CALL FOR BUTTON Current COURSES
    $(document).on("click", ".CurrentCourses", function() {
        let termYear = $("#termYear").val();
        let termType = $("#termType").val();
        let studentId = $("#studentId").val();
        let recSessionID = $("#sessionID").val();
        console.log(recSessionID);

        $.ajax({
            url: "/workspace/businessAjax/verifyStudentRegistrationAJAX.php",
            type: "POST",
            dataType: "json",
            data: {
                termYear: termYear,
                termType: termType,
                studentId: studentId,
                recSessionID: recSessionID,
                action: "getCurrentCourses"
            },
            beforeSend: function() {
                $("#overlay").fadeIn();
            },
            success: function(result) {
                $("#overlay").fadeOut();
                console.log(result);
                let html = getCurrentHTML(result);
                $(".mainContent").html(html);
            },
            error: function(e) {
                console.log(e);
                alert("something went wrong");
                $("#overlay").fadeOut();
            },
        });
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
        // alert(studentId);
        // alert(facultyId);

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
                             //  alert(result);
                               console.log(result);
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
                $(`#row${courseId}`).html("");
                

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
        document.location.replace("/workspace/CourseAdvisor/verifyStudentRegistration.php")
    });


});