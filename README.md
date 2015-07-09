#Kata

[![Build Status](https://img.shields.io/travis/mike182uk/kata.svg?style=flat-square)](http://travis-ci.org/mike182uk/kata)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/mike182uk/kata.svg?style=flat-square)](https://scrutinizer-ci.com/g/mike182uk/kata/)
[![License](https://img.shields.io/github/license/mike182uk/kata.svg?style=flat-square)](https://github.com/mike182uk/kata)

##Prerequisites

1. PHP >=5.5.0

##Installation

```bash
wget https://github.com/mike182uk/kata/raw/master/bin/kata.phar # Download the phar
chmod +x kata.phar # Make the phar executeable
mv kata.phar /usr/local/bin/kata # Move the phar to your bin directory (optional)
```

##Usage

###Create a new kata workspace

```bash
kata create:workspace [-k|--kata <kata>] [-l|--language <language>] <path>
```

To undertake the **Fizz Buzz** kata in **PHP**:

```bash
kata create:workspace -k fizz_buzz -l php ./fizz_buzz_kata
```

`kata` and `language` are both optional parameters - If you do not pass a `kata` or `language` parameter, one will be selected at random.

Once the kata workspace has been created, the package manager for the selected language will be run automatically. To prevent this you can use the `--no-deps` parameter:

```bash
kata create:workspace -k fizz_buzz -l php ./fizz_buzz_kata --no-deps
```

###List available katas

```bash
kata list:katas
```

###List available languages

```bash
kata list:languages
```
