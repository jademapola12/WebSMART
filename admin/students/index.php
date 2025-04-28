<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    .img-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        object-position: center center;
        border-radius: 100%;
    }
    a.disabled {
        pointer-events: none;
        cursor: default;
    }
</style>
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">List of Students</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Status</th>
                            <th>Expiration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                             $today = date("Y-m-d");
                            $conn->query("UPDATE student_list SET status = 0 WHERE expiration_date IS NOT NULL AND expiration_date < '$today'");                        
                            $i = 1;
                            $today = date("Y-m-d");
                            $qry = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename) as name FROM student_list ORDER BY name ASC");
                            while ($row = $qry->fetch_assoc()): 
                                $expiration_date = $row['expiration_date'] ?? 'No Expiration';

                                // If the expiration date has passed, update the status to "Not Verified"
                                if ($row['expiration_date'] != NULL && $row['expiration_date'] <= $today) {
                                    $conn->query("UPDATE student_list SET status = 0 WHERE id = {$row['id']}");
                                    $row['status'] = 0;
                                }
                        ?>
                            <tr id="student-<?php echo $row['id']; ?>">
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class="text-center">
                                    <img src="<?php echo validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar">
                                </td>
                                <td><?php echo ucwords($row['name']) ?></td>
                                <td><p class="m-0 truncate-1"><?php echo $row['student_id'] ?></p></td>
                                <td class="text-center status-badge">
                                    <?php if ($row['status'] == 1): ?>
                                        <span class="badge badge-pill badge-success">Verified</span>
                                    <?php else: ?>
                                        <span class="badge badge-pill badge-primary">Not Verified</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center expiration-date">
                                    <?php 
                                        if ($expiration_date == 'No Expiration') {
                                            echo '<span class="badge badge-secondary">No Expiration</span>';
                                        } elseif ($expiration_date < $today) {
                                            echo '<span class="badge badge-danger">Expired (' . $expiration_date . ')</span>';
                                        } else {
                                            echo '<span class="badge badge-warning">' . $expiration_date . '</span>';
                                        }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Action
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a type="button" class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">
                                                <span class="fa fa-eye text-dark"></span> View
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item set_expiration" href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-name="<?= $row['student_id'] ?>">
                                                <span class="fa fa-calendar text-warning"></span> Set Expiration Date
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item reset_password" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-name="<?= $row['student_id'] ?>">
                                                <span class="fa fa-key text-info"></span> Reset Password
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-name="<?= $row['student_id'] ?>">
                                                <span class="fa fa-trash text-danger"></span> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Setting Expiration Date -->
<div class="modal fade" id="expirationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Expiration Date</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="student_id">
                <label for="expiration_date">Expiration Date:</label>
                <input type="date" id="expiration_date" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_expiration">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

      
$(document).ready(function() {
    // Handle Set Expiration Date
    $(document).ready(function() {
    $(".set_expiration").click(function() {
        var student_id = $(this).data("id");
        $("#student_id").val(student_id);
        $("#expirationModal").modal("show");
    });

    $("#save_expiration").click(function() {
        var student_id = $("#student_id").val();
        var expiration_date = $("#expiration_date").val();

        if (!expiration_date) {
            alert("Please select an expiration date.");
            return;
        }

        $.ajax({
            url: "http://localhost/WebSMART/admin/students/update_expiration.php",
            type: "POST",
            data: { id: student_id, expiration_date: expiration_date },
       
            success: function(response) {
                const res = JSON.parse(response);

                if (res.status === "success") {
                    // Update expiration date column
                    $("#student-" + student_id + " .expiration-date").html(`<span class="badge ${res.status_class}">${res.expiration_date}</span>`);

                    // Update status badge
                  $("#student-" + student_id + " .expiration-date").html(`<span class="badge ${res.exp_class}">${res.expiration_date}</span>`);

                    
                    alert("Expiration date and status updated successfully!");location.reload()
                } else if(res.status === "error"){
                    alert(res.message)
                }
                $("#expirationModal").modal("hide");
            },
            error: function(xhr, status, error) {
                console.log("Error:", xhr); // Log error message
                //alert("An error occurred while updating the expiration date.");
            }
        });
    });
});


    // Handle Reset Password
    $(".reset_password").click(function() {
    var student_id = $(this).data("id");
    var student_name = $(this).data("name");

    if (confirm("Are you sure you want to reset the password for Student ID: " + student_name + "?")) {
        $.ajax({
            url: "http://localhost/WebSMART/admin/students/reset_password.php",
            method: "POST",
            data: { student_id: student_id },
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Password has been reset to 'ABCDEF'.");
                } else {
                    alert("Failed to reset password. Please try again.");
                }
            },
            error: function() {
                alert("An error occurred while resetting the password.");
            }
        });
    }
});

    // Delete student
    $('.delete_data').click(function() {
        _conf("Are you sure to delete <b>" + $(this).attr('data-name') + "</b> from Student List permanently?", "delete_user", [$(this).attr('data-id')])
    });

    // View student details
    $('.view_details').click(function() {
        uni_modal('Student Details', "students/view_details.php?id=" + $(this).attr('data-id'), 'mid-large')
    });

    // DataTable initialization
    $('.table').dataTable({
        "responsive": true,
        "autoWidth": false
    });
});

// Function for deleting student
function delete_user($id) {
    start_loader();
    $.ajax({
        url: _base_url_ + "classes/Users.php?f=delete_student",
        method: "POST",
        data: { id: $id },
        dataType: "json",
        error: err => {
            console.log(err);
            alert_toast("An error occurred.", 'error');
            end_loader();
        },
        success: function(resp) {
            if (typeof resp == 'object' && resp.status == 'success') {
                location.reload();
            } else {
                alert_toast("An error occurred.", 'error');
                end_loader();
            }
        }
    });
}
</script>

