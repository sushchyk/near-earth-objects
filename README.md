## Back-end Test (PHP + Symfony)

### How to run project on your machine
Prerequisites: docker-compose and Make

To start project run following command in the project root folder: `make up`

API will be available on `http://localhost:8007`

To load data fixtures into database run following command: `make fixtures`

### What have been done and what have not been done yet
#### Done:
* project's Docker and Makefile setup
* API endpoints
* fixtures
* functional tests for API
#### Not done:
* pagination for `/neo/hazardous` endpoint
* documentation and sandbox for API (Swagger)
* console command that retrieves the list of Asteroids and saves it to database
* code style
* CI / CD 
* small improvements for code and tests (see TODOs in source code)

### Requirements 

This test requires:
* Working with PHP8.* and Symfony
* Mysql Database
* Use Symfony coding standards
* Nginx

#### Required Functionality

Implement a call to NASA API to retrieve the list of Asteroids based on their closest approach date to Earth (Near-Earth Objects - NEOs):
* Use api.nasa.gov. 
* API-KEY: N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD
* Documentation: https://api.nasa.gov/ and go to Browse APIs -> Asteroids - NeoWs
* Limit the query to the last 3 days.
* Persist the resulting list in your DB without duplicates.

Define the data model as follows:
* date
* reference (neo_reference_id)
* name
* speed (kilometers_per_hour)
* is hazardous (is_potentially_hazardous_asteroid)

Create the following routes in your application:

* GET /neo/hazardous
  * return all DB entries which contain potentially hazardous asteroids (with pagination)
  * response format: JSON

* GET /neo/fastest?hazardous=(true|false)
  * calculate and return the model of the fastest asteroid with a hazardous parameter, where true means is hazardous
  * default hazardous value is false
  * response format: JSON

* GET /neo/best-month?hazardous=(true|false)
  * calculate and return a calendar month in the current year with most asteroids  with a hazardous parameter, where true means is hazardous
  * default hazardous value is false
  * response format: JSON

Bonus points:
* Clean and straightforward code
* Use restful API best practices
* Create functional tests for API endpoints.
* Use Docker

Good luck!
