<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition ">
<script>
$(document).ready(function() {
    // Show/Hide password
    $('#showPassword').click(function() {
        const passwordField = $('#password');
        const confirmPasswordField = $('#cpassword');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        confirmPasswordField.attr('type', type);
    });

    // Real-time password match check
    $('#password, #cpassword').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $('#cpassword').val();
        const passwordHelp = $('#passwordHelp');
        
        if (password !== confirmPassword) {
            passwordHelp.removeClass('d-none');
        } else {
            passwordHelp.addClass('d-none');
        }
    });
});
</script>
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
      overflow: hidden;
    }
    body{
    background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black
    }
    /* #login{
      flex-direction:column !important
    } */
    #login{
        direction:rtl
    }
    #login > *{
        direction:ltr
    }

    #logo-img{
        height:350px;
        width:350px;
        object-fit:scale-up;
        object-position:center center;
        border-radius:100%;
    }
    /* #login .col-7,#login .col-5{
      width: 100% !important;
      max-width:unset !important
    } */
  </style>
<div class="h-100 d-flex  align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="">
        <center><img src="./uploads/2024 LOGO/logo.png" style="transform: scale(0.1)"></center>
      </div>
      
    </div>
    <div class="col-5 h-100 bg-gradient "style="background-color: light-orange; position: relative; left: 100px;">
        <div class="w-100 d-flex justify-content-center align-items-center h-100 text-navy">
            <div class="card card-outline card-success rounded-0 shadow col-lg-10 col-md-10 col-sm-5">
                <div class="card-header">
                    <h5 class="card-title text-center text-dark"><b>Registration</b></h5>
                </div>
                <div class="card-body">
                    <form action="" id="registration-form">
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="firstname" id="firstname" autofocus placeholder="Firstname" class="form-control form-control-border" required oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="middlename" id="middlename" placeholder="Middlename (optional)" class="form-control form-control-border" oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control form-control-border" required oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-auto">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="genderMale" name="gender" value="Male" required checked>
                                    <label for="genderMale" class="custom-control-label">Male</label>
                                </div>
                            </div>
                            <div class="form-group col-auto">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="genderFemale" name="gender" value="Female">
                                    <label for="genderFemale" class="custom-control-label">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span class="text-navy"><small>Department</small></span>
                                    <select name="department_id" id="department_id" class="form-control form-control-border select2" required oninput="this.value = this.value.toUpperCase()">
                                        <option selected disabled>Choose department...</option>
                                        <?php 
                                        $department = $conn->query("SELECT * FROM `department_list` where status = 1 order by `name` asc");
                                        while($row = $department->fetch_assoc()):
                                        ?>
                                        
                                        <option value="<?= $row['id'] ?>"><?= ucwords($row['name']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span class="text-navy"><small>Curriculum</small></span>
                                    <select name="curriculum_id" id="curriculum_id" class="form-control form-control-border select2" required>
                                        <option value="" disabled selected>Select Deparment First</option>
                                        <?php 
                                        $curriculum = $conn->query("SELECT * FROM `curriculum_list` where status = 1 order by `name` asc");
                                        $cur_arr = [];
                                        while($row = $curriculum->fetch_assoc()){
                                            $row['name'] = ucwords($row['name']);
                                            $cur_arr[$row['department_id']][] = $row;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" name="student_id" id="student_id" placeholder="Student ID" class="form-control form-control-border" required pattern="\d+">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-border" required>
                                    <small id="passwordError" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="password" id="cpassword" placeholder="Confirm Password" class="form-control form-control-border" required>
                                    <small id="passwordHelp" class="text-danger d-none">Passwords do not match!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="checkbox" id="showPassword"> Show Passwords
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group text-left">
                                    <a href="./index.php" class="btn btn-default bg-success btn-flat">Back</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group text-right">
                                    <button class="btn btn-default bg-success btn-flat register" >Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
<script>
        document.getElementById("password").addEventListener("input", function() {
    let passwordField = this;
    let passwordError = document.getElementById("passwordError");

    if (passwordField.value.length < 6) {
        passwordError.textContent = "Password must be at least 6 characters long.";
        passwordField.setCustomValidity("Password must be at least 6 characters long.");
    } else {
        passwordError.textContent = "";
        passwordField.setCustomValidity("");
    }
});
        var cur_arr = $.parseJSON('<?= json_encode($cur_arr) ?>');
        $(document).ready(function(){
            end_loader();
            $('.select2').select2({
                width: "100%"
            })

            $('#department_id').change(function(){
                var did = $(this).val()
                $('#curriculum_id').html("")
                if(!!cur_arr[did]){
                    Object.keys(cur_arr[did]).map(k=>{
                        var opt = $("<option>")
                        opt.attr('value',cur_arr[did][k].id)
                        opt.text(cur_arr[did][k].name)
                        $('#curriculum_id').append(opt)
                    })
                }
                $('#curriculum_id').trigger("change")
            })
            $('input[name="user_type"]').change(function () {
                var userType = $(this).val();

                if (userType === 'outsider') {
                    $('#department_id').closest('.row').hide();
                    $('#curriculum_id').closest('.row').hide();
                } else {
                    $('#department_id').closest('.row').show();
                    $('#curriculum_id').closest('.row').show();
                }
            });
            var initialUserType = $('input[name="user_type"]:checked').val();
                if (initialUserType === 'outsider') {
                    $('#department_id').closest('.row').hide();
                    $('#curriculum_id').closest('.row').hide();
                }  

            $('.register').click(function () {
                var userType = $("input[name='user_type']:checked").val();

                if (userType === 'outsider') {
                    handleOutsiderRegistration();
                }
            });

            // Registration Form Submit
            $('#registration-form').submit(function (e) {
                e.preventDefault();
                var userType = $("input[name='user_type']:checked").val();

                if (userType === 'outsider') {
                    handleOutsiderRegistration();
                } else {
                    handleStudentRegistration();
                }
            });

            function handleOutsiderRegistration() {
                var _this = $('#registration-form');
                $(".pop-msg").remove();
                $('#password, #cpassword, #email').removeClass("is-invalid");

                var el = $("<div>");
                el.addClass("alert pop-msg my-2");
                el.hide();

                if ($("#password").val() != $("#cpassword").val()) {
                    el.addClass("alert-danger");
                    el.text("Password does not match.");
                    $('#password, #cpassword').addClass("is-invalid");
                    $('#cpassword').after(el);
                    el.show('slow');
                    return false;
                }

                start_loader();
                $.ajax({
                    url: _base_url_ + "classes/Users.php?f=save_outsider",
                    method: 'POST',
                    data: _this.serialize(),
                    dataType: 'json',
                    error: function (err) {
                        console.log(err);
                        el.text("An error occurred while saving the data");
                        el.addClass("alert-danger");
                        _this.prepend(el);
                        el.show('slow');
                        end_loader();
                    },
                    success: function (resp) {
                        if (resp.status == 'success') {
                            location.href = "./outsiders.php";
                        } else if (!!resp.msg) {
                            el.text(resp.msg);
                            el.addClass("alert-danger");
                            _this.prepend(el);
                            el.show('show');
                        } else {
                            el.text("An error occurred while saving the data");
                            el.addClass("alert-danger");
                            _this.prepend(el);
                            el.show('show');
                        }
                        end_loader();
                        $('html, body').animate({ scrollTop: 0 }, 'fast');
                    }
                });
            }

            function handleStudentRegistration() {
                var _this = $('#registration-form');
                $(".pop-msg").remove();
                $('#password, #cpassword, #student_id').removeClass("is-invalid");

                var el = $("<div>");
                el.addClass("alert pop-msg my-2");
                el.hide();

                if ($("#password").val() != $("#cpassword").val()) {
                    el.addClass("alert-danger");
                    el.text("Password does not match.");
                    $('#password, #cpassword').addClass("is-invalid");
                    $('#cpassword').after(el);
                    el.show('slow');
                    return false;
                }
                var userType = $("input[name='user_type']:checked").val();
                start_loader();
                $.ajax({
                    url: _base_url_ + "classes/Users.php?f=save_student",
                    method: 'POST',
                    data: _this.serialize(),
                    dataType: 'json',
                    error: function (err) {
                        console.log(err);
                        el.text("An error occurred while saving the data");
                        el.addClass("alert-danger");
                        _this.prepend(el);
                        el.show('slow');
                        end_loader();
                    },
                    success: function (resp) {
                        if (resp.status == 'success') {
                            location.href = "./login.php";
                        } else if (!!resp.msg) {
                            el.text(resp.msg);
                            el.addClass("alert-danger");
                            _this.prepend(el);
                            el.show('show');
                        } else {
                            el.text("Student ID already exist!.");
                            el.addClass("alert-danger");
                            _this.prepend(el);
                            el.show('show');
                        }
                        end_loader();
                        $('html, body').animate({ scrollTop: 0 }, 'fast');
                    }
                });
            }
});
</script>

</body>
</html>