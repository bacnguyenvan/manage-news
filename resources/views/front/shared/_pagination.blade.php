<?php
    $total = $paginator->total();
    $last = $paginator->lastPage();
    $current = $paginator->currentPage();
    $isFirst = '';
    $isLast = '';

    if($current == 1) {
        $isFirst = 'disabled';
    }

    if($current == $last) {
        $isLast = 'disabled';
    }

    $eachSide = 1;
    $leftCurrent = $current - $eachSide;
    if($leftCurrent < 1) {
        $leftCurrent = 1;
    }
    $rightCurrent = $current + $eachSide;
    if($rightCurrent > $last) {
        $rightCurrent = $last;
    }
?>
@if($paginate < $total)
<div class="card-tools">
    <ul class="pagination {{!empty($bigSize)?'':'pagination-sm'}} m-0" role="navigation">
        <!-- First Page -->
        <li class="page-item {{$isFirst}}" aria-label="« First">
            <a class="page-link" href="{{$paginator->url(1)}}" aria-hidden="true">«</a>
        </li>
        <!-- Prev Page -->
        <li class="page-item {{$isFirst}}" aria-label="‹ Previous">
            <a class="page-link" href="{{$paginator->previousPageUrl()}}" aria-hidden="true">‹</a>
        </li>
        <!-- Prev Page -->
        <!-- Number Pages -->
        @for($i=$leftCurrent;$i<=$rightCurrent;$i++)
            <li class="page-item {{$i==$current?'active':''}}" aria-label="{{'Page '.$i}}">
                <a class="page-link" href="{{$paginator->url($i)}}" aria-hidden="true">{{$i}}</a>
            </li>
        @endfor
        <!-- Next Page -->
        <li class="page-item {{$isLast}}">
            <a class="page-link" href="{{$paginator->nextPageUrl()}}" rel="next" aria-label="Next ›">›</a>
        </li>
        <!-- Last Page -->
        <li class="page-item {{$isLast}}">
            <a class="page-link" href="{{$paginator->url($last)}}" rel="next" aria-label="Last »">»</a>
        </li>
    </ul>
</div>
@endif
