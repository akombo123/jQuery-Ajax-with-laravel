<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Create Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" />
<body>

  <!-- Modal -->
  <div class="modal fade ajax-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="ajaxForm">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modal-title">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <input type="hidden" name="category_id" id="category_id">
  
            <div class="form-grtoup mb-3">
              <label for="">Name</label>
              <input type="text" name="name" id="name" class="form-control">
              <span id="nameError" class="text-danger error-messages
              $('.error-messages').html('');"></span>
            </div>
  
            <div class="form-group mb-1">
              <label for="">Type</label>
              <select name="type" id="type" class="form-control">
                  <option disabled selected>Select Option</option>
                  <option value="electronic">Electronics</option>
              </select>
              <span id="typeError" class="text-danger error-messages"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveBtn"></button>
          </div>
        </div>
      </div>
    </form>
  </div>

    <div class="row">
        <div class="col-md-6 offset-3" style="margin-top: 100px">
            <a  class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal" id="add_category">Add Category</a>
            <table id="category-table" class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Type</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </div>
    </div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  var table = $('#category-table').DataTable({
    processing:true,
    serverSide:true,

    ajax:"{{ route('categories.index') }}",
    columns:[
      { data : 'id' },
      { data : 'name' },
      { data : 'type' },
      { data : 'action', name:'action', orderable:false, searchable:false},

    ]
  });

  $(document).ready(function(){
    $('#modal-title').html('Create Category');
    $('#saveBtn').html('Save Category');
    var form = $('#ajaxForm')[0]; // This is the correct HTMLFormElement

    
    $('#saveBtn').click(function(){
      $('#saveBtn').attr('disabled',true)
      $('#saveBtn').html('Saving...');
      $('.error-messages').html('');
        // Get the form element using its ID
       
        var formData = new FormData(form); // Create FormData with the form
        $.ajax({ 
          url:'{{ route("categories.store") }}',
          method: 'POST',
          processData: false,
          contentType:false,
          data: formData,

          success: function(response){
            table.draw();

            $('#saveBtn').attr('disabled', false);
            $('#saveBtn').html('Save Category.');

            $('#name').val('');
            $('#type').val('');
            $('#category_id').val('');

            $('.ajax-modal').modal('hide');
            if(response){
              swal("Success!",response.success, "success");
            }
            
          },
          error: function(error){

            $('#saveBtn').attr('disabled', false);
            $('#saveBtn').html('Save Category.');

            if(error){
              console.log(error.responseJSON.errors.name)
              $('#nameError').html(error.responseJSON.errors.name);
              $('#typeError').html(error.responseJSON.errors.type);
              
            }
            
          }
        });
    });

    //edit button code
    $('body').on('click' , '.editButton' , function(){
     var id = $(this).data('id');
    //  console.log(id);
      $.ajax({
      url:'{{ url("categories",'') }}'+'/'+id+'/edit',
      method:'GET',
      success: function(response){
        $('.ajax-modal').modal('show');
        $('#modal-title').html('Edit Category');
        $('#saveBtn').html('Update Category');

        $('#category_id').val(response.id);

        $('#name').val(response.name);
        // $('#type')
        var type = capitalizeFirstLetter(response.type);
         $('#type').empty().append('<option selected value="'+response.type+'">'+type+'</option>');
        // $('#type').append( '<option selected value="'+response.id+'">'+response.type+'</option>' );
 
        
      },
      error: function(error){
        console.log(error);
        
      }
    });
     
      
    });
  //delete button
    $('body').on('click','.delButton', function(){
      var id = $(this).data('id');
     if(confirm('Delete Record?')){
      $.ajax({
      url:'{{ url("categories/destroy",'') }}'+'/'+id,
      method:'DELETE',
      success: function(response){
        table.draw();
        swal("Success!",response.success, "success");
      },
      error: function(error){
        console.log(error);
        
      }
    });
     }
      
    });

    $('#add_category').click(function(){
       $('#modal-title').html('Create Category');
       $('#saveBtn').html('Save Category');
    });

    function capitalizeFirstLetter(string){
        return string.charAt(0).toUpperCase() + string.slice(1);
      }
      $('.ajax-modal').on('hidden.bs.modal', function () {
          console.log('closed');
          
          $('.error-messages').html('');
        })
});
</script>
</body>
</html>