<template>
    <div class="Offers">
        <div class="Offers__Top">
            <div class="Offers__Top__Results">
                Found <strong>{{ offers.length }}</strong> {{ offers.length == 1 ? 'hotel' : 'hotels' }} for your search
                criteria.
            </div>
            <div class="Offers__Top__Sort">
                <span class="Offers__Top__Sort__Label">Sort by:</span>
                <a class="Offers__Top__Sort__Btn" href="#"
                   @click="orderBy('price', $event)">Price</a>
                <a class="Offers__Top__Sort__Btn" href="#"
                   @click="orderBy('discount', $event)">Discount Value</a>
                <a class="Offers__Top__Sort__Btn" href="#"
                   @click="orderBy('guest_reviews', $event)">Guest
                    Reviews</a>
                <a class="Offers__Top__Sort__Btn" href="#"
                   @click="orderBy('hotel_stars', $event)">Hotel Stars</a>
            </div>
            <div class="Offers__Top__Sort__View">
                <a href="#"
                   :class="[gridType == 'list' ? 'active' : '']"
                   @click="toggleView('list', $event)" v-html="listIcon"></a>
                <a href="#"
                   :class="[gridType == 'grid' ? 'active': '']"
                   @click="toggleView('grid', $event)" v-html="gridIcon"></a>
            </div>
        </div>

        <transition-group class="Offers__List" name="flip-list" tag="div">
            <div class="Offers__List__Item" :class="gridTypeClass" :key="offer.key" v-for="(offer, i) in offers">
                <offer :offer="offer" :grid-type="gridType"></offer>
            </div>
        </transition-group>

        <address-map ref="address_map" :markers_list="markers_list"></address-map>

    </div>
</template>

<script>
    let gridIcon = `<svg
    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current w-4 h-4 block">
        <path d="M11 11v6h6v-6h-6zm0-2h6V3h-6v6zm-2 2H3v6h6v-6zm0-2V3H3v6h6zm-8 9V1h18v18H1v-1z"/>
    </svg>`;
    let listIcon = `<svg
    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current w-4 h-4 block">
    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
    </svg>`;
    export default {
        props: ["dataOffers"],
        data() {
            return {
                gridIcon,
                listIcon,
                offers: this.dataOffers.map(e => {
                    e.key = e.hotel.id;
                    return e;
                }),
                modal: false,
                markers_list: [],
                active: null,
                gridType: null,
                gridTypeClass: null,
            };
        },
        mounted() {
            document.addEventListener('keyup', e => {
                if (e.keyCode === 27) this.closeMap();
            });
            this.gridType = 'grid';

            this.markers_list = this.makeMarkersList();
        },
        watch: {
            gridType: function (type) {
                this.gridTypeClass = (type == 'grid') ?
                    "Offers__List__Item--grid" : "Offers__List__Item--list";
            }
        },
        methods: {
            toggleView: function (view, event) {
                event.preventDefault();
                this.gridType = view;
            },
            openMap: function () {
                this.modal = true
            },

            makeMarkersList: function () {
                return this.offers.map(offer => {
                    return {
                        id: offer.hotel.id,
                        name: offer.hotel.name,
                        latitude: offer.hotel.latitude,
                        longitude: offer.hotel.longitude,
                        country: offer.destination.country,
                        city: offer.destination.city,
                        img: offer.hotel.imageUrl.xlarge,
                        starRating: offer.hotel.starRating,
                        travelStartDate: offer.dates.travelStartDate.split('-').reverse().join('/'),
                        travelEndDate: offer.dates.travelEndDate.split('-').reverse().join('/'),
                    }
                });
            },
            book(elm){
                elm.event.preventDefault();
                alert("Let's pretend we have booked this hotel for you, and you can pretend to be packing for the trip.");
            },
            orderBy: function (by, event) {
                //remove classes
                const active = document.querySelectorAll(".active_sort");
                active.forEach(elm => {
                    elm.classList.remove('active_sort');
                });
                event.target.classList.add('active_sort');

                switch (by) {
                    case 'price':
                        return this.orderByPrice();
                        break;
                    case 'discount':
                        return this.orderByDiscount();
                        break;
                    case 'guest_reviews':
                        return this.orderByGuestReviews();
                        break;
                    case 'hotel_stars':
                        return this.orderByHotelStars();
                        break;
                }
            },
            orderByPrice: function () {
                this.offers = this.offers.sort((a, b) => {
                    if (a.price.pricePerNight > b.price.pricePerNight) {
                        return 1;
                    }
                    return -1;
                });
            },
            orderByGuestReviews: function () {
                this.offers = this.offers.sort((a, b) => {
                    if (a.hotel.guestReviewRating > b.hotel.guestReviewRating) {
                        return -1;
                    }
                    return 1;
                });
            },
            orderByHotelStars: function () {
                this.offers = this.offers.sort((a, b) => {
                    if (parseInt(a.hotel.starRating) > parseInt(b.hotel.starRating)) {
                        return -1;
                    }
                    return 1;
                });
            },
            orderByDiscount: function () {
                this.offers = this.offers.sort((a, b) => {
                    let a_total_discount = (Math.round(a.price.priceOriginalPerNight) * a.dates.lengthOfStay) - Math.round(a.price.priceTotal);
                    let b_total_discount = (Math.round(b.price.priceOriginalPerNight) * b.dates.lengthOfStay) - Math.round(b.price.priceTotal);

                    if (a_total_discount > b_total_discount) {
                        return -1;
                    }
                    return 1;
                });
            },
        },
    };
</script>
<style>
    .active_sort {
        color: hsl(207, 100%, 36%);
        border-color: hsl(207, 100%, 36%);
    }

    .offer-item {
        transition: all ease 1s;
    }

    .flip-list-move {
        transition: transform 1s;
    }
</style>
