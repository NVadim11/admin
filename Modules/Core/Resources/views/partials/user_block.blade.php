<!-- BEGIN USER LOGIN DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-user dropdown-dark">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <span class="username username-hide-on-mobile"> {{ Auth::user()->name }} </span>
        <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
        @if(Auth::user()->avatar)
            <img alt="" class="img-circle" src="{{ getImagePath(Auth::user()->avatar, 41, 41, 'crop') }}"/>
        @else
            <img alt="" class="img-circle" src="/admin_assets/img/avatar9.jpg"/>
        @endif

    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="{{ route('users.edit', Auth::user()->id) }}">
                <i class="icon-user"></i> {{__('Профиль')}} </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="icon-key"></i> Выйти </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</li>
<!-- END USER LOGIN DROPDOWN -->
<!-- BEGIN USER LOGIN DROPDOWN -->
<li class="dropdown dropdown-extended ">
    <a class="icon-logout tosite" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="{{__('Выйти')}}}"></a>
</li>
<!-- END USER LOGIN DROPDOWN -->