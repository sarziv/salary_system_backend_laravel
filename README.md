#### In development
### Route
* Auth
* UnAuth
## Route /auth/*
* / - Welcome page 
* /signup - Create new user
* /login - Create access_token for user
* /register - Create a user
* /logout - Revoke access_token
## Auth Route /user/*
- Req: Access_token
* /Statistic -  Current month stats
* /records - User last 5 saves
* /add - Create a new record
* /search - Search user record [To[DATE] -> From[DATE]]

Backend: Laravel with passport API
