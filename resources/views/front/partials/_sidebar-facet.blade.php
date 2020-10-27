<?php 
	$numberOfItems = $config['number_of_items'];
	$count = 0;
?>
<h4>{{$config['name']}}</h4>
@foreach($data as $index => $item)
	<?php 
		$inputId = $config['collapse_key'].'-'.$index;
	?>
	@if($count == 0)
		<ul>
	@elseif($count == $numberOfItems)
		<div id="{{$config['collapse_key']}}" class="collapse">
			<ul>
	@endif
		<li>
			<input type="checkbox" 
				value="{{$item['id']}}" 
				id="{{$inputId}}">
			<label for="{{$inputId}}">
				{{$item['name']}}
			</label>
			<span class="float-right mr-2">({{$item['count']}})</span>
		</li>
	@if($count == $numberOfItems - 1)
		</ul>
	@elseif($count == count($data) - 1 && $count >= $numberOfItems)
			</ul>
		</div>
		<a class="float-right my-2 mr-2 text-muted accordion-btn" 
			data-toggle="collapse" 
			href="#{{$config['collapse_key']}}" 
			role="button" 
			aria-expanded="false" 
			aria-controls="{{$config['collapse_key']}}">
				<span class="">開く　＋</span>
				<span class="d-none">閉じる　－</span>
		</a>
	@endif
	<?php $count++; ?>
@endforeach

