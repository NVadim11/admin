<div class="row g-5 g-xl-10 g-xl-10 mb-10">
    <div class="col-xl-4">
        <!--begin::List widget 12-->
        <div class="card card-flush h-xl-100">
            <!--begin::Body-->
            <div class="card-body d-flex align-items-end">
                <!--begin::Wrapper-->
                <div class="w-100">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-people fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Total Members</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Total number of all members </span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format(\Modules\Accounts\Entities\Account::select('id')->count()) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
{{--                                <span class="badge badge-light-success fs-base">--}}
{{--                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-chart-simple-2 fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">24 Hours</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">New members in 24 hours</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($lastHourNew) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                {{--                                <span class="badge badge-light-success fs-base">--}}
                                {{--                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-joystick fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Voting today</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <!--begin::Desc-->
                                <!--end::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Active a hour: {{ number_format($lastHourPlaying) }} / a min: {{ number_format($lastMinutePlaying) }}</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($nowPlaying) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
{{--                                <span class="badge badge-light-success fs-base">--}}
{{--                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-wallet fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Wallet(Yes/No)</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Players with/without wallet address</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($hasWallet) }} / {{ number_format($noWallet) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                {{--                                <span class="badge badge-light-success fs-base">--}}
                                {{--                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-abstract-11 fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Not voting yet</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Users who have never vote</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($neverPlaying) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
{{--                                <span class="badge badge-light-success fs-base">--}}
{{--                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>0.2%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-data fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Referrals</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Registered by referral link</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format(\Modules\Accounts\Entities\Account::select('id')->where('parent_id', '>', 0)->count()) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
{{--                                <span class="badge badge-light-danger fs-base">--}}
{{--                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
{{--                    <div class="separator separator-dashed my-3"></div>--}}
{{--                    <!--end::Separator-->--}}
{{--                    <!--begin::Item-->--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                        <!--begin::Symbol-->--}}
{{--                        <div class="symbol symbol-30px me-5">--}}
{{--                            <span class="symbol-label">--}}
{{--                                <i class="ki-outline ki-watch fs-3 text-gray-600"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <!--end::Symbol-->--}}
{{--                        <!--begin::Container-->--}}
{{--                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">--}}
{{--                            <!--begin::Content-->--}}
{{--                            <div class="me-5">--}}
{{--                                <!--begin::Title-->--}}
{{--                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Call Down</a>--}}
{{--                                <!--end::Title-->--}}
{{--                                <!--begin::Desc-->--}}
{{--                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Waiting to play (notified: {{ number_format($callDownAccountsNotified) }} / processing: {{ number_format($callDowntNotifyJobs) }} / new: {{ number_format($callDownAccountsNotNotified) }})</span>--}}
{{--                                <!--end::Desc-->--}}
{{--                            </div>--}}
{{--                            <!--end::Content-->--}}
{{--                            <!--begin::Wrapper-->--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <!--begin::Number-->--}}
{{--                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($callDownAccounts) }}</span>--}}
{{--                                <!--end::Number-->--}}
{{--                            </div>--}}
{{--                            <!--end::Wrapper-->--}}
{{--                        </div>--}}
{{--                        <!--end::Container-->--}}
{{--                    </div>--}}
                    <!--end::Item-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::List widget 12-->
    </div>
    <div class="col-xl-8">
        <!--begin::Chart Widget 1-->
        <div class="card card-flush h-lg-100">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">New Members{{ request()->get('new') == 'day' || !request()->get('new') ? ' / Hour' : '' }}{{ request()->get('new') == 'week' ? ' / Day' : '' }}{{ request()->get('new') == 'month' ? ' / Days of month' : '' }}{{ request()->get('new') == 'year' ? ' / Months of year' : '' }}</span>
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
                            <a href="{{ route('admin.index', ['new' => 'day', 'votes' => request()->get('votes') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('new') == 'day' || !request()->get('new') ? 'active' : '' }}">Day</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('admin.index', ['new' => 'week', 'votes' => request()->get('votes') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('new') == 'week' ? 'active' : '' }}">Week</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('admin.index', ['new' => 'month', 'votes' => request()->get('votes') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('new') == 'month' ? 'active' : '' }}">Month</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('admin.index', ['new' => 'year', 'votes' => request()->get('votes') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('new') == 'year' ? 'active' : '' }}">Year</a>
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
                <div id="kt_charts_widget_1" class="min-h-auto ps-4 pe-6 mb-3" style="height: 250px"></div>
                <!--end::Chart-->
                <!--begin::Info-->
                <div class="d-flex align-items-center px-9">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center me-6">
                        <!--begin::Bullet-->
                        <span class="rounded-1 bg-primary me-2 h-10px w-10px"></span>
                        <!--end::Bullet-->
                        <!--begin::Label-->
                        <span class="fw-semibold fs-6 text-gray-600">New members</span>
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
</div>

<div class="col-xl-12">
    <!--begin::Chart Widget 1-->
    <div class="card card-flush h-lg-100">
        <!--begin::Header-->
        <div class="card-header pt-5">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">Voting Activity{{ request()->get('votes') == 'day' || !request()->get('votes') ? ' / Hour' : '' }}{{ request()->get('votes') == 'week' ? ' / Day' : '' }}{{ request()->get('votes') == 'month' ? ' / Days of month' : '' }}{{ request()->get('votes') == 'year' ? ' / Months of year' : '' }}</span>
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
                        <a href="{{ route('admin.index', ['votes' => 'day', 'new' => request()->get('new') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('votes') == 'day' || !request()->get('votes') ? 'active' : '' }}">Day</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="{{ route('admin.index', ['votes' => 'week', 'new' => request()->get('new') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('votes') == 'week' ? 'active' : '' }}">Week</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="{{ route('admin.index', ['votes' => 'month', 'new' => request()->get('new') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('votes') == 'month' ? 'active' : '' }}">Month</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="{{ route('admin.index', ['votes' => 'year', 'new' => request()->get('new') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('votes') == 'year' ? 'active' : '' }}">Year</a>
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

@php
    $period_new = 'day';
    if (isset($_GET['new'])) {
        $period_new = $_GET['new'];
    }
    switch($period_new) {
        case "day":
            $count_new = 24;
            break;
        case "week":
            $count_new = 14;
            break;
        case "month":
            $count_new = 31;
            break;
        case "year":
            $count_new = 12;
            break;
    }

    $period_votes = 'day';
    if (isset($_GET['new'])) {
        $period_votes = $_GET['new'];
    }
    switch($period_votes) {
        case "day":
            $count_votes = 24;
            break;
        case "week":
            $count_votes = 14;
            break;
        case "month":
            $count_votes = 31;
            break;
        case "year":
            $count_votes = 12;
            break;
    }

    $d = collect(array_reverse($days))->pluck('day')->toJson();
    $telegram = collect(array_reverse($days))->pluck('telegram')->toJson();
    $vote_d = collect(array_reverse($votes))->pluck('day')->toJson();
    $vote = collect(array_reverse($votes))->pluck('votes')->toJson();

    $maxValueDays = max(collect(array_reverse($days))->pluck('telegram')->toArray());
    $maxValueVotes = max(collect(array_reverse($votes))->pluck('votes')->toArray());

@endphp
@push('scripts')
    <script>
        var KTChartsWidget1 = (function () {
            var e = { self: null, rendered: !1 },
                    t = function () {
                        var t = document.getElementById("kt_charts_widget_1");
                        if (t) {
                            var a = t.hasAttribute("data-kt-negative-color") ? t.getAttribute("data-kt-negative-color") : KTUtil.getCssVariableValue("--bs-success"),
                                    l = parseInt(KTUtil.css(t, "height")),
                                    r = KTUtil.getCssVariableValue("--bs-gray-500"),
                                    o = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                                    i = {
                                        series: [
                                            { name: "Members", data: {{ $telegram }} },
                                        ],
                                        chart: { fontFamily: "inherit", type: "bar", stacked: !0, height: l, toolbar: { show: !1 } },
                                        plotOptions: { bar: { columnWidth: "35%", barHeight: "70%", borderRadius: [6, 6] } },
                                        legend: { show: !1 },
                                        dataLabels: { enabled: !1 },
                                        xaxis: {
                                            categories: {!! $d !!},
                                            axisBorder: { show: !1 },
                                            axisTicks: { show: !1 },
                                            tickAmount: {{ $count_new }},
                                            labels: {style: { colors: [r], fontSize: "10px" },},
                                            crosshairs: { show: !1 },
                                        },
                                        yaxis: {
                                            min: 0,
                                            max: {{ $maxValueDays }},
                                            tickAmount: 6,
                                            labels: {
                                                style: { colors: [r], fontSize: "10px" },
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
                                            tickAmount: {{ $count_votes }},
                                            labels: { style: { colors: [r], fontSize: "11px" } },
                                            crosshairs: { show: !1 },
                                        },
                                        yaxis: {
                                            min: 0,
                                            max: {{ $maxValueVotes }},
                                            tickAmount: 6,
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
                    KTChartsWidget1.init();
                    KTChartsGameDynamics.init();
                });
    </script>
@endpush