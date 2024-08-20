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
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Total Players</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Total number of all players </span>
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
                                <i class="ki-outline ki-joystick fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Playing today</a>
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
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Has Wallet</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Players with wallet address</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($hasWallet) }}</span>
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
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Not playing yet</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Users who have never played</span>
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
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-watch fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Call Down</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">Waiting to play (notified: {{ number_format($callDownAccountsNotified) }} / processing: {{ number_format($callDowntNotifyJobs) }} / new: {{ number_format($callDownAccountsNotNotified) }})</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">{{ number_format($callDownAccounts) }}</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
{{--                                <span class="badge badge-light-success fs-base">--}}
{{--																	<i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>--}}
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
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
                    <span class="card-label fw-bold text-dark">New Players</span>
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
                            <a href="{{ route('admin.index', ['newPlayers' => 'day', 'playing' => request()->get('playing') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('newPlayers') == 'day' || !request()->get('newPlayers') ? 'active' : '' }}">Day</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('admin.index', ['newPlayers' => 'week', 'playing' => request()->get('playing') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('newPlayers') == 'week' ? 'active' : '' }}">Week</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('admin.index', ['newPlayers' => 'month', 'playing' => request()->get('playing') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('newPlayers') == 'month' ? 'active' : '' }}">Month</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('admin.index', ['newPlayers' => 'year', 'playing' => request()->get('playing') ?? 'day']) }}" class="menu-link px-3 {{ request()->get('newPlayers') == 'year' ? 'active' : '' }}">Year</a>
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
                        <span class="fw-semibold fs-6 text-gray-600">Telegram</span>
                        <!--end::Label-->
                    </div>
                    <!--ed::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Bullet-->
                        <span class="rounded-1 bg-success me-2 h-10px w-10px"></span>
                        <!--end::Bullet-->
                        <!--begin::Label-->
                        <span class="fw-semibold fs-6 text-gray-600">Web</span>
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

{{--<div class="col-xl-12 mb-10">--}}
{{--    <!--begin::Chart Widget 1-->--}}
{{--    <div class="card card-flush h-lg-100">--}}
{{--        <!--begin::Header-->--}}
{{--        <div class="card-header pt-5">--}}
{{--            <!--begin::Title-->--}}
{{--            <h3 class="card-title align-items-start flex-column">--}}
{{--                <span class="card-label fw-bold text-dark">Players/Day</span>--}}
{{--                --}}{{--                <span class="text-gray-400 pt-2 fw-semibold fs-6">75% activity growth</span>--}}
{{--            </h3>--}}
{{--            <!--end::Title-->--}}
{{--        </div>--}}
{{--        <!--end::Header-->--}}
{{--        <!--begin::Body-->--}}
{{--        <div class="card-body pt-0 px-0">--}}
{{--            <!--begin::Chart-->--}}
{{--            <div id="kt_charts_players" class="min-h-auto ps-4 pe-6 mb-3" style="height: 250px"></div>--}}
{{--            <!--end::Chart-->--}}
{{--            <!--begin::Info-->--}}
{{--            <div class="d-flex align-items-center px-9">--}}
{{--                <!--begin::Item-->--}}
{{--                <div class="d-flex align-items-center me-6">--}}
{{--                    <!--begin::Bullet-->--}}
{{--                    <span class="rounded-1 bg-primary me-2 h-10px w-10px"></span>--}}
{{--                    <!--end::Bullet-->--}}
{{--                    <!--begin::Label-->--}}
{{--                    <span class="fw-semibold fs-6 text-gray-600">Telegram</span>--}}
{{--                    <!--end::Label-->--}}
{{--                </div>--}}
{{--                <!--ed::Item-->--}}
{{--                <!--begin::Item-->--}}
{{--                <div class="d-flex align-items-center">--}}
{{--                    <!--begin::Bullet-->--}}
{{--                    <span class="rounded-1 bg-success me-2 h-10px w-10px"></span>--}}
{{--                    <!--end::Bullet-->--}}
{{--                    <!--begin::Label-->--}}
{{--                    <span class="fw-semibold fs-6 text-gray-600">Web</span>--}}
{{--                    <!--end::Label-->--}}
{{--                </div>--}}
{{--                <!--ed::Item-->--}}
{{--            </div>--}}
{{--            <!--ed::Info-->--}}
{{--        </div>--}}
{{--        <!--end::Body-->--}}
{{--    </div>--}}
{{--    <!--end::Chart Widget 1-->--}}
{{--</div>--}}

<div class="col-xl-12">
    <!--begin::Chart Widget 1-->
    <div class="card card-flush h-lg-100">
        <!--begin::Header-->
        <div class="card-header pt-5">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-dark">Last Time Playing</span>
                {{--                <span class="text-gray-400 pt-2 fw-semibold fs-6">75% activity growth</span>--}}
            </h3>
            <!--end::Title-->
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
                    <span class="fw-semibold fs-6 text-gray-600">Telegram</span>
                    <!--end::Label-->
                </div>
                <!--ed::Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center">
                    <!--begin::Bullet-->
                    <span class="rounded-1 bg-success me-2 h-10px w-10px"></span>
                    <!--end::Bullet-->
                    <!--begin::Label-->
                    <span class="fw-semibold fs-6 text-gray-600">Web</span>
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
    $period = 'day';
    if (isset($_GET['newPlayers'])) {
        $period = $_GET['newPlayers'];
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
    $d = collect(array_reverse($days))->pluck('day')->toJson();
    $telegram = collect(array_reverse($days))->pluck('telegram')->toJson();
    $web = collect(array_reverse($days))->pluck('web')->toJson();

    $gaming_d = collect(array_reverse($gaming))->pluck('day')->toJson();
    $gaming_telegram = collect(array_reverse($gaming))->pluck('telegram')->toJson();
    $gaming_web = collect(array_reverse($gaming))->pluck('web')->toJson();

    $maxValue = max(collect(array_reverse($gaming))->pluck('telegram')->toArray());
    $maxValueDays = max(collect(array_reverse($days))->pluck('telegram')->toArray());
//    $players_d = collect(array_reverse($players))->pluck('day')->toJson();
//    $players_telegram = collect(array_reverse($players))->pluck('telegram')->toJson();
//    $players_web = collect(array_reverse($players))->pluck('web')->toJson();
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
                                            { name: "Telegram", data: {{ $telegram }} },
                                            { name: "WEB", data: {{ $web }} },
                                        ],
                                        chart: { fontFamily: "inherit", type: "bar", stacked: !0, height: l, toolbar: { show: !1 } },
                                        plotOptions: { bar: { columnWidth: "45%", barHeight: "70%", borderRadius: [6, 6] } },
                                        legend: { show: !1 },
                                        dataLabels: { enabled: !1 },
                                        xaxis: {
                                            categories: {!! $d !!},
                                            axisBorder: { show: !1 },
                                            axisTicks: { show: !1 },
                                            tickAmount: {{ $count }},
                                            labels: { style: { colors: [r], fontSize: "10px" } },
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
                                            { name: "Telegram", data: {{ $gaming_telegram }} },
                                            { name: "WEB", data: {{ $gaming_web }} },
                                        ],
                                        chart: { fontFamily: "inherit", type: "bar", stacked: !0, height: l, toolbar: { show: !1 } },
                                        plotOptions: { bar: { columnWidth: "35%", barHeight: "70%", borderRadius: [6, 6] } },
                                        legend: { show: !1 },
                                        dataLabels: { enabled: !1 },
                                        xaxis: {
                                            categories: {!! $gaming_d !!},
                                            axisBorder: { show: !1 },
                                            axisTicks: { show: !1 },
                                            tickAmount: 31,
                                            labels: { style: { colors: [r], fontSize: "10px" } },
                                            crosshairs: { show: !1 },
                                        },
                                        yaxis: {
                                            min: 0,
                                            max: {{ $maxValue + 150 }},
                                            tickAmount: 6,
                                            labels: {
                                                style: { colors: [r], fontSize: "10px" },
                                                formatter: function (e) {
                                                    return parseInt(e);
                                                },
                                            },
                                        },
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

        {{--var KTChartsPlayers = (function () {--}}
        {{--    var e = { self: null, rendered: !1 },--}}
        {{--            t = function () {--}}
        {{--                var t = document.getElementById("kt_charts_players");--}}
        {{--                if (t) {--}}
        {{--                    var a = t.hasAttribute("data-kt-negative-color") ? t.getAttribute("data-kt-negative-color") : KTUtil.getCssVariableValue("--bs-success"),--}}
        {{--                            l = parseInt(KTUtil.css(t, "height")),--}}
        {{--                            r = KTUtil.getCssVariableValue("--bs-gray-500"),--}}
        {{--                            o = KTUtil.getCssVariableValue("--bs-border-dashed-color"),--}}
        {{--                            i = {--}}
        {{--                                series: [--}}
        {{--                                    { name: "Telegram", data: {{ $players_telegram }} },--}}
        {{--                                    { name: "WEB", data: {{ $players_web }} },--}}
        {{--                                ],--}}
        {{--                                chart: { fontFamily: "inherit", type: "bar", stacked: !0, height: l, toolbar: { show: !1 } },--}}
        {{--                                plotOptions: { bar: { columnWidth: "25%", barHeight: "70%", borderRadius: [6, 6] } },--}}
        {{--                                legend: { show: !1 },--}}
        {{--                                dataLabels: { enabled: !1 },--}}
        {{--                                xaxis: {--}}
        {{--                                    categories: {!! $players_d !!},--}}
        {{--                                    axisBorder: { show: !1 },--}}
        {{--                                    axisTicks: { show: !1 },--}}
        {{--                                    tickAmount: 14,--}}
        {{--                                    labels: { style: { colors: [r], fontSize: "10px" } },--}}
        {{--                                    crosshairs: { show: !1 },--}}
        {{--                                },--}}
        {{--                                yaxis: {--}}
        {{--                                    min: 0,--}}
        {{--                                    max: 20000,--}}
        {{--                                    tickAmount: 6,--}}
        {{--                                    labels: {--}}
        {{--                                        style: { colors: [r], fontSize: "10px" },--}}
        {{--                                        formatter: function (e) {--}}
        {{--                                            return parseInt(e);--}}
        {{--                                        },--}}
        {{--                                    },--}}
        {{--                                },--}}
        {{--                                fill: { opacity: 1 },--}}
        {{--                                states: { normal: { filter: { type: "none", value: 0 } }, hover: { filter: { type: "none", value: 0 } }, active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } } },--}}
        {{--                                tooltip: {--}}
        {{--                                    style: { fontSize: "12px", borderRadius: 4 },--}}
        {{--                                    y: {--}}
        {{--                                        formatter: function (e) {--}}
        {{--                                            return e > 0 ? e  : Math.abs(e);--}}
        {{--                                        },--}}
        {{--                                    },--}}
        {{--                                },--}}
        {{--                                colors: [KTUtil.getCssVariableValue("--bs-primary"), a],--}}
        {{--                                grid: { borderColor: o, strokeDashArray: 4, yaxis: { lines: { show: !0 } } },--}}
        {{--                            };--}}
        {{--                    (e.self = new ApexCharts(t, i)),--}}
        {{--                            setTimeout(function () {--}}
        {{--                                e.self.render(), (e.rendered = !0);--}}
        {{--                            }, 200);--}}
        {{--                }--}}
        {{--            };--}}
        {{--    return {--}}
        {{--        init: function () {--}}
        {{--            t(),--}}
        {{--                    KTThemeMode.on("kt.thememode.change", function () {--}}
        {{--                        e.rendered && e.self.destroy(), t();--}}
        {{--                    });--}}
        {{--        },--}}
        {{--    };--}}
        {{--})();--}}

        "undefined" != typeof module && (module.exports = KTChartsWidget1) && (module.exports = KTChartsGameDynamics),
                KTUtil.onDOMContentLoaded(function () {
                    KTChartsWidget1.init();
                    KTChartsGameDynamics.init();
                    // KTChartsPlayers.init();
                });
    </script>
@endpush