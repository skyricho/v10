# v10

##todo
script to get letter sent since x date
Save record as HTML
Use js to retrieve cell value i.e ```alert(document.getElementById("myTable").rows[0].cells[0].innerHTML);```
v1 get letter sent on page load. use ic-get 
v2 use ic-poll
v3 and ic-indicator

Use html export to to save assignee list. Use php to parse data and render to browser. See https://www.codeproject.com/Tips/1074174/Simple-Way-to-Convert-HTML-Table-Data-into-PHP-Arr]


## FRI 26 FEB 2021
Pat assigned address to publishers
I create links on main page using nav


## MON 22 FEB 2021
Memorial Campaign Jumbrotron and dynamic tabs


## SAT 20 FEB 2021
Add check icon next to unit blocks that have been completed
StreetNumber::cUnitBlockContacted
Houseing unit label now says 'All units contacted' or 'x units to contact'

## FRI 05 JUNE 2020
Person Lookup is inconsistant with rendering stretnumber suffixes. Sometimes 9A and sometimes 9A
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=9a+Woodbine+2093&state_id=5
https://personlookup.com.au/search?utf8=✓&search=true&page=1&country_id=1&q=17+Woodbine+2093&state_id=5

Solution: If streetNumber is numeric then check if second word length is more than 1. This is becuase in this case second word would be the street not a suffix.