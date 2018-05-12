<template>
    <div v-show="isOpen" class="Map">

        <div class="Map__Close">
            <span @click="closeMap()" class="Map__CloseBtn">Close</span>
        </div>

        <div class="Map__Container">
            <div id="Map__PlacesList" class="Map__PlacesList">
                <div v-for="offer in markers_list"
                     :key="offer.id"
                     :id="`place.${offer.id}`"
                     @click="placeFocus(offer.id);"
                     class="Map__PlacesList__Item"
                     :class="[offer.id == activePlaceId ? 'active' : '']"
                >
                    <div class="name">{{ offer.name }}</div>
                    <div class="address">
                        {{ offer.country }}, {{ offer.city}}
                    </div>
                </div>
            </div>
            <div class="Map__Area">
                <div id="map" ref="map"></div>
            </div>
            <div v-show="false" class="Map__MarkerInfo">
                <div class="Map__MarkerInfo__Item" v-for="place in markers_list" :ref="`marker_info.${place.id}`">
                    <h2 class="name">
                        {{place.name}}
                        <span class="stars" v-html="star.repeat(place.starRating)"></span>
                    </h2>
                    <p class="address">
                        {{place.country}}, {{place.city}}
                    </p>

                    <img class="image" :src="place.img" :alt="place.name">
                    <div class="details">
                        <div class="inner">
                            <span>{{ place.travelStartDate }}</span>
                            <span class="text-grey lowercase">to</span>
                            <span>{{ place.travelEndDate}}</span>
                        </div>
                        <button @click="$parent.book()" class="book_btn">
                            Book
                        </button>
                    </div>

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
        name: 'address-map',
        data() {
            return {
                map: {},
                markers: [],
                activePlaceId: null,
                star,
                isOpen: false,
            };
        },
        mounted() {
            this.initMap(() => {
                this.drawMarkers();

                VueEvent.$on('PlacesMap.open', placeId => {
                    this.openMap(placeId);
                });

                VueEvent.$on('PlacesMap.close', () => {
                    this.closeMap();
                });

            });
        },
        watch: {
            activePlaceId: function (placeId) {
                const place = this.getPlace(placeId);
                if (!place) {
                    return this.activePlaceId = null;
                }
                this.scrollToPlace(`place.${placeId}`);
                this.map.setZoom(10);
                this.map.panTo(place.marker.getPosition());
                place.infoWindow.open(this.map, place.marker);
            }
        },
        methods: {
            initMap: function (cb) {
                VueEvent.$on('GoogleMapsLib.Loaded', () => {
                    this.map = new google.maps.Map(this.$refs.map, {
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        zoom: 2,
                        center: {lat: 0, lng: 0}
                    });
                    return cb();
                });
            },
            openMap: function (placeId) {
                this.isOpen = true;
                this.placeFocus(placeId);
            },
            closeMap: function () {
                this.isOpen = false;
                this.activePlaceId = null;
            },
            placeFocus: function (placeId) {
                this.activePlaceId = placeId;
            },
            getPlace: function (placeId) {
                //closes info window for all markers
                this.markers.forEach(m => (m.infoWindow || {}).close());
                //check if the selected place exists
                return this.markers.find(m => {
                    return m.id == placeId
                });
            },
            scrollToPlace: async function (elmId) {
                (document.getElementById(elmId) || {}).scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            },
            drawMarkers(){
                this.markers = this.markers_list.map(_marker => {
                    const location = new google.maps.LatLng(_marker.latitude, _marker.longitude);

                    const marker = new google.maps.Marker({
                        position: location,
                        map: this.map,
                        title: _marker.name,
                    });

                    marker.addListener('click', () => {
                        this.placeFocus(_marker.id)
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: this.$refs[`marker_info.${_marker.id}`][0],
                        maxWidth: 300
                    });

                    google.maps.event.addListener(infoWindow, 'closeclick', () => {
                        this.map.setZoom(2);
                    });
                    return {
                        id: _marker.id,
                        marker,
                        infoWindow
                    }
                });
            },

        },
    };
</script>
<style>
    #map {
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
