<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-envelope-open"></i>
        @if(auth()->user()->unreadNotifications->isNotEmpty())
        <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }} </span>
        @endif
    </a>

    @if(auth()->user()->unreadNotifications->isNotEmpty())
        <ul class="dropdown-menu">
            <li class="external">
                <h3><span class="bold">{{ auth()->user()->unreadNotifications->count() }} новых</span> уведомлений</h3>
                <a href="#" id="clean_all_notification">Очистить</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">

                    @foreach(auth()->user()->unreadNotifications as $notification)
                    <li>
                        @includeIf('notifications::types.'.snake_case(class_basename($notification->type)))
                    </li>
                    @endforeach

                </ul>
            </li>
        </ul>
    @endif
</li>
<!-- END INBOX DROPDOWN -->