@extends('layouts.app')

@section('content')

    <div class="app-container container-xxl">
        <div class="card-body p-lg-17">
            <!--begin::About-->
            <div class="mb-18">
                <!--begin::Wrapper-->
                <div class="mb-10">
                    <!--begin::Top-->
                    <div class="text-center mb-15">
                        <!--begin::Title-->
                        <h3 class="fs-2hx text-gray-900 mb-5">Manajemen</h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Top-->
                </div>

                <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10"
                    style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('assets/media/illustrations/sketchy-1/4.png')">
                    <!--begin::Card header-->
                    <div class="card-header pt-10">
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
                                <h2 class="mb-1">Main Menu</h2>
                                <div class="text-muted fw-bold">
                                    Konfigurasi Umum
                                </div>
                            </div>
                            <!--end::Title-->
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pb-0">
                        <!--begin::Navs-->
                        <div class="d-flex overflow-auto h-55px">
                            <ul
                                class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-semibold flex-nowrap">
                                <!--begin::Nav item-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary me-6 active" data-bs-toggle="tab"
                                        href="#kt_tab_pane_1">Kategori</a>
                                </li>
                                <!--end::Nav item-->
                                <!--begin::Nav item-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary me-6" data-bs-toggle="tab" href="#kt_tab_pane_2"
                                        id="kt_tab_pane_2tab">Modul</a>
                                </li>
                                <!--end::Nav item-->
                                <!--begin::Nav item-->
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary me-6" data-bs-toggle="tab"
                                        href="#kt_tab_pane_3">Daftar Konten</a>
                                </li>
                                <!--end::Nav item-->
                            </ul>
                        </div>
                        <!--begin::Navs-->
                    </div>
                    <!--end::Card body-->

                </div>
                <!--end::Container-->
                <!-- TABS HERE -->
                <div class="tab-content" id="myTabContent">
                    @include('manajemen.partials.kategori')
                    @include('manajemen.partials.modul', ['kategoris' => $kategoris])
                    @include('manajemen.partials.konten')
                </div>
            </div>
            <!--end::Wrapper-->


        </div>
        @section('content_scripts')
            @include('manajemen.partials.scripts.kategoriscript')
            @include('manajemen.partials.scripts.modulscript')
            @include('manajemen.partials.scripts.kontenscript')
        @endsection
        <!--end::About-->
    </div>

@endsection