#reCaptcha FormIt Custom Validator


MODx FormIt validator for Google reCaptcha

- For the reCaptcha service see: https://www.google.com/recaptcha/intro/index.html
- For more information about MODx see: http://modx.com
- For more information about FormIt see: http://rtfm.modx.com/extras/revo/formit

##Installation

1. Go to https://www.google.com/recaptcha/ and create Site-key and Secret for your site
2. Create the snippet in MODX named reCaptcha with the contents of reCaptcha.php
3. Add the javascript to your ```<head>``` section
  ```
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  ```
4. Edit your FormIt call like below

  Add the custom validator
  ```
  [[!FormIt?
    &customValidators=`reCaptcha`
    &validate=`g-recaptcha-response:reCaptcha=^SECRET^`
  ...
  ]]
  ```

  And in your form add this field
  ```
  [[!+fi.error.g-recaptcha-response:notempty=`[[!+fi.error.g-recaptcha-response]]`]]
  <div class="g-recaptcha" data-sitekey="SITEKEY"></div>
  ```
5. Well, that's it...
