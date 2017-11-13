# WE-CRM

This is a reference project elaborated by the students step-by-step in every FHNW web engineering lecture.

- [Analysis](#analysis)
    - [Scenario](#scenario)
    - [Use Case](#use-case)
    - [Constraints](#constraints)
- [Design](#design)
    - [Solution Strategy](#solution-strategy)
    - [Wireframe](#wireframe)
    - [Entity Relationship Diagram](#entity-relationship-diagram)
    - [Domain Model](#domain-model)
    - [Data Access Model](#data-access-model)
    - [Business Logic Model](#business-logic-model)
- [Implementation](#implementation)
    - [Stage 1: Building a Static Website with Bootstrap](#stage-1-building-a-static-website-with-bootstrap)
    - [Stage 2: PHP Files, Basic Router and Session](#stage-2-php-files-basic-router-and-session)
        - [.htaccess](#htaccess)
        - [Procedural Router](#procedural-router)
        - [Session](#session)
    - [Stage 3: Database, .env Config Files and Passwords](#stage-3-database-env-config-files-and-passwords)
        - [Database](#database)
        - [.env Config Files](#env-config-files)
        - [PDO](#pdo)
    - [Passwords](#passwords)
    - [Stage 4: Dynamic Views](#stage-4-dynamic-views)
    - [Stage 5: namespace/use, Auto-Loading and Class Oriented Router](#stage-5-namespaceuse-auto-loading-and-class-oriented-router)
        - [namespace/use and Auto-Loading](#namespaceuse-and-auto-loading)
        - [Class Oriented Router](#class-oriented-router)
    - [Stage 6: Database, Config Classes, Exception Handling and HTTP Status](#stage-6-database-config-classes-exception-handling-and-http-status)
        - [Exception Handling and HTTP Status](#exception-handling-and-http-status)
    - [Stage 7: Domain and Data Access Objects (DAO)](#stage-7-domain-and-data-access-objects-dao)
        - [Domain Objects](#domain-objects)
        - [Data Access Objects (DAO)](#data-access-objects-dao)
    - [Stage 8: Business Services](#stage-8-business-services)
    - [Stage 9: Template View Pattern and XSS](#stage-9-template-view-pattern-and-xss)
        - [Template View Pattern](#template-view-pattern)
        - [XSS](#xss)
    - [Stage 10: Model-View-Controller](#stage-10-model-view-controller)
    - [Stage 11: Validation](#stage-11-validation)
    - [Stage 12: Auth and Remember Me](#stage-12-auth-and-remember-me)
    - [Stage 13: Email and Password Reset](#stage-13-email-and-password-reset)
    - [Stage 14: PDF](#stage-14-pdf)
    - [Stage 15: REST Service API](#stage-15-rest-service-api)
    - [Stage 16: JavaScript & jQuery Client](#stage-16-javascript-jquery-client)
- [Evaluation and Deployment](#evaluation-and-deployment)
    - [Project Set-Up](#project-set-up)
        - [Visual Paradigm](#visual-paradigm)
            - [Default Parameter Direction Configuration](#default-parameter-direction-configuration)
            - [Postgresql Database Generation](#postgresql-database-generation)
        - [Git](#git)
    - [Heroku Deployment](#heroku-deployment)
- [Maintainer](#maintainer)
- [License](#license)

## Analysis

### Scenario
WE-CRM (Web Engineering Customer-Relationship-Management) is the smallest possible and lightweight demonstration tool that allows agents to manage their customer data. Agents have an own access to their customer data. Besides, agents can email themselves an complete extract or create a PDF of their customers.

### Use Case

![](modelling/images/WE-CRM-Use-Case.png)

- UC-1 [Login on WE-CRM]: Agents can log-in by entering an email address and password. As an extension, new agents my register first.
- UC-2 [Register on WE-CRM]: Agents can register to get an account (profile) to access the WE-CRM system.
- UC-3 [Edit a customer]: Agents can create, update and delete customers.
- UC-4 [Show a customer list]: Agents can get an overview over their customers based on a customer list. As an extension they can create, update and delete customers (UC-3), generate a PDF (UC-5) or send an email (UC-6).
- UC-5 [Generate a PDF customer list]: Agents can generate a PDF containing a list of their customers.
- UC-6 [Send customer list via email]: Agents can send an email containing a list of their customers to their own inbox.

### Constraints

TODO: write

## Design

### Solution Strategy

TODO: write

### Wireframe

![](modelling/images/WE-CRM-Wireframe%20-%20Log-In.png)
![](modelling/images/WE-CRM-Wireframe%20-%20Customers.png)
![](modelling/images/WE-CRM-Wireframe%20-%20Edit.png)

### Entity Relationship Diagram

![](modelling/images/WE-CRM-ERD.png)

### Domain Model

![](modelling/images/WE-CRM-Domain-Model.png)

### Data Access Model

![](modelling/images/WE-CRM-Data-Access.png)

### Business Logic Model

![](modelling/images/WE-CRM-Business-Logic.png)

## Implementation

### Stage 1: Building a Static Website with Bootstrap

In stage 01 a bootstrap based prototype has been created by using a prototyping application. 

In this case, the prototype application Bootstrap Studio has been used to create a basic user interface design based on an HTML grid, Bootstrap CSS and JavaScript, including the selection of web fonts and font-based icons.

The assets (HTML, CSS, JavaScript, image and font files) has been exported and will be extended in the later stages by PHP logic, and later with jQuery, to build a dynamic website.

### Stage 2: PHP Files, Basic Router and Session

In stage 02 the HTML prototype files will be transferred to PHP files, and a basic router functionality will be implemented.

#### .htaccess

The following .htaccess configuration ensures that HTTPS is used (except on localhost) and redirects everything (except asset requests) to the index.php file:

```apacheconf
# .htaccess files provide a way to make configuration changes on a per-directory basis
RewriteEngine On

# this ensures that HTTPS is used except on localhost
RewriteCond %{HTTP_HOST} !=localhost
RewriteCond %{HTTPS} off
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [QSA,L,R=301]

# this sends the authorization header to a PHP envirnoment variable
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

# this redirects everything except asset requests to the index.php file
RewriteRule ^(?!.*assets/)(.*) index.php [QSA,L,E=ORIGINAL_PATH:/$1]
RewriteRule assets/(.*) view/assets/$1 [QSA,L]
```

#### Procedural Router

The basic procedural router provides redirection, an error header, the PATH_INFO and a ROOT_URL global. Then, the link structure has been adapted according to the routers (router configuration) using the ROOT_URL global if required.

The following `route_auth` function stores a route (the configured path) in a multidimensional array using the HTTP method and the path. The route consists of an authentication and a route callback function.
```PHP
function route_auth($method, $path, $authFunction, $routeFunction) {
    global $routes;
    $path = trim($path, '/');
    $routes[$method][$path] = array("authFunction" => $authFunction, "routeFunction" => $routeFunction);
}
```
The following `call_route` function is used to process every request. Remember this is a basic procedural router, later it will be transferred to OOP style.
```PHP
function call_route($method, $path) {
    global $routes;
    global $errorFunction;
    $path = trim(parse_url($path, PHP_URL_PATH), '/');
    if(!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
        $errorFunction(); return;
    }
    $route = $routes[$method][$path];
    if(isset($route["authFunction"])) {
        if (!$route["authFunction"]()) {
            return;
        }
    }
    $route["routeFunction"]();
}
```
#### Session

Sessions are an almost secure (not 100%) way to identify a user over several requests.

It is recommended to start a session at the beginning of a PHP script as follows: 
```PHP
session_start();
```

Then a session value (such as a user id) can be stored in the session array:
```PHP
$_SESSION["key"] = "value";
```

And a value can be accessed again:
```PHP
$value = $_SESSION["key"];
```

Finally, a session can be destroyed again if required (such as logout):
```PHP
session_destroy();
```

### Stage 3: Database, .env Config Files and Passwords

In stage 3 (and stage 4) WE-CRM will be extended with a database functionality. 

#### Database

As a first step, an [Entity Relationship Diagram](#entity-relationship-diagram) needs to be created, which can be partially be derived from the use case's nouns.

Depending on the modelling environment, a [Domain Model](#domain-model) can be created in-sync at the same time. Please make sure that ["in" parameter direction](#default-parameter-direction-configuration) is configured. The [Domain Model](#domain-model) will be used in stage 7 to implement a basic object-relational data access using PDO.

As a result and depending on the modelling environment ([Visual Paradigm Postgresql Database Generation](#postgresql-database-generation)), a Data Definition Language (DDL) SQL can be exported as follows:

```SQL
CREATE TABLE Customer (
  ID      SERIAL NOT NULL, 
  Name    varchar(255) NOT NULL, 
  Email   varchar(255) NOT NULL, 
  Mobile  varchar(255) NOT NULL, 
  AgentID int4 NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE Agent (
  ID       SERIAL NOT NULL, 
  Name     varchar(255) NOT NULL, 
  Email    varchar(255) NOT NULL, 
  Password varchar(255) NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE AuthToken (
  ID         SERIAL NOT NULL, 
  AgentID    int4 NOT NULL, 
  Selector   varchar(255) NOT NULL, 
  Validator  varchar(255) NOT NULL, 
  Expiration timestamp NOT NULL, 
  Type       int4 NOT NULL, 
  PRIMARY KEY (ID));
ALTER TABLE Customer ADD CONSTRAINT AgentCustomer FOREIGN KEY (AgentID) REFERENCES Agent (ID);
ALTER TABLE AuthToken ADD CONSTRAINT AgentToken FOREIGN KEY (AgentID) REFERENCES Agent (ID);
```

As a result of this stage, the user (agent) registration and login will be realized using ([Sessions](#session)), ([.env Config Files](#env-config-files)), ([PDO](#pdo)) and dealing with ([Passwords](#session)) securely.

#### .env Config Files

As a best practice, database related configuration should be stored outside of the source code in a configuration file. By convention, `.env` files must be kept outside of a version control by adding an entry to `.gitignore`. In this web application, the database configuration will be loaded from an INI file with an `.env` extension, since PHP provides already integrated functions for reading INI files. The file in the `config` folder may look like this:

```ini
[database]
driver=<driver>
host=<host>
database=<database>
user=<user>
port=5432
password=<password>
``` 

To read such an INI file, the following PHP functions can be used:
```PHP
$iniFile = "config/config.env";
if(file_exists($iniFile)) {
    $dataArray = parse_ini_file($iniFile, true);
    $dataConfigArray = $dataArray[database];
    // ...
}
```

If this application is deployed out of this GitHub repository to Heroku, the Heroku app can be extended with a Postgresql database. The configuration items to this database can be accessed from PHP code, which is running on Heroku, by using environment variables as follows:
```PHP
if(isset($_ENV["DATABASE_URL"])){
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $config["pdo"]["dsn"] = "pgsql" . ":host=" . $dbopts["host"] . ";port=" . $dbopts["port"] . "; dbname=" . ltrim($dbopts["path"],'/') . "; sslmode=require";
    $config["pdo"]["user"] = $dbopts["user"];
    $config["pdo"]["password"] = $dbopts["pass"];
}
```

#### PDO

As a next step, the user (agent) registration and login are realized using PDO for data access.

In order to use PDO with Postgresql the following lines need to be un-commented in php.ini:
```INI
extension=php_pdo_pgsql.dll
extension=php_pgsql.dll
```

As a good practice, the PDO instantiation should be kept in a different file (in a later stage different class containing static methods).

The initialization of PDO can be realized as following:
```PHP
$pdoInstance = new PDO ($dsn, $username, $password);
$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

Then prepared statements can be executed. In the following example an associative array (`PDO::FETCH_ASSOC`) will be returned. In the later stage 7, objects will be mapped to tables (`PDO::FETCH_CLASS`):
```PHP
$stmt = $pdoInstance->prepare('SELECT * FROM table WHERE id = :id;');
$stmt->bindValue(':id', $id);
$stmt->execute();
$resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

### Passwords

Passwords are extremely sensitive data.
1. They must be transmitted over HTTPS only - never HTTP only!
2. Always the best hashing method available in PHP must be used before storing a password in a database table.
3. Try to keep the raw / un-hashed password as short as possible in memory.

A secure password hashing in PHP can be realized as follows:
```PHP
$hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
// store the $hashedPassword in DB
```

A secure password verification with a re-hashing if required can be realized as follows:
```PHP
if (password_verify($_POST["password"], $hashedPassword)) {
    // start session
    if (password_needs_rehash($hashedPassword, PASSWORD_DEFAULT)) {
        $reHashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
        // store the $reHashedPassword in DB
    }
}
```

### Stage 4: Dynamic Views

In stage 4, the web-application is extended with functionality to store and retrieve customer data in a procedural way and similar as described in the ([PDO](#pdo)) section.

The view files are extended with `<?php ?>` tags injecting the required dynamic data. In this stage, it is still a procedural implementation. The following example shows how a HTML table can be dynamically populated:
```PHP
<?php foreach($customers as $customer): ?>
    <tr>
        <td><?php echo $customer["id"] ?> </td>
        <td><?php echo $customer["name"] ?></td>
        <td><?php echo $customer["email"] ?> </td>
        <td><?php echo $customer["mobile"] ?> </td>
    </tr>
<?php endforeach; ?>
```

The following code snipped shows how an HTML form input field value can be set, if data is available:
```PHP
<input class="form-control" type="email" name="email" value="<?php echo !empty($customer["email"]) ? $customer["email"] : ''; ?>">
```

### Stage 5: namespace/use, Auto-Loading and Class Oriented Router

In stage 5, namespaces and the usage statement are substituting the explicit definition of `require` and `include`. This paradigm shift is valuable in an object or class oriented implementation.

#### namespace/use and Auto-Loading

In PHP a namespace-use scenario is not 100 % equivalent to the package-import scenario is for instance in Java. Namespaces in PHP are providing a similar mechanism for structuring source code, which is stored in separate files, using a namespace, package or folder-like structure. With the use statement, code within a namespace can be accessed if, and this is not equivalent to Java, for instance, a separated code part is included (`require` and `include`).

It is advisable that an autoloader is implemented or a project is relying on a composer-related mechanism such as PSR-4, to overcome the separation of namespaces and files. The following autoloader links the directory structure and a namespace.
```PHP
namespace config;
class Autoloader
{
    public static function autoload($className) {
        //replace namespace backslash to directory separator of the current operating system
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fileName = $className . '.php';

        if (file_exists($fileName)) {
            include_once($fileName);
        } else {
            return false;
        }
    }
}
```
This own-written autoloader can then be registered using a PHP built-in function:
```PHP
spl_autoload_register('config\Autoloader::autoload');
```

#### Class Oriented Router

In stage 5, the previous procedural router has been transferred to a class oriented router, which provides static methods.

The router provides the possibility to register routes using a static method:
```PHP
 Router::route("POST", "/login", function () {
    /** TODO */
    Router::redirect("/");
});
```

Besides, it is possible to set an authentication function before the callback function is executed:
```PHP
Router::route_auth("GET", "/", $authFunction, function () {
    /** TODO */
    layoutSetContent("customers.php");
});
```

Finally, the router will be called by defining the following method in the entry point of the web application, which is, in this case, the `index.php` file:
```PHP
Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);
```

### Stage 6: Database, Config Classes, Exception Handling and HTTP Status

In stage 6, the procedural database and configuration developments will be transferred to a class oriented implementation.

The config class consists of static methods delivering configuration parameters defined in the `.env` file (INI-based syntax).

The database class has been implemented to hold an instance of PDO. This instance will be created once of the class attribute is `NULL`.

#### Exception Handling and HTTP Status

Besides, stage 6 contains classes for exception handling. Exceptions are an adequate way to handle with errors. The exceptions are thrown using a `throw` statement followed by an exception class:

```PHP
function inverse($x) {
    if (!$x)
        throw new Exception('Division by zero.');
    return 1/$x;
}
```

Using the try-catch structure, an exception can be handled using the thrown object:

```PHP
try {
    inverse(0);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
```

Since PHP is an HTTP-oriented programming environment, it makes sense to use the HTTP status codes for dealing with exceptions. The file `HTTPStatusHeader.php` contains a list of constants representing common HTTP status codes (based on [Henrique Moody](https://gist.github.com/henriquemoody/6580488) derived from [Wikipedia - List of HTTP status codes](https://en.wikipedia.org/wiki/List_of_HTTP_status_codes)). Since HTTP status codes are used in standard header definition such as redirects, an `HTTPHeader` class has been implemented as well. Therefore the `HTTPException` and the `HTTPHeader` implementations are using the same HTTP status codes methods, which requires the use of Traits. Traits are an elegant way to overcome typical problems associated with multiple inheritances. The following incomplete and combined listing show the power of Traits:

 ```PHP
interface HTTPStatusCode
{
    const HTTP_200_OK = "OK";
    // ...
}

trait HTTPStatusHeader
{
    protected static function createHeader($statusCode = HTTPStatusCode::HTTP_200_OK, $statusPhrase = null)
    {
        // ...
    }
}

class HTTPHeader implements HTTPStatusCode
{
    use HTTPStatusHeader;

    public static function getHeader($statusCode = HTTPStatusCode::HTTP_200_OK, $replaceHeader = true, $statusPhrase = null){
        self::createHeader($statusCode, $statusPhrase);
        // ...
    }
}

class HTTPException extends Exception implements HTTPStatusCode
{
    use HTTPStatusHeader;

    public function __construct($statusCode = HTTPStatusCode::HTTP_200_OK, $statusPhrase = null, $body = null)
    {
        self::createHeader($statusCode, $statusPhrase);
        // ...
    }
}
```

As shown above, the `HTTPException` class has been extended from `Exception` and trough the Trait functionality with the `HTTPStatusHeader` as well. 

As a result of the new `HTTPException` class, the router is adapted to throw exceptions, and the router configuration now deals with the thrown exception by showing the corresponding HTTP status code:
```PHP
try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
}
```

### Stage 7: Domain and Data Access Objects (DAO)

In stage 7, the [Domain Model](#domain-model), which has been elaborated in [stage 3 (database section)](#database), will be transferred into PHP code and be accessible by implementing data access objects (DAO) in a CRUD (create read, update and delete) style.

#### Domain Objects

Depending on the modelling environment, a [Domain Model](#domain-model) can be transferred into PHP classes. Such domain objects contain no logic, except some very basic logic for setting and getting data (getters/setters).

PDO can provide a very basic object-relational data access mechanism. In the following example the `PDO::FETCH_CLASS` strategy is used to provide an array of `domain\Agent`, which will be used in the next [DAO section](#data-access-objects-dao):

```PHP
$stmt = $this->pdoInstance->prepare('
    SELECT * FROM agent WHERE email = :email;');
$stmt->bindValue(':email', $email);
$stmt->execute();
$agent = $stmt->fetchAll(PDO::FETCH_CLASS, "domain\Agent")[0];
```

#### Data Access Objects (DAO)

Data Access Objects (DAOs) are classes, which consist of CRUD-like (`create, read, update & delete`) methods as shown in the [Data Access Model](#data-access-model). Beside the CRUD methods, DAO usually consists of `find` methods as well. Depending on the selected strategy, DAOs are related to [Domain Objects](#domain-objects), since almost all domain object has a corresponding DAO.

It is more popular nowadays to use the term repository for DAOs. But these two concepts are not the same. DAOs are used to build an abstraction layer for data access only. Repositories are implemented on a higher abstraction for a collection of objects. Many frameworks are implementing a repository using the DAO pattern, whereas vice-versa is not possible. Although this is debatable too, since using the definition of [by Edward Hieatt and Rob Mee](https://martinfowler.com/eaaCatalog/repository.html) repositories should exist as an mediating object: "[A repository mediates] between the domain and data mapping layers using a collection-like interface for accessing domain objects."

There is a big debate if DAOs should consist of static methods or not. Although DAOs are not designed on the same abstraction level such as repositories, DAOs should be designed to reflect various database connections and drivers generically. Therefore DAOs should be implemented as objects to inject different database connections and drivers at run-time.

The [Data Access Model](#data-access-model) is the blueprint of the DAOs in this reference project. After generating the DAO classes, they will be extended with prepared database statements using PDO as shown here:

```PHP
namespace dao;

use domain\Agent;

class AgentDAO extends BasicDAO {

	public function findByEmail($email) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM agent WHERE email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Agent")[0];
        return null;
    }
}
```

### Stage 8: Business Services

In stage 8, two service interfaces and service implementations based on the [Business Logic Model](#business-logic-model) are given. In this reference project, the term service referred to business service has been selected. Sometimes the term business logic acting on a business logic layer is used.

Since this reference project is as small and simplified as possible for teaching purposes, a one-class singleton strategy has been chosen for authentication (`AuthService`) and one service has been implemented for the customer use-cases (`CustomerService`). In a bigger application scenario, it would make sense to build several business services for different use-cases.

Business services contain the business decisions as in PHP transferred business rules. An example such a rule could be that an agent is only allowed to edit the customers she or he is responsible for.

As shown in the [Business Logic Model](#business-logic-model), the service interface just lists the required methods, which must be implemented in the service implementation. 

It is rarely the case that the usage of a singleton makes sense in PHP, since, compared to Java, PHP is strictly stateless (except session) and every request is in an isolated process. Nevertheless, in this reference project the authentication service implementation is realized using the singleton pattern:

```PHP
class AuthServiceImpl implements AuthService {

    private static $instance = null;

    private $currentAgentId;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct() { }

    private function __clone() { }

    protected function verifyAuth() {
        if(isset($this->currentAgentId))
            return true;
        return false;
    }
}
```

The business logic, which is referred to the customer use-case(s), is implemented in the customer service:

```PHP
class CustomerServiceImpl implements CustomerService
{
    public function createCustomer(Customer $customer) {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            $customer->setAgentId(AuthServiceImpl::getInstance()->getCurrentAgentId());
            return $customerDAO->create($customer);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }
}
```

### Stage 9: Template View Pattern and XSS

Since this reference project does not rely on a template engine such as Blade or Twig, a template view pattern class will be implemented in stage 9.

#### Template View Pattern

The one template view pattern does not really exist. This implementation has been inspired by the Book [PHP Design Patterns](https://books.google.ch/books?id=2R5IBAAAQBAJ&pg=PA453) and the example of [Alejandro Gervasio](https://www.sitepoint.com/flexible-view-manipulation-1/).

In following the View class is explained - the complete View class can be found within the stage09\view folder.

The basic idea is to assign a view `.php` file to a view by passing the information through the constructor:
```PHP
$contentView = new View("customerEdit.php");
```
___
```PHP
class View {

    private $view;

    public function __construct($view) {
        $this->view = $view;
    }
}
```

Once the view has been instantiated, data can be injected into the view by using a magic `__set()` method. Finally, the view will be rendered by using the `render()` method:
```PHP
$contentView = new View("customerEdit.php");
$contentView->customer = (new CustomerServiceImpl())->readCustomer($id);
echo $contentView->render();
```
___
```PHP
class View {

    private $view;
    private $variables = array();

    public function __set($key, $variable) {
        $this->variables[$key] = $variable;
    }

    public function render() {
        extract($this->variables);
        ob_start();
        require_once($this->view);
        return ob_get_clean();
    }
}
```

The data that has been injected can be accessed within a view `.php` file by using a magic `__get()` method. At the same time it may make sense to validate if a variable has been set:
```PHP
<input class="form-control" type="text" name="id" readonly="" value="<?php echo isset($this->customer) ? $this->customer->getId() : ''; ?>">
```
___
```PHP
class View {

    private $variables = array();

    public function __get($key) {
        return $this->variables[$key];
    }

    public function __isset($key) {
        if(!array_key_exists($key, $this->variables))
            return false;
        return isset($this->variables[$key]);
    }
}
```

#### XSS

To prevent XSS (Cross-Site Scripting) attacks any character in a user input that can affect the structure of the HTML document must be escaped on output (when displaying to a user). Following the guidelines of the [Paragon Initiative Enterprises Blog](https://paragonie.com/blog/2015/06/preventing-xss-vulnerabilities-in-php-everything-you-need-know) the View class consists of a static method that can be used in a view `.php` file:

```PHP
<input class="form-control" type="text" name="name" value="<?php echo isset($this->customer) ? View::noHTML($this->customer->getName()) : ''; ?>">
```
___
```PHP
class View {

    public static function noHTML($input, $bEncodeAll = true, $encoding = "UTF-8")
    {
        if($bEncodeAll)
            return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, $encoding);
    }
}
```

### Stage 10: Model-View-Controller

Model–view–controller (MVC) is a software architectural pattern, which is one of the most quoted pattern and at the same time it is the most misquoted pattern. There exist various variants of MVC and variants, which are related to MVC such as model-view-presenter (MVP).

- The model stores the data, which will be displayed in the view. In general, the model expresses the behaviour by data, logic and rules.
- The view generates the output to the user based on the model data.
- A controller triggers actions such as a model update, loads an associated view and processes a certain user interaction.

This reference project reflects the following recommendations of [Martin Fowler](https://martinfowler.com/eaaDev/uiArchs.html):
- Make a strong separation between presentation (view & controller) and domain (model) - separated presentation.
- Divide user interface into a controller (for reacting to user stimulus) and view (for displaying the state of the model). Controller and view should (mostly) not communicate directly but through the model.

In the following the in stage 10 implemented `CustomerController`:

```PHP
class CustomerController
{
    public static function create(){
        $contentView = new View("customerEdit.php");
        LayoutRendering::basicLayout($contentView);
    }

    public static function readAll(){
        $contentView = new View("customers.php");
        $contentView->customers = (new CustomerServiceImpl())->findAllCustomer();
        LayoutRendering::basicLayout($contentView);
    }

    public static function edit(){
        $id = $_GET["id"];
        $contentView = new View("customerEdit.php");
        $contentView->customer = (new CustomerServiceImpl())->readCustomer($id);
        LayoutRendering::basicLayout($contentView);
    }

    public static function update(){
        $customer = new Customer();
        $customer->setId($_POST["id"]);
        $customer->setName($_POST["name"]);
        $customer->setEmail($_POST["email"]);
        $customer->setMobile($_POST["mobile"]);
        if ($customer->getId() === "") {
            (new CustomerServiceImpl())->createCustomer($customer);
        } else {
            (new CustomerServiceImpl())->updateCustomer($customer);
        }
    }

    public static function delete(){
        $id = $_GET["id"];
        (new CustomerServiceImpl())->deleteCustomer($id);
    }
}
```

The PHP code above uses a static method of the `LayoutRendering` class, which provides the basic layout of the reference project:

```PHP
namespace view;

class LayoutRendering
{
    public static function basicLayout(View $contentView){
        $view = new View("layout.php");
        $view->header = (new View("header.php"))->render();
        $view->content = $contentView->render();
        $view->footer = (new View("footer.php"))->render();
        echo $view->render();
    }
}
```

### Stage 11: Validation

In stage 11, a PHP input field validator is implemented. Validation refers to the possibility to verify certain fields such as an email field containing a valid email address (name@domain.nic). Validation can be realised on the client and back-end side. This PHP validation is realised on the PHP back-end, by implementing domain-specific validation classes.

### Stage 12: Auth and Remember Me

- extending auth controller with token
- auth token dao
- auth token domain
- auth token in service
- remember me in login view

### Stage 13: Email and Password Reset

Adding SENDGRID_APIKEY to config.env and extend Config Class
Add SENDGRID_APIKEY to heroku env

- SendGrid API
- reset token in service
- email service client
- password forget in login view

### Stage 14: PDF
- HyPDF API

### Stage 15: REST Service API

- change router to work with REST paths
- abstractJSONDTO for customer
- service endpoint

### Stage 16: JavaScript & jQuery Client

## Evaluation and Deployment

### Project Set-Up

TODO: write

#### Visual Paradigm
#####  Default Parameter Direction Configuration
`Window -> Project Options`

![](images/VP-default-parameter-direction.png)

#####  Postgresql Database Generation
![](images/VP-database-generation.png)

#### Git
The project contains a .gitignore file to keep certain 

### Heroku Deployment

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

## Maintainer

- [Andreas Martin](https://github.com/andreasmartin)

## License

- [Apache License, Version 2.0](LICENSE)
