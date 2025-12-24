            <script>
                $(document).ready(function () {
                    $('#kategoriTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route('datakategori') }}', // The URL to the DataTables controller method
                            type: 'GET',
                        },
                        columns: [
                            { data: 'id' },
                            { data: 'nama_kategori' },
                            { data: 'created_by' },
                            {
                                data: 'created_by',
                                render: function (data, type, row) {
                                    var userId = '{{ Auth::user()->name }}';
                                    if (data == userId) {
                                        return '<button aria-controls="kt_accordion_1_body_1" data-bs-target="#kt_accordion_1_body_1" data-bs-toggle="collapse" class="flex justify-content-center align-items-center btn btn-warning btn-sm edit-btn" data-id="' + row.id + '" data-nama="' + row.nama_kategori + '" >Edit</button>';
                                    } else {
                                        return 'Tidak Ada Aksi';
                                    }
                                }
                            }
                        ]
                    });

                    // Reset the form when the "Add Category" button is clicked
                    $('#addCategoryBtn').on('click', function () {
                        // Clear the input field and reset button text to "Simpan"
                        $('input[name="name"]').val('');
                        $('#kt_modal_add_customer_submit').text('Simpan');
                        $('#kt_modal_add_customer_submit').removeAttr('data-id');
                    });

                    // Handle the "Edit" button click
                    $(document).on('click', '.edit-btn', function () {
                        // Get the category data from the button's data attributes
                        var id = $(this).data('id');
                        var nama_kategori = $(this).data('nama');

                        // Populate the form fields with the data
                        $('input[name="name"]').val(nama_kategori);

                        // Change the submit button text to "Update" and store the category ID
                        $('#kt_modal_add_customer_submit').text('Update');
                        $('#kt_modal_add_customer_submit').attr('data-id', id);
                    });

                    // Handle form submission (Create or Update category)
                    $('#kt_modal_add_customer_submit').on('click', function (e) {
                        e.preventDefault();

                        var name = $('input[name="name"]').val();
                        var id = $(this).attr('data-id'); // Check if editing or creating

                        var url = id ? '{{ route('updatekategori', ':id') }}'.replace(':id', id) : '{{ route('storekategori') }}';
                        var method = id ? 'PUT' : 'POST';

                        $.ajax({
                            url: url,
                            method: method,
                            data: { name: name, _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                // Reset the form after saving
                                $('input[name="name"]').val('');
                                $('#kt_modal_add_customer_submit').text('Simpan'); // Reset button text
                                $('#kt_modal_add_customer_submit').removeAttr('data-id'); // Remove data-id attribute
                                // Optionally, reload the DataTable to reflect the changes
                                $('#kategoriTable').DataTable().ajax.reload();
                            },
                            error: function () {
                                alert('Error saving data');
                            }
                        });
                    });
                });
            </script>