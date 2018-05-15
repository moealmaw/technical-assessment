[![Build Status](https://travis-ci.org/moealmaw/technical-assessment.svg?branch=master)](https://travis-ci.org/moealmaw/technical-assessment)

## Demo
The Application can be accessed through this link http://gentle-inlet-28691.herokuapp.com/

> More technical details about the app is documented in [ABOUT.md](https://github.com/moealmaw/technical-assessment/blob/master/ABOUT.md "ABOUT.md")

### Requirements

The installation follows the standard installation requirements for the Laravel Framework, as it can be fairly seen inside the  [.travis.yml](https://github.com/moealmaw/technical-assessment/blob/master/.travis.yml ".travis.yml") they are:

- [PHP >= 7.1](http://php.net/downloads.php "PHP >= 7.1")
- [Composer Package Manager](https://getcomposer.org/ "Composer Package Manager")

Please note that the following extensions must be enabled, which are enabled by default for most of PHP installations and Docker images.

- `OpenSSL PHP Extension`
- `PDO PHP Extension`
- `Mbstring PHP Extension`
- `Tokenizer PHP Extension`
- `XML PHP Extension`
- `Ctype PHP Extension`
- `JSON PHP Extension`

### Installation
Having both PHP and Composer installed on the machine:
    
    $ git clone git@github.com:moealmaw/technical-assessment.git
    $ cd technical-assessment
    $ composer install --no-interaction
    $ cp .env.example .env
    
Once that is completed, you can run the built-in server using the following command

    $ php artisan serve --host=127.0.0.1 --port=8181
    
    Laravel development server started: <http://127.0.0.1:8181>
    

To compile the front-end components and assets, you will need to have Node JS and NPM, installed. More about that inside the - [package.json](https://github.com/moealmaw/technical-assessment/blob/master/package.json "package.json") file. 


### Screenshots

##### Home view
[![Home view](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-Shot-Home.jpg "Home view")](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-Shot-Home.jpg "Home view")

##### Results view
[![](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-Shot-Results.jpg)](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-Shot-Results.jpg)

##### Map View
[![](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-Shot-Map.jpg)](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-Shot-Map.jpg)

##### Responsive view
[![Responsive view](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-shot-responsive-view.jpg "Responsive view")]([![](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-shot-responsive-view.jpg)](https://github.com/moealmaw/technical-assessment/blob/master/screen-shots/Screen-shot-responsive-view.jpg) "Responsive view")









