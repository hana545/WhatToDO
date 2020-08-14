<template>
    <div class="row">
        <div class="col-md-9">
            <div id="#map" v-if="gettingLocation" style="height: 800px">
                <l-map :center="center" :zoom="zoom" ref="mymap">
                    <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                    <l-marker :lat-lng="center" :icon="redIcon"><l-tooltip :content="myLocation"></l-tooltip></l-marker>
                    <li v-for="place in places" :key="place.name">
                        <l-marker :lat-lng="{'lat': place.lat, 'lng': place.lng}"><l-tooltip :content="place.name"></l-tooltip></l-marker>
                    </li>
                </l-map>
            </div>
        </div>

        <div class="col-md-3 overflow-auto border-left " style="height: 900px">


            <div v-if="places" v-for="place in places"  >
                <div class="col-sm my-4" >
                    <div class="card zoom ">
                        <div class="card-body">
                            <h4 class="card-title p-2">{{ place.name }}</h4>
                            <p class="card-text">{{ place.description }}</p>
                            <p class="card-text">{{ place.category_id }}</p>

                            <button  class="btn btn-secondary">Show me</button>


                        </div>
                    </div>
                </div>
            </div>
            <div class="card"  v-else>
                <div class="card-body">
                    There are no matching objects
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { LMap, LMarker, LTileLayer, LPopup, LTooltip} from "vue2-leaflet";
    delete L.Icon.Default.prototype._getIconUrl;

    L.Icon.Default.mergeOptions({
        iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
        iconUrl: require('leaflet/dist/images/marker-icon.png'),
        shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
    });
    export default {
        props: {
            places: [Object, String, Array],
            find: [Boolean, Number],
        },
        data() {
            return {
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


                myLocation: "You are here",
                location:null,
                gettingLocation: false,
                errorStr:null,

            };
        },

        methods: {

        },
        components: { LMap, LTileLayer, LMarker, LPopup, LTooltip},
        computed: {

        },
        events: {

        },
        mounted() {
            this.$getLocation({enableHighAccuracy: true})
                .then(coordinates => {
                    this.gettingLocation = true;
                    this.center = L.latLng(coordinates.lat, coordinates.lng);
                    //console.log('mouted-api.sh ', coordinates.lat, coordinates.lng);
                });
        },
        updated() {
            this.$getLocation({enableHighAccuracy: true, timeout:10000})
                .then(coordinates => {
                    this.center = L.latLng(coordinates.lat, coordinates.lng);
                    //console.log('updated-api.sh ', coordinates.lat, coordinates.lng);

                });

        }
    };
</script>
