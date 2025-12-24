<div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
    <div class="card p-3">
        <!-- Card Header -->
        <div class="card-header">
            <div class="card-toolbar" id="kt_accordion_1">
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <!-- Add Category Button -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                        data-bs-target="#kt_accordion_1_body_1" aria-expanded="true"
                        aria-controls="kt_accordion_1_body_1" id="addCategoryBtn">+ Kategori</button>
                </div>
            </div>
        </div>

        <!-- Card Body with Form -->
        <div class="card-body pt-0">
            <div id="kt_accordion_1_body_1" class="accordion-collapse collapse"
                aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                <div class="accordion-body mt-3">
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" class="form-control form-control-solid" placeholder="" name="name">
                    </div>
                    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Category Table -->
            <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kategoriTable">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">No</th>
                        <th class="min-w-125px">Nama Kategori</th>
                        <th>Created By</th>
                        <th class="text-end min-w-70px">Actions</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    <!-- Data will be loaded here via DataTable -->
                </tbody>
            </table>
        </div>

    </div>
</div>