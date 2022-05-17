$(document).ready((function(e) {


    $(document).on("click", "#btnLogin1", function(e) {

        var un = $("#txtID").val();
        var pw = $("#txtPassword").val();

        var trimmedUn = un.trim();
        var lun = trimmedUn.length;

        var trimmedpw = pw.trim();
        var lpw = trimmedpw.length;

        if (lun != 0 && lpw != 0) {
            $("#lblErrorMessage").text("");

            //MAKE AN AJAX CALL
            $.ajax({
                url: "/workspace/businessAjax/loginAjax.php",
                type: "POST",
                dataType: "json",
                data: { username: trimmedUn, password: trimmedpw, action: "loginHandlerHOD" },
                beforeSend: function() {

                },
                success: function(result) {
                    if (result.status == "OK") {
                        document.location.replace("/workspace/CourseAdvisor/courseAdvisor.php")

                    } else {
                        $("#lblErrorMessage").text("INVALID USERNAME AND PASSWORD");
                    }

                },
                error: function(e) {
                    console.log(e);
                    alert(e);
                },
            })

        } else {
            $("#lblErrorMessage").text("Invalid input");
        }

    });
    $(document).on("click", "#btnLogin2", function(e) {

        var un = $("#txtID").val();
        var pw = $("#txtPassword").val();

        var trimmedUn = un.trim();
        var lun = trimmedUn.length;

        var trimmedpw = pw.trim();
        var lpw = trimmedpw.length;

        if (lun != 0 && lpw != 0) {
            $("#lblErrorMessage").text("");

            //MAKE AN AJAX CALL
            $.ajax({
                url: "/workspace/businessAjax/loginAjax.php",
                type: "POST",
                dataType: "json",
                data: { username: trimmedUn, password: trimmedpw, action: "loginHandlerFaculty" },
                beforeSend: function() {

                },
                success: function(result) {
                    if (result.status == "OK") {
                        document.location.replace("/workspace/CourseAdvisor/dashboard.php")
                    } else {
                        $("#lblErrorMessage").text("INVALID USERNAME AND PASSWORD");
                    }

                },
                error: function(e) {
                    console.log(e);
                    alert("error");
                },
            })

        } else {
            $("#lblErrorMessage").text("Invalid input");
        }

    });
    $(document).on("click", "#forgetPwd", function(e) {
        document.location.replace("/workspace/CourseAdvisor/forgetPassword.php");
    });
}))