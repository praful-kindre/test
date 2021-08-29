<!DOCTYPE html>
<html>
	<head>
		<title>Students</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<br />
			
			<h3 align="center">Students List</h3>
			<br />
			<div align="right" style="margin-bottom:5px;">
				<button type="button" name="add_button" id="add_button" class="btn btn-success btn-sm">Add Student Record</button>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Student Name</th>
							<th>Student DOB</th>
							<th>Student DOJ</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>					<tbody></tbody>
				</table>
			</div>
		</div>
	</body>
</html>

<div id="apicrudModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="api_crud_form">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Add Student Record</h4>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
			        	<label>Enter Student Name</label>
			        	<input type="text" name="student_name" id="student_name" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label>Enter Student DOB</label>
			        	<input type="date" name="student_dob" id="student_dob" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label>Enter Student DOJ</label>
			        	<input type="date" name="student_doj" id="student_doj" class="form-control" />
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<input type="hidden" name="hidden_id" id="hidden_id" />
			    	<input type="hidden" name="action" id="action" value="insert" />
			    	<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Insert" />
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      		</div>
			</form>
		</div>
  	</div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){

	fetch_data();

	function fetch_data()
	{
		$.ajax({
			url:"fetch.php",
			success:function(data)
			{
				$('tbody').html(data);
			}
		})
	}

	$('#add_button').click(function(){
		$('#action').val('insert');
		$('#button_action').val('Insert');
		$('.modal-title').text('Add Data');
		$('#apicrudModal').modal('show');
	});

	$('#api_crud_form').on('submit', function(event){
		event.preventDefault();
		if($('#student_name').val() == '')
		{
			swal("Please Enter Student Name", "", "info");			
		}
		else if($('#student_dob').val() == '')
		{
			swal("Please Enter Student DOB", "", "info");			
		}
		else if($('#student_doj').val() == '')
		{
			swal("Please Enter Student DOJ", "", "info");			
		}
		else
		{
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					fetch_data();
					$('#api_crud_form')[0].reset();
					$('#apicrudModal').modal('hide');
					if(data == 'insert')
					{
						swal("Data Submitted Successfully!", "", "success");
					}
					if(data == 'update')
					{
						swal("Data Updated Successfully!", "", "success");						
					}
				}
			});
		}
	});

	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				// console.log(data);
				// console.log(data.student_name);
				// console.log(data.student_dob);
				// console.log(id);
				$('#hidden_id').val(id);
				$('#student_name').val(data.student_name);
				$('#student_dob').val(data.student_dob);
				$('#student_doj').val(data.student_doj);
				$('#action').val('update');
				$('#button_action').val('Update');
				$('.modal-title').text('Edit Data');
				$('#apicrudModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = 'delete';

		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this student record!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {

					$.ajax({
						url:"action.php",
						method:"POST",
						data:{id:id, action:action},
						success:function(data)
						{
							fetch_data();
						    swal("Student Record Has Been Deleted!", {
						      icon: "success",
						    });
						}
					});
		  } else {
		    swal("Student Record is safe!");
		  }
		});
	});

});
</script>
