# v10

## SAT 20 FEB 2021
Add check icon next to unit blocks that have been completed
StreetNumber::cUnitBlockContacted
Houseing unit label now says 'All units contacted' or 'x units to contact'

## FRI 05 JUNE 2020
Person Lookup is inconsistant with rendering stretnumber suffixes. Sometimes 9A and sometimes 9A
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=9a+Woodbine+2093&state_id=5
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=17+Woodbine+2093&state_id=5

Solution: If streetNumber is numeric then check if second word length is more than 1. This is becuase in this case second word would be the street not a suffix.