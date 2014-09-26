###User Access Documentation

####Purpose
This document will explain how users are authenticated using the kiosk application, and how these sessions are managed throughout the time users are logged in. It will also explain the use of enabled/disabled, which is tied to each user account and how this ties into the session.

####Users Able to Be Logged In
The only users that are able to be "logged in" are:

1. Administrators (called "admin" in code)
2. Personnel Information Coordinators (called "editor" in code)
3. News Posting Coordinators (called "poster" in code)
4. Users that are Personnel Information Coordinators AND News Posting Coordinators

(Read more about [user groups](https://github.com/CIS4690-Fall2014/kiosk-php/blob/master/documentation/user-groups.md).)

####Authenticating
All users will login from one login page, `views/login.php`. Users submit their username and password, and will post to `controllers/controller_login.php`. This script will receive the input from the user and interact with `dao/dao.php` (data access script) to see if the user exists in the database, and if the password matches. If the login is successful, the user is redirected to `home.php`. If the login is not successful, the user is redirected back to `views/login.php`.

Upon valid credentials being entered and submitted, a session variable called `auth_id` will be created, which is directly linked to a user's id number in the database, which is unique. `home.php` and other pages will use this session variable to know who the user is when pages load.

####Where do users go when they are authenticated?
<strong>All users</strong> are redirected to `home.php`. This script acts as a controller for finding out who the user is, what type of user they are, if they are enabled or disabled, and finally displaying the view pertinent to that user. Every time a page is reloaded, the database is queried to find these things out. It's built this way to help simplify the arrangement of pages, and not confuse users to where they need to go. Instead of being confusing, all users simply go to `home.php`, where there is a default page for each user group.

Additionally, a `page` GET variable will be examined to see if a particular view is requested by the user. All pages the user will go to will be `home.php?page=requestedpage`, or simply `home.php` to get the default view. The home script will determine what view is requested, and will match it against a whitelist array of views that are available to the particular user type. If the requested `page` view is present in this array, that view is loaded. If it is not, each user group has a default as to not cause 404 errors if the view that was requested doesn't exist (or isn't authorized).

It should be noted that there are checks in place on these individual pages (within `views/` to ensure users don't try to access these pages <em>directly</em>.

####What does it mean to be enabled/disabled
In the `user` table of the database there is a field called `status`. Every user in the database will have a `status` of either `enabled` or `disabled`. This is another attribute that is loaded as a part of the `home.php` routine of querying the database and figuring out who the user is and what they nee.d If a user is `enabled`, the regular view can be loaded. However, if the user is `disabled`, the user will be temporarily logged in and shown a message that their account is currently `disabled`, and that they need to contact the System Administrator to re-enable their account if they need access. The page currently has a meta refresh, set to redirect the page to `logout.php` after 15 seconds (which effectively ends their session).

####How do users logout?
A user logs out by executing `logout.php`. This script simply destroys the current session and unsets `auth_id` session variable, then redirects the window to `index.php`. A user can easily return to `login.php` to re-establish a login session.
