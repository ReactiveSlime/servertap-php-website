# servertap-php-website
A php wrapper that displays stats about your server and players using [servertap](https://servertap.io)
Here is what the page will look like with players online.


## Features
Quickly see server stats including TPS, Memory Usage, Uptime and weather
Display who is online
See  the location of each player
See their health and hunger
Console support
**
![Example photo with players online](https://raw.githubusercontent.com/ReactiveSlime/servertap-php-website/main/Screenshot%202023-04-05%20222711.png)
And here is what it looks like with no one online
![Example photo with no one online](https://raw.githubusercontent.com/ReactiveSlime/servertap-php-website/main/Screenshot%202023-04-05%20222815.png)
to get it working on your server you will need a webhost and to change the settings in settings.php
For console support the Password is done through a HTTP Header.
The format for the header is console:password-defined-in-settings.php
