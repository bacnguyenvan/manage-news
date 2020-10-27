<?php 
	$from = date('Y/m/d', strtotime($data['from']));
	$to = date('Y/m/d', strtotime($data['to']));
	$list = $data['list'];
?>
<div id="widget-ranking" class="card rounded-0">
	<div class="widget-header widget-danger">
		<h3 class="">論稿アクセスランキング</h3>
		<p class="m-0">集計期間 {{$from}}〜{{$to}}</p>
	</div>
	<div class="widget-body">
		<ol>
			@foreach($list as $index => $item)
			<li class="active">
				<span class="text-dark font-weight-bold">{{$index + 1}}</span>
				<a href="">{{$item->title}}</a>
			</li>
			@endforeach
		</ol>
		<a href="./ranking.html" class="float-right my-2">もっと見る　》</a>
	</div>
</div>