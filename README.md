# paragin-assignment

### Getting started

To get the project working execute the following steps:

 - clone this repository to your local machine
 - `composer install`
 
### Grading

To create an overview of student grades based on the provided test results execute:

`php bin/console grades`

### Question stats

To create an overview of question stats such as the pearson correlation or the p-value exucute:

`php bin/console question-stats`

You can query a particular question by executing:

`php bin/console question-stats <question number>`

Or you can create an overview of all questions by running:

`php bin/console question-stats -a`

### Unit test

There is one whole unit test that you can run by executing:

`./vendor/bin/phpunit`

### Choices made

First off thank you for allowing me to showcase my abilities with this assignment. There are 
couple of assumptions being made such as the ordering of the test results being consistent
throughout the application. But if I was to ensure this I think I would still be working on this 
for a day or so more while I'm only supposed to spend a couple of hours. The things I spent the most time
on were figuring out the maths and getting the application to work. It's the first time I put together a
stand alone console application using symfony. Usually I create projects with the full framework :^)

It was an interesting assignment for sure focusing quite a bit on the math side of things which 
has been a while ago for me. I had to study a couple of different resources to figure out how to tackle 
these problems among which of course wikipedia and using some plain old pencil and paper. I did also come 
across some libraries for statistic calculations but I felt it would be more cool to implement the formulae 
myself. In the future however I would choose to implement a tried and tested library to avoid introducing 
any errors on my part. Another idea I had was to make a comparison between my own implementation and the 
library but due to time constraints I decided against this.

I've tried to apply a good amount of separation of concerns in order to increase testability of the code
to make the code better extensible in the future. I haven't used any interfaces simply because of the 
simple nature of the program, but a couple of places where an interface could be used is the ResultGrader
in order to support different grading formulae that could easily be plugged in using the DI container.