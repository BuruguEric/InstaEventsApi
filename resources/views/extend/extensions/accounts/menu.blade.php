

    <?php if ($CoreLoad->auth('account')): ?>
    <li class="sub-menu"> <!-- active -->
        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-pin-account zmdi-hc-fw blue"></i> Doctors </a>
        <ul>
            <li class=""><a href="{{url('doctors/open/add')}}">New</a></li>
            <li class=""><a href="{{url('doctors')}}">Manage</a></li>
        </ul>
    </li>

    <li class="sub-menu"> <!-- active -->
        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-pin-account zmdi-hc-fw red_less"></i> Owners </a>
        <ul>
            <li class=""><a href="{{url('owners/open/add')}}">New</a></li>
            <li class=""><a href="{{url('owners')}}">Manage</a></li>
        </ul>
    </li>

    <?php endif ?>
