# Modus Create PHP API Development Assignment
## Introduction
This is a short coding assignment, in which you will be asked to
implement an API in PHP that calls a "backend API" to get information
about crash test ratings for vehicles.
The underlying API that is to be used here is the [NHTSA NCAP 5 Star
Safety Ratings API](https://one.nhtsa.gov/webapi/Default.aspx?
SafetyRatings/API/5). This requires no sign up / authentication on
your part, and you are not required to study it. The exact calls that
you need to use are provided in this document.
## Ground Rules
* You must use [PHP](https://www.php.net/) (and state which version
you used -- you should use whatever the current LTS / Long Term Stable
version is at the time that you develop your solution)
* You may use any framework you like or no framework at all
* You may use any webserver (apache2, nginx, etc) you like
* You may use as many or as few [composer](https://getcomposer.org/)
packages as you like
* You must submit your solution by providing a link to a GitHub repo
containing a `README.md` file containing any documentation that you
deem suitable, and which is written in English
* We must be able to verify your submission by cloning your repo,
setting any required environment variables (documenting them in
`README.md` is a good idea), setting any webserver configuration
outside of the defaults (documenting this in `README.md` is a good
idea as well), then running `composer install`.
## Requirements to Implement
Your solution must provide an implementation for each of the following
requirements, and respond on the specified endpoints with the
specified JSON.
### Requirement 1
When the endpoint:
```
GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>
```
is requested, your PHP application should query the NHTSA API and use
the data received to respond with precisely the following JSON if
there are results:
```
{
 Count: <NUMBER OF RESULTS>,
 Results: [
 {
 Description: "<VEHICLE DESCRIPTION>",
 VehicleId: <VEHICLE ID>
 },
 {
 Description: "<VEHICLE DESCRIPTION>",
 VehicleId: <VEHICLE ID>
 },
 {
 Description: "<VEHICLE DESCRIPTION>",
 VehicleId: <VEHICLE ID>
 },
 {
 Description: "<VEHICLE DESCRIPTION>",
 VehicleId: <VEHICLE ID>
 }
 ]
}
```
or precisely this JSON if NHTSA's API returns no results:
```
{
 Count: 0,
 Results: []
}
```
Where:
* `<MODEL YEAR>`, `<MANUFACTURER>` and `<MODEL>` are variables that
are used when calling the NHTSA API. Example values for these are:
 * `<MODEL YEAR>`: 2015
 * `<MANUFACTURER>`: Audi
 * `<MODEL>`: A3
* `<NUMBER OF RESULTS>` is the number of records returned from the
NHTSA API and is an integer
* `<VEHICLE DESCRIPTION>` is the name of the vehicle model returned
from the NHTSA API and is a string
In order to get the data to generate your application's response, you
will need to call the following NHTSA API endpoint:
```
GET https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/<MODEL
YEAR>/make/>MANUFACTURER>/model/<MODEL>?format=json
```
Concrete example for the 2015 Audi A3:
```
GET
https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/2015/make/Aud
i/model/A3?format=json
```
Another set of valid values to test with is:
* `<MODEL YEAR>`: 2015
* `<MANUFACTURER>`: Toyota
* `<MODEL>`: Yaris
A set of test values that will cause NHTSA to have no results is:
* `<MODEL YEAR>`: 2013
* `<MANUFACTURER>`: Ford
* `<MODEL>`: Crown Victoria
Example output of the NHTSA API for the 2015 Audi A3 is:
```
{
 Count: 4,
 Message: "Results returned successfully",
 Results: [
 {
 VehicleDescription: "2015 Audi A3 4 DR AWD",
 VehicleId: 9403
 },
 {
 VehicleDescription: "2015 Audi A3 4 DR FWD",
 VehicleId: 9408
 },
 {
 VehicleDescription: "2015 Audi A3 C AWD",
 VehicleId: 9405
 },
 {
 VehicleDescription: "2015 Audi A3 C FWD",
 VehicleId: 9406
 }
 ]
}
```
Note that the JSON property names that NHTSA uses don't quite match
the ones in the required output that your application needs to
deliver, so pay attention to this. Also, not all of the output from
NHTSA is required in your application's output - you may need to
suppress some field(s).
### Requirement 2
Enhance your application so that it also responds on an additional
endpoint:
```
POST http://localhost:8080/vehicles
```
Which, when called with an application/JSON body as follows:
```
{
 "modelYear": 2015,
 "manufacturer": "Audi",
 "model": "A3"
}
```
should respond with exactly the same JSON as your existing endpoint
from Requirement 1 does.
### Requirement 3
When the endpoint:
```
GET http://localhost:8080/vehicles/<MODEL
YEAR>/<MANUFACTURER>/<MODEL>?withRating=true
```
is requested, your PHP application shoud make multiple queries to the
NHTSA API and return the same JSON specified in Requirements 1 and 2,
but with an additional field for each car model. The new field is
`CrashRating` and it will be a string field whose possible values are:
* `"Not Rated"`
* `"0"`
* `"1"`
* `"2"`
* `"3"`
* `"4"`
* `"5"`
So your example response JSON from this endpoint should look precisely
like this:
```
{
 Count: <NUMBER OF RESULTS>,
 Results: [
 {
 CrashRating: "<CRASH RATING>"
 Description: "<VEHICLE DESCRIPTION>",
 VehicleId: <VEHICLE ID>
 },...
 ]
}
```
As with the previous Requirements 1 and 2, you will need to make this
NHTSA API call to get some of the data required:
```
GET https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/<MODEL
YEAR>/make/>MANUFACTURER>/model/<MODEL>?format=json
```
For Requirement 3, you will need to use the value of `VehicleId` that
the NHTSA API returns to make a further API call to obtain the crash
rating data. If multiple vehicles match the initial query (e.g. there
are 4 variants of the 2015 Audi A3), then you will need to make a
subsequent NHTSA API call for each before you can respond with all of
the data.
Example: to get all the data required for the 2015 Audi A3, you first
call:
```
GET
https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/2015/make/Aud
i/model/A3?format=json
```
This will return 4 vehicle variants:
```
{
 Count: 4,
 Message: "Results returned successfully",
 Results: [
 {
 VehicleDescription: "2015 Audi A3 4 DR AWD",
 VehicleId: 9403
 },
 {
 VehicleDescription: "2015 Audi A3 4 DR FWD",
 VehicleId: 9408
 },
 {
 VehicleDescription: "2015 Audi A3 C AWD",
 VehicleId: 9405
 },
 {
 VehicleDescription: "2015 Audi A3 C FWD",
 VehicleId: 9406
 }
 ]
}
```
In order to obtain the crash rating for each of these, you need to
take each value of `VehicleId` from the above, and call the NHTSA API
endpoint to get ratings for that vehicle:
```
GET
https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/<VehicleId>?
format=json
```
Where `<VehicleId>` is one of the vehicle IDs from the initial API
response (so 9403, 9408, 9405, 9406 in the case of the 2015 Audi A3).
The response from NHTSA looks like this (vehicle has a rating -- you
need the value of `OverallRating`):
```
{
 Count: 1,
 Message: "Results returned successfully",
 Results: [
 {
 VehiclePicture:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/images/201
5/v09005P005.jpg",
 OverallRating: "5",
 OverallFrontCrashRating: "4",
 FrontCrashDriversideRating: "4",
 FrontCrashPassengersideRating: "5",
 FrontCrashPicture:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/images/201
5/v09005P087.jpg",
 FrontCrashVideo:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/movies/201
5/v09005C016.wmv",
 OverallSideCrashRating: "5",
 SideCrashDriversideRating: "5",
 SideCrashPassengersideRating: "5",
 SideCrashPassengersideNotes: "These ratings do not apply
to vehicles with optional torso/pelvis side air bags in the second
row.",
 SideCrashPicture:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/images/201
5/v09008P108.jpg",
 SideCrashVideo:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/movies/201
5/v09008C012.wmv",
 RolloverRating: "4",
 RolloverRating2: "Not Rated",
 RolloverPossibility: 0.109,
 RolloverPossibility2: 0,
 SidePoleCrashRating: "5",
 SidePolePicture:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/images/201
5/v09007P079.jpg",
 SidePoleVideo:
"http://www.safercar.gov/staticfiles/DOT/safercar/ncapmedia/movies/201
5/v09007C012.wmv",
 NHTSAForwardCollisionWarning: "Optional",
 NHTSALaneDepartureWarning: "Optional",
 ComplaintsCount: 20,
 RecallsCount: 3,
 InvestigationCount: 0,
 ModelYear: 2015,
 Make: "AUDI",
 Model: "A3",
 VehicleDescription: "2015 Audi A3 4 DR AWD",
 VehicleId: 9403
 }
 ]
}
```
Responses from NHTSA may also look like this in the case where the
vehicle was not tested, again you want to get the value of
`OverallRating`:
```
{
 Count: 1,
 Message: "Results returned successfully",
 Results: [
 {
 OverallRating: "Not Rated",
 OverallFrontCrashRating: "Not Rated",
 FrontCrashDriversideRating: "Not Rated",
 FrontCrashPassengersideRating: "Not Rated",
 OverallSideCrashRating: "Not Rated",
 SideCrashDriversideRating: "Not Rated",
 SideCrashPassengersideRating: "Not Rated",
 RolloverRating: "Not Rated",
 RolloverRating2: "Not Rated",
 RolloverPossibility: 0,
 RolloverPossibility2: 0,
 SidePoleCrashRating: "Not Rated",
 NHTSAForwardCollisionWarning: "Optional",
 NHTSALaneDepartureWarning: "Optional",
 ComplaintsCount: 22,
 RecallsCount: 3,
 InvestigationCount: 0,
 ModelYear: 2015,
 Make: "AUDI",
 Model: "A3",
 VehicleDescription: "2015 Audi A3 C FWD",
 VehicleId: 9406
 }
 ]
}
```
Here's an example response that your application should return for
Requirement 3 when testing with the 2015 Audi A3:
```
{
 Count: 4,
 Results: [
 {
 CrashRating: "5",
 Description: "2015 Audi A3 4 DR AWD",
 VehicleId: 9403
 },
 {
 CrashRating: "5",
 Description: "2015 Audi A3 4 DR FWD",
 VehicleId: 9408
 },
 {
 CrashRating: "Not Rated",
 Description: "2015 Audi A3 C AWD",
 VehicleId: 9405
 },
 {
 CrashRating: "Not Rated",
 Description: "2015 Audi A3 C FWD",
 VehicleId: 9406
 }
 ]
}
```
## How We Will Test Your Solution
We will perform the following tests on your submission, and suggest
that you do to prior to submitting your solution:
### Setup
Can we clone the GitHub repo, set any required environment variables,
set any webserver configuration, and load all external dependencies
using `composer install`?
### Requirement 1
Can we visit the following Requirement 1 URLs and get meaningful JSON
output from them:
* `GET http://localhost:8080/vehicles/2015/Audi/A3`
* `GET http://localhost:8080/vehicles/2015/Toyota/Yaris`
* `GET http://localhost:8080/vehicles/2015/Ford/Crown Victoria`
* `GET http://localhost:8080/vehicles/undefined/Ford/Fusion`
### Requirement 2
Can we visit the Requirement 2 URL when sending each of the following
JSON request bodies and get meaninful JSON output from each:
```
POST http://localhost:8080/vehicles
```
```
{
 "modelYear": 2015,
 "manufacturer": "Audi",
 "model": "A3"
}
```
```
{
 "modelYear": 2015,
 "manufacturer": "Toyota",
 "model": "Yaris"
}
```
Note - the JSON body below is erroneous, and should not crash your
application but should return an empty `Results` object and set
`Count` to `0` in your response.
```
{
 "manufacturer": "Honda",
 "model": "Accord"
}
```
### Requirement 3
Can we visit the following Requirement 2 URLs and get meaningful JSON
output from them:
* `GET http://localhost:8080/vehicles/<MODEL
YEAR>/<MANUFACTURER>/<MODEL>?withRating=true`
* `GET http://localhost:8080/vehicles/<MODEL
YEAR>/<MANUFACTURER>/<MODEL>?withRating=false` (should return the same
output as Requirement 1)
* `GET http://localhost:8080/vehicles/<MODEL
YEAR>/<MANUFACTURER>/<MODEL>?withRating=bananas` (should return the
same output as Requirement 1)
* `GET http://localhost:8080/vehicles/<MODEL
YEAR>/<MANUFACTURER>/<MODEL>` (should return the same output as
Requirement 1)
## Follow Up Actions
At any follow up phone / video interview, you should be prepared to
talk about:
* Your rationale for choosing or not choosing any composer packages
that you used, or thought about using and didn't
* Your rationale for choosing or not choosing the framework that you
used, or thought about using and didn't
* Your rationale for choosing or not choosing to use various features
available in PHP
* Which tools and debugging techniques you used in the development of
your solution
* How you would go about deploying your solution to a server
* How you would go about ensuring that deploying your solution to a
server 6 months from now would result in exact same code being
deployed as it would be today (including dependencies)
* How would you provide documentation to developers wanting to learn
and try out your new API
* How your implementation might scale to cope with high traffic load
* How your implementation might be secured so that only permitted
clients can call your API
* How your implementation might change if the NHTSA API were to
require an API key or Oauth flow
* Any other implementation specific details about your submission
## Frequently Asked Questions
**Question:** Does the order of JSON objects in my responses matter?
**Answer:** No
**Question:** Does the order of property names in my JSON responses
matter?
**Answer:** No
**Question:** Should my solution respond with error messages when
passed bad data?
**Answer:** No, but it should return an appropriate response object
with `Count` set to `0` and `Results` set to `[]`
