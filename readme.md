# Conway's Game of life PHP implementation

This application is an example of php implementation of well known game using some Symfony 5.x components and PHP 7.4.x features.

I am using dependency injection, immutable value objects and producing readable and unit testable code.
The first version was written few years ago as a test and is still maintained in order to present my PHP skills.

## How to use

First, install dependencies and generate a new world into a xml file in order to create initial state.
Then run the data import that will draw the life on the screen and save the 
last frame into another xml file.

### Install dependencies

Install all necessarily dependencies by using command

``composer install``

### Generate your world

World generation is simple and is done by following console command:

``php app/console.php generate:world initialState.xml 50 10 15``

The first argument is a file that will describe the world and its occupants.
The other parameters are a number of organisms to life in the world, number of cells
of which the world consists and number of life cycles.

### Import and process the life

Then, you can start the life cycles:

``php app/console.php import:xml initialState.xml finalState.xml 2``

The cycle reads initial state from ``sourceFile.xml`` and executes the logic.
The last frame is saved into target file ``targetFile.xml`` in a format of source files
 so that they can be further processed as source files. The last argument is FPS for the writer.

## Contribute

[![Build Status](https://travis-ci.org/tuscanicz/livingworld.svg?branch=master)](https://travis-ci.org/tuscanicz/livingworld)

Feel free to contribute!

Please, run the tests via ``composer ci`` and keep the code quality.

Enjoy.
