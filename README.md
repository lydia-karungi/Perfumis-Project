# Perfumis – Online Perfume Shop

Perfumis is an elegant online store for browsing, reviewing, and purchasing premium fragrances. It includes a customer-facing storefront and an admin panel for managing products, orders, and reports.

---

## Technologies Used

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Tools**: MySQL Workbench, VS Code, GitHub

---

## Importing the Database

To set up the database locally:

1. Open **MySQL Workbench**
2. Go to **Server > Data Import**
3. Choose **Import from Self-Contained File**
   - File path: `database/perfumis_db.sql`
4. Under **Default Target Schema**, type `perfumis_db`
5. Click **Start Import**

Make sure `includes/db.php` uses the correct credentials:

```php
$host = 'localhost';
$user = 'root';
$pass = ''; // Replace with your local MySQL password
$db = 'perfumis_db';
