<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <span>{{ auth('admin')->user()->name }}</span><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li>
            <a href="/admin/profile/{{ auth('admin')->user()->id }}/edit"><i class="fa fa-user fa-fw"></i> User Profile</a>
        </li>
        <li>
            <a href="/admin/profile/reset/{{ auth('admin')->user()->id }}"><i class="fa fa-gear fa-fw"></i> Reset Passport</a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                        class="fa fa-sign-out fa-fw"></i> Logout</a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</li>
