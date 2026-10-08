# TikDrop Documentation

## Installation

### Requirements

Before installing TikDrop, make sure your hosting environment meets the following requirements:

- PHP 8.0.1 or higher
- PDO (PHP Data Objects)
- MySQLi (MySQL Improved Extension)
- cURL (Client URL Library)
- `allow_url_fopen` enabled

Check with your hosting provider to ensure these dependencies are installed and configured correctly.

### Installation Steps

#### 1. Upload the `htdocs` files


Upload the contents of the `htdocs` package to your web hosting server.

Choose the appropriate directory where you want the script to be installed.

Run the command `composer update` to install all dependencies.

#### 2. Extract and move the files

After uploading the `htdocs` package:

1. Extract the files.
2. Move the files contained inside the `htdocs` folder to the directory where your website will run.
3. Make sure you move the **contents of the `htdocs` folder**, not the `htdocs` folder itself.

#### 3. Open the installation URL

Open your preferred web browser and access the URL corresponding to the directory where you uploaded the script files.

This will start the installation process.

#### 4. Create a database

Before continuing with the installation, make sure you have already created a MySQL database.

You will need the database credentials during the installation process.

#### 5. Enter the database credentials

On the installation screen, provide the required database information:

- Database name
- Database username
- Database password
- Database host

Make sure the credentials are correct so the script can establish a successful database connection.

#### 6. Configure the website

After a successful database connection, you will be redirected to the website configuration screen.

Enter the following information:

- **Site Title:** The desired title for your website.
- **Site Description:** A brief description representing the purpose or content of your website.
- **Site URL:** The main URL of your website.

#### 7. Create the administrator account

On the same configuration screen, enter the administrator account details:

- **Administrator's Name:** Full name of the administrator.
- **Administrator's Email:** Administrator's email address.
- **Administrator's Password:** A secure password for the administrator account.

#### 8. Finish the installation

After filling in all required information, proceed to the next step and click **Finish** to complete the installation.

---

## Theme Customization

To customize the TikDrop theme, you must be logged in with an administrator account.

### Steps

1. Log in to TikDrop using your administrator credentials.
2. Open the **Appearance** section in the admin panel's side menu.
3. Select **Theme Options**.
4. Use the available options to customize the theme according to your requirements.

### Available Customization Options

The Theme Options section includes customization settings such as:

- Website icons
- Navigation area style
- Front-end color scheme
- Typography

Explore the available options to configure the appearance of your website.

---

## API Usage

TikDrop allows applications to integrate with the script through its API.

### Requirements

To manage API keys, the user must have either an **Administrator** or **Editor** account.

### Generate an API Key

1. Log in to the TikDrop dashboard.
2. Navigate to the **API Keys** section.
3. Generate an API key for your application.
4. Keep your API key secure and do not expose it publicly.

### API Documentation

For information about available API endpoints and how to use them, navigate to:

**Dashboard → API Keys → Documentation**

Follow the API documentation provided there when integrating TikDrop with your application.

---

## Support

For support, contact:

**leembytes@gmail.com**
