# ICEA LION Insurance — Booking Website

A small insurance marketing site (Bootstrap 5 + custom CSS) paired with a PHP/MySQL
CRUD backend that lets visitors book an insurance plan and lets staff view, update,
and delete those bookings.

## Tech Stack

- **Frontend:** HTML5, [Bootstrap 5.3.8](https://getbootstrap.com/) (via CDN), custom `style.css`
- **Backend:** PHP (procedural, `mysqli` with prepared statements)
- **Database:** MySQL / MariaDB

## File Structure

```
.
├── index.HTML              Home page (hero video, plan cards, carousel, sign-up modal)
├── about_us.HTML            About page (mission/vision/values, map embed)
├── insuarance_plan.HTML     Insurance plan catalog (links into add_booking.PHP)
├── contact_us.HTML          Contact page (static form — not wired to a backend)
├── style.css                Shared site styles
│
├── db.PHP                   Central DB connection ($conn), included by every PHP script
├── add_booking.PHP          Create — booking form + INSERT
├── view.PHP                 Read — lists all bookings in a table
├── Update.PHP                Update — edit form + UPDATE for one booking
├── deleting.PHP              Delete — confirmation page + DELETE for one booking
```

## Database Setup

`db.PHP` connects to a database named **`my project icea`** on `localhost` with
user `root` and no password. No `.sql` schema file was included in this upload, but
based on the columns used throughout `add_booking.PHP`, `view.PHP`, `Update.PHP`,
and `deleting.PHP`, the required table is:

```sql
CREATE DATABASE IF NOT EXISTS `my project icea`;
USE `my project icea`;

CREATE TABLE bookings (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    email      VARCHAR(255) NOT NULL,
    phone      VARCHAR(50)  NOT NULL,
    insurance  VARCHAR(100) NOT NULL,
    start_date DATE         NOT NULL
);
```

Run this before using `add_booking.PHP`, or the app will fail with a "table
doesn't exist" error on the first insert.

## Setup / Run Locally

1. Install a local PHP + MySQL stack (XAMPP, MAMP, Laragon, or `php -S` + MySQL).
2. Create the database and table using the SQL above.
3. Place all project files in your web root (e.g. `htdocs/icea-lion/`).
4. Update credentials in `db.PHP` if your MySQL user/password differ from
   `root` / *(empty)*.
5. Visit `index.HTML` in the browser, or `view.PHP` to see the admin booking list.

## Features

- **Marketing pages:** home, about, insurance plans, contact — Bootstrap navbar,
  hero sections, cards, carousel, and Bootstrap modals for quotes/sign-up.
- **Booking flow:** each insurance plan on `insuarance_plan.HTML` links to
  `add_booking.PHP?insurance=<Plan Name>`, which pre-selects the plan in the
  dropdown.
- **Validation:** server-side required-field and email-format checks in
  `add_booking.PHP` / `Update.PHP`, with `htmlspecialchars()` used throughout to
  prevent XSS on output.
- **SQL injection protection:** all queries use `mysqli` prepared statements with
  bound parameters.
- **Admin table view (`view.PHP`):** lists bookings with Update/Delete links and
  shows success banners after add/update/delete via `?success=` query params.
- **Delete confirmation:** `deleting.PHP` shows a "are you sure?" page before
  performing the delete (GET to view, POST to actually delete).

## Known Issues / Bugs to Fix

These are worth cleaning up before deployment:

1. **Filenames vs. links don't match (case & spaces).** Uploaded files are named
   `about us.HTML`, `contact us.HTML`, `insuarance plan.HTML` (with spaces), but
   most `href`s reference `about-us.HTML`/`about us.HTML` inconsistently, and some
   reference lowercase `index.html` vs. the actual `index.HTML`. Linux servers are
   case-sensitive and don't tolerate spaces well in URLs — recommend renaming all
   files to lowercase, hyphenated names (`about-us.html`, `contact-us.html`,
   `insurance-plan.html`) and updating every `href` to match.
2. **`insuarance_plan.HTML` "Life Insurance" card has no booking link** — the
   `<a href="add_booking.PHP">` for Life Insurance is missing the query param
   (works, but doesn't preselect the plan like the others).
3. **Broken heading tag in `index.HTML`:** `<h1 ...></h1>Protect what Matters
   Most</h1>` — the closing tag is misplaced, leaving "Protect what Matters Most"
   outside the heading and an orphan `</h1>`.
4. **Stray character in `index.HTML` modal:** a stray `o` sits before "Our
   insuarance advisor..." in the quote modal body.
5. **Case-sensitive `require`/redirect mismatches:** files are uploaded as
   `db.PHP`, `Update.PHP`, `deleting.PHP` (capitalized), but code references
   `db.php`, `Update.php`, `view.php` (lowercase) in `require_once` and
   `header('Location: ...')` calls. On case-sensitive filesystems (any real Linux
   host) these will 404/fail. Pick one casing convention and use it everywhere —
   lowercase is the PHP community standard.
6. **`contact_us.HTML` form isn't functional** — it's a static Bootstrap form with
   no `action`/`method` and no PHP handler, so submissions currently do nothing.
   Needs a `contact_handler.php` (e.g. send mail or store to a `messages` table)
   if it should actually work.
7. **No table styling in `style.css`** — `view.PHP` renders a `<table>` inside
   `.table-container`, but `style.css` has no rules for `table`, `.table-container`,
   `.success-message`, or `.error-message`, so the admin view will look unstyled.
8. **Placeholder/broken external links** in `index.HTML` — e.g.
   `https://Lagoon Hotel.co.ke/...` for the Health and Motor Insurance "Learn
   More" buttons appear to be leftover placeholder URLs from a template and
   contain a space (invalid in a URL).
9. **Plaintext DB credentials in `db.PHP`** — fine for local dev, but before
   deploying, move credentials to environment variables or a `.env`/config file
   outside the web root, and set a real MySQL password.
10. **`add_booking.PHP` links to `view.PHP`** after success but never appends
    `?success=added`, so the "Insurance booking saved successfully" banner logic
    in `view.PHP` won't trigger from that flow (only Update/Delete redirects set
    it correctly).

## Suggested Next Steps

- Standardize all filenames to lowercase-with-hyphens and fix every internal link.
- Add the missing `bookings` table SQL (and consider a `contact_messages` table
  for the contact form) as a versioned `schema.sql` file in the repo.
- Add basic CSS for tables, success/error messages, and form elements used in the
  PHP-rendered pages (currently they only get Bootstrap defaults where Bootstrap
  is included, and none at all on the PHP pages, which don't load Bootstrap).
- Wire up `contact_us.HTML`'s form to a real handler.
- Consider consolidating repeated `<footer>` markup (it currently appears twice,
  with slightly different styles, in `index.HTML`) into one partial/include.
