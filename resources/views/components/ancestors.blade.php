<?php $ancestors = App\Http\Controllers\AncestorController::getAncestors($user_id);?>

@if(count($ancestors)>0)
    <div class="text-center">
        <h2>Ancestors</h2>
    </div>
    <?php $number = 0 ?>
    @foreach ($ancestors as $a)
        @if($number==2 || $number==0)
            <div class="row">
                <?php $number = 0 ?>
                @endif
                @if(isset($edit_id))
                    @include('components.ancestorCard',['ancestor'=>$a,'edit_id'=>$edit_id])
                @else
                    @include('components.ancestorCard',['ancestor'=>$a])
                @endif
                <?php $number++; ?>
                @if($number==2)
            </div>
        @endif
    @endforeach

@else
    <h3 class="text-center">No ancestor information provided.
    </h3>
@endif