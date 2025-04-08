# South East Collective Database Management System

## Overview

This project is a web-based user interface (UI) designed to for administrators to manage a retail store's database system. It allows admins to interact directly with the Oracle database, enabling actions such as viewing, editing, and managing products, orders, returns, customers, and employees. The system also includes a secure authentication feature, ensuring that only authorized users can make changes to the database.

## Features

### Admin Authentication

- **Login Page**: Ensures that only authorized admin users can access the database management features.
- **Secure Authentication**: Admin users must log in with valid credentials to access the UI and perform actions.

### Database Management

- **Order and Return Management**: Admins can view all order and return details.
- **Customer Management**: Admins can view, edit, and delete customer records.
- **Employee Management**: Admins can view, edit, and delete employee records.
- **Create, Edit, and Delete Tables**: Admins can modify information from the database directly from the UI.

## Tech Stack

The following technologies are used:

- **Frontend**:

  - **HTML5**: For structuring the web pages.
  - **CSS3**: For styling the UI and providing a responsive design.

- **Backend**:

  - **PHP**: For server-side logic, including handling authentication and database queries.
  - **Oracle Database**: The relational database used for storing data such as customer, employee, and order information.

- **Authentication**:

  - **PHP Sessions**: Used for user authentication and session management.

- **Tools & Libraries**:

  - **Oracle SQL Developer**: For managing the database.
  - **Git**: For version control and managing the project repository.
