<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM tenants where id= ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k=$val;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-tenant">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">Full Name <span style="color:red">*</span></label>
				<input type="text" class="form-control" name="fullname"  value="<?php echo isset($fullname) ? $fullname :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">NID No</label>
				<input type="text" class="form-control" name="nid"  value="<?php echo isset($nid) ? $nid :'' ?>">
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">House Rent <span style="color:red">*</span></label>
				<input type="text" class="form-control" name="rent"  value="<?php echo isset($rent) ? $rent :'' ?>" required>
			</div>

		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Family Member <span style="color:red">*</span></label>
				<input type="text" class="form-control" name="fmember"  value="<?php echo isset($fmember) ? $fmember :'' ?>" required>
			</div>	
			<div class="col-md-4">
				<label for="" class="control-label">Contact No <span style="color:red">*</span></label>
				<input type="text" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Apartment No <span style="color:red">*</span></label>
				<select name="house_id" id="products" class="custom-select select2">
					<option value=""></option>
					<?php 
					$house = $conn->query("SELECT * FROM houses where id not in (SELECT house_id from tenants where status = 1) ".(isset($house_id)? " or id = $house_id": "" )." ");
					while($row= $house->fetch_assoc()):
						?>
						<option value="<?php echo $row['id'] ?>" 
							<?php echo isset($house_id) && $house_id == $row['id'] ? 'selected' : '' ?>  data-price="<?php echo $row['house_no']; ?>" >
							<?php echo $row['house_no'] ?>							
						</option>
					<?php endwhile; ?>
				</select>		
				<!-- <input class="form-control" type="hidden" name="house_no" id="priceInput"  ></br> -->
				<input class="form-control" type="hidden" value="<?php echo isset($house_no) ? $house_no :'' ?>" name="house_no" id="priceInput"  ></br>		
			</div>
			<div class="col-md-4">
				<label for="" class="control-label"> Date <span style="color:red">*</span></label>
				<input type="date" class="form-control" name="date_in"  value="<?php echo isset($date_in) ? date("Y-m-d",strtotime($date_in)) :'' ?>" required>
			</div>
		</div>
	</form>
</div>
<script>
	$(function () {
		$('#products').change(function () {
			$('#priceInput').val($('#products option:selected').attr('data-price'));
		});
	});
	
	$('#manage-tenant').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_tenant',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
</script>