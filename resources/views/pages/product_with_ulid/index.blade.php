<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>PRODUCT WITH ULID</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
                crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
    </head>
    <body>
        <div class="container p-4">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h1>PRODUCT WITH PRIMARY KEY ULID</h1>
                    <a href="javascript:void(0)" class="btn btn-success mt-3" id="btn-create">
                        + Create Data
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered tale-striped w-100" id="table-product">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th width="20%">Color</th>
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
                    </div>
                    <div class="modal-body">
                        <form action="" enctype="multipart/form-data" id="form-post" class="p-3">
                            @csrf

                            <input type="hidden" readonly name="id" id="id">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" id="name" required class="form-control" maxlength="50" placeholder="Name" value="{{ old('name') }}">
                                <label for="name">Name*</label>
                                <p class="text-danger error-text name_error"></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="price" id="price" required class="form-control" placeholder="Price" value="{{ old('price') }}">
                                <label for="price">Price*</label>
                                <p class="text-danger error-text price_error"></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="color" id="color" required class="form-control" maxlength="50" placeholder="Color" value="{{ old('color') }}">
                                <label for="color">Color*</label>
                                <p class="text-danger error-text color_error"></p>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
                integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
                crossorigin="anonymous"
                referrerpolicy="no-referrer">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
                integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
                crossorigin="anonymous"
                referrerpolicy="no-referrer">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
                crossorigin="anonymous">
        </script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- Custom Function --}}
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                // looping data
                $('#table-product').DataTable({
					processing : true,
					serverSide : true,
					ajax : {
						url : "{{ route('product-with-ulid.index') }}",
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
                    $('#modal-post').modal('show');
                    $('#form-post').trigger("reset");
                    $('.modal-title').text("Create Data (* Required)");
                    $('#id').val('');
                });

                // method edit data
                $(document).on('click', '.edit', function () {
                    let dataId = $(this).data('id');
                    $(".modal-body").find("p").hide();
                    $.get('product-with-ulid/' + dataId + '/edit', function (data) {
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
                                        url: "{{ route('product-with-ulid.store') }}",
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
                                                $('#table-product').DataTable().ajax.reload();
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
                                url: "product-with-ulid/" + dataId,
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
