<a href="{{$link}}">{{$title}}</a>
<a href="#yoyakuModal0{{$index}}" class="badge badge-outline-primary" data-toggle="modal" data-target="#yoyakuModal0{{$index}}">
	要約
	<span class="ion-share ml-1"></span>
</a>
<div class="modal fade" id="yoyakuModal0{{$index}}" tabindex="-1" role="dialog" aria-labelledby="yoyakuModal01Title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content rounded-0">
			<div class="modal-header">
				<h2 class="text-success">
					【要約】 {{$title}}
				</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>{{mb_substr($wrapUp,0,600)}}</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">閉じる</button>
			</div>
		</div>
	</div>
</div>