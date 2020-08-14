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

import { LMap, LMarker, LTileLayer, LPopup, LTooltip} from "vue2-leaflet";
delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});
import 'leaflet/dist/leaflet.css';
import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);

Vue.component('map-component', require('./components/Map-Leaflet.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        seenPhone: false,
        seenEmail: false,
        seenWebsite: false,
        addmore: "Add one more",
        remove: "Remove one",
        show: false,

        all: true,
        one:false,

        location:null,
        gettingLocation: false,
        error:null,

            center: null,
            url: "http://{s}.tile.osm.org/{z}/{x}/{y}.png",
            attribution:
                '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 12,
            marker:null,
            dicon:L.icon({
                iconUrl: 'https://www.pngkey.com/png/full/933-9338142_icon-marker-circle.png',
                iconUrl: 'https://cdn1.iconfinder.com/data/icons/ui-5/502/marker-512.png',
                iconSize: [40, 40], // size of the icon
            }),
            greenIcon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            redIcon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            goldIcon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }),
            showInside: false,


            myLocationstring: "You are here",
            myLocation: null,
            location:null,
            gettingLocation: false,
            errorStr:null,


    },
    components: { LMap, LTileLayer, LMarker, LPopup, LTooltip},
    props: {
        places: [Object, String, Array],
        find: [Boolean, Number],
    },
    methods: {
        toggleShow(){
            this.show = !this.show
        },
        seeOne(){
            this.one = true;
            this.all = false;
        },
        showPlace(lat, lng){
            this.center = L.latLng(lat, lng);
            this.zoom = 15;
        },
        showMe(){
            this.$getLocation({enableHighAccuracy: true})
                .then(coordinates => {
                    this.gettingLocation = true;
                    this.myLocation = L.latLng(coordinates.lat, coordinates.lng);
                    this.center = L.latLng(coordinates.lat, coordinates.lng);
                    this.zoom = 13;
                });
        }
    },
    mounted() {
        this.$getLocation({enableHighAccuracy: true})
            .then(coordinates => {
                this.gettingLocation = true;
                this.center = L.latLng(coordinates.lat, coordinates.lng);
                this.myLocation = L.latLng(coordinates.lat, coordinates.lng);
                    $.ajax({
                        url:'/getgeo',
                        type:'get',
                        data:{latitude:coordinates.lat,longitude:coordinates.lng},


                        success:function(data)
                        {
                            // alert('success');
                        }
                    });
                //console.log('mouted-api.sh ', coordinates.lat, coordinates.lng);
            });
    },

    updated() {
        this.$getLocation({enableHighAccuracy: true})
            .then(coordinates => {
                this.gettingLocation = true;
                this.center = L.latLng(coordinates.lat, coordinates.lng);
                this.myLocation = L.latLng(coordinates.lat, coordinates.lng);
                $.ajax({
                    url:'/getgeo',
                    type:'get',
                    data:{latitude:coordinates.lat,longitude:coordinates.lng},


                    success:function(data)
                    {
                        // alert('success');
                    }
                });
                //console.log('mouted-api.sh ', coordinates.lat, coordinates.lng);
            });
    },


});


///alert fade up
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 2000);
////


// Scrolling Effect for nav

$(window).on("scroll", function() {
    if($(window).scrollTop()) {
        $(".navbar").addClass('bg-black');
    }

    else {
        $(".navbar").removeClass('bg-black');
    }
})


const $dropdown = $(".dropdown");
const $dropdownToggle = $(".dropdown-toggle");
const $dropdownMenu = $(".dropdown-menu");
const showClass = "show";

$(window).on("load resize", function() {
    if (this.matchMedia("(min-width: 768px)").matches) {
        $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
        );
    } else {
        $dropdown.off("mouseenter mouseleave");
    }
});


////_________________map______
/*
var map = L.map('mapid');

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else {
    console.log("Geolocation is not supported by this browser.");
}


function showPosition(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    console.log('lat:', lat);
    console.log('lng:', lng);
    map.setView([lat,lng], 15);
    L.marker([lat,lng]).addTo(map);
}



/*

var mylocation;
var radius_circle;


function onLocationFound(e)

    {
        var radius = e.accuracy / 2;
        var location = e.latlng;
        if (mylocation) map.removeLayer(mylocation);
        if (radius_circle) map.removeLayer(radius_circle);
        mylocation = L.marker(location);
        map.addLayer(mylocation);
        radius_circle = L.circle(location, radius);
        map.addLayer( radius_circle);
    }
}


function onLocationError(e) {
    alert(e.message);
}

$("#locate").on("click", function(){
    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);

    map.locate({setView: true, maxZoom: 16});
});

*/

$("#picture").on('change', function() {

    var input = document.getElementById( 'picture' );
    var infoArea = document.getElementById( 'file-upload-filename' );
    // the change event gives us the input it occurred in
    var input = event.srcElement;

    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName = input.files[0].name;

    // use fileName however fits your app best, i.e. add it into a div
    infoArea.textContent = '- ' + fileName;
    infoArea.style.display = 'initial';
    if (fileName.length < 15){
        document.getElementById( 'length_filename' ).style.width = '40%';
    } else if (fileName.length < 30) {
        document.getElementById('length_filename').style.width = '50%';
    } else if (fileName.length < 50) {
        document.getElementById('length_filename').style.width = '80%';
    } else {
        document.getElementById('length_filename').style.width = '100%';
    }
});

$(document).ready(function(){
    $('#rangeIndicator').on('change', function(e){
        var id = e.target.value;
        document.getElementById("rangeValue").innerHTML = id;
        document.getElementById("inputRangeValue").value = id;

    });
    $('#rangeIndicator').change();
});




