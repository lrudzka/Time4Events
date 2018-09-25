# Time4Events
Events Manager - project using PHP and mySql database

## Project goal
The goal of this project is to learn and practice using PHP and mySQL database

## Description
The application is to be used to manage events. 

### The basic principles of the application

* events are to be added by a logged user
* a logged user can update or delete his own events - as long as they are still actual
* everyone can view the list of events - the actual events list or the archive events list
* both lists of events can be filtered - by keyword, by province, by city, by category and by dates
* everyone can add new user account to the database to be able to log in to the application and to use all of the functionality

## Technologies

The application was created using HTML5, PHP, mySQL database, CSS, Bootstrap framework.

Connections to the mySQL database are established by creating instances of the PDO base class.
Users' passwords are hashed, and the database is protected against sql injection.

## RWD

Page is fully responsive, there should be no troubles in accessing it on any device. 

## Installation

If you want to run/develop the code, you need to import event.sql file to your database, and copy all of the components.
