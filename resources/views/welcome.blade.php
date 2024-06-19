@include('modals.create_category')
@include('modals.upload_file')
@include('modals.rename_category')
@include('modals.delete_category')
@include('modals.permission')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            @if ($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif
            <div class="alert" id="messages"></div>
            <div class="col-md-12">
                <div class="row align-items-center my-4">
                    <div class="col">
                        <h2>Kategóriák</h2>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="createCatButton" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModal">
                            Új kategória
                        </button>
                    </div>
                </div>
                <div id="jstree"></div>
                <div class="row align-items-center my-4">
                    <div class="col">
                        <h2>Fájlok</h2>
                    </div>
                    <div class="col-auto text-uppercase" id="catName"></div>
                </div>
                <div id="documentList"></div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{ asset('js/category.js') }}"></script>
<script src="{{ asset('js/document.js') }}"></script>
<script src="{{ asset('js/permission.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>

</html>