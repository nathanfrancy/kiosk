#Run Kiosk Locally

This document explains everything, step by step, in how to get this application running locally in order to test and perform maintenance. Follow these steps and contact [Nathan Francy](mailto:nathanfrancy@gmail.com) if there are problems with this. This document has been broken down into "Prepare your system" and "Install kiosk" sections.



##Prepare Your System

Your system will need each of these things: Apache HTTP Server, MySQL Server and phpmyadmin, and PHP. As there are several systems to consider (Windows, Mac, Linux), you'll just need to Google how to install these onto your system, depending on what it is. 

If you are on Windows, the project is most easily set up using apachefriends' [xampp stack](https://www.apachefriends.org/index.html) which will install apache, mysql, php, and perl. We used xampp to deploy in production, so it should be very easy to download, install and run. It will open a Xampp Control Panel when installed, and you should easily be able to run apache, mysql and php.

##Test User Accounts

These are test user accounts that matchup with the [user groups](https://github.com/CIS4690-Fall2014/kiosk/blob/master/documentation/user-groups.md) defined for the project. You should be able to login with these usernames once the project is installed on your system (via `localhost/kiosk/login.php`).

1. <strong>Administrator: </strong>`johndoe`, password: `password`
2. <strong>Editor: </strong>`joedoe`, password: `password`
3. <strong>Poster: </strong>`marydoe`, password: `password`
4. <strong>Editor/Poster: </strong>`kevindoe`, password: `password`

These aren't meant for a production deploy, so be sure these logins aren't present if you are deploying into production.

##Install Kiosk

1. [Download the project from GitHub](https://github.com/CIS4690-Fall2014/kiosk). There are a couple ways to do this: 
    1. Clone the project using git. This is preferred, since the history of the project since day 1 is logged in the repository on GitHub, and if there are changes to the project this way is easiest to see when it last changed. If you don't have git or github, get a username on [GitHub](https://github.com), and download the GitHub application for your OS (there is Windows and Mac version). Contact [Nathan Francy](mailto:nathanfrancy@gmail.com) in order to be made an administrator for the repository. Being made an administrator will give you the ability to commit new changes if need be to the project.
    2. Alternatively, click "Download ZIP" on the [project page](https://github.com/CIS4690-Fall2014/kiosk) and extract the folder into your webroot in your apache installation. This would normally be your "htdocs", "public_html", or wherever apache is pointed to serve files. Keep in mind, if you use this method and make changes to push into production, and do not push the changes back to the repository, the next time someone tries to access the site on GitHub it will be outdated and might cause issues in overlapping.
2. Initialize the test database. If you followed the "Prepare your system" section above, you should have mysql and phpmyadmin installed. Access localhost/phpmyadmin (or wherever you access mysql), and create a database `ucmo_kiosk`. Enter this database by clicking on it, and open the `SQL` tab. The test database files are in the project under `assets/db`, and you should select the latest version, which will have the latest number (we are are `rev20.sql` at the time I'm writing this). Copy all (`ctrl + a` or `cmd + a`) from the file into the text box on the `SQL` tab page, and click Submit. This will add all necessary tables and some test data to initialize with. It's important to note that if you make changes to the actual structure of the database, please perform an export of the database and create a latest version `.sql` file in this folder, for others to use later on.
3. Make sure the connection will work. Before trying to access the site, make sure it will connect to the database. Do this by going into the `dao/` folder and opening `connection.ini`. Be sure the host, username, password and database name are correct for your installation of mysql. Next, go to `dao/dao.php` and in the `connect_db` method, the first line will be `$prod`. Be sure this is set to `false` in order to tell this function to use local variables and connect to the local database you are specifying in the `connection.ini` file.
4. Try to access the site. Go to [localhost/kiosk](http://localhost/kiosk) (or wherever you have it installed), and see if you can use the front end of the site and pull information, and use regularly (good news if it is!). Next, go to `localhost/kiosk/login.php` and use the login information to try to login to one of the test user accounts that has been initialized for the project. It should work if everything above has been done, but we have run into things such as permissions (chmod 775 all of the project files in the webroot). Observe the console and error log in Google Chrome or Firefox in order to see any other issues that might occur.

##Other Documentation for Maintenance

The majority of our project was build using [PHP](http://php.net) and JavaScript (lots of [jQuery](http://jquery.com)). We also implement the front-end framework [bootstrap](http://getbootstrap.com). Please refer to their documentation for specific questions with these languages. We've tried to outline what our code is trying to do in comments, but realize we probably didn't outline it in enough detail to explain exactly what's going on.