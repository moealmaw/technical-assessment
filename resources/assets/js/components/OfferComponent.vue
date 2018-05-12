<template>
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
                            <a @click="openPlaceMap(offer.hotel.id)"
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


</template>

<script>
    let star = `<svg
    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 block">
    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
    </svg>`;
    export default {
        props: ["offer"],
        data() {
            return {
                star
            };
        },
        mounted() {
            document.addEventListener('keyup', e => {
                if (e.keyCode === 27) this.closeMap();
            });
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
