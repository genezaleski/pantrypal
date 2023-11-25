<a name="readme-top"></a>

[![Contributors][contributors-shield]][contributors-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/genezaleski/pantrypal">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center">PantryPal</h3>

  <p align="center">
    Recipe Recommendation Web App
    <br />
    <a href="https://github.com/genezaleski/pantrypal"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/genezaleski/pantrypal">View Demo</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

Senior Project 2019

This web application allows users to search for recipes from the spoonacular database.

The application can be used as an anonymous user, however to take advantage of all of the sites capabilities
the user must create an account.

Users can easily create an account using the Google OAuth service.

--- Usage ---

1.) Searching the database via the Navigation Bar (Nav Bar)
Users can search the spoonacular recipe database using the search bar located in the orange 
Nav Bar at the top of the screen. You can search by recipe name or by ingredients in a comment separated list.
The Nav Bar also includes a link to the homepage, and a user options tab
which includes links to the user's profile and inventory.

2.) Starting from the Home Page
The home page of the application is a great way to search for general recipes and find
something you want to make. You can post a new search via the Nav Bar as stated above,
or you can use our preset tabs for a more guided search.

3.) Browsing search results
After searching, you will see the recipe results page. The recipe results page automatically filters
by your allergies if you are logged in. You can filter your results by Vegetarian options,
or by Main Course/Appetizers. To use these filters, click the orange tab in the top left
of the screen with an arrow on it. This button will extend the search filters menu, which 
allows you to check off which filters you want to apply, and then submit them on the
click of the "Submit" button.

4.) Interacting with recipes
From the search page, if you click on a recipe link you will find yourself on an individual
recipe page. The recipe page will list a recipe's community rating, nutrition facts, 
ingredients, and the instructions on how to cook said recipe. If you are a registered user,
you can leave a like and comment on the recipe. In addition to these features, the recipe page
will also list recommended recipes for you to browse after viewing your initial recipe.

5.) Managing your inventory
To manage your user inventory, visit the inventory page accessible
from the user options drop down menu located in the Nav Bar. Once on the inventory page, 
you can easily add and remove ingredients you have in your pantry. To find ingredients based off
of your inventory items, click the button at the bottom of the page labeled, 
"Find recipes from my pantry"

6.) Managing your profile
To manage your profile, visit the profile page accessible
from the user options drop down menu located in the Nav Bar. From this page, you can
add and remove your allergies, view comments you have made, and view recipes you have 
liked. Finally, you can view recipes recommended for you based off your likes by clicking 
the "Reccommended" button at the bottom right of your screen.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Built With

* [![Spoonacular][Spoonacular.link]][Spoonacular-url]
* [![PHP][PHP.link]][PHP-url]
* [![Wampserver][Wampserver.link]][Wampserver-url]
* [![mySQL][mySQL.link]][mySQL-url]
* [![Postman][Postman.link]][Postman-url]


<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- GETTING STARTED -->
## Getting Started

To run this app, you must first subscribe to the <a href="https://spoonacular.com/food-api">Spoonacular API.</a>

This project utlized PHP for frontend and backend development.
Installation instructions can be found <a href="https://www.php.net/manual/en/install.php">here.</a>

To test frontend changes, we used Wampserver for development on windows. 
Installation instructions can be found <a href="https://www.wampserver.com/en/">here.</a>

To test backend changes, we used PHP to create an object relational manager to interface with a locally hosted mySQL instance. This iterface was tested in a standalone environment using Postman. 
Installation instructions for mySQL can be found <a href="https://dev.mysql.com/doc/mysql-installation-excerpt/5.7/en/">here.</a>
Installation instructions for Postman can be found <a href="https://www.postman.com/downloads/">here.</a>

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- USAGE EXAMPLES -->
## Usage

Please refer to the Design Document(PDF) at the top level of the repository for usage screenshots, general app outlines and flow diagrams. 

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- CONTACT -->
## Contact

Gene Zaleski - zaleskig8@students.rowan.edu.com

Project Link: [https://github.com/genezaleski/pantrypal](https://github.com/genezaleski/pantrypal)

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

Our senior project spring 2019 team put a lot of time and effort into the creation of this web app. 

Members include:

Jared Bauta
Eric DeAngelis
Nick Hutchinson
Bill Jacobs
David Liotta
Gene Zaleski

Instructor - Dr. Ganesh Baliga

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/genezaleski/pantrypal.svg?style=for-the-badge
[contributors-url]: https://github.com/genezaleski/pantrypal/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/genezaleski/pantrypal.svg?style=for-the-badge
[forks-url]: https://github.com/genezaleski/pantrypal/network/members
[stars-shield]: https://img.shields.io/github/stars/genezaleski/pantrypal.svg?style=for-the-badge
[stars-url]: https://github.com/genezaleski/pantrypal/stargazers
[issues-shield]: https://img.shields.io/github/issues/genezaleski/pantrypal.svg?style=for-the-badge
[issues-url]: https://github.com/genezaleski/pantrypal/issues
[license-shield]: https://img.shields.io/github/license/genezaleski/pantrypal.svg?style=for-the-badge
[license-url]: https://github.com/genezaleski/pantrypal/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/gene-zaleski-56b2a0175/
[product-screenshot]: images/screenshot.png

[Spoonacular.link]: https://img.shields.io/badge/Spoonacular-green
[Spoonacular-url]: https://spoonacular.com/food-api
[PHP.link]: https://img.shields.io/badge/PHP-purple
[PHP-url]: https://www.php.net/
[Wampserver.link]: https://img.shields.io/badge/Wampserver-pink
[Wampserver-url]: https://www.wampserver.com/en/
[mySQL.link]: https://img.shields.io/badge/mySQL-blue
[mySQL-url]: https://www.mysql.com/
[Postman.link]: https://img.shields.io/badge/Postman-orange
[Postman-url]: https://www.postman.com/