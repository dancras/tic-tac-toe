Over-engineered tic-tac-toe
---------------------------

Created for fun and out of curiousity.

A full description is available [on my blog](http://dancras.co.uk/2013/03/17/over-engineering-tic-tac-toe.html).


The Application
===============

A simple web application is (poorly) built on the over-engineered model. It uses [event sourcing](http://martinfowler.com/eaaDev/EventSourcing.html) to persist the game.

To run this on php 5.4+:

    cd app
    php -S localhost:8000


Known issues
============

 * The game notifies of a winner, but allows further moves to be played

 * The application code is shocking