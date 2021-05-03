# v10

## TODO
Hide "letter sent" text in MAy.

## SAT 24 APR 201
* Fix hand map in function
* Hide "Still to call" on phone map info. Moved map to below street list.

### Poll Report
Add ''''verify' => false''' to guzzle parameters. See https://docs.guzzlephp.org/en/stable/request-options.html
or ```'verify' => 'cacert.pem', // or false``` Cert download https://curl.se/ca/cacert.pem

## THU 15 APR 2021
Add map below progess bar on street list.

## SUN 10 APR 2021
Add fields to MapStreet table: houses to contact, units to contact and houses + units to contact
Checkbox next to Housing unit blocks to standardise list and make it eaiser to scan
List of units is now a seperate view 'unlitList.twig'
Admin script createMapLocalitiesList.php saves map localities to json file map-localities.json
List of streets view now pulls locality from json file
Add 'Hand map in' form to dropdown menu
Progress bar: Use addressTotal from Maps table to determine progress percentage

## SAT 09 APR 2021
Add check icon next to unit blocks that have been completed
StreetNumber::cUnitBlockContacted
Houseing unit label now says 'All units contacted' or 'x units to contact'
Unit status changed from 'ah' to icon + 'letter sent'

### New brach: letter-writing
Use phone view to display list of streets and add progress bar


## WED 31 MACH 2021
### Fix admin actions


### Speed up database query
Revert to Master (last cahnge SEP 2020)
The branch 'Assignee-list' is buggy. The php code does not run the script to save the map list to json.
Add code to time database query

Create map-list-experiment branch
https://thisinterestsme.com/php-get-query-execution-time/
Find Assigned maps: Query takes 19 seconds, 15 seconds, 8 seconds, 8 seconds, 8 seconds
FindAll: Query takes 17 seconds, 17 seconds, 17 seconds, 
Create new layout 'Map Lite' with only 6 fields. 
Find Assigned maps: Query takes 0.1 seconds
FindAll: Query takes 0.4 seconds
index now uses Filemaker 'Map Lite' layout
Google PageSpeed report: 96



## FRI 05 JUNE 2020
Person Lookup is inconsistant with rendering stretnumber suffixes. Sometimes 9A and sometimes 9A
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=9a+Woodbine+2093&state_id=5
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=17+Woodbine+2093&state_id=5

Solution: If streetNumber is numeric then check if second word length is more than 1. This is becuase in this case second word would be the street not a suffix.