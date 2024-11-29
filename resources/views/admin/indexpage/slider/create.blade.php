<!DOCTYPE html>
<html lang="en">
@include('layouts.admin.tableheader')
<body class="hold-transition sidebar-mini">
<div class="wrapper">
@include('layouts.admin.nav')
@include('layouts.admin.aside')

  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Add New Slider Image</h2>
              <a href="#" class="btn btn-sm btn-primary float-right">Back</a>
            </div>
            <div class="card-body">
              <form action="{{ route('slider_images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="image">Image</label>
                  <input type="file" name="image" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@include('layouts.admin.foot')
@include('layouts.admin.tablefooter')
</body>
</html>
<!-- Bootstrap 5 for custom file input styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  /* Custom file input styling */
  .custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
  }
  .custom-file input[type="file"] {
    opacity: 0;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
  }

  .custom-file-label {
    display: block;
    padding: 10px 15px;
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color: #f8f9fa;
    color: #495057;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
  }

  .custom-file-label:hover {
    background-color: #e9ecef;
  }

  .custom-file input[type="file"]:focus + .custom-file-label {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.25);
  }

  .custom-file input[type="file"]:valid + .custom-file-label {
    background-color: #28a745;
    color: white;
  }
</style>

