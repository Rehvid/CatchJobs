# CatchJobs

## Table of Contents

  - [General information](#general-information)
  - [Technologies Used](#technologies-used)
  - [How to use](#how-to-use)
  - [Features](#features)
  - [Project status](#project-status)

## General information

This application is used for posting jobs and applying to them as logged candidate.

## Technologies Used

* Laravel
* PHP Unit
* MySQL
* HTML
* CSS
* JavaScript
* Tailwind
* Flowbite
* Tagify

## How to use

* Clone the repository with git clone
* Copy .env.example file to .env and edit database credentials there
* Run composer install
* Run php artisan key:generate
* Run php artisan migrate --seed (it has some seeded data for your testing)
* That's it: launch the main URL
* If you want to login, click Login on top-right and use credentials **admin@admin - admin**
* Employer credentials are **employer@employer - employer**

## Features

List the ready features here:

* Company:
    * Create company with associated models like: socials, files, locations, industries, benefits.
    * Listing companies belongs to Employer.
    * Listing all companies for Administrator.
    * Remove images associated to company.
    * Update the company with associated models.
    * Destroy the company with associated models.
    * Updating status for the company by administrator
* Register as employer or candidate and login into app.
* Roles and Permissions
* Getting by fetch location, industries, or benefits and injecting them into blade.

To Do:
* Locations:
    * Listing locations belongs to Employer
    * CRUD methods for locations.
* Jobs:
    * CRUD methods for jobs.
    * Manage jobs by employer and administrator.
    * Apply for a job as Candidate.
    * Listing applied candidates by Employer and manage them.
    * Listing applied jobs for Candidate in back office.
    * Get notification before jobs announcement end.
* Candidate:
    * Improve profile, adds more information about him, and possible to upload CV/Certificates.
* Wishlist:
    * CRUD methods for wishlist
    * Add to wishlist employer or job.
    * Get notification on email after a new job is posted.
* Improve RWD for application.
* Improve blade views for application like: dashboard, index etc.

## Project status

Project is: in progress
