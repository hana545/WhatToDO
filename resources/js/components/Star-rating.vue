<template>
    <div class='rating-stars text-center'>
        <ul v-bind:class="{stars_click: star_hover}">
            <li class='' v-bind:class="{ chosen: avg_star >= 1 && chosen, selected: avg_star >= 1 && selected, star: star_hover, star_hover: star_hover, star_static: star_static, star_small: star_small }" title='Awful' data-value='1'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='' v-bind:class="{ chosen: avg_star >= 2 && chosen, selected: avg_star >= 2 && selected, star: star_hover, star_hover: star_hover, star_static: star_static, star_small: star_small }" title='Bad' data-value='2'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='' v-bind:class="{ chosen: avg_star >= 3 && chosen, selected: avg_star >= 3 && selected, star: star_hover, star_hover: star_hover, star_static: star_static, star_small: star_small }" title='Good' data-value='3'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='' v-bind:class="{ chosen: avg_star >= 4 && chosen, selected: avg_star >= 4 && selected, star: star_hover, star_hover: star_hover, star_static: star_static, star_small: star_small }" title='Very good' data-value='4'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='' v-bind:class="{ chosen: avg_star >= 5 && chosen, selected: avg_star >= 5 && selected, star: star_hover, star_hover: star_hover, star_static: star_static, star_small: star_small }"  title='Excellent!!!' data-value='5'>
                <i class='fa fa-star fa-fw'></i>
            </li>
        </ul>
    </div>


</template>

<script>

    export default {
        props: {
            avg_star:  {type: [Object, String, Array, Number],
                        default: 0},

            star_static: {type:[Boolean], default: false},
            star_small: {type:[Boolean], default: false},
            star_hover:{type:[Boolean], default: false},
            selected:{type:[Boolean], default: false},
            chosen:{type:[Boolean], default: false},

        },
        data() {
            return {

            };
        },

        methods: {

            starRating : function () {

                /* 1. Visualizing things on Hover - See next part for action on click */
                $('.stars_click li').on('mouseover', function () {
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function (e) {
                        if (e < onStar) {
                            $(this).addClass('hover');
                        } else {
                            $(this).removeClass('hover');
                        }
                    });

                }).on('mouseout', function () {
                    $(this).parent().children('li.star').each(function (e) {
                        $(this).removeClass('hover');
                    });
                });


                /* 2. Action to perform on click */
                $('.stars_click li').on('click', function () {

                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');
                    var i = 0;
                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                        $(stars[i]).removeClass('chosen');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');

                    }

                    // JUST RESPONSE (Not needed)
                    //var ratingValue = parseInt($('.stars_click li.selected').last().data('value'), 10);
                    var ratingValue = i;
                    var msg = "Thanks! You are rating this place with " + ratingValue + " stars.";

                    $('.success-box').fadeIn(200);
                    $('.success-box img').attr('src', "https://superiusidea.hr/wp-content/uploads/2014/06/kvacica.png");
                    $('.success-box img').show();
                    $('.success-box div.text-message').html("<span>" + msg + "</span>");
                    $('.StarValue').attr('value', ratingValue);
                });

                $('.stars-button').on('click', function () {
                    $('.success-box img').attr('src', "");
                    $('.success-box img').hide();
                });
            },
        },
        mounted() {
            this.starRating();
        }

    };
</script>
