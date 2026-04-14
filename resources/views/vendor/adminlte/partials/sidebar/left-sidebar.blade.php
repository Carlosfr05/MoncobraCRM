<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    @php
        $sidebarMenu = array_values($adminlte->menu('sidebar'));
        $toolsStartIndex = null;

        foreach ($sidebarMenu as $index => $item) {
            $itemClass = $item['class'] ?? '';
            $isToolsHeader = isset($item['header']) && ($item['header'] ?? '') === 'Herramientas';

            if (str_contains($itemClass, 'sidebar-tools-start') || $isToolsHeader) {
                $toolsStartIndex = $index;
                break;
            }
        }

        $mainMenu = $toolsStartIndex === null ? $sidebarMenu : array_slice($sidebarMenu, 0, $toolsStartIndex);
        $toolsMenu = $toolsStartIndex === null ? [] : array_slice($sidebarMenu, $toolsStartIndex);
    @endphp

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2 d-flex flex-column h-100">
            <ul class="nav nav-pills nav-sidebar flex-column flex-grow-1 sidebar-main-menu {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Main sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $mainMenu, 'item')
            </ul>

            @if(count($toolsMenu) > 0)
                <ul class="nav nav-pills nav-sidebar flex-column sidebar-tools-menu {{ config('adminlte.classes_sidebar_nav', '') }}"
                    data-widget="treeview" role="menu"
                    @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                        data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                    @endif
                    @if(!config('adminlte.sidebar_nav_accordion'))
                        data-accordion="false"
                    @endif>
                    {{-- Tools links pinned to bottom --}}
                    @each('adminlte::partials.sidebar.menu-item', $toolsMenu, 'item')
                </ul>
            @endif
        </nav>
    </div>

</aside>
