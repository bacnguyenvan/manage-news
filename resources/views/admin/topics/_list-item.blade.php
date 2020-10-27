<?php 
	$index = !empty($index)?$index:'';
	$id = !empty($data['topics_id'])?$data['topics_id']:'';
	$name = !empty($data['topics_name'])?$data['topics_name']:'';
	$displayOrder = !empty($data['display_order'])?$data['display_order']:'';
	$cutline = !empty($data['cutline'])?$data['cutline']:'';
	$topics_phonetic = !empty($data['topics_phonetic'])?$data['topics_phonetic']:'';
?>

<tr class="topics-item" 
	data-topics-id="{{$id}}"
	data-topics-name="{{$name}}"
	data-display-order="{{$displayOrder}}"
	data-cutline="{{$cutline}}"
	data-topics_phonetic="{{$topics_phonetic}}"
	>
	<td class="topics-index">{{$index}}</td>
	<td>
		<div class="align-items-center">
			<input type="checkbox" 
				value="{{$id}}" 
				class="table-checkbox">
		</div>
	</td>
	<td>{{$name}}</td>
	<td>{{$topics_phonetic}}</td>
	<td>{{$displayOrder}}</td>
	<td>{{$cutline}}</td>
	<td>
		<input type="text" name="topics_name" class="form-control">
	</td>
	<td>
		<input type="text" name="topics_phonetic" class="form-control">
	</td>
	<td>
		<input type="text" name="display_order" class="form-control">
	</td>
	<td>
		<input type="text" name="cutline" class="form-control">
	</td>
	<td class="border-0">
		<a href="javascript:void(0)"
			class="btn btn-sm btn-secondary add-keywords"
			link="{{route('admin-topics-keywords', ['pk' => $id])}}"
			is-new-message="関連キーワードを編集する場合は、先にトピックスを登録してください。"
			new-exist-message="追加されたトピックスが存在しますが登録されません。よろしいですか？"
			edited-exist-message="編集されたトピックスが存在しますが更新されません。よろしいですか？">
			関連キーワード編集
		</a>
	</td>
</tr>





