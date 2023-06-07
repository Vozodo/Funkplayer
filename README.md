# Funkplayer
<p align="center">
<img src="view/img/Default_Logo.png" alt="Logo Funkplayer" width="200"/>
</p>
Funkplayer is a simple, fast web-based player for radio streams. Currently it only supports Icecast streams, but Shoutcast will be added.

# Requirements
- PHP >= 7.4
- Apache/Ngnix webserver

## PHP extensions
- curl
- gd
- mbstring
- bcmath

# Installation
0. Download Funkplayer.zip
1. Extract on the webserver
2. Go to the folder model
3. Rename sample-config.m.php to sonfig.m.php
4. Set your information

# Usage of the external API - WIP
With the External API you have the possibility to host coverarts on an external server and access them via PHP.
For this you have to place the folder "image_api/" on the target webserver and activate and configure the API in the "index.php".
You can find more information in the corresponding folder "image_api/".


# Acknowledgments
## Mp3StreamTitle
Oleg Kovalenko - Owner/Maintainer - KO-N

To get the metadata from the Icecast server, "Mp3StreamTitle" from @ko-n is used. The advantage: The metadata is taken from the header and therefore the "status-json.xsl" does not have to be active on the Icecast server.
https://github.com/ko-n/Mp3StreamTitle
