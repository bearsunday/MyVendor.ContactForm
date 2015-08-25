# MyVendor.ContactForm
Web form sample application

## How to test and run

```
git clone git@github.com:bearsunday/MyVendor.ContactForm.git
composer install
phpunit
php -S 127.0.0.1:8080 var/www/index.php
```

 * http://127.0.0.1:8080 for simple single form page.
 * http://127.0.0.1:8080/multi for multiple form page.

Form class test code is abailable at [tests/Form/ContactFormTest.php](https://github.com/bearsunday/MyVendor.ContactForm/blob/master/tests/Form/ContactFormTest.php).
