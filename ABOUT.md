## Overview

As per your requirements to the coding exercise, this repository includes the source code of the app running on http://gentle-inlet-28691.herokuapp.com/

## File Changes
[A list of files containing the code I have written and implemented is at the end of this page, each is linked to it's source code in this repository.](#file-changes-list "A list of files containing the code I have written and implemented is at the end of this page, each is linked to it's source code in this repository.")

## Tech Stack

### Backend

##### PHP

Although I have been working with NodeJS in the past year, I chose to accomplish the task using PHP mainly because its the programming language I have worked with nearly most of the years of my career. 

##### Laravel Framework
Laravel is an open source PHP framework with expressive and elegant syntax, it includes most of the features and tools a developer might need to accomplish business requirements, and that goes way beyond the MVC structure, such as advanced routing, middlewares, queues, events, IoC container, and really much more https://laravel.com/docs/5.6/introduction, it is super quick to setup and get started with, It's well maintained and have one of the most active online communities, Laravel is also the most starred PHP framework on Github.

### The Frontend

- [VueJS](https://vuejs.org/v2/guide/list.html "VueJS") is a modern Javascript framework that competes with React and Angular. It provides reactivity and speed in execution and development time.
- [Tailwind CSS](https://tailwindcss.com/ "Tailwind CSS") is a CSS utilities framework, IMHO CSS utilities approach is the best and fastest way to prototype front-end layout,
- [Babel JS](https://babeljs.io/ "Babel JS") & [Webpack](https://webpack.js.org/ "Webpack") (and a bunch of it's loaders) is used to transpile, compile, version, optimize, and minify web assets, such as ES2015 & SCSS files into valid Javascript and CSS files.

> Since I love what I do, I try to improve myself and practice different methods and learn new techniques with every task I work on, weather it's an exercise or for production, So since I worked on this over the weekend, I have put some extra "out of scope" efforts on the front-end to give the final results a good apperance and some extra functionality.


#### Expedia API issue:

##### Limited Requests:

When I started implementing the API calls in the code, an issue started to appear when sending the requests from the PHP HTTP client, returning `429` HTTP status (Too Many Requests), and an actual HTML page in the body including Google reCAPTCHA asking for verification after three or four requests to the API. Although the issue did not really appear that often when using the browser, it was obvious that the API is using the headers sent by the browser to validate the request.

So to work around this, and since caching is a feature you wanted to be excluded in the requirements, I have configured the HTTP Client in the [App Service Provider](https://github.com/moealmaw/technical-assessment/blob/master/app/Providers/AppServiceProvider.php#L31-L39 "App Service Provider") and attached some extra headers to the request (same headers the browser attaches when performing HTTP request)

		....
        $client = new \GuzzleHttp\Client([
            'cookies'  => new \GuzzleHttp\Cookie\FileCookieJar('/tmp/expedia_cookie_new', true),
            'headers'  => [
                'user-agent'      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36",
                'accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'accept-encoding' => 'gzip, deflate, br',
                'accept-language' => 'en-GB,en;q=0.9,en-US;q=0.8,ar;q=0.7',
            ],
        ]);
and that fixes the problem, or increases the number of allowed requests per IP to be more precise.

##### The `minTripStartDate` and `maxTripStartDate` trap

The API won't return no results when one of the two values is not set, and since it would not be so user friendly and confusing to have two travel dates, moreover the API wont likely return any results if both are set to the same, I have added a select option for the user in te form called Flexibility with predefined options, which gives the option to select how flexible they are with travel date. What it does is, it takes the user specified travel date and it creates a range of min/max travel dates and send them to the API.
For example if the user sets `20-06-2018` as travel date and `+/-3` in flexibility field, the search will be performed on `minTripStartDate=17-06-2018` and `maxTripStartDate=20-06-2018`. It will also handles if the selected travel date is today, it wont set the min travel date in the past.

### Request Life Cycle

After the request is sent to the server, it runs through the Laravel framework pipeline, then the request runs into the code as the following:

- [routes/web.php](https://github.com/moealmaw/technical-assessment/blob/master/routes/web.php "routes/web.php") Matches the request and sends it the approperiate handler (Controller, Response)

- A request of the offers main page, would return a view of an HTML page including the search form (Home Screen Shot)

- when the user fills the form and submits it, it will be rerouted and gets handled by OffersController using the `search` method:


	class OffersController {
		....
        public function __construct(OffersInterface $offers)
        {
            $this->offers = $offers;
        }

        public function search(OfferSearchRequest $request)
        {
            try {
                $offers = $this->offers->searchFromRequest($request);
            }
            ...
        }

[OfferSearchRequest](https://github.com/moealmaw/technical-assessment/blob/master/app/Http/Requests/OfferSearchRequest.php "OfferSearchRequest") is responsible for validating the form input, it also adds missing allowed params to the HTTP Request params, to keep them consistent in the entire request cycle.
Please note that "Laravel" auto inject any type-hinted class and can run a predefined method, in this scenario, it injects the OfferSearchRequest and it runs the "validate" method, so we get the `$request` HTTP Request object that's actually validated.

**Note on the OffersController Class:**
>While `$this->offer` refers to [OfferInterface](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/OffersInterface.php "OfferInterface") in this class construct method, Its actually an injected implementation class called [ExpediaApi](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Expedia/ExpediaApi.php "ExpediaApi") of the [OfferInterface](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/OffersInterface.php "OfferInterface").

>Laravel helps with that using its Service Container, it resolves that implementation and auto inject it wherever the interface is type-hinted, to provide a better Dependancy Injection and Inversion of Control (IoC).

A call to `searchFromRequest` on the [ExpediaApi](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Expedia/ExpediaApi.php "ExpediaApi") is executed with the form object which includes the search params. it runs the request into several methods:
- it maps the form params to the API predefined params.
- creates the date range for min and max trip dates and fixes any other parameter.
- Performs the HTTP request
- It calls [ExpediaTransformer](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Expedia/ExpediaTransformer.php "ExpediaTransformer") class, which:
	- iterates through the API response.
	- Parses response.
	- Splits each found hotel into structured objects called "Nodes".
	- Nodes are [DateRange](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/DateRange.php "DateRange"), [Destination](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/Destination.php "Destination"), [Hotel](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/Hotel.php "Hotel"), [Price](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/Price.php "Price"), each has the relevant information, then all these nodes are attached to one main object called [Offer](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Offer.php "Offer").

After transformation is done, a collection of offers is then returned to the controller, which then sends them to the HTML view [results.blade.php](https://github.com/moealmaw/technical-assessment/blob/master/resources/views/offers/results.blade.php "results.blade.php")

VueJS handles this data in the results page, it takes the offers sent by the backend (as JSON object inside the HTML view, no AJAX), and renders them.

[OffersListComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/OffersListComponent.vue "OffersListComponent.vue") component receives the list of offers as a prop, then renders each one in an a child component called [OfferComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/OfferComponent.vue "OfferComponent.vue"). OffersList.vue also provides the funcationalities of Sorting the results, and the Layout Display (List & Grid).

Since the max results returned from the API seems to be (max 25 or so), and the requirements did not provide much information about the fields that can be used to order results, I have implemented that on front-end, results can be ordered with Javascript using different fields.

Each single result (offer) is rendered using the [OfferComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/OfferComponent.vue "OfferComponent.vue"), which applies the styling and displays the offer data.

The [AddressMap.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/AddressMap.vue "AddressMap.vue") component will render all the hotels and will place a marker for each one on a Google Maps view, it can also display more information about each offer when the marker is clicked.

#### Some more to mention

The front-end design over all follows a modern approach, and if it was not for the requirements and limitations, it would be possible to release them into a real product after a little more work and refactoring.

Components are encapsulated and depends only on data, messaging between them is done using events and listeners, although they communicate, non of them knows about the existence of the other, and many of them are rendered/updated asynchronosly.

Javascript is optimized and bundled into a single [app.js](https://github.com/moealmaw/technical-assessment/blob/master/public/js/app.js "app.js") file that contains all the logic and functions for the app to run.
CSS is is purified and purged (removal of non-used CSS) and minified.

The front-end is tested on the Google Chrome browser and its around 90% responsive. it could pass the Google Chrome audit if I had a little more control on the data source (API) and the time of course.

## Tests

The code has (**17** tests, **45** assertions), which are Unit and Integration tests, they test "most" of the code and functions. The coverage is 100% green for the two types of tests combined (when run together).

Use the following command to run the test suit:

	$ vendor/bin/phpunit --testdox

You can also check the code coverage on the following link:
http://gentle-inlet-28691.herokuapp.com/phpunit_coverage

## File changes list
- [.travis.yml](https://github.com/moealmaw/technical-assessment/blob/master/.travis.yml ".travis.yml")
- [Procfile](https://github.com/moealmaw/technical-assessment/blob/master/Procfile "Procfile")
- [composer.json](https://github.com/moealmaw/technical-assessment/blob/master/composer.json "composer.json")
- [package.json](https://github.com/moealmaw/technical-assessment/blob/master/package.json "package.json")

### HTTP Classes

- [routes/web.php](https://github.com/moealmaw/technical-assessment/blob/master/routes/web.php "routes/web.php")
- [app/Http/Controllers/OffersController.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Http/Controllers/OffersController.php "app/Http/Controllers/OffersController.php")
- [app/Http/Requests/OfferSearchRequest.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Http/Requests/OfferSearchRequest.php "app/Http/Requests/OfferSearchRequest.php")
- [app/Exceptions/ApiException.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Exceptions/ApiException.php "app/Exceptions/ApiException.php")

### Offers & API Integration

- [app/Offers/Expedia/ExpediaApi.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Expedia/ExpediaApi.php "app/Offers/Expedia/ExpediaApi.php")
- [app/Offers/Expedia/ExpediaTransformer.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Expedia/ExpediaTransformer.php "app/Offers/Expedia/ExpediaTransformer.php")
- [app/Offers/Nodes/DateRange.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/DateRange.php "app/Offers/Nodes/DateRange.php")
- [app/Offers/Nodes/Destination.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/Destination.php "app/Offers/Nodes/Destination.php")
- [app/Offers/Nodes/Hotel.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/Hotel.php "app/Offers/Nodes/Hotel.php")
- [app/Offers/Nodes/Price.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Nodes/Price.php "app/Offers/Nodes/Price.php")
- [app/Offers/Offer.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/Offer.php "app/Offers/Offer.php")
- [app/Offers/OffersInterface.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/OffersInterface.php "app/Offers/OffersInterface.php")
- [app/Offers/OffersTransformerInterface.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Offers/OffersTransformerInterface.php "app/Offers/OffersTransformerInterface.php")
- [app/Providers/AppServiceProvider.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Providers/AppServiceProvider.php "app/Providers/AppServiceProvider.php")
- [app/Providers/BroadcastServiceProvider.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Providers/BroadcastServiceProvider.php "app/Providers/BroadcastServiceProvider.php")

#### Utilities

- [app/Utilities/DateUtilities.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Utilities/DateUtilities.php "app/Utilities/DateUtilities.php")
- [app/Utilities/ToArrayToJson.php](https://github.com/moealmaw/technical-assessment/blob/master/app/Utilities/ToArrayToJson.php "app/Utilities/ToArrayToJson.php")

#### Front End

- [public/css/app.css](https://github.com/moealmaw/technical-assessment/blob/master/public/css/app.css "public/css/app.css")
- [public/js/app.js](https://github.com/moealmaw/technical-assessment/blob/master/public/js/app.js "public/js/app.js")
- [public/mix-manifest.json](https://github.com/moealmaw/technical-assessment/blob/master/public/mix-manifest.json "public/mix-manifest.json")
- [resources/assets/js/app.js](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/app.js "resources/assets/js/app.js")
- [resources/assets/js/bootstrap.js](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/bootstrap.js "resources/assets/js/bootstrap.js")
- [resources/assets/js/components/AddressMap.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/AddressMap.vue "resources/assets/js/components/AddressMap.vue")
- [resources/assets/js/components/DatepickerComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/DatepickerComponent.vue "resources/assets/js/components/DatepickerComponent.vue")
- [resources/assets/js/components/ExampleComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/ExampleComponent.vue "resources/assets/js/components/ExampleComponent.vue")
- [resources/assets/js/components/GooglePlacesComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/GooglePlacesComponent.vue "resources/assets/js/components/GooglePlacesComponent.vue")
- [resources/assets/js/components/OfferComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/OfferComponent.vue "resources/assets/js/components/OfferComponent.vue")
- [resources/assets/js/components/OffersListComponent.vue](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/components/OffersListComponent.vue "resources/assets/js/components/OffersListComponent.vue")
- [resources/assets/js/tailwind.js](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/js/tailwind.js "resources/assets/js/tailwind.js")
- [resources/assets/sass/app.scss](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/sass/app.scss "resources/assets/sass/app.scss")
- [resources/assets/sass/tw-auto.scss](https://github.com/moealmaw/technical-assessment/blob/master/resources/assets/sass/tw-auto.scss "resources/assets/sass/tw-auto.scss")
- [resources/views/layouts/app.blade.php](https://github.com/moealmaw/technical-assessment/blob/master/resources/views/layouts/app.blade.php "resources/views/layouts/app.blade.php")
- [resources/views/offers/home.blade.php](https://github.com/moealmaw/technical-assessment/blob/master/resources/views/offers/home.blade.php "resources/views/offers/home.blade.php")
- [resources/views/offers/results.blade.php](https://github.com/moealmaw/technical-assessment/blob/master/resources/views/offers/results.blade.php "resources/views/offers/results.blade.php")
- [webpack.mix.js](https://github.com/moealmaw/technical-assessment/blob/master/webpack.mix.js "webpack.mix.js")

#### Tests

- [tests/Feature/ExampleTest.php](https://github.com/moealmaw/technical-assessment/blob/master/tests/Feature/ExampleTest.php "tests/Feature/ExampleTest.php")
- [tests/Feature/ExpediaApiHttpTest.php](https://github.com/moealmaw/technical-assessment/blob/master/tests/Feature/ExpediaApiHttpTest.php "tests/Feature/ExpediaApiHttpTest.php")
- [tests/Feature/OffersTest.php](https://github.com/moealmaw/technical-assessment/blob/master/tests/Feature/OffersTest.php "tests/Feature/OffersTest.php")
- [tests/TestUtilities.php](https://github.com/moealmaw/technical-assessment/blob/master/tests/TestUtilities.php "tests/TestUtilities.php")
- [tests/Unit/ExampleTest.php](https://github.com/moealmaw/technical-assessment/blob/master/tests/Unit/ExampleTest.php "tests/Unit/ExampleTest.php")
- [tests/Unit/ExpediaApiUnitTest.php](https://github.com/moealmaw/technical-assessment/blob/master/tests/Unit/ExpediaApiUnitTest.php "tests/Unit/ExpediaApiUnitTest.php")
- [tests/mock/sample_response_raw.json](https://github.com/moealmaw/technical-assessment/blob/master/tests/mock/sample_response_raw.json "tests/mock/sample_response_raw.json")
- [tests/mock/sample_response_rendered.json](https://github.com/moealmaw/technical-assessment/blob/master/tests/mock/sample_response_rendered.json "tests/mock/sample_response_rendered.json")
