<template>
    <div id="locationField">
        <input :class="classname" ref="autocomplete" id="autocomplete" placeholder="Enter your destination city"
               @focus="geolocate()" type="text" v-model="place"/>
        <input type="hidden"  name="destination_name" v-model="place">
    </div>
</template>

<script>
let autocomplete;

export default {
    props: ["classname", "value"],
    data() {
        return {
            place: this.value || null,
        };
    },
    mounted() {
        VueEvent.$on("initGooglePlacesAutocomplete", () => this.init());
    },
    methods: {
        init: function() {
            autocomplete = new google.maps.places.Autocomplete(
                this.$refs.autocomplete,
                { types: ["(cities)"] },
            );
            autocomplete.addListener("place_changed", this.parseAddress);
        },
        parseAddress: function() {
            const place = autocomplete.getPlace();
            this.place = place.formatted_address;
        },
        geolocate: function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    const circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy,
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        },
    },
};
</script>
