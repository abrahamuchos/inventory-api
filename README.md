# Inventory API

This is an experimental API to manage inventory and stock. All this by managing your users (they must log in).

Rest API for managing items, repurchase, users and stock.


## ✅ Features

- Add item
- Update item
- Get items by filters
- Get item (by sku)
- Get stock and reorder status
- Add stock
- Reduce stock
- Register user
- Login user


## ⚙️ Tech Stack

- Laravel 11.9
- SqLite 
- Pest 2.0


## 💾 Installation

Install and run

1. Clone and move to folder
```bash
$ git clone git@github.com:abrahamuchos/inventory-api.git
$ cd inventory-api
```

2. Install dependecies
```bash
$  composer install
```

3. Create a copy of the `.env.example` file and rename it to `.env`. Next, configure the necessary environment variables.


4. Generate an application key by running `php artisan key:generate`.


5. Run `php artisan migrate` to create the database tables.


6. Run `php artisandb:seed` to create dummy data and admin user.


7. Run `php artisan serve` to start the Laravel development server.

## 🧪 Tests
To run all the tests

```bash
 $ php artisan test
```

To run a specific test
```bash
 $ php artisan test --filter test_name_example
```

## Usage/Examples

[Invoice API Collection - Postman](https://www.postman.com/abrahamuchos/workspace/public-projects/collection/6168326-0da64ad0-4488-42d8-bd8a-6b72b4e5023c?action=share&creator=6168326)

You can find a .json with the endpoints in `/docs/Inventory API.postman_collection.json`

## 🧑‍💻 Authors

- [@abrahamuchos](https://github.com/abrahamuchos)
- [Contact mail](mailto:j.abraham29@gmail.com)


## 📄 License

[MIT](https://choosealicense.com/licenses/mit/)
