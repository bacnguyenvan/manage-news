<?php 
	$menu = AppData::frontSidebar;
?>
<div class="drbtn"><!--991px以下のメニューボタン-->
    <span class="hambarg"></span>
    <span class="hambarg"></span>
    <span class="hambarg"></span>
    <span>MENU</span>
</div><!--./drbtn-->
<header class="header mb-2">
	<div class="container">
		<div class="row no-gutters">
			<div class="brand-logo col-10 col-lg-6">
				<a href="{{route('front-index')}}">
					<h1 class="h3"><img src="{{ asset('img/logo.png') }}" alt="証券アナリストジャーナル検索" width="450" height="auto" class="my-2" /></h1>
				</a>          
			</div>
		<div class="col-2 d-md-none">
		</div>
		<div class="col-12 col-lg-6 header-sub-menu">
			<ul class="nav py-2 float-right">
				<li class="nav-item d-none d-lg-flex"><a href="{{route('front-lp')}}" class="nav-link py-0">ジャーナル電子ブック</a></li>

				<li class="nav-item d-none d-lg-flex"><a href="{{route('front-guide')}}" class="nav-link py-0">使い方ガイド</a></li>
				<li class="nav-item"><a href="#" class="nav-link font-weight-bold py-0">ログイン中</a></li>
				@if(Auth::guard('committee')->check())
				<li class="nav-item login-name">
					<a href="{{route('front-committee-logout')}}" class="nav-link py-0">
						ログアウト
					</a>
				</li>
				@endif
			</ul>
		</div>

		</div>
	</div>
	<div id="toggle-menu-wrap" class="drawer">
		<div class="container">
		 <div class="row no-gutters">
			<div class="col-12 col-lg-8">
				<ul class="nav">
					
					@foreach($menu as $item)
			            <?php
			                $active = '';
			                $activeRoutes = $item['active_routes'];
			               
			                if(in_array(app('router')->currentRouteName(), $activeRoutes)) {
			                    $active = 'active';
			                }
			                
			            ?>
			            <li class="nav-item {{$active}}">
			                <a class="nav-link" 
			                    href="{{!empty($item['route'])?route($item['route']):'javascript:void(0)'}}">
			                   
			                    <span class="item-title">
			                        {{$item['title']}}
			                    </span>
			                </a>
			                
			            </li>
			        @endforeach
				</ul>            
			</div>
			<div class="col-12 col-lg-2 d-lg-none">
				<ul class="nav">
					<li class="nav-item">
						<a href="./lp.html" class="nav-link">ジャーナル電子ブック</a>
					</li>
					<li class="nav-item">
						<a href="./guide.html" class="nav-link">使い方ガイド</a>
					</li>
				</ul>                        
			</div>
			<div class="col-12 col-lg-2 offset-0 offset-lg-2 small switcher-wrap">
				<div aria-label="Page navigation m-0">
					<span class="small float-left mr-2 mt-2">文字サイズ</span>
					<ul class="pagination pagination-sm m-0">
						<li class="page-item txt_small"><a class="page-link" href="javascript:switchTxtsize('txt_small');">小</a></li>
						<li class="page-item active txt_normal"><a class="page-link" href="javascript:switchTxtsize('txt_normal');">中</a></li>
						<li class="page-item txt_big"><a class="page-link" href="javascript:switchTxtsize('txt_big');">大</a></li>
					</ul>
				</div>
			</div>
		 </div>
		</div>
	</div>
	<div class="bg-primary py-2">
		<div class="container">
			@if($routeName == 'front-ranking')
				@include('front.partials._header-search-ranking')
	        @elseif($routeName == 'front-guide')
	        	<form class="form">
		            <div class="row">
		              <div class="col-12 col-lg-3">
		                <h1 class="h4 my-1 text-white font-weight-bold">使い方ガイド</h1>
		              </div>
		              <div class="col-12 col-lg-5">
		                <div class="input-group">
		                  <div class="input-group-prepend">
		                    <div class="input-group">
		                      <select class="form-control">
		                        <option>表示したいガイドを選択してください</option>
		                      </select>
		                    </div>
		                  </div>
		                  <input type="submit" class="form-control" value="表　示">
		                </div>
		              </div>
		            </div>
		        </form>
			@elseif($routeName == 'front-index')
				@include('front.partials._header-search-index')
			@elseif($routeName == 'front-contents')
				<form class="form">
		            <div class="row">
		              <div class="col-12 col-lg-3">
		                <h1 class="h4 my-1 text-white font-weight-bold">各号目次一覧</h1>
		              </div>
		              <div class="col-12 col-lg-5">
		                <div class="input-group">
		                  <div class="input-group-prepend">
		                    <div class="input-group">
		                      <select class="form-control">
		                        <option>表示年を選択してください</option>
		                        <optgroup label="2000年代">
		                          <option>2021年</option>
		                          <option>2020年</option>
		                          <option>2019年</option>
		                          <option>2018年</option>
		                          <option>2017年</option>
		                          <option>2016年</option>
		                          <option>2015年</option>
		                          <option>2014年</option>
		                          <option>2013年</option>
		                          <option>2012年</option>
		                          <option>2011年</option>
		                          <option>2010年</option>
		                          <option>2009年</option>
		                          <option>2008年</option>
		                          <option>2007年</option>
		                          <option>2006年</option>
		                          <option>2005年</option>
		                          <option>2004年</option>
		                          <option>2003年</option>
		                          <option>2002年</option>
		                          <option>2001年</option>
		                          <option>2000年</option>
		                        </optgroup>
		                        <optgroup label="1900年代">
		                          <option>1999年</option>
		                          <option>1998年</option>
		                          <option>1997年</option>
		                          <option>1996年</option>
		                          <option>1995年</option>
		                          <option>1994年</option>
		                          <option>1993年</option>
		                          <option>1992年</option>
		                          <option>1991年</option>
		                          <option>1990年</option>
		                          <option>1989年</option>
		                          <option>1988年</option>
		                          <option>1987年</option>
		                          <option>1986年</option>
		                          <option>1985年</option>
		                          <option>1984年</option>
		                          <option>1983年</option>
		                          <option>1982年</option>
		                          <option>1981年</option>
		                          <option>1980年</option>
		                          <option>1979年</option>
		                          <option>1978年</option>
		                          <option>1977年</option>
		                          <option>1976年</option>
		                          <option>1975年</option>
		                          <option>1974年</option>
		                          <option>1973年</option>
		                          <option>1972年</option>
		                          <option>1971年</option>
		                          <option>1970年</option>
		                          <option>1969年</option>
		                          <option>1968年</option>
		                          <option>1967年</option>
		                          <option>1966年</option>
		                          <option>1965年</option>
		                          <option>1964年</option>
		                          <option>1963年</option>
		                        </optgroup>
		                      </select>
		                    </div>
		                  </div>
		                  <input type="submit" class="form-control" value="検索">
		                </div>
		              </div>              
		            </div>
		        </form>
			@elseif($routeName == 'front-topics')
				<form class="form">
		            <div class="row">
		              <div class="col-12 col-lg-4">
		                <h1 class="h4 my-1 text-white font-weight-bold">トピックス検索</h1>
		              </div>              
		            </div>
		        </form>
			@else
				<form class="form" action="./search.html">
					<div class="row">
						<div class="col-12 col-lg-5">
							<input class="form-control" type="text" placeholder="検索キーワードを入力してください">
						</div>
						<div class="col-12 col-lg-3">
							<select class="form-control">
								<option selected="">表記揺れを含まない</option>
								<option>表記揺れを含む</option>
							</select>
						</div>
						<div class="col-12 col-lg-4">
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group">
										<select class="form-control">
											<option>全て</option>
											<option>タイトル</option>
											<option>著者</option>
										</select>
									</div>
								</div>
								<input type="submit" class="form-control" value="検　索">
							</div>
						</div>
					</div>
				</form>
			@endif
		</div>
	</div>
</header>





