<template>
    <div>
        <div class="flex items-center bg-white px-4 mb-4">
            <div class="flex-1 flex items-center">
                <span class="mr-3 text-sm border-b-2 border-transparent text-grey-darkest">Found <strong>{{ offers.length }}</strong> {{ offers.length == 1 ? 'hotel' : 'hotels' }} for your search criteria</span>
            </div>
            <div class="flex items-center font-semibold text-xs mr-4">
                <span class="mr-1 border-b-2 border-transparent text-grey uppercase">Sort by:</span>
                <a class="px-1 mr-1 no-underline text-grey-darkest border-b-2 border-transparent py-4" href="#"
                   @click="orderBy('price', $event)">Price</a>
                <a class="px-1 mr-1 no-underline text-grey-darkest border-b-2 border-transparent py-4" href="#"
                   @click="orderBy('discount', $event)">Discount Value</a>
                <a class="px-1 mr-1 no-underline text-grey-darkest border-b-2 border-transparent py-4" href="#"
                   @click="orderBy('guest_reviews', $event)">Guest
                    Reviews</a>
                <a class="px-1 mr-1 no-underline text-grey-darkest border-b-2 border-transparent py-4" href="#"
                   @click="orderBy('hotel_stars', $event)">Hotel Stars</a>
            </div>
            <div class="flex items-center font-semibold text-xs">
                <a href="#" class="mr-2 no-outline" :class="[gridType == 'list' ? 'text-expedia-blue' : 'text-grey-dark']" @click="toggleView('list', $event)" v-html="listIcon"></a>
                <a href="#" :class="[gridType == 'grid' ? 'text-expedia-blue': 'text-grey-dark']" @click="toggleView('grid', $event)" v-html="grid"></a>
            </div>
        </div>

        <transition-group class="flex flex-wrap -mx-2" name="flip-list" tag="div">
            <div :key="offer.key" v-for="(offer, i) in offers" :class="offer.className"
                 class="mb-4 mx-2 md:mx-0 offer-item px-2">
                <div class="bg-white shadow">
                    <div class="grid-flex grid-gap-2 flex-col md:flex-row">
                        <div class="grid-cell w-full md:w-64 relative">
                            <object class="obj-fit-cover min-h-48 block w-full relative" :data="offer.hotel.imageUrl.xlarge"
                                    type="image/jpeg">
                                <div class="flex flex-col justify-center items-center absolute pin text-md text-grey font-bold uppercase text-center">
                                    <span class="text-4xl">&#x1F3E8;</span>
                                    <span>No Photo</span>
                                </div>
                            </object>

                        </div>
                        <div class="grid-cell flex-1 details">
                            <div class="flex flex-col py-2 px-2 md:px-0 md:py-2 justify-between min-h-full">
                                <div class="dates grid-flex grid-gap-1 items-center mb-2">
                                    <div class="grid-cell">
                                        <div class="grid-flex grid-gap-hair">
                                            <span class="grid-cell grid-cell text-xs text-grey font-black uppercase">Dates:</span>
                                            <span class="grid-cell grid-cell text-xs uppercase text-expedia-blue-dark font-black">{{ offer.dates.travelStartDate.split('-').reverse().join('/') }}</span>
                                            <span class="grid-cell grid-cell text-xs text-grey font-black">to</span>
                                            <span class="grid-cell grid-cell text-xs uppercase text-expedia-blue-dark font-black">{{ offer.dates.travelEndDate.split('-').reverse().join('/')}}</span>
                                        </div>
                                    </div>
                                    <div class="grid-cell">
                                        <div class="grid-flex grid-gap-hair items-center">
                                            <span class="grid-cell text-xs uppercase text-grey font-black">Avg Price Per Night:</span>

                                            <span class="grid-cell text-sm uppercase text-expedia-blue-dark font-black">{{ currencySymbol(offer.price.priceCurrency) }}{{ Math.round(offer.price.pricePerNight)}}</span>

                                            <span v-if="offer.price.pricePercentSaving"
                                                  class="grid-cell text-sm uppercase text-grey-dark font-black line-through">{{ currencySymbol(offer.price.priceCurrency) }}{{ Math.round(offer.price.priceOriginalPerNight)}}</span>

                                        </div>
                                    </div>
                                </div>
                                <div class="title flex-1">
                                    <h2 class="text-xl text-expedia-blue-dark font-medium font-bold leading-tight">{{
                                        offer.hotel.name }}</h2>
                                    <p class="text-sm text-grey-darker">{{ offer.destination.country }}, {{
                                        offer.destination.city }}
                                        <a @click="placeFocus(offer.hotel.id)"
                                           class="text-xs font-semibold no-underline text-expedia-blue cursor-pointer">Address
                                            map</a></p>

                                    <div class="font-semibold text-sm mt-2 opacity-100 text-grey-dark inline-block"><span
                                            class="text-expedia-blue">{{ currencySymbol(offer.price.priceCurrency) }}{{
                            (Math.round(offer.price.priceOriginalPerNight) * offer.dates.lengthOfStay) - Math.round(offer.price.priceTotal)}} </span>off
                                        original price on <span
                                                class="text-expedia-blue">{{ offer.dates.lengthOfStay }}</span>
                                        nights stay.
                                    </div>
                                </div>

                                <div class="stats flex mb-0">
                                    <div class="flex text-grey mr-4 flex-col">
                                        <span class="uppercase font-black text-xs">Star Rating</span>
                                        <span class="text-expedia-yellow flex"
                                              v-html="star.repeat(offer.hotel.starRating)"></span>
                                    </div>
                                    <div class="flex text-grey flex-col">
                                        <span class="mr-2 uppercase font-black text-xs">Guest Rating</span>

                                        <div v-if="offer.hotel.reviewTotal" class="flex items-center">
                                            <span class="mr-1 text-sm font-bold text-expedia-blue">{{ (Math.round(offer.hotel.guestReviewRating * 10) / 10) }}/5</span>
                                            <span class="mr-1 text-xs font-bold">based on</span>
                                            <span class="mr-1 text-sm font-bold text-expedia-blue">{{ offer.hotel.reviewTotal }}</span>
                                            <span class="mr-1 text-xs font-bold">reviews.</span>
                                        </div>
                                        <span v-else
                                              class="mr-1 text-expedia-blue uppercase font-black text-xs">New Hotel</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="grid-cell pricing min-w-48">
                            <div class="relative pt-8 pb-4 px-2 flex flex-col h-full items-end">

                                <div v-if="offer.price.pricePercentSaving"
                                     class="discount absolute pin-t pin-r flex px-2 text-xl text-expedia-blue-dark font-bold bg-expedia-yellow">
                                    <span class="mr-1">{{ Math.round(offer.price.pricePercentSaving) }}%</span>
                                    <span>off</span>
                                </div>

                                <div class="flex items-center">
                                    <h3 v-if="offer.price.pricePercentSaving" class="mr-1 text-grey-dark line-through">
                                        {{ currencySymbol(offer.price.priceCurrency) }}{{
                                        Math.round(offer.price.priceOriginalPerNight) * offer.dates.lengthOfStay}}
                                    </h3>
                                    <h2 class="text-expedia-blue text-3xl mb-0">
                                        {{ currencySymbol(offer.price.priceCurrency) }}{{
                                        Math.round(offer.price.priceTotal)}}
                                    </h2>
                                </div>
                                <span class="uppercase font-black text-grey text-xs text-right mb-2">
                            Price for {{ offer.dates.lengthOfStay }} nights
                        </span>
                                <div class="flex-1 flex">
                                    <a @click="book(this)" href="#"
                                       class="self-end inline-block bg-expedia-blue text-white hover:bg-expedia-yellow hover:text-expedia-blue-dark no-underline font-bold py-2 px-3 rounded text-sm uppercase">
                                        Book
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition-group>
        <div v-if="modal" class="bg-black p-10 pt-0 fixed pin-t pin-b pin-l pin-r">
            <div class="text-white font-bold uppercase text-xs text-right">
                <span @click="closeMap()" class="cursor-pointer hover:bg-grey-darkest my-1 p-2 inline-block rounded">Close</span>
            </div>
            <div class="flex flex-row bg-white h-full justify-center mx-auto p-3">
                <div class="bg-white pr-3" style="overflow-y: auto;">
                    <div :key="offer.hotel.id" @click="placeFocus(offer.hotel.id);" :id="`place.${offer.hotel.id}`"
                         v-for="offer in offers"
                         class="border-b mb-0 p-2"
                         :class="[offer.hotel.id == active ? 'text-white bg-expedia-blue rounded' : '']">
                        <span class="block">{{ offer.hotel.name }}</span>
                        <span class="block text-sm opacity-75">{{ offer.destination.country }}, {{ offer.destination.city
                            }}</span>
                    </div>
                </div>
                <div class="flex-1 h-full">
                    <address-map ref="address_map" :markers_list="markers_list"></address-map>
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
    let grid = `<svg
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
                star,
                grid,
                listIcon,
                offers: this.dataOffers.map(e => {
                    e.className = 'w-full';
                    e.key = e.hotel.id;
                    return e;
                }),
                modal: false,
                markers_list: [],
                active: null,
                gridType: 'list'
            };
        },
        mounted() {
            document.addEventListener('keyup', e => {
                if (e.keyCode === 27) this.closeMap();
            });

            this.markers_list = this.makeMarkersList();
        },
        watch: {
            gridType: function (type) {
                let gridClasses = ['grid-view'].join(' ');
                let listClasses = ['list-view'].join(' ');
                this.offers.forEach(e => {
                    e.className = (type == 'grid') ? gridClasses : listClasses
                });
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
            closeMap: function () {
                this.modal = false
            },
            placeFocus: function (placeId) {

                this.active = placeId;
                this.openMap();
                this.$nextTick(() => {
                    document.getElementById(`place.${placeId}`).scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                    this.$refs.address_map.markerFocus(placeId);
                });
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
                        travelStartDate: offer.dates.travelStartDate.split('-').reverse().join('/'),
                        travelEndDate: offer.dates.travelEndDate.split('-').reverse().join('/'),
                    }
                });
            },
            currencySymbol: function (currency) {
                switch (currency.toLowerCase()) {
                    case "usd":
                        return "$";
                        break;
                }
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
