# wp-strong-password
Prevent user from using weak password from WP_CLI and WordPress backend.

## Installing

- Clone this plugin in your plugins directory.
- Execute `composer install` in plugin (wp-strong-password) directory.
- Activate plugin from backend or using WP-CLI.

## Development tools

- https://github.com/bjeavons/zxcvbn-php
- WordPress password strength meter

## Screenshots

Creating new user with weak password

![image](https://user-images.githubusercontent.com/26354653/85937263-884b9180-b91f-11ea-93cf-bd5224035c80.png)

Updating weak password from CLI

`wp user update 2 --user_pass=hello`
![image](https://user-images.githubusercontent.com/26354653/85936814-baf38b00-b91b-11ea-9ec1-f1c45943cc04.png)

Updating weak password from backend

![image](https://user-images.githubusercontent.com/26354653/85936878-5ab11900-b91c-11ea-8d9c-4f38a902149c.png)
