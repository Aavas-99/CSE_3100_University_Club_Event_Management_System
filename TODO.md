# TODO

## Authentication by Role + Role-Specific Login Pages

### Step 1 — Inspect database
- [x] Verified `users` table has `role` column (default `student`).

### Step 2 — Registration rules + strong password
- [x] Update `AuthController@register` validation so only `student` and `organizer` can register (no `admin`).

- [x] Add strong password validation (Laravel password rules) with `confirmed`.

### Step 3 — Create role-specific login routes + controller actions
- [x] Add routes for:

  - GET/POST `/login/student`
  - GET/POST `/login/organizer`
  - GET/POST `/login/admin`
- [x] Add `AuthController` methods to authenticate by credentials + enforce expected role.

### Step 4 — Create 3 login views
- [x] Create:
  - `resources/views/auth/login-student.blade.php`
  - `resources/views/auth/login-organizer.blade.php`
  - `resources/views/auth/login-admin.blade.php`

- [x] Ensure all views use shared CSS classes/styles.


### Step 5 — Home redirects and role buttons
- [x] Update `resources/views/home/index.blade.php`:

  - Student/Club/Admin login buttons redirect to exact role login routes.
  - Any “Sign in” redirect should go to role-specific login (and “Register” should go to `/register`).

### Step 6 — Navbar / modal login behavior
- [x] Update `resources/views/partials/navbar.blade.php` so “Sign In” goes to student login and “Get Started” goes to registration.



### Step 7 — CSS design updates
- [x] Extend `public/css/style.css` with shared auth page styles (form card, input focus, button gradient, error styles).


### Step 8 — Quick test checklist
- [ ] Register as student/organizer works; admin registration blocked.

- [x] Role login only allows matching users.

- [x] Home page buttons redirect correctly.


