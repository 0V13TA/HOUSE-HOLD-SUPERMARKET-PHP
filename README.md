# House Hold Supermarket Environment Setup

=============================================

<img src="https://res.cloudinary.com/cloudinary/image/upload/v1575950212/cloudinary_logo_for_white_background-2x.png" alt="Cloudinary Logo" width="100" height="50">

<img src="https://stripe.com/img/about/logos/logos/stripe-logo-blue@2x.png" alt="Stripe Logo" width="100" height="50">

## Table of Contents

---

1. [Environment Variables in PHP](#environment-variables-in-php)
2. [Incorporating Cloudinary in PHP](#incorporating-cloudinary-in-php)
3. [Incorporating Stripe in PHP](#incorporating-stripe-in-php)

## Environment Variables in PHP

---

### What are Environment Variables?

Environment variables are values that are set outside of a PHP script, but are available to the script during runtime. They are often used to store sensitive information such as database credentials, API keys, and other configuration settings.

### Setting Environment Variables in PHP

There are several ways to set environment variables in PHP:

#### Using the `$_ENV` Super Globals

You can set environment variables using the `$_ENV` super globals. For example:

```php
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_USERNAME'] = 'root';
$_ENV['DB_PASSWORD'] = 'password';
```

#### Using the `putenv` Function

You can also set environment variables using the `putenv` function. For example:

```php
putenv('DB_HOST=localhost');
putenv('DB_USERNAME=root');
putenv('DB_PASSWORD=password');
```

#### Using a `.env` File

Another way to set environment variables is by using a `.env` file. You can create a `.env` file in the root of your project and add your environment variables there. For example:

```makefile
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=password
```

You can then load the environment variables in your PHP script using the `dotenv` library. For example:

```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
```

### Accessing Environment Variables in PHP

You can access environment variables in PHP using the `$_ENV` super globals or the `getenv` function. For example:

```php
$dbHost = $_ENV['DB_HOST'];
$dbUsername = getenv('DB_USERNAME');
$dbPassword = $_ENV['DB_PASSWORD'];
```

## Incorporating Cloudinary in PHP

---

### What is Cloudinary?

Cloudinary is a cloud-based image and video management platform that provides an easy-to-use API for uploading, managing, and delivering media assets.

### Setting up Cloudinary in PHP

To set up Cloudinary in PHP, you need to install the Cloudinary PHP SDK using Composer. For example:

```bash
composer require cloudinary/cloudinary_php
```

You can then configure Cloudinary in your PHP script by setting your Cloudinary credentials. For example:

```php
require 'vendor/autoload.php';

\Cloudinary::config(array(
  'cloud_name' => 'your_cloud_name',
  'api_key' => 'your_api_key',
  'api_secret' => 'your_api_secret'
));
```

### Uploading Images to Cloudinary

You can upload images to Cloudinary using the `upload` method. For example:

```php
$image = \Cloudinary\Uploader::upload('image.jpg', array(
  'public_id' => 'image',
  'resource_type' => 'image'
));
```

### Delivering Images from Cloudinary

You can deliver images from Cloudinary using the `url` method. For example:

```php
$imageUrl = \Cloudinary::cloudinary_url('image.jpg', array(
  'resource_type' => 'image'
));
```

## Incorporating Stripe in PHP

---

### What is Stripe?

Stripe is a payment gateway that provides an easy-to-use API for processing payments.

### Setting up Stripe in PHP

To set up Stripe in PHP, you need to install the Stripe PHP SDK using Composer. For example:

```bash
composer require stripe/stripe-php
```

You can then configure Stripe in your PHP script by setting your Stripe credentials. For example:

```php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('your_stripe_secret_key');
```

### Creating a Payment Intent

You can create a payment intent using the `create` method. For example:

```php
$paymentIntent = \Stripe\PaymentIntent::create(array(
  'amount' => 1000,
  'currency' => 'usd',
  'payment_method_types' => array('card')
));
```

### Confirming a Payment Intent

You can confirm a payment intent using the `confirm` method. For example:

```php
$paymentIntent->confirm(array(
  'payment_method' => 'pm_card_visa'
));
```

## Creating PDF Files with PHP

---

### What is PDF?

PDF (Portable Document Format) is a file format used to present and exchange documents reliably, independent of the software, hardware, or operating system used to create them.

### Setting up PDF Generation in PHP

To generate PDF files in PHP, you can use the TCPDF library. You can install it using Composer:

```bash
composer require tecnickcom/tcpdf
```

### Creating a PDF File

You can create a PDF file using the `TCPDF` class. For example:

```php
require 'vendor/autoload.php';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Your Title');
$pdf->SetSubject('Your Subject');
$pdf->SetKeywords('Your Keywords');

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 12);

$pdf->Cell(0, 10, 'Hello, World!', 0, 1, 'C');

$pdf->Output('example.pdf', 'I');
```

### Adding Content to a PDF File

You can add content to a PDF file using the `Cell` method. For example:

```php
$pdf->Cell(0, 10, 'This is a paragraph of text.', 0, 1, 'L');
```

### Adding Images to a PDF File

You can add images to a PDF file using the `Image` method. For example:

```php
$pdf->Image('image.jpg', 50, 50, 100, 100, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
```

### Adding Links to a PDF File

You can add links to a PDF file using the `Link` method. For example:

```php
$pdf->Link(10, 10, 30, 25, 'http://www.example.com', 0, 'Link to Example.com', 'Link to Example.com');
```

## User Session Management

---

### What is User Session Management?

User session management is the process of managing user data and authentication across multiple page requests.

### Setting up User Session Management

To set up user session management, you need to start a session on each page where you need to access the session data.

```php
session_start();
```

### Setting Session Data on Login

When a user successfully logs in (after validating their credentials), store their data in a session. For example:

```php
session_start();
$_SESSION['user_id'] = $user_id; // Store user ID
$_SESSION['username'] = $username; // Store username
```

### Checking for Active Session

On any page where you want to keep the user logged in, check if the session variables are set:

```php
session_start();
if (isset($_SESSION['user_id'])) {
    // User is logged in
    echo "Welcome, " . $_SESSION['username'];
} else {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
```

### Using Cookies for Persistent Login (Optional)

To keep the user logged in even after they close and reopen the browser, you can use cookies to store their session or login token. For example:

1. **Set a cookie on login**:

   ```php
   setcookie('user_id', $user_id, time() + (86400 \* 30), "/"); // 86400 = 1 day
   ```

2. **Retrieve the cookie on page load**:

   ```php
   if (isset($_COOKIE['user_id'])) {
       $_SESSION['user_id'] = $_COOKIE['user_id'];
       // Fetch other user data from the database if needed
   }
   ```

3. **On logout, clear the cookie**:
   ```php
   setcookie('user_id', '', time() - 3600, "/"); // Set to expire in the past
   session_destroy();
   ```

### Securing the Session

For security, make sure:

- Use `session_regenerate_id()` on login to prevent session fixation attacks.
- Use HTTPS for cookie transmission and set the `HttpOnly` and `Secure` flags to protect cookies.

This setup should keep the user logged in across page refreshes, browser restarts (with cookies), and without requiring them to log in repeatedly.

---

## Materialize Cheat Sheet

=======================

### Grid System

- Container: `.container`
- Row: `.row`
- Column: `.col.s*` (e.g., `.col.s1`, `.col.s2`, ..., `.col.s12`)
- Offset: `.offset-s*` (e.g., `.offset-s1`, `.offset-s2`, ..., `.offset-s12`)
- Push: `.push-s*` (e.g., `.push-s1`, `.push-s2`, ..., `.push-s12`)
- Pull: `.pull-s*` (e.g., `.pull-s1`, `.pull-s2`, ..., `.pull-s12`)

### Navigation

- Navbar: `.navbar`
- Navbar Brand: `.navbar-brand`
- Navbar Nav: `.navbar-nav`
- Navbar Item: `.navbar-item`
- Navbar Link: `.navbar-link`
- Navbar Toggle: `.navbar-toggle`
- Navbar Collapse: `.navbar-collapse`

### Buttons

- Button: `.btn`
- Button Colors:
  - Default: `.btn-default`
  - Primary: `.btn-primary`
  - Secondary: `.btn-secondary`
  - Success: `.btn-success`
  - Danger: `.btn-danger`
  - Warning: `.btn-warning`
  - Info: `.btn-info`
  - Light: `.btn-light`
  - Dark: `.btn-dark`
- Button Sizes:
  - Large: `.btn-lg`
  - Small: `.btn-sm`
  - Extra Small: `.btn-xs`

### Forms

- Form: `.form`
- Form Group: `.form-group`
- Form Control: `.form-control`
- Form Control Label: `.form-control-label`
- Form Control Feedback: `.form-control-feedback`
- Form Text: `.form-text`
- Input: `.input`
- Input Group: `.input-group`
- Input Group Addon: `.input-group-addon`
- Input Group Button: `.input-group-btn`
- Select: `.select`
- Select Option: `.select-option`
- Textarea: `.textarea`
- Checkbox: `.checkbox`
- Checkbox Input: `.checkbox-input`
- Checkbox Label: `.checkbox-label`
- Radio: `.radio`
- Radio Input: `.radio-input`
- Radio Label: `.radio-label`

### Tables

- Table: `.table`
- Table Responsive: `.table-responsive`
- Table Striped: `.table-striped`
- Table Bordered: `.table-bordered`
- Table Hover: `.table-hover`
- Table Condensed: `.table-condensed`
- Table Header: `.table-header`
- Table Footer: `.table-footer`
- Table Row: `.table-row`
- Table Cell: `.table-cell`

### Alerts

- Alert: `.alert`
- Alert Dismissible: `.alert-dismissible`
- Alert Link: `.alert-link`
- Alert Success: `.alert-success`
- Alert Info: `.alert-info`
- Alert Warning: `.alert-warning`
- Alert Danger: `.alert-danger`

### Badges

- Badge: `.badge`
- Badge Success: `.badge-success`
- Badge Info: `.badge-info`
- Badge Warning: `.badge-warning`
- Badge Danger: `.badge-danger`

### Breadcrumbs

- Breadcrumb: `.breadcrumb`
- Breadcrumb Item: `.breadcrumb-item`
- Breadcrumb Link: `.breadcrumb-link`

### Cards

- Card: `.card`
- Card Image: `.card-image`
- Card Title: `.card-title`
- Card Text: `.card-text`
- Card Footer: `.card-footer`
- Card Header: `.card-header`
- Card Actions: `.card-actions`

### Chips

- Chip: `.chip`
- Chip Contact: `.chip-contact`
- Chip Image: `.chip-image`
- Chip Text: `.chip-text`

### Collapsible

- Collapsible: `.collapsible`
- Collapsible Header: `.collapsible-header`
- Collapsible Body: `.collapsible-body`

### Dropdowns

- Dropdown: `.dropdown`
- Dropdown Trigger: `.dropdown-trigger`
- Dropdown Content: `.dropdown-content`
- Dropdown Item: `.dropdown-item`
- Dropdown Link: `.dropdown-link`

### Footers

- Footer: `.footer`
- Footer Copyright: `.footer-copyright`
- Footer Links: `.footer-links`

### Icons

- Icon: `.icon`
- Icon Prefix: `.icon-prefix`
- Icon Suffix: `.icon-suffix`

### Inputs

- Input: `.input`
- Input Field: `.input-field`
- Input Label: `.input-label`
- Input Prefix: `.input-prefix`
- Input Suffix: `.input-suffix`
- Input Icon Prefix: `.prefix`
- Input Icon Suffix: `.suffix`
- Input Error: `.input-error`
- Input Valid: `.input-valid`
- Textarea: `.textarea`
- Textarea Materialize: `.materialize-textarea`
- Select: `.select`
- Select Browser Default: `.select-wrapper`
- Select Dropdown: `.select-dropdown`
- Checkbox: `.checkbox`
- Checkbox Input: `.checkbox-input`
- Checkbox Label: `.checkbox-label`
- Radio: `.radio`
- Radio Input: `.radio-input`
- Radio Label: `.radio-label`
- Switch: `.switch`
- Switch Label: `.switch-label`
- Switch Input: `.switch-input`

### Forms

- Form: `.form`
- Form Group: `.form-group`
- Form Control: `.form-control`
- Form Control Label: `.form-control-label`
- Form Control Feedback: `.form-control-feedback`
- Form Text: `.form-text`
- Input: `.input`
- Input Group: `.input-group`
- Input Group Addon: `.input-group-addon`
- Input Group Button: `.input-group-btn`
- Select: `.select`
- Select Option: `.select-option`
- Textarea: `.textarea`
- Checkbox: `.checkbox`
- Checkbox Input: `.checkbox-input`
- Checkbox Label: `.checkbox-label`
- Radio: `.radio`
- Radio Input: `.radio-input`
- Radio Label: `.radio-label`
- Switch: `.switch`
- Switch Label: `.switch-label`
- Switch Input: `.switch-input`

# Using the `$_FILES` Super Global in PHP

=====================================================

The `$_FILES` super global in PHP is used to handle file uploads. It is an associative array that contains information about the uploaded files.

## Structure of the `$_FILES` Array

---

The `$_FILES` array has the following structure:

```php
$_FILES['file_name'] = array(
    'name' => 'file_name.txt',
    'type' => 'text/plain',
    'tmp_name' => '/tmp/php12345',
    'error' => 0,
    'size' => 12345
);
```

- `name`: The original name of the uploaded file.
- `type`: The MIME type of the uploaded file.
- `tmp_name`: The temporary name of the uploaded file.
- `error`: The error code associated with the uploaded file.
- `size`: The size of the uploaded file in bytes.

## Error Codes

---

The `error` key in the `$_FILES` array can have the following values:

- `UPLOAD_ERR_OK`: 0, No error occurred.
- `UPLOAD_ERR_INI_SIZE`: 1, The uploaded file exceeds the `upload_max_filesize` directive in `php.ini`.
- `UPLOAD_ERR_FORM_SIZE`: 2, The uploaded file exceeds the `MAX_FILE_SIZE` directive that was specified in the HTML form.
- `UPLOAD_ERR_PARTIAL`: 3, The uploaded file was only partially uploaded.
- `UPLOAD_ERR_NO_FILE`: 4, No file was uploaded.
- `UPLOAD_ERR_NO_TMP_DIR`: 6, Missing a temporary folder.
- `UPLOAD_ERR_CANT_WRITE`: 7, Failed to write file to disk.
- `UPLOAD_ERR_EXTENSION`: 8, A PHP extension stopped the file upload.

## Example: Uploading a File

---

Here is an example of how to upload a file using the `$_FILES` super global:

```php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the file has been uploaded
    if ($_FILES['file']['error'] == 0) {
        // Get the file name and temporary name
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];

        // Move the uploaded file to a new location
        $newLocation = 'uploads/' . $fileName;
        if (move_uploaded_file($tmpName, $newLocation)) {
            echo 'File uploaded successfully!';
        } else {
            echo 'Failed to upload file!';
        }
    } else {
        echo 'Error uploading file!';
    }
}
```

## Example: Uploading Multiple Files

---

Here is an example of how to upload multiple files using the `$_FILES` super global:

```php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop through the uploaded files
    foreach ($_FILES['files']['name'] as $key => $fileName) {
        // Get the file name and temporary name
        $tmpName = $_FILES['files']['tmp_name'][$key];

        // Move the uploaded file to a new location
        $newLocation = 'uploads/' . $fileName;
        if (move_uploaded_file($tmpName, $newLocation)) {
            echo 'File uploaded successfully!';
        } else {
            echo 'Failed to upload file!';
        }
    }
}
```

## Security Considerations

---

When working with file uploads, it's essential to consider security. Here are some tips:

- Always validate the file type and size before uploading.
- Use a secure upload directory that is not accessible from the web.
- Use a secure file name that does not include any sensitive information.
- Always check the `error` key in the `$_FILES` array to ensure that the file was uploaded successfully.

By following these tips and using the `$_FILES` super global correctly, you can securely handle file uploads in your PHP applications.

# Comprehensive Guide to Uploading to Git and Other Git Operations

## Table of Contents

1. [Creating a Git Repository](#creating-a-git-repository)
2. [Initializing a Git Repository](#initializing-a-git-repository)
3. [Adding Files to a Git Repository](#adding-files-to-a-git-repository)
4. [Committing Changes to a Git Repository](#committing-changes-to-a-git-repository)
5. [Uploading to a Git Repository](#uploading-to-a-git-repository)
6. [Cloning a Git Repository](#cloning-a-git-repository)
7. [Branching in Git](#branching-in-git)
8. [Merging Branches in Git](#merging-branches-in-git)
9. [Resolving Conflicts in Git](#resolving-conflicts-in-git)
10. [Git Best Practices](#git-best-practices)

## Creating a Git Repository

To create a new Git repository, navigate to the directory where you want to create the repository and run the following command:

```bash
git init
```

This will create a new `.git` directory in your project directory, which will contain all the necessary metadata for the new repository.

## Initializing a Git Repository

If you have an existing project directory that you want to turn into a Git repository, navigate to the directory and run the following command:

```bash
git init
```

This will initialize a new Git repository in the existing directory.

## Adding Files to a Git Repository

To add files to a Git repository, navigate to the repository directory and run the following command:

```bash
git add .
```

This will add all files in the current directory and subdirectories to the Git repository.

## Committing Changes to a Git Repository

To commit changes to a Git repository, navigate to the repository directory and run the following command:

```bash
git commit -m "commit message"
```

Replace `"commit message"` with a meaningful message that describes the changes you made.

## Uploading to a Git Repository

To upload your local repository to a remote repository, navigate to the repository directory and run the following command:

```bash
git remote add origin https://github.com/username/repository.git
git push -u origin master
```

Replace `https://github.com/username/repository.git` with the URL of your remote repository.

## Cloning a Git Repository

To clone a Git repository, navigate to the directory where you want to clone the repository and run the following command:

```bash
git clone https://github.com/username/repository.git
```

Replace `https://github.com/username/repository.git` with the URL of the repository you want to clone.

## Branching in Git

To create a new branch in a Git repository, navigate to the repository directory and run the following command:

```bash
git branch new-branch
```

Replace `new-branch` with the name of the new branch.

## Merging Branches in Git

To merge two branches in a Git repository, navigate to the repository directory and run the following command:

```bash
git merge new-branch
```

Replace `new-branch` with the name of the branch you want to merge.

## Resolving Conflicts in Git

To resolve conflicts in a Git repository, navigate to the repository directory and run the following command:

```bash
git status
```

This will show you the files that have conflicts. Open the files in a text editor and resolve the conflicts manually.

## Git Best Practices

Here are some best practices to follow when using Git:

- Use meaningful commit messages that describe the changes you made.
- Use branches to manage different versions of your code.
- Merge branches regularly to keep your code up-to-date.
- Use `git status` and `git log` to keep track of changes in your repository.
- Use `git remote` to manage remote repositories.
- Use `git push` and `git pull` to upload and download changes from remote repositories.

# MySQL Cheat Sheet
=====================

## Table of Contents

1. [SQL Basics](#sql-basics)
2. [Data Types](#data-types)
3. [SQL Queries](#sql-queries)
4. [Table Management](#table-management)
5. [Indexing](#indexing)
6. [Constraints](#constraints)
7. [Views](#views)
8. [Stored Procedures](#stored-procedures)
9. [Functions](#functions)
10. [Triggers](#triggers)
11. [Error Handling](#error-handling)
12. [Security](#security)

## SQL Basics
------------

### SQL Syntax

* SQL statements are case-insensitive
* SQL statements end with a semicolon (`;`)
* SQL statements can be written in multiple lines

### SQL Data Types

* `INT`: whole numbers
* `DECIMAL`: decimal numbers
* `VARCHAR`: character strings
* `DATE`: dates
* `TIME`: times
* `TIMESTAMP`: timestamps

## Data Types
-------------

### Numeric Data Types

* `INT`: whole numbers
* `DECIMAL`: decimal numbers
* `FLOAT`: floating-point numbers
* `DOUBLE`: double-precision floating-point numbers

### String Data Types

* `VARCHAR`: character strings
* `CHAR`: fixed-length character strings
* `TEXT`: large character strings
* `BLOB`: binary large objects

### Date and Time Data Types

* `DATE`: dates
* `TIME`: times
* `TIMESTAMP`: timestamps
* `DATETIME`: dates and times

## SQL Queries
-------------

### SELECT Statement

* `SELECT * FROM table_name;`: selects all columns from a table
* `SELECT column1, column2 FROM table_name;`: selects specific columns from a table
* `SELECT * FROM table_name WHERE condition;`: selects rows from a table based on a condition

### INSERT Statement

* `INSERT INTO table_name (column1, column2) VALUES ('value1', 'value2');`: inserts a new row into a table

### UPDATE Statement

* `UPDATE table_name SET column1 = 'value1', column2 = 'value2' WHERE condition;`: updates rows in a table based on a condition

### DELETE Statement

* `DELETE FROM table_name WHERE condition;`: deletes rows from a table based on a condition

## Table Management
-----------------

### CREATE TABLE Statement

* `CREATE TABLE table_name (column1 data_type, column2 data_type);`: creates a new table

### ALTER TABLE Statement

* `ALTER TABLE table_name ADD column3 data_type;`: adds a new column to a table
* `ALTER TABLE table_name DROP COLUMN column2;`: drops a column from a table

### DROP TABLE Statement

* `DROP TABLE table_name;`: drops a table

## Indexing
------------

### CREATE INDEX Statement

* `CREATE INDEX index_name ON table_name (column1, column2);`: creates a new index on a table

### DROP INDEX Statement

* `DROP INDEX index_name ON table_name;`: drops an index from a table

## Constraints
-------------

### PRIMARY KEY Constraint

* `CREATE TABLE table_name (column1 data_type PRIMARY KEY);`: creates a primary key constraint on a table

### FOREIGN KEY Constraint

* `CREATE TABLE table_name (column1 data_type, FOREIGN KEY (column1) REFERENCES parent_table (parent_column));`: creates a foreign key constraint on a table

### UNIQUE Constraint

* `CREATE TABLE table_name (column1 data_type UNIQUE);`: creates a unique constraint on a table

### CHECK Constraint

* `CREATE TABLE table_name (column1 data_type CHECK (condition));`: creates a check constraint on a table

## Views
---------

### CREATE VIEW Statement

* `CREATE VIEW view_name AS SELECT * FROM table_name;`: creates a new view

### DROP VIEW Statement

* `DROP VIEW view_name;`: drops a view

## Stored Procedures
-----------------

### CREATE PROCEDURE Statement

* `CREATE PROCEDURE procedure_name (parameter1 data_type, parameter2 data_type) BEGIN SELECT * FROM table_name; END;`: creates a new stored procedure

### DROP PROCEDURE Statement

* `DROP PROCEDURE procedure_name;`: drops a stored procedure

## Functions
------------

### CREATE FUNCTION Statement

* `CREATE FUNCTION function_name (parameter1 data_type, parameter2 data_type) RETURNS data_type BEGIN RETURN expression; END;`: creates a new function

### DROP FUNCTION Statement

* `DROP FUNCTION function_name;`: drops a function

## Triggers
------------

### CREATE TRIGGER Statement

* `CREATE TRIGGER trigger_name BEFORE/AFTER INSERT/UPDATE/DELETE ON table_name FOR EACH ROW BEGIN SET NEW.column1 = 'value1'; END;`: creates a new trigger

### DROP TRIGGER Statement

* `DROP TRIGGER trigger_name;`: drops a trigger

## Error Handling
----------------

### TRY-CATCH Block

* `BEGIN TRY SELECT * FROM table_name; END TRY BEGIN CATCH SELECT 'Error occurred'; END CATCH;`: handles errors in a SQL statement

## Security
------------

### GRANT Statement

* `GRANT SELECT, INSERT, UPDATE, DELETE ON table_name TO 'username'@'hostname';`: grants privileges to a user

### REVOKE Statement

* `REVOKE SELECT, INSERT, UPDATE, DELETE ON table_name FROM 'username'@'hostname';`: revokes privileges from a user