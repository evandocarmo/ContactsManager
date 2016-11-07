# ContactsManager

ContactsManager is a web utility to manage your contacts (duh?) with **Google Maps API** integration. It is based on the **PHP** framework **CodeIgniter** v2.1.3 and the client-side library **jQuery**. The data is stored in a **MySQL** database.

## Features:
- Create, edit and delete contacts;
- Statistics page with general details;
- Heatmap and Google Maps pins on Geolocated contacts;
- Filters with detailed information;
- Field service schedule and list manager;
- Reserved contatcs information;
- Status and Category taxonomy interface;
- Automated backup system;
- Mobile and responsive interfaces;
- PDF print of single contacts and contact list;

## Dependencies and Quickstart

As this utility is requested by people with different background levels of tech knowledge, follows an detailed explanation on how to install it:

### Composer

Some extra functionalitis of this utility depends on third party applications. Such as **PDF** and **XLS** generation, link compression and **QR** code. To manage this extra features a dependency injection tool called [Composer](https://getcomposer.org/) is required.

```bash
composer update
```

* [Snappy](https://github.com/KnpLabs/snappy)
* [FPDI](https://github.com/Setasign/FPDI)
* [FPDI-FPDF](https://github.com/Setasign/FPDI-FPDF)
* [PHPExcel](https://github.com/PHPOffice/PHPExcel)
* [Bitly](https://github.com/gabrielkaputa/bitly)
* [CodeIgniter-PHP-QR-Code](https://github.com/elvisoliveira/strptime-php)
* [strptime-php](https://github.com/elvisoliveira/CodeIgniter-PHP-QR-Code)

After installing [Composer](https://getcomposer.org/) and executing the command **update** on the command-line interface, [Composer](https://getcomposer.org/) will install the packages above.

### Node.js

In order to make available the client side package manager [Bower](ttps://bower.io/) and the task runner [Grunt](http://gruntjs.com/) it is required to install [Node.js](https://nodejs.org/).
```bash
npm update
```

* [Slideout.js](https://github.com/Mango/slideout)
* [jQuery Validation](https://github.com/jzaefferer/jquery-validation)
* [jQuery Mask Plugin](https://github.com/igorescobar/jQuery-Mask-Plugin)
* [Geocomplete](https://github.com/ubilabs/geocomplete)
* [Bootstrap Colorpicker 2](https://github.com/itsjavi/bootstrap-colorpicker)
* [Font Awesome](https://github.com/FortAwesome/Font-Awesome)

After installing [Node.js](https://nodejs.org/) and executing the command **update** on the command-line interface, the packages above will be installed.


### Bower
see [Google Developers](https://developers.google.com/maps/premium/usage-limits#maps-javascript-api-services-client-side)

> Shared daily free quota of 100,000 requests per 24 hours; additional requests applied against the annual purchase of Maps APIs Credits. Maximum of 23 waypoints per request. Rate limit applied per user session, regardless of how many users share the same project.

Due to the authentication layer and use limitations on **Google Maps API**, it is not possible to use it on a shared IP server.

As the integration with **Google Maps API** is required to be on the client side, a package manager called [Bower](ttps://bower.io/) is required to make it easier to be up-to-date with the changes on the **Google Maps API** javascript library [Geocomplete](https://github.com/ubilabs/geocomplete). Althout this is the main reason, other browser dependencies are also managed by this application.

```bash
bower update
```

* [Slideout.js](https://github.com/Mango/slideout)
* [jQuery Validation](https://github.com/jzaefferer/jquery-validation)
* [jQuery Mask Plugin](https://github.com/igorescobar/jQuery-Mask-Plugin)
* [Geocomplete](https://github.com/ubilabs/geocomplete)
* [Bootstrap Colorpicker 2](https://github.com/itsjavi/bootstrap-colorpicker)
* [Font Awesome](https://github.com/FortAwesome/Font-Awesome)

After executing the command **update**, [Bower](ttps://bower.io/) will install the packages above.

### Grunt

The task runner [Grunt](http://gruntjs.com/) is required to convert all the scripts and styles generated from the [Bower](ttps://bower.io/) package manager to the project assets directory.

```bash
grunt
```

## Database

The sctucture of the database ca be imported using the **BASIC.sql** file, located at **assets/database/** folder. Due to the usual updates, more **.sql** files are added in the same folder, to have the most updated version of the utility, import them as well, following the date order on the file names.

## Last Words

This is a MIT licensed project. Have fun. **:)**