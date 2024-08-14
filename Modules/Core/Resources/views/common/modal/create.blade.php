<!--begin::Modal - Items - Add-->
<div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" id="kt_modal_add_customer_form" action="{{ action($controller.'@modalCreate') }}" data-kt-redirect="../../demo42/dist/apps/customers/list.html">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ $add_new_title }}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                        @include('core::common.modal.form')
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">{{ __('core::app.btn_cancel') }}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                        <span class="indicator-label">{{ __('core::app.btn_save') }}</span>
                        <span class="indicator-progress">{{ __('core::app.title_loading') }}
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

@push('scripts')
    <script>
        "use strict";
        var KTModalCustomersAdd = (function () {
            var t, e, o, n, r, i;
            return {
                init: function () {
                    (i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer"))),
                            (r = document.querySelector("#kt_modal_add_customer_form")),
                            (t = r.querySelector("#kt_modal_add_customer_submit")),
                            (e = r.querySelector("#kt_modal_add_customer_cancel")),
                            (o = r.querySelector("#kt_modal_add_customer_close")),
                            (n = FormValidation.formValidation(r, {
                                fields: {
                                    name: { validators: { notEmpty: { message: "Customer name is required" } } },
                                    email: { validators: { notEmpty: { message: "Customer email is required" } } },
                                    "first-name": { validators: { notEmpty: { message: "First name is required" } } },
                                    "last-name": { validators: { notEmpty: { message: "Last name is required" } } },
                                    country: { validators: { notEmpty: { message: "Country is required" } } },
                                    address1: { validators: { notEmpty: { message: "Address 1 is required" } } },
                                    city: { validators: { notEmpty: { message: "City is required" } } },
                                    state: { validators: { notEmpty: { message: "State is required" } } },
                                    postcode: { validators: { notEmpty: { message: "Postcode is required" } } },
                                },
                                plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                            })),
                            $(r.querySelector('[name="country"]')).on("change", function () {
                                n.revalidateField("country");
                            }),
                            t.addEventListener("click", function (e) {
                                e.preventDefault(),
                                n &&
                                n.validate().then(function (e) {
                                    console.log("validated!"),
                                            "Valid" == e
                                                    ? (t.setAttribute("data-kt-indicator", "on"),
                                                            (t.disabled = !0),
                                                            setTimeout(function () {
                                                                e.isConfirmed && (i.hide(), (t.disabled = !1));
                                                                const formData = new FormData(r);
                                                                fetch(r.getAttribute('action'), {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                                    },
                                                                    body: formData
                                                                })
                                                                        .then(function(res){
                                                                            t.removeAttribute("data-kt-indicator");
                                                                            Swal.fire({ text: "{{ __('core::app.message_success_submitted') }}", icon: "success", buttonsStyling: !1, confirmButtonText: "{{ __('core::app.message_got_it') }}", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                                                if (t.value) {
                                                                                    (r.reset(), i.hide());
                                                                                    setTimeout(function(){
                                                                                        location.reload()
                                                                                    }, 100)
                                                                                }
                                                                            });
                                                                        })
                                                                        .catch(function(res){ console.log("error") })
                                                            }, 500))
                                                    : Swal.fire({
                                                        text: "{{ __('core::app.message_errors_in_form') }}",
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "{{ __('core::app.message_got_it') }}",
                                                        customClass: { confirmButton: "btn btn-primary" },
                                                    });
                                });
                            }),
                            e.addEventListener("click", function (t) {
                                t.preventDefault(),
                                        Swal.fire({
                                            text: "{{ __('core::app.message_cancel_form') }}",
                                            icon: "warning",
                                            showCancelButton: !0,
                                            buttonsStyling: !1,
                                            confirmButtonText: "{{ __('core::app.message_yes_cancel') }}",
                                            cancelButtonText: "{{ __('core::app.message_no_return') }}",
                                            customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" },
                                        }).then(function (t) {
                                            t.value
                                                    ? (r.reset(), i.hide())
                                                    : "cancel" === t.dismiss && Swal.fire({ text: "{{ __('core::app.message_not_cancel_form') }}", icon: "error", buttonsStyling: !1, confirmButtonText: "{{ __('core::app.message_got_it') }}", customClass: { confirmButton: "btn btn-primary" } });
                                        });
                            }),
                            o.addEventListener("click", function (t) {
                                t.preventDefault(),
                                        Swal.fire({
                                            text: "{{ __('core::app.message_cancel_form') }}",
                                            icon: "warning",
                                            showCancelButton: !0,
                                            buttonsStyling: !1,
                                            confirmButtonText: "{{ __('core::app.message_yes_cancel') }}",
                                            cancelButtonText: "{{ __('core::app.message_no_return') }}",
                                            customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" },
                                        }).then(function (t) {
                                            t.value
                                                    ? (r.reset(), i.hide())
                                                    : "cancel" === t.dismiss && Swal.fire({ text: "{{ __('core::app.message_not_cancel_form') }}", icon: "error", buttonsStyling: !1, confirmButtonText: "{{ __('core::app.message_got_it') }}", customClass: { confirmButton: "btn btn-primary" } });
                                        });
                            });
                },
            };
        })();
        KTUtil.onDOMContentLoaded(function () {
            KTModalCustomersAdd.init();
        });
    </script>
@endpush
<!--end::Modal - Items - Add-->