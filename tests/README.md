Important things to note about testing
=====================
Tests should only be run on a test system, never a live one.

They have been created to help developers test and improve not only TastyIgniter but also extensions too.

Requirements:
=====================
* Git
* Codeception
* A bit of command line knowledge
* Selenium Web Server (optional)

In other to begin testing `run: wget http://codeception.com/codecept.phar` from tests folder to download and save the phar archive.


Selenium installation instructions
=====================
Running Acceptance (Functional) Tests with Selenium requires a standalone selenium server on your machine. 

The Selenium server can be downloaded from [here](http://docs.seleniumhq.org/download/). 

Before starting your Selenium Tests you have to run the standalone server: java -jar selenium-server-standalone-2.32.0.jar 

*Writing Acceptance (Functional) Tests requires you to extend the TastyIgniterTestCase class.

`run: php codecept.phar run acceptance -g main` from tests folder to run main group tests

OR

`run: php codecept.phar run acceptance -g admin` from tests folder to run admin group tests

Must READ
=====================
The tests are still under development, there are hundreds of them to do.

The tests will drop and recreate tables in database specified in tests/codeception.dist.yml

