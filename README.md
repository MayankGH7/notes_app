# iNotes - PHP Notes Management Application

iNotes is a simple PHP-based notes management application that allows users to add, edit, and delete notes. This application uses PHP for server-side scripting, MySQL for database storage, and Bootstrap for styling.

## Table of Contents

- [Description](#description)
- [Prerequisites](#prerequisites)
- [Usage](#usage)
- [License](#license)

## Description

iNotes provides a user-friendly interface for managing notes. It includes the following features:

- Adding new notes with titles and descriptions.
- Editing existing notes.
- Deleting notes.
- Option to clear all notes.
- Dynamic table for displaying notes using DataTables.
- Bootstrap for a responsive and attractive design.
- Error handling for form submissions.

The code is organized into different sections, including HTML markup, PHP scripts for database interaction, and JavaScript for dynamic behavior.

## Prerequisites

Before using iNotes, make sure you have the following prerequisites:

- A web server with PHP support (e.g., Apache, Nginx).
- MySQL database for storing notes (You can configure the database connection in `_dbconnect.php`).
- Bootstrap and DataTables dependencies (included via CDNs).

## Usage

1. Clone or download this repository to your web server's directory.

2. Configure the database connection by editing the `_dbconnect.php` file with your database credentials.

3. Open `index.php` in a web browser to access the notes management application.

4. Use the application to add, edit, and delete notes. You can also clear all notes using the "Clear All Notes" button.

## License

This code is provided under the [MIT License](LICENSE). You are free to use, modify, and distribute this code for both personal and commercial purposes. However, please give credit to the original author if you use it in your projects.

---

Feel free to reach out if you have any questions or need further assistance with iNotes.
