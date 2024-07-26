<?php $__env->startSection('page-title', $title); ?>

<?php $__env->startSection('actions'); ?>
	<a href="<?php echo e(action($controller.'@create')); ?>" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> <?php echo e(__('core::app.btn_create')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="col-xl-12">
		<!--begin::Chart Widget 1-->
		<div class="card card-flush h-lg-100">
			<!--begin::Header-->
			<div class="card-header pt-5">
				<!--begin::Title-->
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bold text-dark">Completing Partners Quests</span>
					
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
						<span class="fw-semibold fs-6 text-gray-600">Players</span>
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

	<?php
		$gaming_d = collect(array_reverse($gaming))->pluck('day')->toJson();
		$gaming_telegram = collect(array_reverse($gaming))->pluck('telegram')->toJson();
        $maxValue = max(collect(array_reverse($gaming))->pluck('telegram')->toArray());
	?>

	<?php $__env->startPush('scripts'); ?>

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
										{ name: "Players", data: <?php echo e($gaming_telegram); ?> },
									],
									chart: { fontFamily: "inherit", type: "bar", stacked: !0, height: l, toolbar: { show: !1 } },
									plotOptions: { bar: { columnWidth: "25%", barHeight: "70%", borderRadius: [6, 6] } },
									legend: { show: !1 },
									dataLabels: { enabled: !1 },
									xaxis: {
										categories: <?php echo $gaming_d; ?>,
										axisBorder: { show: !1 },
										axisTicks: { show: !1 },
										tickAmount: 31,
										labels: { style: { colors: [r], fontSize: "10px" } },
										crosshairs: { show: !1 },
									},
									yaxis: {
										min: 0,
										max: <?php echo e($maxValue); ?>,
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

			"undefined" != typeof module && (module.exports = KTChartsWidget1) && (module.exports = KTChartsGameDynamics),
				KTUtil.onDOMContentLoaded(function () {
					KTChartsGameDynamics.init();
				});
		</script>
	<?php $__env->stopPush(); ?>
	<!--begin::Card-->
	<div class="card rounded-0 border-0">
		<!--begin::Card header-->
		<div class="card-header border-1 pt-0">
			<!--begin::Card title-->
			<div class="card-title">
				<!--begin::Search-->
				<div class="d-flex align-items-center position-relative my-1">
					<i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
					<form action="<?php echo e(action($controller.'@index')); ?>" method="get">
						<input type="text" name="search" value="<?php echo e(request()->get('search') ?? ''); ?>" data-kt-customer-table-filter="search" class="form-control ps-13 rounded-0 h-40px" placeholder="<?php echo e(__('core::app.placeholder_search')); ?>" />
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
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer"><?php echo e(__('core::app.btn_add')); ?></button>
					<!--end::Add customer-->
				</div>
				<!--end::Toolbar-->
				<!--begin::Group actions-->
				<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
					<div class="fw-bold me-5">
						<span class="me-2" data-kt-customer-table-select="selected_count"></span><?php echo e(__('core::app.btn_selected')); ?></div>
					<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected"><?php echo e(__('core::app.btn_delete_selected')); ?></button>
				</div>
				<!--end::Group actions-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-0">
			<?php echo $__env->make('partners_quests::common.table.' . $outlist, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<!--end::Card body-->
	</div>
	<!--end::Card-->

	<?php echo $__env->make('core::common.modal.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/theshit_php/Modules/PartnersQuests/Providers/../Resources/views/partners_quests/index.blade.php ENDPATH**/ ?>