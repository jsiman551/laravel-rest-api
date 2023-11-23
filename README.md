<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
## About Laravel

## What is this app about?

This is an app that was created as a real practice to create a REST API leveraging "LARAVEL PASSPORT" Feature.
This app uses Laravel Passport Feature to manage users authentications and protect authenticated Endpoints.
This is about the creating of users and activities, users are related to activities and are able to confirm if they are going to
those activies related to them.

## How to replicate locally

After cloning this repository, run migrations, and use the /register route to register a new user, and then /login to get the
access token that will let you run authenticated routes to create activities and even more users with more detailed data.

I recommend POSTMAN to manage and run all routes (endpoints).
