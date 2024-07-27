<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold px-1" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<!--begin:Menu item-->
			<div class="menu-item pt-5">
				<!--begin:Menu content-->
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Modules</span>
				</div>
				<!--end:Menu content-->
			</div>
			<!--end:Menu item-->
			@foreach($modules as $section_name => $section)
				@php $current = \Modules\Core\Entities\Modules::where('name', request()->segment(2))->first(); @endphp
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ isset($current) && $current->section == $section_name ? 'here show' : ''}}">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-outline ki-{{ $sections[$section_name]['icon'] }} fs-1"></i>
						</span>
						<span class="menu-title">{{ $sections[$section_name]['name'] }}</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						@foreach($section as $k => $module)
							<!--begin:Menu item-->
							@if($k < 4)
								<div class="menu-item">
									<!--begin:Menu link-->
									<a class="menu-link {!! request()->segment(2) == $module->name ? 'active' : '' !!}" href="{{ route($module->name.'.index') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">{{ $module->title }}</span>
									</a>
									<!--end:Menu link-->
								</div>
							@endif
							<!--end:Menu item-->
						@endforeach
						<div class="menu-inner flex-column collapse" id="kt_app_sidebar_menu_dashboards_collapse">
							@foreach($section as $k => $module)
								<!--begin:Menu item-->
								@if($k > 3)
									<div class="menu-item">
										<!--begin:Menu link-->
										<a class="menu-link {!! request()->segment(2) == $module->name ? 'active' : '' !!}" href="{{ route($module->name.'.index') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
											<span class="menu-title">{{ $module->title }}</span>
										</a>
										<!--end:Menu link-->
									</div>
								@endif
								<!--end:Menu item-->
							@endforeach
						</div>
						@if(count($section) > 4)
							<div class="menu-item">
								<div class="menu-content">
									<a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 toggle collapsible collapsed" data-bs-toggle="collapse" href="#kt_app_sidebar_menu_dashboards_collapse" data-kt-toggle-text="Show Less">
										<span data-kt-toggle-text-target="true">Show {{ (count($section) - 4) }} More</span>
										<i class="ki-outline ki-minus-square toggle-on fs-2 me-0"></i>
										<i class="ki-outline ki-plus-square toggle-off fs-2 me-0"></i>
									</a>
								</div>
							</div>
						@endif
					</div>
					<!--end:Menu sub-->
				</div>
				<!--end:Menu item-->
			@endforeach
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>