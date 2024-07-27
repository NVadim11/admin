<div class="card border-0">
    <div class="card-header card-header-stretch">
{{--        <h3 class="card-title">Localization</h3>--}}
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                <li class="nav-item">
                    <a class="nav-link text-uppercase active" data-bs-toggle="tab" href="#kt_tab_pane_1">EN</a>
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
                @foreach($form->getFields() as $name=>$value)
                    @if(!$value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType || !$value->getOption('tab'))
                        {!! form_row($value) !!}
                    @endif
                @endforeach
            </div>

            @foreach($form->getFields() as $name=>$value)
                @if( $value instanceof \Kris\LaravelFormBuilder\Fields\ChildFormType && $value->getOption('tab'))
                    <div class="tab-pane fade" id="kt_tab_{{ $name }}" role="tabpanel">
                        {!! form_row($value) !!}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>