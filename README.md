autoflow
========
[![Build Status](http://david-coombes.com:8080/jenkins/buildStatus/icon?job=Autoflow-v1.0)](http://david-coombes.com:8080/jenkins/job/Autoflow-v1.0/)

Allows user's to login to social networks, such as Facebook, Google, Dropbox or Github by default.

This plugin uses the [API Connection Manager](https://github.com/api-connection-manager/api-connection-manager) plugin
to manage connections. This means that multiple services can be available for login.

The plugin will add the login buttons to the registered wordpress login page, but a shortcode is also provided:
```
[AutoFlow]
```