@extends('layouts.app')

@section('content')
    <style>
        .image-card {
            width: 220px;
            flex: 0 0 auto;
        }

        .image-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: .5rem;
        }

        /* Initially hide the header when the toggle is active */
        .hide-header {
            display: none;
        }
    </style>

    <div class="card-body p-lg-17">
        <!--begin::About-->
        <div class="mb-18">
            <!--begin::Wrapper-->
            <div class="mb-10">
                <!--begin::Top-->
                <div class="text-center mb-15">
                    <!--begin::Title-->
                    <h3 class="fs-2hx text-gray-900 mb-5">Dokumentasi</h3>
                    <!--end::Title-->
                </div>
                <!--end::Top-->
            </div>
            <form id="createPostForm" enctype="multipart/form-data">
                @csrf


                <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10"
                    style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('assets/media/illustrations/sketchy-1/4.png')">
                    <!--begin::Card header-->
                    <div class="card-header pt-10 pb-10">
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="symbol symbol-circle me-5">
                                <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                                    <i class="ki-outline ki-abstract-47 fs-2x text-primary"></i>
                                </div>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column">
                                <h2 class="mb-1">Buat Postingan</h2>
                                <div class="text-muted fw-bold">
                                    Isi Konten Baru
                                </div>
                            </div>
                            <!--end::Title-->
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <!--end::Card body-->
                </div>
                <div class="card mb-8">
                    <div class="card-header">
                        <h3 class="card-title">Detail Dokumentasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Judul Dokumentasi</label>
                            <input type="text" name="judul_posts" class="form-control form-control-solid"
                                placeholder="Judul Disini" />
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="form-label">Filename</label>
                            <input type="text" name="filename" class="form-control form-control-solid"
                                placeholder="judul-disini" readonly />
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Pilih Modul</label>
                            <select class="form-select " data-control="select2" name="id_modul" aria-label="Select Module">
                                <option>Pilih Modul</option>
                                @foreach ($modul as $md)
                                    <option value="{{$md->id}}">{{$md->nama_modul}} | Kategori: {{$md->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-10">
                            <label for="exampleFormControlInput1" class="required form-label">Deskripsi</label>
                            <input type="text" name="deskripsi" class="form-control form-control-solid"
                                placeholder="deskripsi" />
                        </div>
                    </div>
                </div>
                <div class="card mb-8">
                    <div class="card-header">
                        <h3 class="card-title">Media Library</h3>
                    </div>
                    <div class="card-body">

                        <input type="file" id="imageUploadInput" class="form-control mb-4" accept="image/*">

                        <div id="imageGallery" class="d-flex gap-4 overflow-auto pb-3">
                        </div>

                    </div>
                </div>

                <!--end::Container-->
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div id="tocContainer" style="position: sticky; top: 20px;">
                                    <!-- The TOC will be dynamically inserted here -->
                                    <h3>Table of Contents</h3>
                                    <div class="menu menu-rounded menu-column menu-title-gray-700 menu-bullet-gray-500 menu-arrow-gray-500 menu-state-bg fw-semibold w-250px"
                                        data-kt-menu="true" id="tocMenu">
                                        <!-- TOC will be dynamically inserted here -->
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-10 mb-3">
                                <textarea id="MyID"></textarea>
                                <div class="d-grid gap-2">
                                    <button type="button" name="submitForm" id="submitForm"
                                        class="btn btn-primary py-3 my-3">
                                        Simpan Konten
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Wrapper-->


    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="" id="previewImage" class="img-fluid w-100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="escToast" class="toast bg-primary " role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary">
                <strong class="me-auto text-white">Notifikasi</strong>
                <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <strong class="text-white">
                    Klik ESC untuk keluar dari Preview.
                </strong>
            </div>
        </div>
    </div>
    @section('content_scripts')

        <link rel="stylesheet" href="assets/css/easymde.min.css">

        <!-- <script src="assets/js/scripts.bundle.js"></script> -->
        <!-- <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script> -->
        <script src="assets/js/easymde.min.js"></script>


        <script>
            const easyMDE = new EasyMDE({
                element: document.getElementById("MyID"),
                spellChecker: false,
                uploadImage: true,
                imageUploadFunction: uploadImage,
                autosave: {
                    enabled: true,
                    uniqueId: "MyUniqueID",
                    delay: 1000,
                    submit_delay: 5000,
                    timeFormat: {
                        locale: 'en-US',
                        format: {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                        },
                    },
                    text: "Autosaved: "
                },
                maxHeight: "600px",
                lineWrapping: false,
                lineNumbers: true,
            });

            function uploadImage(file, onSuccess, onError) {
                const formData = new FormData();
                formData.append("image", file);
                formData.append("_token", "{{ csrf_token() }}");

                fetch("#", {
                    method: "POST",
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.url) {
                            onSuccess(data.url);
                        } else {
                            onError("Upload failed");
                        }
                    })
                    .catch(() => onError("Upload error"));
            }   
        </script>
        <script>
            const input = document.getElementById('imageUploadInput');
            const gallery = document.getElementById('imageGallery');
            const STORAGE_KEY = 'markdown_images';

            document.addEventListener('DOMContentLoaded', loadImages);

            input.addEventListener('change', function () {
                if (!this.files.length) return;

                const file = this.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    compressImage(file, 1200, 0.7).then(base64 => {
                        saveImage({
                            id: Date.now(),
                            title: file.name,
                            data: base64
                        });
                        loadImages();
                    });
                };

                reader.readAsDataURL(file);
                this.value = '';
            });

            function saveImage(image) {
                const images = getImages();
                images.push(image);
                localStorage.setItem(STORAGE_KEY, JSON.stringify(images));
            }

            function getImages() {
                return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
            }

            function loadImages() {
                gallery.innerHTML = '';
                getImages().forEach(addImageCard);
            }

            function addImageCard(image) {
                const card = document.createElement('div');
                card.className = 'card image-card';

                card.innerHTML = `
                                                                                                                                                                                                                                                                                                    <div class="position-relative">
                                                                                                                                                                                                                                                                                                        <img src="${image.data}">
                                                                                                                                                                                                                                                                                                        <button
                                                                                                                                                                                                                                                                                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                                                                                                                                                                                                                                                                            title="Delete"
                                                                                                                                                                                                                                                                                                        >
                                                                                                                                                                                                                                                                                                            &times;
                                                                                                                                                                                                                                                                                                        </button>
                                                                                                                                                                                                                                                                                                    </div>

                                                                                                                                                                                                                                                                                                    <div class="card-body p-3">
                                                                                                                                                                                                                                                                                                        <div class="fw-bold text-truncate mb-2">${image.title}</div>

                                                                                                                                                                                                                                                                                                        <select class="form-select form-select-sm mb-2">
                                                                                                                                                                                                                                                                                                            <option value="300">Small</option>
                                                                                                                                                                                                                                                                                                            <option value="600" selected>Medium</option>
                                                                                                                                                                                                                                                                                                            <option value="900">Large</option>
                                                                                                                                                                                                                                                                                                        </select>

                                                                                                                                                                                                                                                                                                        <button class="btn btn-sm btn-info w-100" type="button">
                                                                                                                                                                                                                                                                                                            Insert
                                                                                                                                                                                                                                                                                                        </button>
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                `;

                // Insert image to editor
                card.querySelector('.btn-info').onclick = () => {
                    const width = card.querySelector('select').value;
                    insertToEditor(image.data, width);
                };

                // Delete image
                card.querySelector('.btn-danger').onclick = () => {
                    deleteImage(image.id);
                };

                gallery.appendChild(card);
            }
            function deleteImage(id) {
                let images = getImages();
                images = images.filter(img => img.id !== id);
                localStorage.setItem(STORAGE_KEY, JSON.stringify(images));
                loadImages();
            }
            function insertToEditor(src, width) {
                // Wrap image in <a> that triggers modal
                const html = `\n<img src="${src}" width="${width}" style="cursor:pointer;" />\n`;

                easyMDE.codemirror.replaceSelection(html);
                easyMDE.codemirror.focus();
            }
            function compressImage(file, maxWidth = 1200, quality = 0.7) {
                return new Promise(resolve => {
                    const img = new Image();
                    const reader = new FileReader();

                    reader.onload = e => img.src = e.target.result;

                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const scale = Math.min(maxWidth / img.width, 1);

                        canvas.width = img.width * scale;
                        canvas.height = img.height * scale;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        resolve(canvas.toDataURL('image/jpeg', quality));
                    };

                    reader.readAsDataURL(file);
                });
            }
            document.addEventListener('click', function (e) {
                const link = e.target.closest('.preview-link');
                if (!link) return;

                e.preventDefault();
                const src = link.getAttribute('data-src');
                const modalImg = document.getElementById('previewImage');

                modalImg.src = src;
                const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                modal.show();
            });
            // For a single element with the class 'side-by-side no-disable no-mobile'
            const element = document.querySelector('.side-by-side.no-disable.no-mobile');
            if (element) {
                element.addEventListener('click', function () {
                    const header = document.getElementById('kt_app_header');
                    header.classList.toggle('hide-header');

                    // Show the toast
                    // const toast = new bootstrap.Toast(document.getElementById('escToast'));
                    // toast.show();
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toastr-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.info("Untuk Keluar Dari Preview, Tekan ESC", "Informasi");
                });
            }

            // Listen for the Esc key to show the header if hidden
            document.addEventListener('keydown', function (event) {
                if (event.key === "Escape") {
                    const header = document.getElementById('kt_app_header');
                    // If the header is hidden, show it when Esc is pressed
                    if (header.classList.contains('hide-header')) {
                        header.classList.remove('hide-header');
                    }
                }
            });

            // Function to generate the TOC based on EasyMDE content
            function generateTOC() {
                const content = easyMDE.value(); // Get markdown content
                const headings = [];

                // Regular expression to match headings (e.g. # Heading, ## Subheading)
                const headingRegex = /^(#{1,6})\s+(.+)$/gm;

                let match;
                while ((match = headingRegex.exec(content)) !== null) {
                    const level = match[1].length;  // The number of '#' represents the heading level
                    const text = match[2];          // The actual heading text

                    // Create an ID for the heading to use in the anchor tag
                    const id = text.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');

                    // Push to headings array with level and text
                    headings.push({ level, text, id });
                }

                return headings;
            }

            // Function to build and display the TOC in the menu
            function showTOC() {
                const tocContainer = document.getElementById('tocMenu');  // The container where the TOC will be inserted
                const headings = generateTOC();  // Get the headings from the markdown content

                if (headings.length === 0) {
                    tocContainer.innerHTML = '<div class="menu-item">No headings found</div>';
                    return;
                }

                // Build the HTML for the TOC
                let tocHTML = '';
                headings.forEach(heading => {
                    tocHTML += `
                                                                                                                                                                <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click" style="margin-left: ${heading.level * 4}px;">
                                                                                                                                                                    <!--begin::Menu link-->
                                                                                                                                                                    <a href="#${heading.id}" class="menu-link py-1">
                                                                                                                                                                        <span class="menu-title">${heading.text}</span>
                                                                                                                                                                        <span class="menu-arrow"></span>
                                                                                                                                                                    </a>
                                                                                                                                                                    <!--end::Menu link-->

                                                                                                                                                                    <!--begin::Menu sub-->
                                                                                                                                                                    <div class="menu-sub menu-sub-accordion pt-1">
                                                                                                                                                                        <!-- Add sub-menu items here if needed -->
                                                                                                                                                                    </div>
                                                                                                                                                                    <!--end::Menu sub-->
                                                                                                                                                                </div>
                                                                                                                                                            `;
                });

                tocContainer.innerHTML = tocHTML;
            }

            // Example: Show the TOC when the editor content changes
            easyMDE.codemirror.on('change', function () {
                showTOC();
            });


            // Initially load the TOC when the page is ready or when editor content is loaded
            document.addEventListener('DOMContentLoaded', showTOC);

        </script>

        <script>
            document.getElementById('submitForm').addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default form submit behavior

                // Create FormData object
                // Create FormData object from the form
                var formData = new FormData(document.getElementById('createPostForm'));

                // Get markdown content from EasyMDE and append it to FormData
                formData.append('content', easyMDE.value()); // Append the markdown content

                // Use Fetch API or AJAX to submit the form
                fetch('{{ route("storekonten") }}', {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'Post inserted successfully!') {
                            alert('Konten berhasil disimpan!');
                            // Optionally, redirect or reset the form
                        } else {
                            alert('Terjadi kesalahan!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim data.');
                    });
            });
        </script>
    @endsection
@endsection