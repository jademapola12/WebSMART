<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-success">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "": 'required' ?>>
                    <?php if(isset($_GET['id'])): ?>
					<small class="text-info"><i>Leave this blank if you don't want to change the password.</i></small>
                    <?php endif; ?>
				</div>
				<div class="form-group col-6">
					<label for="type">User Type</label>
					<select name="type" id="type" class="form-control" required>
						<option value="" disabled <?php echo !isset($meta['type']) ? 'selected' : '' ?>>Select User Type</option>
						<option value="1" <?php echo (isset($meta['type']) && $meta['type'] == 1) ? 'selected' : '' ?>>Administrator</option>
						<option value="2" <?php echo (isset($meta['type']) && $meta['type'] == 2) ? 'selected' : '' ?>>UREC Member</option>
						<option value="3" <?php echo (isset($meta['type']) && $meta['type'] == 3) ? 'selected' : '' ?>>Research Teacher</option>
					</select>
				</div>

				<div class="form-group col-6">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" accept="image/png, image/jpeg, image/jpg" onchange="validateImage(this)">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				<div class="form-group col-6 d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
				<a class="btn btn-sm btn-secondary" href="./?page=user/list">Cancel</a>
			</div>
		</div>
	</div>
</div>

<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100%;
	}
</style>

<script>
	function validateImage(input) {
	    const file = input.files[0];
	    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

	    if (file) {
	        if (!allowedTypes.includes(file.type)) {
	            alert('Please upload a valid image file (JPG, JPEG, PNG only).');
	            input.value = ''; // Reset the input field
	            $('#cimg').attr('src', ''); // Clear the preview
	        } else {
	            displayImg(input);
	        }
	    }
	}

	function displayImg(input) {
	    if (input.files && input.files[0]) {
	        const reader = new FileReader();
	        reader.onload = function (e) {
	            $('#cimg').attr('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$('#manage-user').submit(function(e){
		e.preventDefault();
		var _this = $(this);
		start_loader();
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success:function(resp){
				if(resp == 1){
					location.href = './?page=user/list';
				} else {
					$('#msg').html('<div class="alert alert-danger">Username already exists</div>');
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
				end_loader();
			}
		})
	});
</script>
