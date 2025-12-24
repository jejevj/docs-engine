<script>
    $(document).ready(function () {
        $('#modulTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('datamodul') }}',
                type: 'GET',
            },
            columns: [
                {
                    data: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'nama_modul' },
                { data: 'kategori_name' },
                {
                    data: 'created_by',
                    render: function (data, type, row) {
                        var userId = '{{ Auth::user()->name }}';
                        if (data == userId) {
                            return '<button aria-controls="kt_accordion_2_body_1" data-bs-target="#kt_accordion_2_body_1" data-bs-toggle="collapse" class="ms-3 btn btn-warning btn-sm edit-btn" data-id="' + row.id + '" data-nama="' + row.nama_modul + '" >Edit</button><button aria-controls="kt_accordion_2_body_1" data-bs-target="#kt_accordion_2_body_1" data-bs-toggle="collapse" class="ms-3 btn btn-danger btn-sm del-btn" data-id="' + row.id + '" data-nama="' + row.nama_modul + '" >Delete</button>';
                        } else {
                            return 'Tidak Ada Aksi';
                        }
                    }
                }
            ]
        });


        $('#addCategoryBtn').on('click', function () {

            $('input[name="nama_modul"]').val('');
            $('select[name="id_kategori"]').val('');
            $('#kt_modal_add_customer_submit2').text('Simpan');
            $('#kt_modal_add_customer_submit2').removeAttr('data-id');
        });


        $(document).on('click', '.edit-btn', function () {

            var id = $(this).data('id');
            var nama_modul = $(this).data('nama');
            $('input[name="nama_modul"]').val(nama_modul);
            $('#kt_modal_add_customer_submit2').text('Update');
            $('#kt_modal_add_customer_submit2').attr('data-id', id);
        });
        $(document).on('click', '.del-btn', function () {

            var id = $(this).data('id');
            var nama_modul = $(this).data('nama');
            $('input[name="nama_modul"]').val(nama_modul);
            $('#kt_modal_add_customer_submit2').text('Delete');
            $('#kt_modal_add_customer_submit2').attr('data-id', id);
        });


        $('#kt_modal_add_customer_submit2').on('click', function (e) {
            e.preventDefault();

            var name = $('input[name="nama_modul"]').val();
            var id_kategori = $('select[name="id_kategori"]').val();
            var id = $(this).attr('data-id');

            var url = id ? '{{ route('updatemodul', ':id') }}'.replace(':id', id) : '{{ route('storemodul') }}';
            var method = id ? 'PUT' : 'POST';

            var buttonText = $('#kt_modal_add_customer_submit2').text();


            if (buttonText == 'Delete') {
                var url = '{{ route('destroymodul', ':id') }}'.replace(':id', id);
                var method = 'DELETE';
            }
            $.ajax({
                url: url,
                method: method,
                data: {
                    nama_modul: name,
                    id_kategori: id_kategori,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {

                    $('input[name="nama_modul"]').val('');
                    $('#kt_modal_add_customer_submit2').text('Simpan');
                    $('#kt_modal_add_customer_submit2').removeAttr('data-id');

                    $('#kt_accordion_2_body_1').removeClass('show');
                    $('#modulTable').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Error saving data');
                }
            });
        });
    });
</script>