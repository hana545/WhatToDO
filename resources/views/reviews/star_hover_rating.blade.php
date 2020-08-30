<div class='rating-stars text-center'>
    <ul id='stars'>
        <li class='star  star-hover @if($star >= 1)chosen  @endif' title='Awful' data-value='1'>
            <i class='fa fa-star fa-fw'></i>
        </li>
        <li class='star  star-hover  @if($star >= 2)chosen  @endif' title='Bad' data-value='2'>
            <i class='fa fa-star fa-fw'></i>
        </li>
        <li class='star  star-hover  @if($star >= 3)chosen  @endif' title='Good' data-value='3'>
            <i class='fa fa-star fa-fw'></i>
        </li>
        <li class='star  star-hover  @if($star >= 4)chosen  @endif' title='Very good' data-value='4'>
            <i class='fa fa-star fa-fw'></i>
        </li>
        <li class='star  star-hover  @if($star >= 5)chosen  @endif'  title='Excellent!!!' data-value='5'>
            <i class='fa fa-star fa-fw'></i>
        </li>
    </ul>
</div>
