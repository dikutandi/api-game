# Test API Game

Dillinger is a cloud-enabled, mobile-ready, offline-storage compatible,
AngularJS-powered HTML5 Markdown editor.

## Task

-   CRUD player/user
-   CRUD game
-   generate token
-   login atau play game dengan token dan langsung input score (boleh random)
-   list leaderboard 1 bulan dengan rangking per minggu

## Install

```sh
git clone git@github.com:dikutandi/api-game.git new_folder
cd new_folder
composer install
```

### Migration and Dummy Data

```sh
php artisan migrate --seed
```

Json For how to Akses API in

```sh
public/thunder-collection.json
```

Import to Postmane or VS-Code Extension Thunder Client

-   [Postman](https://www.postman.com/).
-   [VS-code Extension Thunder Client](https://www.thunderclient.io/).
