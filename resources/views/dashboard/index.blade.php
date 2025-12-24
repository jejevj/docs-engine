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
                        <h3 class="fs-2hx text-gray-900 mb-5">Selamat Datang di CMS Dokumentasi Kemenag</h3>
                        <!--end::Title-->

                        <!--begin::Text-->
                        <div class="fs-5 text-muted fw-semibold">
                            This is a Content Management System (CMS) application designed to manage zakat distribution data
                            and
                            integrate with Docusaurus for documentation deployment. The system connects to the Data Terpadu
                            Sosial Ekonomi Nasional (DTSEN) to verify beneficiaries based on NIK, address, and
                            socio-economic
                            conditions, ensuring accurate zakat distribution. The CMS serves as the backend data management
                            solution that can be connected to Docusaurus for documentation and deployment purposes.
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Top-->

                    <!--begin::Overlay-->
                    <div class="overlay">
                        <!--begin::Image-->
                        <img class="w-100 card-rounded" src="assets/media/ok.webp" alt="">
                        <!--end::Image-->

                        <!--begin::Links-->
                        {{-- <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                            <a href="/metronic8/demo35/pages/pricing.html" class="btn btn-primary">Pricing</a>

                            <a href="/metronic8/demo35/pages/careers/apply.html" class="btn btn-light-primary ms-3">Join
                                Us</a>
                        </div> --}}
                        <!--end::Links-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Description-->
                <div class="fs-5 fw-semibold text-gray-600">
                    <!--begin::Text-->
                    <p class="mb-8">
                        The application features:
                        <li>
                            Zakat distribution management
                        </li>
                        <li>
                            DTSEN data integration for beneficiary verification
                        </li>
                        <li>
                            CMS functionality for content management
                        </li>
                        <li>
                            Secure authentication system
                        </li>
                        <li>
                            Docusaurus integration for documentation deployment
                        </li>
                        <li>
                            Responsive web interface
                        </li>
                    </p>
                    <!--end::Text-->

                    <!--begin::Text-->
                    <p class="mb-8">
                        This system ensures transparent and data-driven zakat distribution by leveraging validated
                        socio-economic data from DTSEN, moving away from traditional estimation-based approaches to
                        evidence-based targeting.
                    </p>
                    <!--end::Text-->


                </div>
                <!--end::Description-->
            </div>
            <!--end::About-->


        </div>
    </div>

@endsection