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

- replace the contents of class `MovieRepository` with the following - all we need is a constructor since all the work is being done by methods we are inheriting from class `DatabaseTableRepository`:

    ```php
      namespace Mattsmithdev;
      
      use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;
      
      class MovieRepository extends DatabaseTableRepository
      {
          public function __construct()
          {
              parent::__construct(__NAMESPACE__, 'Movie', 'movie');
          }
      
      }    
    ```
    
    - Note, we could of could write out the namespace ecplicity in our constructor parent call:
    
        ```php
            parent::__construct('Mattsmithdev', 'Movie', 'movie');
        ```
        
    - we need to pass these values to the constructor, so that the methods in `DatabaseTableRepository` can use reflection on the `Movie` entity class to generate and execute appropriate `SQL` commands to communicate with the database tgable `movie`
   `
    
That's it - everything should work just as before, except that the details of the movies are now coming from the database rather than a har-coded array of objects in `MovieRepository`. Since `MovieRepository` inherits method `findAll()` from `DatabaseTableRepository` we don't need to change our controller methods in class `MainController` at all - so the following should work just as before:

```php
    class MainController
    {
            ... other methds          
        
          function listMovies()
          {
              $movieRepository = new \Mattsmithdev\MovieRepository();
              $movies = $movieRepository->findAll();
        
              $pageTitle = 'list';
              $listPageStyle = 'current_page';
              require_once __DIR__ . '/../templates/list.php';
          }
```