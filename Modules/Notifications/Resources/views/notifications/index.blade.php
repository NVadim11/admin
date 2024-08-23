@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('page-title', $title)

@section('actions')
	<a href="{{ action($controller.'@create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> {{ __('core::app.btn_create') }}</a>
@endsection

@section('content')
	<div class="col-xl-12 mb-10">
		<!--begin::Chart Widget 1-->
		<div class="card card-flush h-lg-100">
			<!--begin::Header-->
			<div class="card-header pt-5">
				<!--begin::Title-->
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold text-dark">Notify activity</span>
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
							<a href="/admin/notifications/?stat=minute" class="menu-link px-3 {{ request()->get('stat') == 'minute' || !request()->get('stat') ? 'active' : '' }}">Minute</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="/admin/notifications/?stat=hour" class="menu-link px-3 {{ request()->get('stat') == 'hour' ? 'active' : '' }}">Hour</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="/admin/notifications/?stat=day" class="menu-link px-3 {{ request()->get('stat') == 'day' ? 'active' : '' }}">Day</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="/admin/notifications/?stat=week" class="menu-link px-3 {{ request()->get('stat') == 'week' ? 'active' : '' }}">Week</a>
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
	<!--begin::Card-->
	<div class="card rounded-0 border-0">
		<!--begin::Card header-->
		<div class="card-header border-1 pt-0">
			<!--begin::Card title-->
			<div class="card-title">
				<!--begin::Search-->
				<div class="d-flex align-items-center position-relative my-1">
					<i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
					<form action="{{ action($controller.'@index') }}" method="get">
						<input type="text" name="search" value="{{ request()->get('search') ?? '' }}" data-kt-customer-table-filter="search" class="form-control ps-13 rounded-0 h-40px" placeholder="{{ __('core::app.placeholder_search') }}" />
					</form>
				</div>
				<!--end::Search-->
			</div>
			<!--begin::Card title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Toolbar-->
				<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
					<!--begin::Add customer-->
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">{{ __('core::app.btn_add') }}</button>
					<!--end::Add customer-->
				</div>
				<!--end::Toolbar-->
				<!--begin::Group actions-->
				<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
					<div class="fw-bold me-5">
						<span class="me-2" data-kt-customer-table-select="selected_count"></span>{{ __('core::app.btn_selected') }}</div>
					<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">{{ __('core::app.btn_delete_selected') }}</button>
				</div>
				<!--end::Group actions-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-0">
			@include('notifications::common.table.' . $outlist)
		</div>
		<!--end::Card body-->
	</div>
	<!--end::Card-->

	@include('core::common.modal.create')
@endsection

@php
	$period = 'minute';
	if (isset($_GET['stat'])) {
		$period = $_GET['stat'];
	}
	switch($period) {
		case "minute":
			$count = 60;
			break;
		case "hour":
			$count = 24;
			break;
		case "day":
			$count = 14;
			break;
		case "week":
			$count = 4;
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
                            chart: { fontFamily: "inherit", type: "line", height: l, toolbar: { show: !1 } },
                            plotOptions: {
                                line: {
                                    curve: 'smooth', // Установка сглаживания линии
                                    dataLabels: { enabled: false }, // Отключаем метки данных
                                }
                            },
                            legend: { show: !1 },
                            dataLabels: { enabled: !1 },
                            xaxis: {
                                categories: {!! $vote_d !!},
                                axisBorder: { show: !1 },
                                axisTicks: { show: !1 },
                                tickAmount: {{ $count }},
                                labels: { style: { colors: [r], fontSize: "10px" } },
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
                                        return e > 0 ? e : Math.abs(e);
                                    },
                                },
                            },
                            colors: [KTUtil.getCssVariableValue("--bs-primary"), a],
                            grid: { borderColor: o, strokeDashArray: 4, yaxis: { lines: { show: !0 } } },
                            markers: {
                                size: 4, // Размер маркеров (точек) на линии
                                colors: [KTUtil.getCssVariableValue("--bs-primary")],
                                strokeColor: KTUtil.getCssVariableValue("--bs-primary"),
                                strokeWidth: 2,
                                hover: {
                                    size: 6,
                                },
                            },
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