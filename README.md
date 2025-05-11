# Timesheet Project

This project provides functionality for managing timesheets, with the ability to submit clockin and clockout times and manage staff members. Built with Laravel and InertiaJS, this is a rework leveraging modern frameworks of a project I intially developed in vanilla PHP and jQuery in a previous role.

Currently the functionality is limited however I will be adding to this over time (see [here](#future-development) for proposed future changes). 

See below a breakdown of the existing functionality.

### Manage and view timesheets

You can manage and view timesheets for a list of staff, and filter by month and year. The timesheet currently renders a single calendar month, and to ensure the calendar is a clean square grid it backfills any days not in the current month. The current day is highlighted in red, and weekends are greyed out.

Clicking on a specific date takes you to a new page to submit time entries for clockin and clockout times.

In future this functionality would be expanded further, with the option to upload data via a CSV and also disable bank holiday dates. The time entry submission could also be streamlined by handling it via a modal rather than navigating to a new page.

![image](https://github.com/user-attachments/assets/4b49467e-06e2-4439-b927-da1ae91c3943)

### Add new staff members

New staff members can be added via the Add Staff member page, this is a basic form using InertiaJS and Laravel for the server-side validation. In future this would be developed further into a CRUD interface with functionality to view all staff members, amend details and delete/archive staff.

![image](https://github.com/user-attachments/assets/675f328d-52be-4d35-a7eb-2e28ade4f3f5)

### Add new time entries

New time entries are submitted via the timesheet itself, which brings you to this page. Again this is a basic form using InertiaJS and Laravel. In future this would be removed entirely and reworked as a modal on the timesheet page.

![image](https://github.com/user-attachments/assets/10b6932c-e728-4bf6-952f-908367dcae3d)

# Future Development

- [ ] Implement upload CSV functionality
- [ ] Convert manual time entry submit to modal
- [ ] Implement update, delete and manage (view all) staff functionality
- [ ] Add tagging to timesheet (usecase would be for explaining if a staff member leaves early)
- [ ] Add reports and/or charts per staff member
- [ ] Add shift patterns/working hours and validation on the timesheet
- [ ] Add data export (usecase would be for payroll data)
- [ ] Build REST API (usecase would be Slack integration)
- [ ] Add functionality for absence reporting
- [ ] Add staff member login and permissions
- [ ] Add functionality for staff members to clockin/clockout themselves
