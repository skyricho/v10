# v10


## WED 31 MACH 2021
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

## FRI 05 JUNE 2020
Person Lookup is inconsistant with rendering stretnumber suffixes. Sometimes 9A and sometimes 9A
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=9a+Woodbine+2093&state_id=5
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=17+Woodbine+2093&state_id=5

Solution: If streetNumber is numeric then check if second word length is more than 1. This is becuase in this case second word would be the street not a suffix.