# evote-movie-2019-11-database-movie-data


Part of the progressive Movie Voting website project at:
https://github.com/dr-matt-smith/evote-movie-2019

The project has been refactored as follows:

- run a MySQL compatible database server

- create a database schema named `evote`

- create a table `movie` with the following SQL:

    ```sql
      -- create the table
      create table if not exists movie (
          id integer primary key AUTO_INCREMENT,
          title text,
          price float
      );
      
      -- insert some data
      insert into movie values (1, 'jaws',9.99);
      insert into movie values (2, 'jaws2',4);
      insert into movie values (3, 'mama mia',9.99);
    ```

- use Composer to add the `pdo-crud-for-free-repositories` library to this project. At the command line type:

    ```bash
        composer require mattsmithdev/pdo-crud-for-free-repositories
    ```
    
- crete new folder `/config` and in that folder create a file `db.php` to declare 4 constants for the database:

    ```php
      define('DB_HOST', 'localhost:3306');
      define('DB_USER', 'root');
      define('DB_PASS', 'pass');
      define('DB_NAME', 'evote');
    ```
    
    - change the above to match your database port, usernamne and password
    
- add a `require_once` statement at the beginning of Front Controller `/public/index.php` to read in the configuration file that defines the 4 database constants:

    ```php
      <?php
      require_once __DIR__ . '/../config/db.php';
      require_once __DIR__ . '/../vendor/autoload.php';

      ...
    ```
