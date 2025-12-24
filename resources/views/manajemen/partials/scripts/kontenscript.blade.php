<script>
    $(document).ready(function () {
        $('#kontenTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('datakonten') }}', // The URL to the DataTables controller method
                type: 'GET',
            },
            columns: [
                { data: 'id' },
                { data: 'judul_posts' },
                { data: 'modul_name' },
                { data: 'kategori_name' },
                {
                    data: 'created_by',
                    render: function (data, type, row) {
                        var userId = '{{ Auth::user()->name }}';
                        if (data == userId) {
                            return '<button aria-controls="kt_accordion_1_body_1" data-bs-target="#kt_accordion_1_body_1" data-bs-toggle="collapse" class="flex justify-content-center align-items-center btn btn-warning btn-sm edit-btn" data-id="' + row.id + '" data-nama="' + row.judul_posts + '" >Lihat Dokumentasi</button>';
                        } else {
                            return 'Tidak Ada Aksi';
                        }
                    }
                }
            ]
        });


    });
</script>