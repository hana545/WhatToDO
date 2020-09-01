
@if ($place->workhour)
    <div class="p-3 border-bottom border-top text-center grey-box text-white-muted">
        <h6> <i>Workhours</i></h6>
    </div>
    <div class="mt-2">
        @if($place->workhour->monday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Monday:</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                        {{ $place->workhour->monday_start1->format('H:i') }}  -  {{ $place->workhour->monday_end1->format('H:i') }}
                        @if($place->workhour->monday_start2)
                            {{ $place->workhour->monday_start2->format('H:i') }}  -  {{ $place->workhour->monday_end2->format('H:i') }}
                        @endif
                </div>
            </div>
        @endif
        @if($place->workhour->tuesday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Tuesday</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                    {{ $place->workhour->tuesday_start1->format('H:i') }}  -  {{ $place->workhour->tuesday_end1->format('H:i') }}
                    @if($place->workhour->tuesday_start2)
                        <br>{{ $place->workhour->tuesday_start2->format('H:i') }}  -  {{ $place->workhour->tuesday_end2->format('H:i') }}
                    @endif
                </div>
            </div>
        @endif

        @if($place->workhour->wednesday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Wednesday</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                    {{ $place->workhour->wednesday_start1->format('H:i') }}  -  {{ $place->workhour->wednesday_end1->format('H:i') }}
                    @if($place->workhour->wednesday_start2)
                        {{ $place->workhour->wednesday_start2->format('H:i') }}  -  {{ $place->workhour->wednesday_end2->format('H:i') }}
                    @endif
                </div>
            </div>
        @endif

        @if($place->workhour->thursday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Thursday</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                    {{ $place->workhour->thursday_start1->format('H:i') }}  -  {{ $place->workhour->thursday_end1->format('H:i') }}
                    @if($place->workhour->thursday_start2)
                        {{ $place->workhour->thursday_start2->format('H:i') }}  -  {{ $place->workhour->thursday_end2->format('H:i') }}
                    @endif
                </div>
            </div>
        @endif

        @if($place->workhour->friday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Friday</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                    {{ $place->workhour->friday_start1->format('H:i') }}  -  {{ $place->workhour->friday_end1->format('H:i') }}
                    @if($place->workhour->friday_start2)
                        {{ $place->workhour->friday_start2->format('H:i') }}  -  {{ $place->workhour->friday_end2->format('H:i') }}
                    @endif
                </div>
            </div>
        @endif

        @if($place->workhour->saturday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Saturday</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                    {{ $place->workhour->saturday_start1->format('H:i') }}  -  {{ $place->workhour->saturday_end1->format('H:i') }}
                    @if($place->workhour->saturday_start2)
                        {{ $place->workhour->saturday_start2->format('H:i') }}  -  {{ $place->workhour->saturday_end2->format('H:i') }}
                    @endif
                </div>
            </div>
        @endif

        @if($place->workhour->sunday_start1)
            <div class="row text-white">
                <div class="col-6 text-right">
                    <p> <strong>Sunday</strong></p>
                </div>
                <div class="col-6 text-left pb-1 mb-1">
                    {{ $place->workhour->sunday_start1->format('H:i') }}  -  {{ $place->workhour->sunday_end1->format('H:i') }}
                    @if($place->workhour->sunday_start2)
                        {{ $place->workhour->sunday_start2->format('H:i') }}  -  {{ $place->workhour->sunday_end2->format('H:i') }}
                    @endif
                </div>
            </div>
        @endif

    </div>
@endif
