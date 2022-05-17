# MVC

Student course repo for the mvc course.

Course is available at:

* https://dbwebb.se/mvc

GitHub Pages for this repo are published at:

* https://github.com/eriknastesjo/mvc-report.git


# Garden Project

## Project idea

The idea behind this project is to make a simple garden-sale simulator. In the simulator the user can plant and grow different plants. There are different seeds to choose from and a watering can helps them grow. Too much water will destroy the plant. Then the user has to render the page again to start over.

Additionally there are customers with specific orders. If the plants in the garden match the order the plants will be "sold" to the customer and disappear from the garden. Finally the actions are logged in a database. That way the user can view the history of planted seeds and sold plants.

The garden and the customer are in different "rooms". The user must be able to travel between the rooms. Every time the user plants or waters something the page will process the request and reload.

There is no real goal of the garden-sale simulator except having fun, experimenting a bit and making some fake money.


## Implementation

The web page was created with the framework Symphony. It's a set of tools to help with navigation and rendering of routes on a web page. The language used in Symphony is PHP for navigation and TWIG for rendering.

Several objects have also been created in PHP to hold and manipulate key information, most importantly the garden object. Further more ORM (Object Relation Mapping) Doctrine has been used to store some information kept in the garden object. The transfer of information from the garden object to the database happens during certain events, more specifically when a user is planting a seed or selling a plant.

On the front end Javascript and CSS has been used to style the pages. Javascript has also been used to change form events when the user clicks on a seed or the watering can tool.


## Documentation

<a href="docs/api/index.html">PhpDoc</a>,
<a href="https://github.com/eriknastesjo/mvc-report.git">Git rep</a>,
<a href="https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/">Scrutinizer report</a>


[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/?branch=master)

[![Code Coverage](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/?branch=master)

[![Build Status](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/badges/build.png?b=master)](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/build-status/master)

[![Code Intelligence Status](https://scrutinizer-ci.com/g/eriknastesjo/mvc-report/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)


Copyright (c) 2022 Erik Nästesjö Todd

