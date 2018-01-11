# AltisLife Web Panel

ALWP is a sandbox web panel made to manage any AltisLife server. Merging strong backend using PHP and a simple bootstrap integration, ALWP is made to be 100% editable to match any of your ideas anytime, anywhere.

> **Note**  
> This panel is made for [AltisFrance](http://altisfrance.fr/) and all the features included in this panel are directly made for this server. Therefore it is not impossible that you will find some difficulties installing this panel of a different server and need to alter my code to use ALWP on your server. If you need any help regarding the installation feel free to contact me for assistance.  
> Oh ! And you'll probably see some french in there, sorry for that : )


----------

## Getting Started

To use this panel, choose one of the following options to get started:
* Download the [latest release on Github.](https://github.com/atouzard/ALWP-AltisLife-Web-Panel/releases/tag/v1)
* Fork this repository on GitHub.

## Install

First ! Include all files downloaded. Optional : You can `bower install` to update all dependencies for possible new content.

Then import the sql file `install.sql` into your server database. It will self alter and create all the tables, columns and stuff required by the panel.

You will now have to find `/class/config.php` and change this following code to match your database user

`define("DB_HOST", "localhost");`  
`define("DB_NAME", "altisfrance");`  
`define("DB_USER", 'root');`  
`define("DB_PASSWORD", 'root');`  

When ALWP is installed and your database informations are set you only need to go on your web server and log yourself using theses credentials :

**Login : admin**  
**Password : admin**  

## Cronjobs

Many of the features in this panel needs cronjobs to work, i'm talking about the backups, the donations and (if you want to use it) the taxes program. Here are the following cronjobs you want to set up. BTW you will need to generate a new hash to protect yourselves from possible ninjas trying to ruin your crons.

* `/crons/donators.php?hash=yourhash`
* `/crons/impots.php?hash=yourhash`
* `/dbBackup/dbDumpExe.php`

## Donations

Donations are self managed by homemade scripts, it mainly use Paypal IPN to verify transactions between donators and you. Basically you'll never have to manage donators, it's all working fine on itself but you will probably need to setup your credentials in the file `/includes/content-donate.php`

## Sponsorships

Basically self managing itself like donations but you'll need to setup your rewards here `/class/class.tools.php` in the function `algoAddSponsor`.

## Bugs and Issues

Have a bug or an issue with this panel ? Open a [new issue on GitHub](https://github.com/atouzard/ALWP-AltisLife-Web-Panel/issues) or leave me an email here : arthur@touzard.fr

## Creator

ALWP was created by and is maintained by **Arthur Touzard**, Admin of [AltisFrance](http://altisfrance.fr/).

* https://twitter.com/atouzard
* https://github.com/atouzard
* http://touzard.fr

ALWP is using [Bootstrap](http://getbootstrap.com/) framework created by [Mark Otto](https://twitter.com/mdo) and [Jacob Thorton](https://twitter.com/fat).  
Licenses work inspired by [Panel-AltisLife-GAMEWAVE](https://github.com/BloodMotion/Panel-AltisLife-GAMEWAVE).  

## Copyright and License

**Copyright 2015-2016 Arthur Touzard.**

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
