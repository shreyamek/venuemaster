# VENUE MASTER SOURCE CODE
## Description
VenueMaster is an application that acts as a comprehensive and user-friendly concert venue website that efficiently manages and organizes data related to concerts. This includes handling details about concerts, ticket sales, and customer and artist information. Our database system is designed to improve the efficiency of data handling, to be able to grow with the user base, and to protect the important and private information of customers and artists.


## Instalation Guide
1. To install Venue Master and use the app first you have to download XAMPP. XAMPP is a software tool that uses your local machine to host the web server and MySQL database for our application.
2. Start MySQL Database and Apache Web Server
3. Use the Database Scehma and SQL create commands listed in the project documentation to create the database tables. (Make sure to call the project database venue_master_db)
4. Upload the source code files on the githib to the htdocs folder in the XAMPP file folder
5. To use the site go to either http://localhost/venuemaster/login.html or http://localhost/venuemaster/customer_registration.html to begin using Venue Master Application


## How To use
VenueMaster has two primary user groups: customers and artists, each with specific access levels and responsibilities.
Customers are users who browse the concert venue website to find concerts, artists, and purchase tickets. Customers have view access to most tables in the database and can add reviews on concerts and artists or purchase tickets for concerts.
Artists manage their concert details, such as show titles, track lists, date, and time. Artists have limited access to the database, focusing primarily on their own concert information.
