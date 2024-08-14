@php $aside = 0; @endphp
@foreach($form->getFields() as $name=>$value)
    @if($value->getOption('aside'))
        @php $aside = 1; @endphp
    @endif
@endforeach
<div class="card border-0">
    @include('core::common.particles.save-button')
    <div class="card-header card-header-stretch">
{{--        <h3 class="card-title">Localization</h3>--}}
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                <li class="nav-item">
                    <a class="nav-link text-uppercase active" data-bs-toggle="tab" href="#kt_tab_pane_1">{{ app()->getLocale() }}</a>
                </li>
                @foreach($form->getFields() as $name=>$value)
                    @if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType && $value->getOption('tab'))
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_{{ $name }}">{{ $value->getOption('label') }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                <!--begin::Form-->
                <div id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo42/dist/apps/ecommerce/catalog/products.html">
                    @if($aside)
                        <!--begin::Aside column-->
                        <div class=" aside d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                            @foreach($form->getFields() as $name=>$value)
                                @if(!$value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType || !$value->getOption('tab'))
                                    @if($value->getOption('aside'))
                                        <!--begin::Thumbnail settings-->
                                        <div class="card card-flush">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h5>{{ $value->getOption('label') }}</h5>
                                                </div>
                                                <!--end::Card title-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body text-center pt-0">
                                                {!! form_row($value) !!}
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Thumbnail settings-->
                                    @endif
                                @endif
                            @endforeach
                            @if(isset($uri))
                                <div class="card card-flush">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h5>QR code</h5>
                                        </div>
                                    </div>
                                    <!--begin::Card body-->
                                    <div class="card-body text-center pt-0">
                                        <div class="form-group">
                                            <div class="col-md-9">
                                                <img src="<?= $uri ?>" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!--end::Aside column-->
                    @endif
                    <!--begin::Main column-->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('core::app.title_general') }}</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @foreach($form->getFields() as $name=>$value)
                                    @if(!$value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType || !$value->getOption('tab'))
                                        @if(!$value->getOption('aside'))
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                {!! form_row($value) !!}
                                            </div>
                                            <!--end::Input group-->
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                    <!--end::Main column-->
                </div>
                <!--end::Form-->
            </div>

            @foreach($form->getFields() as $name=>$value)
                @if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType
					&& $value->getOption('tab')
				)
                    <div class="tab-pane fade" id="kt_tab_{{ $name }}" role="tabpanel">
                        {!! form_row($value) !!}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>