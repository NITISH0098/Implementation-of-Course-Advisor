$(function(e) {
    $(document).on("click", "#btnLogOut", function() {
        document.location.replace("/workspace/CourseAdvisor/logout.php")
    });
     
    $(document).on("click", "#btnBack", function() {
        document.location.replace("/workspace/CourseAdvisor/HodDashboard.php")
    });

    $(document).on("click", "#btnShowPdf", function(e) {

        var rollno = $("#rollnoID").val();
        var trimRollno = rollno.trim();
        var lenRollNo = trimRollno.length;

        if (lenRollNo != 0) {
            $("#lblErrorMessage").text("");
            $.ajax({
                url: "/workspace/businessAjax/showStudentReportAJAX.php",
                type: "POST",
                dataType: "json",
                data: { rollno:trimRollno, action: "findStudentAndShowReport" },
                beforeSend: function() {
                     
                },
                success: function(result) {
                    if (result.status == "YES") {
                      //  alert("yes");
                        console.log(result);
           
                  tt = `<br><br><iframe src="${result[0]['path']}" width="100%" height="500px">
                  </iframe>`;
                  $("#showStudentReport").html(tt);
                    } else {
                        $("#lblErrorMessage").text("INVALID ROLL NUMBER");
                    }

                },
                error: function(e) {
                    console.log(e);
                    alert(e);
                },
            })

          }
        else
          {
            $("#lblErrorMessage").text("INVALID INPUT");
          }
        
    })
})