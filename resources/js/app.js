/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import Vue from 'vue';

import { LMap, LMarker, LTileLayer, LPopup, LTooltip, LControl} from "vue2-leaflet";
delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});
import 'leaflet/dist/leaflet.css';
import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);

Vue.component('star-rating', require('./components/Star-rating.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        showMap: true,
        showLoc: false,

        defaultlat: 45.099998,
        defaultlng: 15.200000,

        clat: 45.099998,
        clng: 15.200000,
        center: null,

        llat: null,
        llng: null,
        myLocationstring: "You are here",
        myLocation: null,
        savedLoc : null,

        url: "https://{s}.tile.osm.org/{z}/{x}/{y}.png",
        attribution:
            '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        zoom: 12,

        dicon:L.icon({
            iconUrl: 'https://www.pngkey.com/png/full/933-9338142_icon-marker-circle.png',
            iconUrl: 'https://cdn1.iconfinder.com/data/icons/ui-5/502/marker-512.png',
            iconSize: [40, 40], // size of the icon
        }),
        redIcon: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),
        greenIcon: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        }),

        location:null,
        gettingLocation: false,
        errorStr:null,


    },
    components: { LMap, LTileLayer, LMarker, LPopup, LTooltip, LControl},
    props: {
        places: [Object, String, Array],
        find: [Boolean, Number],
    },
    methods: {

        toggleShowMap(){
            this.showMap = !this.showMap
        },
        showLocations(){
            this.showLoc = true;
        },
        hideLocations(){
            this.showLoc = false;
        },
        ShowMap(){
            this.showMap = true;
        },

        showPlace: function(placelat, placelng){
            this.center = L.latLng(placelat, placelng);
            this.zoom = 15;
        },
        showMe: function() {
            this.center = L.latLng(this.llat, this.llng);
            this.myLocation = L.latLng(this.llat, this.llng);
            this.zoom = 13;
        },

        GetLocation(){


            this.$getLocation({enableHighAccuracy: true})
                .then(coordinates => {
                    this.gettingLocation = true;
                    this.llat = coordinates.lat;
                    this.llng = coordinates.lng;
                    this.myLocation = L.latLng(this.llat, this.llng);



                    if(this.llat == null || this.llng == null){
                        this.center = L.latLng(this.defaultlat, this.defaultlng);
                        this.zoom = 5;
                    }
                    //send to session

                        $.ajax({
                            url:'/getgeo',
                            type:'get',
                            data:{latitude:this.llat, longitude:this.llng},


                            success:function(data)
                            {
                                 //alert('success');
                            }
                        });
                    });


        },
        AdjustCenterForSavedLoc: function(){
            if(this.$refs.mylat) this.clat = this.$refs.mylat.value;
            if(this.$refs.mylng) this.clng = this.$refs.mylng.value;

            if(this.clat === '' || this.clng === ''){
                this.center = L.latLng(this.defaultlat, this.defaultlng);
                this.zoom = 3;
            } else {
                this.center = L.latLng(this.clat, this.clng);
                this.savedLoc  = L.latLng(this.clat, this.clng);
            }
        },
        scrollNav: function (event) {
            //if collapsed navbar is opened and scroll is on top, add
            if($(".navbar-toggler").attr("aria-expanded") == "true" && $(window).scrollTop() == 0){
                $(".navbar").addClass('bg-black');
                ///if its not on top, add black background
            } else if($(window).scrollTop()) {
                $(".navbar").addClass('bg-black');
            } else {
                ///else transparent
                $(".navbar").removeClass('bg-black');
            }

        },
        CheckNav: function() {
            if($(window).scrollTop()) {
                $(".navbar").addClass('bg-black');
            } else {
                $(".navbar").removeClass('bg-black');
            }
        },
        CheckSmallNav: function() {
            $(".navbar").addClass('bg-black');


        },
        AlertTimeout: function () {
            setTimeout(function () {
                $(".timeout").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);
        },

        image_adjustment: function () {
            var input = document.getElementById( 'multiple_images' );
            var infoArea = document.getElementById( 'file-upload-filename' );
            // the change event gives us the input it occurred in
            var input = event.srcElement;

            if(input.files.length > 1){
                var fileName = input.files.length + ' files'
            } else {
                // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
                var fileName = input.files[0].name;
            }

            // use fileName however fits your app best, i.e. add it into a div
            infoArea.textContent = '- ' + fileName;
            infoArea.style.display = 'initial';

        },


        GoogleAutocomplete (){
            if (document.getElementById('google_address')){
                var input = document.getElementById('google_address');
                var autocomplete = new google.maps.places.Autocomplete(input);
            }
            if (document.getElementById('google_location')){
                var input1 = document.getElementById('google_location');
                var autocomplete = new google.maps.places.Autocomplete(input1);
            }
        },


        ChangeRange: function (event) {
            var range = event.target.value;
            document.getElementById("rangeValue").innerHTML = range;
            document.getElementById("inputRangeValue").value = range;

        },
        GetTimezone : function () {
            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
            $.ajax({
                url:'/gettimezone',
                type:'get',
                data:{timezone:tz},
                success:function(data)
                {
                    //alert('success');
                }
            });
        },
        starRating : function () {

            /* 1. Visualizing things on hover*/
            $('#stars li').on('mouseover', function () {
                var onStar = parseInt($(this).data('value'), 10); // the star currently mouse on

                // now highlight all the stars before hovered star
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
            $('#stars li').on('click', function () {

                var onStar = parseInt($(this).data('value'), 10); //the star currently selected
                var stars = $(this).parent().children('li.star');
                var i = 0;
                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                    $(stars[i]).removeClass('chosen');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');

                }

                var ratingValue = i;
                var msg = "Thanks! You are rating this place with " + ratingValue + " stars.";

                $('.success-box').fadeIn(200);
                $('.success-box img').attr('src',"https://superiusidea.hr/wp-content/uploads/2014/06/kvacica.png");
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
    mounted: function () {
        this.GetLocation();
        this.AlertTimeout();
        this.CheckNav();
        this.AdjustCenterForSavedLoc();
        this.GoogleAutocomplete();
        this.GetTimezone();
        if(this.$refs.savedlocation && this.$refs.savedlocation.checked) this.showLoc = true;
        this.starRating();

    },
    created: function () {
        window.addEventListener('scroll', this.scrollNav);


    },
    destroyed: function () {
        window.removeEventListener('scroll', this.scrollNav);
    }


});




