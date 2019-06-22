#### In development
### Route
* Public
* Authenticated
#### Route /auth/*
* / - Welcome page 
* /signup - Create new user
* /login - Create access_token for user
* /register - Create a user
* /logout - Revoke access_token
#### Authenticated Route /user/*
##### Require: Access_token
* /statistic -  Current month stats
* /records - User last 5 saves
* /add - Create a new record
* /search - Search user record [from[DATE] -> to[DATE]]

Backend: Laravel with passport API
