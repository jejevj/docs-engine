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
                        var documentationUrl = '{{ config('app.documentation_url') }}';
                        var fileLocation = row.file_location;
                        const regex = /content\/docs\/(.+?)\.md/;
                        const match = fileLocation.match(regex);
                        let result; // This will give 'sistem-informasi-zakat/dtsen/overview-dtsen'

                        if (match) {
                            result = match[1]; // This will give 'sistem-informasi-zakat/dtsen/overview-dtsen'
                            // console.log(result);
                        }
                        if (data == userId) {
                            return '<a target="_blank" href="' + documentationUrl + '/' + result + '" class="flex justify-content-center align-items-center btn btn-warning btn-sm edit-btn" data-id="' + row.id + '" data-nama="' + row.judul_posts + '" >Lihat Dokumentasi</a>';
                        } else {
                            return 'Tidak Ada Aksi';
                        }
                    }
                }
            ]
        });


    });
</script>