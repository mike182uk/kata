# String Calculator

Create a string calculator with a single method that takes a string of numbers (separated by a delimiter) and returns an integer of the sum of all of the numbers in the string

## Requirements
  - Numbers delimited by a comma
  - Allow the method to handle an unknown amount of numbers
  - Allow the method to handle new lines between numbers (instead of delimiter)
  - Allow the method to support different delimiters - to change a delimiter, the beginning of the string will contain a separate line that looks like: `//[delimiter]\n[numbers…]` i.e `//;\n1;2` should return three where the default delimiter is `;`
  - Calling the method with a negative number will throw an exception
  - Numbers bigger than 1000 should be ignored
  - Delimiters can be of any length with the format: `//[delimiter]\n` i.e `//[***]\n1***2***3` should return 6
  - Allow multiple delimiters like `//[delim1][delim2]\n` i.e `//[*][%]\n1*2%3` should return 6.
  - Make sure you can also handle multiple delimiters with a length longer than one character
