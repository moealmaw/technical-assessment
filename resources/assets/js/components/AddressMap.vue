<!--suppress JSUnresolvedVariable -->
<template>
    <div class="map">
        <div id="map" ref="map"></div>
        <div v-if="true">
            <div v-for="m in markers_list" :ref="`marker_info.${m.id}`">
                <h2 class="mb-0">
                    {{m.name}}
                    <span class="text-expedia-yellow inline-flex" v-html="star.repeat(3)"></span>
                </h2>
                <p class="mb-1 flex">
                    <span class="text-expedia-bluedark inline-flex mr-1">{{m.country}}, {{m.city}}</span>
                </p>

                <img class="w-full" :src="m.img" :alt="m.name">
                <div class="flex justify-between items-center">
                    <div class="flex">
                        <span class="grid-cell text-xs uppercase text-expedia-blue-dark font-black mr-1">{{ m.travelStartDate }}</span>
                        <span class="grid-cell text-xs text-grey font-black mr-1">to</span>
                        <span class="grid-cell text-xs uppercase text-expedia-blue-dark font-black">{{ m.travelEndDate}}</span>
                    </div>
                    <button @click="$parent.book()"
                            class="bg-expedia-blue-dark text-white hover:text-expedia-blue-dark hover:bg-expedia-yellow px-2 py-2 rounded font-bold">
                        Book
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    let star = `<svg
    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 block">
    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
</svg>`;

    export default {
        props: ['markers_list'],
        data() {
            return {
                map: {},
                markers: [],
                active: null,
                star,
            };
        },
        mounted() {
            this.initMap(() => {
                this.drawMarkers();
            });
        },
        watch: {},
        methods: {
            initMap(cb) {
                if (typeof google == 'undefined') {
                    return setTimeout(() => {
                        this.initMap(cb);
                    }, 500);
                }
                this.map = new google.maps.Map(this.$refs.map, {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoom: 2,
                    center: {lat: 0, lng: 0}
                });
                return cb();
            },
            drawMarkers(){
                this.markers = this.markers_list.map(m => {
                    const location = new google.maps.LatLng(m.latitude, m.longitude);

                    const marker = new google.maps.Marker({
                        position: location,
                        map: this.map,
                        title: m.name,
                    });

                    marker.addListener('click', () => {
                        this.markerFocus(m.id)
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: this.$refs[`marker_info.${m.id}`][0],
                        maxWidth: 300
                    });

                    google.maps.event.addListener(infoWindow, 'closeclick', () => {
                        this.$parent.active = null;
                        this.map.setZoom(2);
                    });
                    return {
                        id: m.id,
                        marker,
                        infoWindow
                    }
                });
            },
            markerFocus(placeId){
                this.markers.forEach(m => (m.infoWindow || {}).close());
                let place = this.markers.find(m => {
                    return m.id == placeId
                });
                if (place) {
                    this.$parent.active = placeId;
                    this.map.setZoom(10);
                    this.map.panTo(place.marker.getPosition());
                    place.infoWindow.open(this.map, place.marker);
                }
            },
        },
    };
</script>
<style>
    #map, .map {
        height: 100%;
        width: 100%;
    }

    #map {
        min-height: 300px;

    }

    #map * {
        border-style: unset;
    }
</style>
