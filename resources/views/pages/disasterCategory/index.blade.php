@extends('layouts.templates.main')

@push('custom-style')
<link href="{{ asset('assets/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
  .loading-container{
      position: absolute; 
      top: 0;
      left: 0;
      height: 100%; 
      width: 100%; 
      z-index: 9999999999; 
      background: black; 
      opacity: 0.5;
  }
</style>
@endpush

@section('content') 
<div class="container-fluid main-content ">
  <div class="loading-container d-flex justify-content-center align-items-center" id="loading-container">
      <img src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="loading">
      Loading...
  </div>
  <div class="row">
      <div class="col-md-12 page-header d-flex justify-content-between">
          <!-- <div class="page-pretitle">Overview</div> -->
          <h2 class="page-title">Disaster Categories</h2>
		  		<button  class="btn btn-info btn-sm" id="create-disaster-category" type="button"  data-toggle="modal" data-target="#CreateDisasterCategoryModal">
		        Create Disaster Category
		      </button>
      </div>
  </div>

  <!-- flash message -->
  <div class="row my-2">
  	<div class="col-12 flash-message-container">

  	</div>
  </div>
  <!-- end of flash message -->
  <div class="row">
  	<div class="col-md-12">
  		<table class="table table-hover" id="my-datatables" width="100%">
			  <thead>
			      <tr>
			          <th>ID</th>
			          <th>Name</th>
			          <th>Amount of disaster areas</th>
			          <th>Action</th>
			      </tr>
			  </thead>
			  <!-- <tbody>
			  		@foreach($disasterCategories as $disasterCategory)
			      <tr>
			          <td>{{ $disasterCategory->id}}</td>
			          <td>{{ $disasterCategory->name}}</td>
			          <td>{{ $disasterCategory->dangerousAreas()->count()}}</td>
			          <td>
			          	<a href="" class="btn btn-danger">
			          		<i class="fas fa-trash"></i>
			          	</a>
			          	<a href="" class="btn btn-success">
			          		<i class="fas fa-edit"></i>
			          	</a>
			          </td>
			      </tr>
			      @endforeach
			  </tbody> -->
			</table>

  	</div>
  </div>
</div>

<!-- Create Disaster Category Modal -->
<div class="modal" id="CreateDisasterCategoryModal">
  <div class="modal-dialog">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Disaster Category Create</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                  <strong>Success!</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="POST">
	              <div class="form-group">
	                <label for="name">Name</label>
	                <input type="text" class="form-control" name="name" id="name">
	                <span class="invalid-feedback create-name-error" role="alert">
			                <strong></strong>
			            </span>

	              </div>
	          		<div class="form-group">
	          			<button type="button" class="btn btn-success" id="SubmitCreateDisasterCategory">Create</button>
	          		</div>
          		</form>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
<!-- end of create modal -->

<!-- edit Disaster Category Modal -->
<div class="modal" id="EditDisasterCategoryModal">
  <div class="modal-dialog">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Disaster Category Edit</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                  <strong>Success!</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form>
	              <div class="form-group">
	                <label for="name">Name</label>
	                <input type="text" class="form-control" name="edit-name" id="edit-name">
	                <span class="invalid-feedback create-name-error" role="alert">
			                <strong></strong>
			            </span>

	              </div>
	          		<div class="form-group">
	          			<button type="button" class="btn btn-success" id="SubmitEditDisasterCategory">Edit</button>
	          		</div>
          		</form>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="button" class="btn btn-danger modal-close" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
<!-- end of edit modal -->

@endsection

@push('custom-script')
<script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/initiate-datatables.js') }}"></script>
<script>
	$(function(){
		let id = null;

    $(document).bind("ajaxSend", function(){
        $("#loading-container").removeClass('d-none');
        $("#loading-container").addClass('d-flex');
    }).bind("ajaxComplete", function(){
        $("#loading-container").addClass('d-none');
        $("#loading-container").removeClass('d-flex');
    });

    function hideModal(){
      $('#CreateDisasterCategoryModal').hide();
    	$('#EditDisasterCategoryModal').hide();
    	$('.alert-danger').hide();
   		$(this).find('form').trigger('reset');
    }

    function renderSuccessFlashMessage(message = ''){
    	$('.alert-danger').hide();
    	$('.datatable').DataTable().ajax.reload();
    	$('.flash-message-container').html(`
    	<div class="alert alert-success alert-dismissible fade show" role="alert" >
        	${message}
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
      	  </button>
    	</div>`)
    	setTimeout(function(){
    		$('.flash-message-container').html('');
    	}, 10000)
    }

		$('#CreateDisasterCategoryModal').on('hidden.bs.modal', function () {
    	hideModal();
   		$(this).find('form').trigger('reset');
		})

    $('.close').on('click', function(){
        hideModal()
    });

    $('.modal-close').on('click', function(){
        hideModal()
    });

 		$('#my-datatables').dataTable( {
	    processing: true,
      serverSide: true,
      ajax: "{{ route('disaster-categories.index') }}",
      columns: [
          {data: 'id', name: 'id'},
          {data: 'name', name: 'name'},
          {data: 'disasterAreas', name: 'disasterAreas'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
       ]
	  });

    $('body').on('click', '#edit-disaster-category-button', function(e) {
        e.preventDefault();
        id = $(this).data('id');
        $.ajax({
          url: "disaster-categories/" + id,
          method: 'GET',
          success: function(response){
          	$('#edit-name').val(response.data.name)
          	$('#EditDisasterCategoryModal').show();
          },
          error: function(error){
          	console.log(error)
          }
      });
    });

    // delete data
    $('body').on('click', '#disaster-category-delete-button', function(e) {
        e.preventDefault();
        id = $(this).data('id');
        if(!confirm('Are you sure want to delete the data?')) return false;
				$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      	});
        $.ajax({
          url: "disaster-categories/" + id,
          method: 'DELETE',
          success: function(response){
            $('.datatable').DataTable().ajax.reload();
          },
          error: function(error){
          	console.log(error)
          }
      });
    });

    // post data
	  $('#SubmitCreateDisasterCategory').click(function(e) {
      e.preventDefault();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url: "disaster-categories",
          method: 'POST',
          data: {
              name: $('#name').val(),
          },
          success: function(response){
            $('#CreateDisasterCategoryModal').modal('hide');
          	renderSuccessFlashMessage(response.message);
          },
          error: function(error){
          	let errorMesages = '';
            $('.alert-danger').show();
						$.each(error.responseJSON.errors, function(key, value) {
             	errorMesages += '<strong><li>'+value+'</li></strong>';
            });
            $('.alert-danger').html(errorMesages);
          }
      });

    });

    // Update  Ajax request.
    $('#SubmitEditDisasterCategory').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "disaster-categories/" + id ,
            method: 'PUT',
            data: {
                name: $('#edit-name').val(),
            },
            success: function(response) {
              if(!response.errors) {
              	$('#EditDisasterCategoryModal').hide();
                renderSuccessFlashMessage(response.message)
              }
            },
            error: function(error){
              let errorMesages = '';
              $('.alert-danger').show();
							$.each(error.responseJSON.errors, function(key, value) {
               	errorMesages += '<strong><li>'+value+'</li></strong>';
	            });
	            $('.alert-danger').html(errorMesages);
            }
        });
    });
 	})
</script>
@endpush
