<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon la la-question'></i> Products</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon la la-question'></i> Categories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('order') }}'><i class='nav-icon la la-question'></i> Orders</a></li>
<li class="nav-title">EXTRA</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}\"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('stock') }}'><i class='nav-icon la la-question'></i> Stocks</a></li>