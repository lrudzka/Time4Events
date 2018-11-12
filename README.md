# Time4Events
Events Manager - project using PHP and mySql database

## Project goal
The goal of this project is to learn and practice using PHP and mySQL database

## Description
The application is to be used to manage events. 

### Modules of the application

**_1. MAIN MODULES_**

* **Main Page** with: 
  - list of the closest events
  - list of the last added events
  - searching menu - directing the user to the list of events

* **List of events** with:
  - searching menu
  - filter information
  - list of events according to the filter used by the user, all the events with the option:
    - _details_ - opening the _Single Event_ module for the selected event
    - _report_ - reporting abuse about the selected event by sending email to all the users with admin option, with all the necessary information: the user reporting    (the user must be logged to the application), the name of the event, the link to the event

    List of events can be watched in two option:
    - actual and incoming events
    - archive events

* **Single event**
  - opened by the _details_ button in the _List of events_ module, showing all the information about the event

* **Rules** 


**_2. USER MODULES_**

   _2.1. Available for the unlogged user_:

* **Register**

* **Login** with:
  - link to the _Register_ module
  - _password recovery_ option - opening the _Password recovery_ module
  - login function

* **Password recovery**
opened by the _password recovery_ button in the _Login_ module, allowing the user to recover the password after entering the e-mail address registered to the application; the module starts the recovery password procedure - if the entered e-mail address exists in the database the password is being changed for the new string with the random numbers and letters, and new password is being sent to the entered e-mail address

   _2.2. Available after login to the application_:

* **User Panel** with:
  - menu to all user modules
  - information about the user events and about the user blocked events

* **Add event**

* **Manage your events** with
  - searching menu
  - filter information
  - list of user's events according to the filter userd by the user - all the events with options:
    - _details_ - opening the _Single Event_ module for the selected event
    - _update_ - opening the _Update Event_ module for the selected event
    - _delete_ - opening the _Single Event_ module for the selected event with the _delete_ option at the top of the page

* **Update event**
opened by the _update_ button in the _Manage your events_ module, allowing to make changes to the selected event

* **User's data change** with:
  - changing e-mail address
  - changing password


3. **_ADMIN MODULES_** - available to all the users with the admin option

* **List of users** with:
  - quick search input - by the user's login
  - filter restricing the list of users, according to the following options:
    - all the users
    - users with the admin option
    - users with the blocked events
    - blocked users
  - list of users with the following information:
    - login
    - registration date
    - number of events
    - number of blocked events
    - admin privilege button - for the users with the admin option: _delete admin privilege_; for the users without the admin option and without blocked events: _add admin privilege_
    - block / delele the user button - for the user with some blocked events: _block the user_, for the user with 0 events: _delete the user_

* **List of categories** with:
  - list of categories with the following information:
    - name of the category
    - order id
    - number of events
    - delete button - for the categories with 0 events
  - add new category option
  - change category's order id option

* **List of blocked events**
  - searching menu
    - filter information
    - list of blocked events according to the filter used by the user, all the events with the option:
      - _details_ - opening the _Single Event_ module for the selected event

* **Single event with admin options**
  - opened by the _details_ button in the _List of events_ module or in the _List of blocked events_ module, showing all the information about the event with blocking/unbloking option


**_NAVIGATING THE APPLICATON_**

The user can easily navigate the applicaton - all the modules have in the bottom links to the _main page_, to the _user panel_, and to the _admin panel_ - for the users with admin option. There is also menu in the header: with main links - to the main modules, and with user links - to the user's module.


## Technologies

The application was created using HTML5, PHP, mySQL database, CSS, Bootstrap framework.

The application uses Google reCAPTCHA Component for protecting the application against bots.

Connections to the mySQL database are established by creating instances of the PDO base class.

Users' passwords are hashed, and the database is protected against sql injection.

The application uses PHPMailer for sending e-mail - for the recovery password procedure, for the abuse reporting procedure, and for the information to the user about blocking his event.

## RWD

Page is fully responsive, there should be no troubles in accessing it on any device. 

## Installation

If you want to run/develop the code, you need to import event.sql file to your database, and copy all of the components.
