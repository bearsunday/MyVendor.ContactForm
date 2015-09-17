# MyVendor.ContactForm

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ray-di/Ray.WebFormModule/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/ray-di/Ray.WebFormModule/?branch=1.x)
[![Code Coverage](https://scrutinizer-ci.com/g/ray-di/Ray.WebFormModule/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/ray-di/Ray.WebFormModule/?branch=1.x)
[![Build Status](https://travis-ci.org/bearsunday/MyVendor.ContactForm.svg?branch=master)](https://travis-ci.org/bearsunday/MyVendor.ContactForm)

Web form sample application

## How to test and run

```
git clone git@github.com:bearsunday/MyVendor.ContactForm.git
cd MyVendor.ContactForm
composer install
phpunit
php -S 127.0.0.1:8080 var/www/index.php
```

 * http://127.0.0.1:8080 for simple single form page.
 * http://127.0.0.1:8080/multi for multiple form page.
 * http://127.0.0.1:8080/loop for repeated input element form page.
 
Form class test code is abailable at [tests/Form/NameFormTest.php](https://github.com/bearsunday/MyVendor.ContactForm/blob/master/tests/Form/NameFormTest.php).
