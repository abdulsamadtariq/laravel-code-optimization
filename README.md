# laravel-code-optimization
DRY( don't repeat yourself)

# Updated and new files for expected output

1. Readme described above (point X above) + refactored code 
OR
2. Readme described above (point X above) + refactored core + a unit test of the code that we have sent

I took 2nd approach for solving the code test. What I have done is here.

- I have added files into folder files as 
  - files_to_refactor -it contains 2 files named BookingController.php and BookingRepository.php. ( I have added comments and refactored code in same files)
  - files_for_test -it contains Helper class and Repositroy to perfom unit test on.
  - tests -it contains the tests that I have written to give understanding how possibiliy we can write test for diff. use cases. 


## Thoughts about the code
The initial code was somehow ok if it works as the famous Qoute is don't touch if it works(🥸). But still i have some suggestions to make it better to be maintained for long run.

- The project used repository design pattern for interacting with database. That's good. The repository is accessed directorly.It would have been better if we had defined an interface to specify all the methods which the repository must declare. This makes our code flexible because, should it become necessary to make a change in the future, the controller remains unaffected.

- The code contained some logical errors. Not sure was intentenal or not. I have made comments on respective areas inside of the code.

- The code didn't contains comments that's ok, but the naming convention of the variables and functions was missing some sort of clarity.

## Thoughts about the structure And Formating

- The structure in the code didn't followed a standard to be used on all the places. On some areas there are scope brackets ({}) are defined in a single line manner and some places ignored it totally.

- The proper spacing and line breaks were missing inside of the block of code.

- The standarded approach was not taken in defining functions as camel case or some other code standard so it should seem consistent.


I was not aware of bussiness logic behind the code . But overall it seems to be of hurry state of code. As for each major purpose there should be defined different controller . i.e . as the BookingController inside of files_to_refactor depicts it will be handling booking related but it has jobs fetching in same controller that makes it somehow terrible 🥲. But it still has more room for optimization to look more better 😎. 


Thanks for reading.


 
