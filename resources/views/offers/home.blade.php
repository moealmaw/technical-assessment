@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row min-h-screen">
        <div class="lg:w-1/2 w-full h-64 lg:h-auto HomeCover"></div>
        <div class="lg:w-1/2 w-full -my-8 md:my-0 md:pt-6 lg:px-12 flex flex-col">
            <div id="logo" class="w-full mb-4 pr-6 lg:pr-0">
                <h5 class="uppercase bg-expedia-blue-dark text-white px-3 py-3 block text-xl rounded-r-full border-t-4 border-b-4 border-r-4 border-expedia-yellow m-0">
                    <span class="text-expedia-yellow">Trav</span>offers.<span class="text-expedia-yellow">com</span>
                </h5>
            </div>
            <div class="w-full px-6 md:px-0 mb-2 mx-auto">
                <h1 class="text-expedia-blue-dark leading-tight mb-2 text-3xl sm:text-4xl md:text-5xl text-left uppercase font-bold">Book your perfect stay with us</h1>
                <p class="text-grey mb-4">Book your perfect stay with over two million properties</p>
                <div class="text-center">
                    <a href="{{ route('offers.search') }}" class="inline-block bg-expedia-yellow text-expedia-blue-dark hover:bg-expedia-blue hover:text-white no-underline font-bold py-2 px-4 rounded text-lg">Browse Available Offers</a>
                </div>
            </div>
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
                        <google-places-picker id="destination-city"
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
                            <datepicker default-date="{{ old('trip_date', Carbon\Carbon::now()->format('Y-m-d')) }}" id="datepicker"></datepicker>
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
                    <div class="w-full md:w-1/2 px-1 mb-4">
                        <label class="block uppercase w-full tracking-wide text-grey-darker text-xs font-bold mb-2"
                               for="flexibility">
                            Flexible Dates
                        </label>
                        <div class="relative">
                            <select name="flexibility" id="flexibility"
                                    class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 rounded">
                                <option value="3">-/+ 3 Days</option>
                                <option value="5">-/+ 5 Days</option>
                                <option value="7">-/+ 7 Days</option>
                                <option value="0">Exact Date</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-1 mb-4">
                        <label class="block uppercase w-full tracking-wide text-grey-darker text-xs font-bold mb-2"
                               for="lengthOfStay">
                            Length of stay <small>days</small>
                        </label>
                        <div class="relative">
                            <input type="number"
                                   name="length_of_stay"
                                   value="5"
                                   class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 rounded"
                                   id="lengthOfStay"/>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-1 flex-row-reverse">
                    <div class="w-full md:w-1/4 px-1">
                        <button type="submit" class="w-full shadow bg-expedia-blue hover:bg-expedia-blue-dark text-white font-bold py-2 px-4 rounded text-lg">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection