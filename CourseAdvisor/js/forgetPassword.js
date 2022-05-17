$(document).ready((function(e) {


    $(document).on("click", "#gotp", function(e) {

        var un = $("#txtID").val();

        var trimmedUn = un.trim();
        var lun = trimmedUn.length;

        if (lun != 0) {
            $("#lblErrorMessage").text("");

            //MAKE AN AJAX CALL
            $.ajax({
                url: "/workspace/businessAjax/forgetPasswordAJAX.php",
                type: "POST",
                dataType: "json",
                data: { username: trimmedUn, action: "generateMail" },
                beforeSend: function() {
                    $("#overlay").fadeIn();
                },
                success: function(result) {
                    $("#overlay").fadeOut();
                    if (result.status == "OK") {
                        $("#lblErrorMessage").text("OTP has been sent to your mail");

                    } else {
                        console.log(result);
                        $("#lblErrorMessage").text(`INVALID EMAIL ENTERED`);
                    }

                },
                error: function(e) {
                 //   alert(e);
                 console.log(e);
                },
            })

        } else {
            $("#lblErrorMessage").text("Invalid input");
        }

    });
    $(document).on("click", "#votp", function(e) {
      
      //  alert("clicked");
        var pw = $("#txtPassword").val();

        var trimmedpw = pw.trim();
        var lpw = trimmedpw.length;

        if (lpw != 0) {
            $("#lblErrorMessage").text("");

            $.ajax({
                url: "/workspace/businessAjax/forgetPasswordAJAX.php",
                type: "POST",
                dataType: "json",
                data: { otp: trimmedpw, action: "verifyOTP" },
                beforeSend: function() {

                },
                success: function(result) {
                    if (result.status == "OK") {
                        let html = getReplaceForm();
                        $("#replace").html(html);
                        $("#lblErrorMessage").text(`Enter the new password`);

                    } else {
                        $("#lblErrorMessage").text("INVALID OTP ENTERED");
                    }

                },
                error: function(e) {
                    console.log(e);
                    $("#lblErrorMessage").text("INVALID OTP ENTERED");
                },
            })

        } else {
            $("#lblErrorMessage").text("INVALID INPUT");
        }

    });

    $(document).on("click", "#btnBack", function() {
        document.location.replace("/workspace/CourseAdvisor/login.php");
    });

    $(document).on("click","#savePassword",function(){
        var un = $("#firstP").val();
        var pw = $("#secondP").val();

        var trimmedfp = un.trim();
        var lun = trimmedfp.length;

        var trimmedcp = pw.trim();
        var lpw = trimmedcp.length;

        if(trimmedfp===trimmedcp)
          {
            $("#lblErrorMessage").text("");
             //MAKE AN AJAX CALL
             $.ajax({
                url: "/workspace/businessAjax/forgetPasswordAJAX.php",
                type: "POST",
                dataType: "json",
                data: { password: trimmedfp, action: "updatePassword" },
                beforeSend: function() {
                   // $("#overlay").fadeIn();
                },
                success: function(result) {
                   // $("#overlay").fadeOut();
                   console.log(result);
                    if (result.status == "OK") {
                        swal({
                            title: "Password has been successfully updated",
                            text: "Do you want to redirect to the LOGIN page?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                          })
                          .then((willDelete) => {
                            if (willDelete) {
                              swal("hold your sitbelt,you will be in LOGIN page in a second!", {
                                icon: "success",
                              });
                              document.location.replace("/workspace/CourseAdvisor/login.php")
                            } else {
                              swal("Use the back key to return to the login page!");
                            }
                          });
                       
                    } else {
                        console.log(result);
                        $("#lblErrorMessage").text(`SOME ERROR HAS OCCURED,PLEASE TRY AGAIN LATER`);
                    }

                },
                error: function(e) {
                   // alert(e);
                   console.log(e);
                },
            })
          }
        else
         {
            $("#lblErrorMessage").text("PASSWORD DONOT MATCHED");
         }

    })
}))


function getReplaceForm() {
         let html = `<div class="txt-field">
                         <input  type="password" id="firstP" required>
                         <span></span>
                         <label for="">Enter New Password</label>
                  </div>
                  <div id="overlay" style="display:none;">
                        <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
                        <br/>
                        Please Wait. It might take a few minutes.
                  </div>
                  <div class="txt-field">
                       <input type="password" id="secondP"  required>
                       <span></span>
                       <label for="">Confirm Password</label>
                 </div>
                 <div id="lblErrorMessage"></div> 
                 <div class="loginButton">
                    <input type="submit" value="SAVE" id="savePassword">
                </div>`;
         return html;

  }