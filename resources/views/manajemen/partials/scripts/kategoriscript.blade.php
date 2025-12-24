<script>
    $(document).ready(function () {
        $('#kategoriTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('datakategori') }}', 
                type: 'GET',
            },
            columns: [
                {
                    data: 'id', 
                    render: function (data, type, row, meta) {
                        return meta.row + 1; 
                    }
                },
                { data: 'nama_kategori' },
                { data: 'created_by' },
                {
                    data: 'created_by',
                    render: function (data, type, row) {
                        var userId = '{{ Auth::user()->name }}';
                        if (data == userId) {
                            return '<button aria-controls="kt_accordion_1_body_1" data-bs-target="#kt_accordion_1_body_1" data-bs-toggle="collapse" class="ms-3 btn btn-warning btn-sm edit-btn" data-id="' + row.id + '" data-nama="' + row.nama_kategori + '" >Edit</button><button aria-controls="kt_accordion_1_body_1" data-bs-target="#kt_accordion_1_body_1" data-bs-toggle="collapse" class="ms-3 btn btn-danger btn-sm del-btn" data-id="' + row.id + '" data-nama="' + row.nama_kategori + '" >Delete</button>';
                        } else {
                            return 'Tidak Ada Aksi';
                        }
                    }
                }
            ]
        });

        
        $('#addCategoryBtn').on('click', function () {
            
            $('input[name="name"]').val('');
            $('#kt_modal_add_customer_submit').text('Simpan');
            $('#kt_modal_add_customer_submit').removeAttr('data-id');
        });

        
        $(document).on('click', '.edit-btn', function () {
            
            var id = $(this).data('id');
            var nama_kategori = $(this).data('nama');

            
            $('input[name="name"]').val(nama_kategori);

            
            $('#kt_modal_add_customer_submit').text('Update');
            $('#kt_modal_add_customer_submit').attr('data-id', id);
        });
        $(document).on('click', '.del-btn', function () {
            
            var id = $(this).data('id');
            var nama_kategori = $(this).data('nama');

            
            $('input[name="name"]').val(nama_kategori);

            
            $('#kt_modal_add_customer_submit').text('Delete');
            $('#kt_modal_add_customer_submit').attr('data-id', id);
        });

        
        $('#kt_modal_add_customer_submit').on('click', function (e) {
            e.preventDefault();

            var name = $('input[name="name"]').val();
            var id = $(this).attr('data-id'); 

            var url = id ? '{{ route('updatekategori', ':id') }}'.replace(':id', id) : '{{ route('storekategori') }}';
            var method = id ? 'PUT' : 'POST';

            var buttonText = $('#kt_modal_add_customer_submit').text();
            

            if (buttonText == 'Delete') {
                var url = '{{ route('destroykategori', ':id') }}'.replace(':id', id);
                var method = 'DELETE';
            }
            $.ajax({
                url: url,
                method: method,
                data: { nama_kategori: name, _token: '{{ csrf_token() }}' },
                success: function (response) {
                    
                    $('input[name="name"]').val('');
                    $('#kt_modal_add_customer_submit').text('Simpan'); 
                    $('#kt_modal_add_customer_submit').removeAttr('data-id'); 
                    
                    $('#kt_accordion_1_body_1').removeClass('show');
                    $('#kategoriTable').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Error saving data');
                }
            });
        });
    });
</script>