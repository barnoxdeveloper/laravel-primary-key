<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container p-4">
            <div class="card">
                <div class="card-header">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered tale-striped" id="table-product">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal post --}}
        <div class="modal fade" id="modal-post" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="static-backdrop-label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="static-backdrop-label"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" enctype="multipart/form-data" id="form-post">
                            @csrf
                            <input type="hidden" readonly name="id" id="id">
                            <div class="row justify-content-center">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="name">NAME*</label>
                                        <input type="text" name="name" id="name" required class="form-control" maxlength="50" placeholder="NAME" value="{{ old('name') }}">
                                        <p class="text-danger error-text name_error"></p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="price">Price*</label>
                                        <input type="text" autofocus name="price" id="price" required class="form-control" maxlength="50" placeholder="Price" value="{{ old('price') }}">
                                        <p class="text-danger error-text price_error"></p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="color">Color*</label>
                                        <input type="text" name="color" id="color" required class="form-control" maxlength="20" placeholder="Color" value="{{ old('color') }}">
                                        <p class="text-danger error-text color_error"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i>
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- Custom Function --}}
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                // looping data
                $('#table-data').DataTable({
					processing : true,
					serverSide : true,
					pageLength : 25,
					lengthMenu : [
						[10, 25, 50, -1],
						[10, 25, 50, 'All'],
					],
					columnDefs : [{
						"targets" : [3],
						"orderable" : false,
						"searchable" : false,
					}],
					ajax : {
						url : "{{ $route }}",
						type : 'GET',
					},
					columns: [
						{ data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center" },
						{ data: 'name', name: 'name', className: "text-center" },
						{ data: 'price', name: 'price', className: "text-center" },
						{ data: 'color', name: 'color', className: "text-center" },
						{ data: 'action', name: 'action', className: "text-center" },
					],
				});

                // method create
                $('#btn-create').click(function () {
                    $('#form-post').trigger("reset");
                    $('.modal-title').text("Create Data (* Required)");
                    $('#id').val('');
                    $('#modal-post').show();
                });

                // method edit data
                $(document).on('click', '.edit', function () {
                    let dataId = $(this).data('id');
                    $(".modal-body").find("p").hide();
                    $.get('product-with-id/' + dataId + '/edit', function (data) {
                        $('#modal-post').modal('show');
                        $('.modal-title').text("Edit Data (* Required)");
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#price').val(data.price);
                        $('#color').val(data.color);
                    });
                });

                // method post
                if ($("#form-post").length > 0) {
                    $("#form-post").validate({
                        submitHandler: function (form) {
                            let formData = new FormData(document.getElementById('form-post'));
                            Swal.fire({
                                title: 'Are you sure?',
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Save it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $(".modal-body").find("p").show();
                                    $.ajax({
                                        url: "{{ route('product-with-id.store') }}",
                                        data: formData,
                                        type: 'POST',
                                        dataType: 'json',
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        beforeSend:function(){
                                            $(document).find('p.error-text').text('');
                                        },
                                        success: function (data) {
                                            if (data.code == 0) {
                                                $.each(data.messages, function(prefix, val) {
                                                    $('p.'+prefix+'_error').text(val[0]);
                                                });
                                            } else {
                                                $('#form-post').trigger("reset");
                                                $('#modal-post').modal('hide');
                                                $('#table-data').DataTable().ajax.reload();
                                                Swal.fire(
                                                    'Saved!',
                                                    `${data.message}`,
                                                    'success'
                                                );
                                            }
                                        },
                                        error: function (data) {
                                            $.each(data.messages, function(prefix, val) {
                                                $('p.'+prefix+'_error').text(val[0]);
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }

                // method delete
                $(document).on('click', '.delete', function () {
                    dataId = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "product-with-id/" + dataId,
                                type: 'DELETE',
                                success: function (data) {
                                    if (data.code == 200) {
                                        Swal.fire(
                                            'Saved!',
                                            `${data.message}`,
                                            'success'
                                        );
                                        $('#table-product').DataTable().ajax.reload();
                                    }
                                },
                                error: function (data) {
                                    console.log('Error: ', data);
                                }
                            });
                        }
                    });
                });
			});
        </script>
    </body>
</html>
