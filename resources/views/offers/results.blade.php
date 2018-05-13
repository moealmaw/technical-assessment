@extends('layouts.app')

@section('content')

    <div class="bg-grey-lighter min-h-screen">
        <div class="container mx-auto">
            <div class="mb-4">
                <h5 class="uppercase bg-expedia-blue-dark text-white px-3 py-3 block text-xl rounded-r-full border-t-4 border-b-4 border-r-4 border-expedia-yellow m-0">
                    <span class="text-expedia-yellow">Trav</span>offers.<span class="text-expedia-yellow">com</span>
                </h5>
            </div>

            <div class="Main">
                <div class="grid-flex grid-gap-2 flex-wrap">
                    <aside id="sidebar" class="grid-cell">
                        <div class="h-full bg-white p-4">
                            <form action="{{ route('offers.search') }}" class="w-full mb-4 mx-auto px-6 md:px-0">
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full px-3">
                                        <span class="inline-block text-expedia-blue-dark text-lg font-bold">Search Offers</span>
                                        <hr class="border-grey-lighter border mb-4 relative" />
                                    </div>
                                    <div class="w-full px-3 mb-4">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                                               for="destination-city">
                                            Destination City
                                        </label>
                                        <google-places-picker value="{{ request('destination_name') }}" id="destination-city"
                                                              className="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4">
                                        </google-places-picker>
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-1">
                                    <div class="w-full px-1 mb-4">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2"
                                               for="datepicker">
                                            Travel Date
                                        </label>
                                        <div class="relative">
                                            <datepicker default-date="{{ request('trip_date') }}" id="datepicker"></datepicker>
                                            <div class="drop">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20">
                                                    <path></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-1">
                                    <div class="w-full px-1 mb-4">
                                        <label class="block uppercase w-full tracking-wide text-grey-darker text-xs font-bold mb-2"
                                               for="flexibility">
                                            Flexible Dates
                                        </label>
                                        <div class="relative">
                                            <select name="flexibility" id="flexibility"
                                                    class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 rounded">
                                                <option {{ request('flexibility') == 3 ? 'selected' : '' }} value="3">-/+ 3 Days</option>
                                                <option {{ request('flexibility') == 5 ? 'selected' : '' }} value="5">-/+ 5 Days</option>
                                                <option {{ request('flexibility') == 7 ? 'selected' : '' }} value="7">-/+ 7 Days</option>
                                                <option {{ request('flexibility') == 0 ? 'selected' : '' }} value="0">Exact Date</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-full px-1 mb-4">
                                        <label class="block uppercase w-full tracking-wide text-grey-darker text-xs font-bold mb-2"
                                               for="lengthOfStay">
                                            Length of stay <small>days</small>
                                        </label>
                                        <div class="relative">
                                            <input type="number"
                                                   name="length_of_stay"
                                                   value="{{ request('length_of_stay', 5) }}"
                                                   class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 rounded"
                                                   id="lengthOfStay"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-1 flex-row-reverse">
                                    <div class="w-full px-1">
                                        <button type="submit" class="w-full shadow bg-expedia-blue hover:bg-expedia-blue-dark text-white font-bold py-2 px-4 rounded text-lg">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </aside>
                    <section id="results" class="grid-cell flex-1">
                        <offers-list :data-offers="{{ $offers }}"></offers-list>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
