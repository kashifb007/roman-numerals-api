## Kashif Bhatti - Roman Numerals API Task

#### Assumptions
No user registration or authentication.
Used GET for all API endpoint tests, instead of a POST to persist a number into the DB.

#### Approach
Put converter logic into the Service file.
Set up Routes file and Controller file to interact with the DB and Collection. 
Validation logic to accept only 1 to 3999

#### Improvements?
Provide authentication.

#### Testing URLs.

1. Test a conversion
https://roman.preview1.co/api/convert/test/11
2. Store a conversion
https://roman.preview1.co/api/convert/123
3. List all stored conversions (10 per page)
https://roman.preview1.co/api/convert/list
4. List top 10
https://roman.preview1.co/api/convert/top


