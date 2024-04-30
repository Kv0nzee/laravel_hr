# HR Management System

![image](https://github.com/Kv0nzee/laravel_hr/assets/62888962/63fc8857-0225-451e-b33c-410546548259)

## Overview
The HR Management System is a Laravel-based web application designed to streamline and automate various human resources tasks within an organization. It provides a centralized platform for managing employee information, tracking attendance, processing payroll, and more.

## Features
1. **Employee Management**: 
   - Add, view, edit, and delete employee records.
   - Maintain employee profiles with details such as name, email, department, and position.

2. **Attendance Tracking**:
   - Record daily check-ins and check-outs for employees.
   - View attendance reports and summaries for individual employees or the entire organization.
   - Check in using QR code or PIN code for quick and easy attendance tracking.
     
3. **Salary Management**:
   - Track salary details for each employee, including earnings, deductions, and bonuses.
   - Generate salary reports and statements for payroll processing.

4. **Department Management**:
   - Create, update, and delete department records.
   - Assign employees to departments for organizational structure and reporting.

5. **Project Management**:
   - Create and manage projects within the organization.
   - Assign employees to projects and define project timelines and milestones.

6. **Task Management**:
   - Break down projects into tasks and subtasks.
   - Assign tasks to employees and track task progress and completion status.
   - Set deadlines and priorities for tasks to ensure timely completion.

7. **Role and Permission Management**:
   - Define roles and permissions for different user types (e.g., admin, manager, HR).
   - Assign permissions to roles to control access to system features and functionalities.

## Installation
1. Clone the repository to your local machine.
   git clone https://github.com/Kv0nzee/laravel_hr.git

2. Navigate to the project directory.
    composer install

3. Copy the .env.example file and rename it to .env. Update the necessary environment variables such as database credentials and application URL.

4. Generate an application key.
    php artisan key:generate

5. Run database migrations and seeders to populate the database with initial data.
    php artisan migrate --seed

6. Serve the application.
    php artisan serve

7. Access the application in your web browser at http://localhost:8000.

## Usage
1. **Login**:
    Use the default login credentials provided in the seeders or register a new account.
    For admin access: email:admin@gmail.com, password:admin@gmail.com
   
2. **Navigate**:
    Explore the different modules and functionalities available in the application.

3. **Manage Employees**:
    Add, edit, and delete employee records.
    View detailed employee profiles and manage department assignments.
   
4. **Track Attendance**:
    Record employee check-ins and check-outs.
    Generate attendance reports and summaries.
    Optionally, check in using QR code or PIN code for quick attendance tracking.

5. **Process Payroll**:
    Manage salary details for each employee.
    Generate payroll reports and statements.
6. **Manage Projects and Tasks**:
    Create and manage projects.
    Break down projects into tasks and assign them to employees.
    Track task progress and completion status.
    Set deadlines and priorities for tasks.

7. **Manage Roles and Permissions**:
    Define roles for different user types.
    Assign permissions to control access to system features.


This version now includes the project and task management features in the features section and mentions them in the usage section. Feel free to adjust the wording or add more details as needed.

## Feedback and Suggestions
We welcome any feedback or suggestions you may have to improve the HR Management System. If you have any ideas for new features, improvements, or general feedback, please don't hesitate to reach out to us.

## Contact Information
For any inquiries, feedback, or collaboration opportunities regarding the HR Management System project, feel free to contact us:

- **Email**: [kaungzawhein@gmail.com](mailto:kaungzawhein@gmail.com)
