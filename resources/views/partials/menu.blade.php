<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        {{-- <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li> --}}
        @can('sale_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/sales*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                </i>
                Penjualan
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @foreach (App\Models\OutletKitchen::whereIn('id',auth()->user()->ok()->pluck('outlet_kitchen_id'))->pluck('lokasi','id') as $id=>$ok)
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.sales.list", ['id' => $id]) }}" class="c-sidebar-nav-link {{ request()->is("admin/sales") || request()->is("admin/sales/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                        </i>
                        {{$ok}}
                    </a>
                </li>
                @endforeach
            </ul>
        @endcan
        @can('order_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/orders*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.order.title') }} dan Perubahan
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                            <i class="fa-fw fab fa-first-order c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.order.title') }}
                        </a>
                        
                    </li>
                </ul>
            </li>
        @endcan
        @can('bahan_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/rm-categories*") ? "c-show" : "" }} {{ request()->is("admin/raw-materials*") ? "c-show" : "" }} {{ request()->is("admin/products*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.bahan.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('rm_category_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.rm-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/rm-categories") || request()->is("admin/rm-categories/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-tablets c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.rmCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('raw_material_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.raw-materials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/raw-materials") || request()->is("admin/raw-materials/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-utensils c-sidebar-nav-icon">

                                </i>
                                Stok {{ trans('cruds.rawMaterial.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-product-hunt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.product.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('outlet_kitchen_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.outlet-kitchens.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/outlet-kitchens") || request()->is("admin/outlet-kitchens/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-code-branch c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.outletKitchen.title') }}
                </a>
            </li>
        @endcan
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>