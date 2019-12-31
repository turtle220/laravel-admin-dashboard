<?php
    $currentRoute = Route::currentRouteName();
    // $perpage
    $num = ($total / $perpage);
    $allPages = (int)ceil($num);
    $pagesArrays = [

    ];
    for($x = 1 ; $x <= $allPages ; $x += 1)
        $pagesArrays[] = [
            'url' => route($currentRoute , ['perpage' => $perpage , 'offset' => ($x - 1) * $perpage]),
            'perpage' => $perpage ,
            'offset'  => ($x - 1) * $perpage ,
            'isActive' => $offset == ($x - 1) * $perpage,
        ];
    endfor
?>

<div class="float-right">
    <nav aria-label="...">
        <ul class="pagination">
            @for($x = 1 ; $x <= $allPages ; $x += 1)
                <li class="page-item @if($offset == ($x - 1) * $perpage) active @endif">
                    <a class="page-link" href="{{route($currentRoute , ['perpage' => $perpage , 'offset' => ($x - 1) * $perpage])}}">{{$x}}</a>
                </li>
            @endfor
        </ul>
    </nav>
</div>
