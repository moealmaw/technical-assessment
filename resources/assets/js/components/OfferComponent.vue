<template>
    <div class="Offer__Body">
        <div class="Offer__Inner">
            <div class="Offer__Image grid-cell">
                <object class="Offer__Image__Object" :data="offer.img"
                        type="image/jpeg">
                    <div class="Offer__Image__Object__NotFound">
                        <span class="text-4xl">&#x1F3E8;</span>
                        <span>No Photo</span>
                    </div>
                </object>
            </div>
            <div class="grid-cell flex-1">
                <div class="Offer__Details">
                    <div class="grid-flex grid-gap-1 Offer__Details__Dates">
                        <div class="grid-cell">
                            <div class="grid-flex grid-gap-hair Offer__Details__Dates__Line">
                                <span class="grid-cell">Dates:</span>
                                <span class="grid-cell val">{{ offer.travelStartDate }}</span>
                                <span class="grid-cell low">to</span>
                                <span class="grid-cell val">{{ offer.travelEndDate}}</span>
                            </div>
                        </div>
                        <div class="grid-cell">
                            <div class="grid-flex grid-gap-hair Offer__Details__Dates__Line">
                                <span class="grid-cell">Avg Price Per Night:</span>

                                <span class="grid-cell val">{{ offer.priceCurrency }}{{ offer.pricePerNight }}</span>

                                <span v-if="offer.pricePercentSaving"
                                      class="grid-cell line-through">{{ offer.priceCurrency }}{{ offer.priceOriginalPerNight }}</span>

                            </div>
                        </div>
                    </div>
                    <div class="Offer__Details__Title">
                        <h2 class="Offer__Details__HotelName">{{offer.name }}</h2>
                        <p class="Offer__Details__HotelAddress">
                            {{ offer.country }}, {{ offer.city }} <a
                                @click="openPlaceMap(offer.id)" class="Offer__Details__Link">Address map</a>
                        </p>

                        <div class="Offer__Details__Body">
                            <span>{{ offer.priceCurrency }}{{ offer.totalSaving }}</span>
                            off original price on <span>{{ offer.lengthOfStay }}</span>
                            nights stay.
                        </div>
                    </div>

                    <div class="Offer__Details__Footer">
                        <div class="Offer__Details__Footer__Box">
                            <span class="label">Star Rating</span>
                            <span class="text-expedia-yellow flex" v-html="star.repeat(offer.starRating)"></span>
                        </div>
                        <div class="Offer__Details__Footer__Box">
                            <span class="label">Guest Rating</span>

                            <div v-if="offer.reviewTotal" class="flex items-center">
                                <span class="mr-1 text-sm font-bold text-expedia-blue">{{ offer.guestReviewRating }}/5</span>
                                <span class="mr-1 text-xs font-bold">based on</span>
                                <span class="mr-1 text-sm font-bold text-expedia-blue">{{ offer.reviewTotal }}</span>
                                <span class="mr-1 text-xs font-bold">reviews.</span>
                            </div>
                            <span v-else
                                  class="mr-1 text-expedia-blue uppercase font-black text-xs">New Hotel</span>
                        </div>

                    </div>

                </div>
            </div>
            <div class="grid-cell">
                <div class="Offer__Pricing">
                    <div v-if="offer.pricePercentSaving"
                         class="Offer__Pricing__Discount">
                        {{ offer.pricePercentSaving }}% off
                    </div>

                    <div class="Offer__Pricing__Details">
                        <h3 v-if="offer.pricePercentSaving" class="Offer__Pricing__Saving">
                            {{ offer.priceCurrency }}{{offer.priceTotalOriginal}}
                        </h3>
                        <h2 class="Offer__Pricing__Total">
                            {{ offer.priceCurrency }}{{offer.priceTotal}}
                        </h2>
                    </div>
                    <span class="Offer__Pricing__Notice">
                            Price for {{ offer.lengthOfStay }} nights
                        </span>
                    <div class="Offer__Pricing__Book">
                        <a @click="book(this)" href="#">
                            Book
                        </a>
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
        props: ["offer", "gridType"],
        data() {
            return {
                star,
            };
        },
        mounted() {

        },
        watch: {},
        methods: {
            openPlaceMap: function (placeId) {
                VueEvent.$emit('PlacesMap.open', placeId);
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
