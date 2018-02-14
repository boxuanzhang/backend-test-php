# REX Backend Test

## Overview

This is a forum application partially built based on [Laravel 5.6](https://laravel.com/).
We would like you to help improve this application by completing the tasks outlined below.

### How to complete the test

* Fork this repository and add this repository as an upstream.
* Create branches or work on master (up to you).
* Complete the tasks as outlined below.
* Feel free to add any of your own improvements, be sure to identify them in your commit messages.
* Make sure you replace this README with your own, add any suggestions to developers for getting started.
* Submit a PR once you've completed your work.

We would appreciate you indicating which tasks you are addressing in your commits or PR messages.

Other hints: feel free to use community packages, you don't have to write everything yourself. Use the PHP ecosystem.

### Tasks

#### Task 1 - Add authentication 

Our API currently does not have any authentication defined.  Please protect the following routes with an auth scheme that requires a valid API key.

TODO: List routes, more explanation

#### Task 2 - Improve database performance

Currently none of the database tables have any indexes defined. 

* Identify and define any indexes
* Explain how you measured the performance improvements

TODO

#### Task 3 - Refactor controller

The controller method `App\Http\Controllers\Api\SomeController::someMethod()` has been put together by one of our developers in a hurry, but now it's time to refactor it into something more readable and maintable.

* Write a test that shows that the current controller works
* Refactor controller
* Create any methods and/or classes you deem necessary
* Improve any logic
* Refine the test (if necessary)

TODO

#### Task 4 - Transform output

Our controller methods currently return our api output via Model->toArray() and Collection->toArray(), but it's becoming a problem because every time we update our model properties we break what is expected from our API.  Also, we would like all our dates to be returned in UTC format.

* Change the methods in `SomeOtherController` to transform the output
* Ensure all dates are returned in UTC format

Note there are packages available that can help you with this, or you can roll your own solution.

#### Task 5 - Add images to this resource

TODO


#### Task 6 - Add a new endpoint which does X

TODO

#### Task 7 - Refactor pivot table into a regular model

#### Task 8 - Add not null constraint

The column in `tableX` currently permits null values.  Unfortunately, we already have 100 records, and our system is in production!

* Update the model(s)
* Update the database migration(s)
* Handle migration of existing data
* Update any data transformations for the resource

TODO
TODO: We need to fake a 100 records

#### Task 9 -  Identify the issue with this section of code

It looks like there's a problem in one of our endpoints. 

* Identify the issue
* Update the code

TODO

#### Task 10 - Document a controller

One of our customers has asked how to use the API for `some resource`, but we don't have any documentation :(

* We like the OpenAPI 3.0 spec (swagger)
* You can use another spec/format but if soplease explain the advantages.
* You only need to document the one controller.

#### Task 11 - Dockerize this application

We've been having some trouble reproducing some issues between staging and dev.  The developer of this application, has appropriately told support "Works for me", but we think there might be a better way:

* Dockerize this application
* Explain the benefits of using docker

TODO

## Installation

### Requirements

- PHP 7.0
- Postgresql or MySQL

### Configure

```bash
cp .env.example .env
```

Edit the `.env` file to update database credentials

### Install dependencies

```bash
composer install
```

### Run tests

```bash
composer tests
```

### Run application

```bash
php artisan serve
```

Application available from: `http://localhost/`

