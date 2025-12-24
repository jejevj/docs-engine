
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <div class="card p-3">
                            <div class="card-header">
                                <div class="card-toolbar" id="kt_accordion_2">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                        <!--begin::Filter-->
                                        <!--begin::Add customer-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                                            data-bs-target="#kt_accordion_2_body_1" aria-expanded="true"
                                            aria-controls="kt_accordion_2_body_1">+ Modul</button>
                                        <!--end::Add customer-->
                                    </div>

                                    <!--end::Toolbar-->
                                    <!--begin::Group actions-->
                                    <div class="d-flex justify-content-end align-items-center d-none"
                                        data-kt-customer-table-toolbar="selected">
                                        <div class="fw-bold me-5">
                                            <span class="me-2"
                                                data-kt-customer-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-kt-customer-table-select="delete_selected">Delete Selected</button>
                                    </div>
                                    <!--end::Group actions-->
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div id="kt_accordion_2_body_1" class="accordion-collapse collapse"
                                    aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                                    <div class="accordion-body mt-3">
                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2">Nama Modul</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder=""
                                                name="name">
                                            <!--end::Input-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>

                                        <div class="fv-row mb-7 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-semibold mb-2">Kategori</label>
                                            <!--end::Label-->
                                            <div class="mb-3">
                                                <select class="form-select" name="" id="">
                                                    <option selected>Select one</option>
                                                    <option value="">New Delhi</option>
                                                    <option value="">Istanbul</option>
                                                    <option value="">Jakarta</option>
                                                </select>
                                            </div>

                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>

                                        <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                                            <span class="indicator-label">Simpan</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </div>
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_customers_table">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                        data-kt-check-target="#kt_customers_table .form-check-input"
                                                        value="1" />
                                                </div>
                                            </th>
                                            <th class="min-w-125px">Nama Modul</th>
                                            <th class="min-w-125px">Kategori</th>
                                            <th class="text-end min-w-70px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>