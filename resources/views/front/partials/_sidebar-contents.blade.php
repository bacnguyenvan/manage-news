<div class="widget-body">
  <form>
    <ul>
      @foreach($list as $key => $item)
        <li class="has-submenu">
          <span class="accordion-btn ml-3" data-toggle="collapse" href="#widget02-check0{{$key}}-sub" role="button" aria-expanded="false" aria-controls="widget02-check01-sub">{{$item['max']}}年-{{$item['min']}}年</span>
          <span class="float-right mr-2">(50)</span>
            <ul id="widget02-check0{{$key}}-sub" class="collapse widget-check-submenu {{$key==0?'show':''}}">
              @for($y = $item['max'] ; $y >= $item['max'] - 4 ; $y--)
              <li class="current"><a href=""><span class="ml-2">{{$y}}年</span><span class="float-right mr-2">(2)</span></a></li>
              @endfor
            </ul>
        </li>
      @endforeach

      
      </ul>
  </form>
</div>
