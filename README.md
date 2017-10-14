# WE-CRM

## Summary
This is a reference project elaborated by the students step-by-step in every FHNW web engineering lecture.

## Process

### Analysis

#### Scenario
WE-CRM (Web Engineering Customer-Relationship-Management) is the smallest possible and lightweight demonstration tool that allows agents to manage their customer data. Agents have an own access to their customer data. Besides, agents can email themselves an complete extract or create a PDF of their customers.

#### Use Case

![](modelling/images/WE-CRM-Use-Case.png)

- UC-1 [Login on WE-CRM]: Agents can log-in by entering an email address and password. As an extension, new agents my register first.
- UC-2 [Register on WE-CRM]: Agents can register to get an account (profile) to access the WE-CRM system.
- UC-3 [Edit a customer]: Agents can create, update and delete customers.
- UC-4 [Show a customer list]: Agents can get an overview over their customers based on a customer list. As an extension they can create, update and delete customers (UC-3), generate a PDF (UC-5) or send an email (UC-6).
- UC-5 [Generate a PDF customer list]: Agents can generate a PDF containing a list of their customers.
- UC-6 [Send customer list via email]: Agents can send an email containing a list of their customers to their own inbox.

#### Constraints

TODO: write

### Design

#### Solution Strategy

TODO: write

#### Wireframe

![](modelling/images/WE-CRM-Wireframe%20-%20Log-In.png)
![](modelling/images/WE-CRM-Wireframe%20-%20Customers.png)
![](modelling/images/WE-CRM-Wireframe%20-%20Edit.png)

#### Domain Model

![](modelling/images/WE-CRM-Domain-Model.png)

#### Entity Relationship Diagram

![](modelling/images/WE-CRM-ERD.png)

#### Data Access Model

![](modelling/images/WE-CRM-Data-Access.png)

#### Business Logic Model

![](modelling/images/WE-CRM-Business-Logic.png)

### Implementation

#### Stage 1: Building a Static Website with Bootstrap

In stage 01 a bootstrap based prototype has been created by using a prototyping application. 

In this case, the prototype application Bootstrap Studio has been used to create a basic user interface design based on an HTML grid, Bootstrap CSS and JavaScript, including the selection of web fonts and font-based icons.

The assets (HTML, CSS, JavaScript, image and font files) has been exported and will be extended in the later stages by PHP logic, and later with jQuery, to build a dynamic website.

#### Stage 2: PHP Files and Basic Router

In stage 02 the HTML prototype files will be transferred to PHP files, and a basic router functionality will be implemented.

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

The basic procedural router provides redirection, an error header, the PATH_INFO and a ROOT_URL global. Then, the link structure has been adapted according to the routers (router configuration) using the ROOT_URL global if required.

The follwing `route_auth` function stores a route (the configured path) in a multidimensional array using the HTTP method and the path. The route consists of an autentication and a route callback function.
```PHP
function route_auth($method, $path, $authFunction, $routeFunction) {
    global $routes;
    $path = trim($path, '/');
    $routes[$method][$path] = array("authFunction" => $authFunction, "routeFunction" => $routeFunction);
}
```
The follwing `call_route` function is used to process every request. Remeber this is a besic procedural router, later it will be transferred to OOP style.
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

#### Stage 3: Database and .env Config Files

In stage 3 (and stage 4) WE-CRM will be extended with a database functionality. 

[Link-name2](#domain-model)
[Link-name2](#default-parameter-direction)


- creation of the database
- creation of config files
- session and login in DB
- customer access and view in stage 4

##### PostgreSQL
```SQL
CREATE TABLE Customer (
  ID      SERIAL NOT NULL, 
  Name    varchar(255), 
  Email   varchar(255), 
  Mobile  varchar(255), 
  AgentID int4 NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE Agent (
  ID       SERIAL NOT NULL, 
  Name     varchar(255), 
  Email    varchar(255), 
  Password varchar(255), 
  PRIMARY KEY (ID));
CREATE TABLE AuthToken (
  ID         SERIAL NOT NULL, 
  AgentID    int4 NOT NULL, 
  Selector   varchar(255), 
  Validator  varchar(255), 
  Expiration timestamp, 
  PRIMARY KEY (ID));
ALTER TABLE Customer ADD CONSTRAINT AgentCustomer FOREIGN KEY (AgentID) REFERENCES Agent (ID);
ALTER TABLE AuthToken ADD CONSTRAINT AgentToken FOREIGN KEY (AgentID) REFERENCES Agent (ID);
```

un-comment the following lines in php.ini:

extension=php_pdo_pgsql.dll
extension=php_pgsql.dll

```SQL
INSERT INTO agent (email, password) VALUES ('test@test.org','secret');
```

### Evaluation and Deployment

#### Project Set-Up

TODO: write

##### Visual Paradigm Configuration
######  Default Parameter Direction
![](images/VP-default-parameter-direction.png)

##### Git
The project contains a .gitignore file to keep certain 

#### Heroku Deployment

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

## Maintainer

- [Andreas Martin](https://github.com/andreasmartin)

## License

- [Apache License, Version 2.0](LICENSE)
