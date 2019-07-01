#### Status
[![Build Status](https://travis-ci.org/sarziv/salary_system_backend_laravel.svg?branch=master)](https://travis-ci.org/sarziv/salary_system_backend_laravel) 
#### Routes
##### Public Route /auth/
* / - Welcome page 
* /signup - Create new user
* /login - Create access_token for user
* /register - Create a user
* /logout - Revoke access_token
***
##### Authenticated Route /user/
    ! Require: access_token
* /statistic -  Current month stats
* /records - User last 5 saves
* /add - Create a new record
* /search - Search user record [from[DATE] -> to[DATE]]
***
##### Public Utility Route
* /rate/all - Gets current rates
#### Make with
* Laravel 5.8 and Laravel passport
#### Front-end
front-end of the application can be found:
[here](https://github.com/sarziv/salary_system_front_react)
