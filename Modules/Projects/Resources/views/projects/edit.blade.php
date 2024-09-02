@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('page-title', $title)

@section('breadcrumb')
    @include('core::common.breadcrumb')
@endsection

@section('content')
    <div class="col-xl-12 mb-10">
        <!--begin::Chart Widget 1-->
        <div class="card card-flush h-lg-100">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">{{ $item->name }} Voting Activity{{ request()->get('stat') == 'day' || !request()->get('stat') ? ' / Hour' : '' }}{{ request()->get('stat') == 'week' ? ' / Day' : '' }}{{ request()->get('stat') == 'month' ? ' / Days of month' : '' }}{{ request()->get('stat') == 'year' ? ' / Months of year' : '' }}</span>
                    {{--                <span class="text-gray-400 pt-2 fw-semibold fs-6">75% activity growth</span>--}}
                </h3>
                <!--end::Title-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-calendar fs-2qx"></i>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true" style="">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Settings</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/admin/projects/{{ $item->id }}/edit?stat=day" class="menu-link px-3 {{ request()->get('stat') == 'day' || !request()->get('stat') ? 'active' : '' }}">Day</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/admin/projects/{{ $item->id }}/edit?stat=week" class="menu-link px-3 {{ request()->get('stat') == 'week' ? 'active' : '' }}">Week</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/admin/projects/{{ $item->id }}/edit?stat=month" class="menu-link px-3 {{ request()->get('stat') == 'month' ? 'active' : '' }}">Month</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/admin/projects/{{ $item->id }}/edit?stat=year" class="menu-link px-3 {{ request()->get('stat') == 'year' ? 'active' : '' }}">Year</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mt-3 opacity-75"></div>
                        <!--end::Menu separator-->
                    </div>
                    <!--begin::Menu 2-->

                    <!--end::Menu 2-->
                    <!--end::Menu-->
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 px-0">
                <!--begin::Chart-->
                <div id="kt_charts_game_dynamics" class="min-h-auto ps-4 pe-6 mb-3" style="height: 250px"></div>
                <!--end::Chart-->
                <!--begin::Info-->
                <div class="d-flex align-items-center px-9">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center me-6">
                        <!--begin::Bullet-->
                        <span class="rounded-1 bg-primary me-2 h-10px w-10px"></span>
                        <!--end::Bullet-->
                        <!--begin::Label-->
                        <span class="fw-semibold fs-6 text-gray-600">Votes</span>
                        <!--end::Label-->
                    </div>
                    <!--ed::Item-->
                </div>
                <!--ed::Info-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Chart Widget 1-->
    </div>
    @section('actions')
        <a href="{{ action($controller.'@index') }}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">{{ __('core::app.btn_to_list') }}</a>
        <a href="{{ route('projects-tasks.index', $item->id) }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">Tasks</a>
    @endsection
    {!! form_start($form, ['class'=>'form-horizontal form-bordered form-label-stripped', 'id' => 'kt_ecommerce_add_product_form']) !!}
    @include('core::common.form_body')
    {!! form_end($form) !!}
@endsection
@push('scripts')
    <script src="{{ config('assets.metronic.assets_path', '') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ config('assets.base.scripts', '') }}/form/save.js"></script>
@endpush

@php
    $period = 'day';
	if (isset($_GET['stat'])) {
		$period = $_GET['stat'];
	}
	switch($period) {
		case "day":
			$count = 24;
			break;
		case "week":
			$count = 14;
			break;
		case "month":
			$count = 31;
			break;
		case "year":
			$count = 12;
			break;
	}

	$vote_d = collect(array_reverse($votes))->pluck('day')->toJson();
	$vote = collect(array_reverse($votes))->pluck('votes')->toJson();

	$maxValueVotes = max(collect(array_reverse($votes))->pluck('votes')->toArray());

@endphp
@push('scripts')
    <script>
        var KTChartsGameDynamics = (function () {
            var e = { self: null, rendered: !1 },
                    t = function () {
                        var t = document.getElementById("kt_charts_game_dynamics");
                        if (t) {
                            var a = t.hasAttribute("data-kt-negative-color") ? t.getAttribute("data-kt-negative-color") : KTUtil.getCssVariableValue("--bs-success"),
                                    l = parseInt(KTUtil.css(t, "height")),
                                    r = KTUtil.getCssVariableValue("--bs-gray-500"),
                                    o = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                                    i = {
                                        series: [
                                            { name: "Votes", data: {{ $vote }} },
                                        ],
                                        chart: { fontFamily: "inherit", type: "bar", stacked: !0, height: l, toolbar: { show: !1 } },
                                        plotOptions: { bar: { columnWidth: "35%", barHeight: "70%", borderRadius: [6, 6] } },
                                        legend: { show: !1 },
                                        dataLabels: { enabled: !1 },
                                        xaxis: {
                                            categories: {!! $vote_d !!},
                                            axisBorder: { show: !1 },
                                            axisTicks: { show: !1 },
                                            tickAmount: {{ $count }},
                                            labels: { style: { colors: [r], fontSize: "11px" } },
                                            crosshairs: { show: !1 },
                                        },
                                        yaxis: {
                                            min: 0,
                                            max: {{ $maxValueVotes }},
                                            tickAmount: 3,
                                            labels: {
                                                style: { colors: [r], fontSize: "11px" },
                                                formatter: function (e) {
                                                    return parseInt(e);
                                                },
                                            },
                                        },
                                        responsive: [
                                            {
                                                breakpoint: 768,
                                                options: {
                                                    xaxis: {
                                                        labels: {
                                                            style: {
                                                                fontSize: "7px"
                                                            }
                                                        }
                                                    },
                                                    yaxis: {
                                                        labels: {
                                                            style: {
                                                                fontSize: "7px"
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        ],
                                        fill: { opacity: 1 },
                                        states: { normal: { filter: { type: "none", value: 0 } }, hover: { filter: { type: "none", value: 0 } }, active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } } },
                                        tooltip: {
                                            style: { fontSize: "12px", borderRadius: 4 },
                                            y: {
                                                formatter: function (e) {
                                                    return e > 0 ? e  : Math.abs(e);
                                                },
                                            },
                                        },
                                        colors: [KTUtil.getCssVariableValue("--bs-primary"), a],
                                        grid: { borderColor: o, strokeDashArray: 4, yaxis: { lines: { show: !0 } } },
                                    };
                            (e.self = new ApexCharts(t, i)),
                                    setTimeout(function () {
                                        e.self.render(), (e.rendered = !0);
                                    }, 200);
                        }
                    };
            return {
                init: function () {
                    t(),
                            KTThemeMode.on("kt.thememode.change", function () {
                                e.rendered && e.self.destroy(), t();
                            });
                },
            };
        })();

        "undefined" != typeof module && (module.exports = KTChartsWidget1) && (module.exports = KTChartsGameDynamics),
                KTUtil.onDOMContentLoaded(function () {
                    KTChartsGameDynamics.init();
                });
    </script>
@endpush