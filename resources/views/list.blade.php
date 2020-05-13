<!DOCTYPE html>
  
<html lang="en">
<head>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laravel DataTable Ajax Crud Tutorial - Tuts Make</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container">
<h2>Books</h2>
<br>
<a href="javascript:void(0)" class="btn btn-info ml-3" id="delete-all-book">Delete All</a>
<a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-book">Add New</a>
<br><br>
  
<table class="table table-bordered table-striped" id="laravel_datatable">
   <thead>
      <tr>
         <th>Del</th>
         <th>ID</th>
         <th>Title</th>
         <th>Category</th>
         <th>Author</th>
         <th>Publish</th>
         <th>ISBN</th>
         <th>Created at</th>
         <th>Action</th>
      </tr>
   </thead>
</table>
</div>
  
<div class="modal fade" id="ajax-book-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="bookCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="bookForm" name="bookForm" class="form-horizontal">
           <input type="hidden" name="book_id" id="book_id">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Title</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Tilte" value="" maxlength="50" required="">
                </div>
            </div> 
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-12">
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach($categories as $val)
                        <option value="{{ $val->id }}">{{ $val->category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ISBN</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN" value="" maxlength="50" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Author</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="author" name="author" placeholder="Enter Author" value="" maxlength="50" required="">
                </div>
            </div>
  
            <div class="form-group">
                <label class="col-sm-2 control-label">Publish</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="publish" name="publish" placeholder="Enter Publish" value="" required="">
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
             </button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
         
    </div>
</div>
</div>
</div>
</body>
<script>
 var SITEURL = '{{URL::to('')}}';
 $(document).ready( function () {
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#laravel_datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
          //url: SITEURL + "book-list",
          url: "{{ route('book-list') }}",
          type: 'GET',
         },
         columns: [
                  
                  {data: 'checkboxdel', name: 'checkboxdel', orderable: false},
                  {data: 'id', name: 'id', 'visible': false},
                  { data: 'title', name: 'title' },
                  { data: 'category', name: 'category_id' },
                  { data: 'author', name: 'author' },
                  { data: 'publish', name: 'publish' },
                  { data: 'isbn', name: 'isbn' },
                  { data: 'created_at', name: 'created_at' },
                  {data: 'action', name: 'action', orderable: false},
               ],
        order: [[0, 'desc']]
      });
 
 /*  When book click add book button */
    $('#create-new-book').click(function () {
        $('#btn-save').val("create-book");
        $('#book_id').val('');
        $('#bookForm').trigger("reset");
        $('#bookCrudModal').html("Add New Book");
        $('#ajax-book-modal').modal('show');
    });
  
   /* When click edit book */
    $('body').on('click', '.edit-book', function () {
      var book_id = $(this).data('id');
      $.get('book-list/' + book_id +'/edit', function (data) {
         $('#title-error').hide();
         $('#book_code-error').hide();
         $('#description-error').hide();
         $('#bookCrudModal').html("Edit book");
          $('#btn-save').val("edit-book");
          $('#ajax-book-modal').modal('show');
          $('#book_id').val(data.id);
          $('#title').val(data.title);
          $('#isbn').val(data.isbn);
          $('#author').val(data.author);
          $('#publish').val(data.publish);
      })
   });
 
    $('body').on('click', '#delete-book', function () {
  
        var book_id = $(this).data("id");
        
        if(confirm("Are You sure want to delete !")){
          $.ajax({
              type: "get",
              url: SITEURL + "book-list/delete/"+book_id,
              success: function (data) {
              var oTable = $('#laravel_datatable').dataTable(); 
              oTable.fnDraw(false);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
    }); 
   
   });
  
if ($("#bookForm").length > 0) {
      $("#bookForm").validate({
  
     submitHandler: function(form) {
  
      var actionType = $('#btn-save').val();
      $('#btn-save').html('Sending..');
       
      $.ajax({
          data: $('#bookForm').serialize(),
          //url: SITEURL + "book-list/store",
          url: "{{ route('book-list/store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
  
              $('#bookForm').trigger("reset");
              $('#ajax-book-modal').modal('hide');
              $('#btn-save').html('Save Changes');
              var oTable = $('#laravel_datatable').dataTable();
              oTable.fnDraw(false);
               
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }
  })
}
</script>
 
</html>