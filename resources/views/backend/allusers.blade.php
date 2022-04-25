@include('backend.header')

	<div class="col-sm-12">
		<table class="table table-striped table-bordered" style="background-color: white;">
			<thead>
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>User E-Mail</th>
					<th>Status</th>
					<th>Created At</th>
					<th>Actions</th>
				</tr>
        	</thead>
        	<tbody>
        		@php
        			$array = $allUsers->items();
        		@endphp
				@if ( isset($array) && !empty($array))
						@foreach($array as $key => $value)
							<tr>
								<td>{{ $value->id }}</td>
								<td>{{ $value->f_name }}</td>
								<td>{{ $value->l_name }}</td>
								<td>{{ $value->e_mail }}</td>
								<td>{{ $value->u_status }}</td>
								<td>{{ $value->created_at }}</td>
								<td>
									<a href="/bio/{{ $value->id }}"><i class="material-icons">visibility</i></a>
                            		<a href="/add_user"><i class="material-icons">create</i></a>
                            		<a href="#" data-id="{{ $value->id }}" data-toggle="modal" data-target="#delete_confirm" class="delete_user"><i class="material-icons text-danger">delete</i></a>
                            	</td>
							</tr>
						@endforeach
				@endif
			</tbody>
      	</table>
      	<?php echo $pagination = $allUsers->appends(array('value' => 'key')); ?>
	</div>

	<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true" style="display: none;">
	   <div class="modal-dialog">
	      <div class="modal-content">
	         <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            <h4 class="modal-title" id="user_delete_confirm_title">Delete User</h4>
	         </div>
	         <div class="modal-body">
	            Are you sure to delete this user? This operation is irreversible.
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            <a href="/delete/{{ $value->id }}" type="button" id="deleteuserurl" class="btn btn-danger">Delete</a>
	         </div>
	      </div>
	   </div>
	</div>

@include('backend.footer')