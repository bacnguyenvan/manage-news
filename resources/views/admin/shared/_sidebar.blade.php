<?php
    $menu = AppData::adminSidebar;
    $loginUser = Auth::guard('admin')->user();
    $permission = 'all';
?>
<sidebar class="sidebar admin-color">
    <div class="title">
        <a href="{{route('admin-main')}}">証券アナリストジャーナル 検索システム管理画面</a>
    </div>
    <ul class="menu">
        @foreach($menu as $item)
            <?php
                $active = '';
                $activeRoutes = $item['active_routes'];
                $showParent = true;
                if(!empty($item['childs'])) {
                    $showParent = false;
                    foreach($item['childs'] as $child) {
                        if(!empty($child['active_routes'])) {
                            $activeRoutes = array_merge($child['active_routes'], $activeRoutes);
                        }
                        if($permission != 'all') {
                            if(in_array($child['key'], $permission)) {
                                $showParent = true;
                            }
                        } else {
                            $showParent = true;
                        }
                    }
                }
                if(in_array(app('router')->currentRouteName(), $activeRoutes)) {
                    $active = 'active';
                }
                if(!$showParent) {
                    $hideMenu = 'd-none';
                } else {
                    $hideMenu = '';
                }
            ?>
            <li class="menu-item {{!empty($item['childs'])?'has-sub-menu':''}} {{$active}} {{$hideMenu}}">
                <a class="item-link" 
                    href="{{!empty($item['route'])?route($item['route']):'javascript:void(0)'}}">
                    @if(!empty($item['icon']))
                        <i class="{{$item['icon']}}"></i>
                    @endif
                    <span class="item-title">
                        {{$item['title']}}
                    </span>
                </a>
                @if(!empty($item['childs']))
                <ul class="sub-menu">
                    @foreach($item['childs'] as $child)
                        <?php
                            $childActive = '';
                            $hideChild = '';
                            if(in_array(app('router')->currentRouteName(), $child['active_routes'])) {
                                $childActive = 'active';
                            }
                            if($permission != 'all'){
                                if(!in_array($child['key'], $permission)) {
                                    $hideChild = 'd-none';
                                }
                            }
                        ?>
                        <li class="sub-menu-item {{$childActive}} {{$hideChild}}">
                            
                            <a class="item-link" 
                                href="{{!empty($child['route'])?route($child['route']):'javascript:void(0)'}}">
                                @if(!empty($child['icon']))
                                    <i class="{{$child['icon']}}"></i>
                                @endif
                                <span class="item-title">
                                    {{$child['title']}}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </li>
        @endforeach
    </ul>
</sidebar>