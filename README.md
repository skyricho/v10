# v10

## FRI 05 JUNE 2020
Person Lookup is inconsistant with rendering stretnumber suffixes. Sometimes 9A and sometimes 9A
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=9a+Woodbine+2093&state_id=5
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=17+Woodbine+2093&state_id=5

Solution: If streetNumber is numeric then check if second word length is more than 1. This is becuase in this case second word would be the street not a suffix.