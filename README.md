# TeeBot - Golf Score Tracker

TeeBot is a web-based Golf Score Tracking application that allows users to log in, track their golf rounds, and manage scorecards efficiently. The application utilizes PHP, JavaScript, jQuery, MySQL, and TailwindCSS to provide a seamless user experience. This was a great project for me where I was using PHP for the very first time as well as utilizing XAMPP as my local web server.

## Screenshots
![Dashboard](/screenshots/dashboard.png)
![Scorecard](/screenshots/create_scorecard.png)
![Login](/screenshots/login.png)

## Features
- User Authentication: Sign up, log in, and manage user profiles.
- Golf Scorecard Management: Create, edit, and save golf scorecards for 18 holes.
- Database Persistence: All data is stored in a MySQL database for future retrieval.
- Responsive UI: Styled using TailwindCSS for a modern and mobile-friendly interface.

## Technologies Used

- **Frontend**:
  - HTML
  - CSS (TailwindCSS)
  - JavaScript
  - jQuery
- **Backend:**
  - PHP
  - MySQL (Database)
- **Software Requirements**:
  - XAMPP (for local development and database management)

## Installation & Setup

### Prerequisites

Make sure you have the following installed:

- [XAMPP](https://www.apachefriends.org/index.html) (to run Apache, PHP, and MySQL locally)
- A web browser (Google Chrome, Firefox, etc.)
- A text editor or IDE (VS Code, PHPStorm, etc.)

### Steps to Run Locally

1. Clone the Repository
```sh
git clone https://github.com/yourusername/TeeBot.git
cd TeeBot
```

2. Move the Project to XAMPP's htdocs Directory
```sh
mv TeeBot /xampp/htdocs/
``` 
3. Start XAMPP
- Open XAMPP Control Panel.
- Start Apache and MySQL services.

4. Create the Database
- Open phpMyAdmin (http://localhost/phpmyadmin/).
- Create a new database named teebot.
- Import the SQL file from /database/teebot.sql to set up the necessary tables.

5. Configure Database Connection
- Open includes/db.php.
- Update the following details if necessary:
```sh
$host = "localhost";
$dbname = "teebot";
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP
```

6. Run the Application

- Open your browser and go to:
```sh
http://localhost/TeeBot/public/login.php
```
- Create an account and start using TeeBot!

## Stretch Goals
- Impliment user profiles to be edited to add as well as track handicaps, birthdays, profile pictures, about me sections, age, and more.
- To make courses pre loaded so that you can see the length, teeboxes, pars, and hole yardage.
- Make it available to save only 9 if played and not having to have a full 18 be filled out in order to save.
- Show total scores and averages for rounds played.
- Be able to connect users and add their scores to your card if you played with them, while having it save to their profile as well.
- Add a GPS distance to see where you are on the hole.
- Make a "Whats in the Bag" section where you can add and show off your clubs as well as the distance hit with each club.
- A club selector tool that shows you what yardage you are from the hole and recommends to you a club to hit from your bag.
- Turn it into an App!

## Contributing

If you'd like to contribute, feel free to fork the repo and submit a pull request.

## License

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

This README provides a complete guide to setting up and running the project locally. Let me know if you need any modifications!

