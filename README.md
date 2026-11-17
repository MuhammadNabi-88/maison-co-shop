# Maison & Co. — PHP/MySQL E-commerce Portfolio

A responsive boutique storefront with an editorial visual identity, built with PHP 8+, MySQL, PDO, HTML, CSS and vanilla JavaScript.

## Features
- Homepage, product catalogue, category browsing, search and sorting
- Product detail, stock availability and session shopping cart
- Customer registration/login and order history
- Password hashing, PDO prepared statements, CSRF tokens
- Checkout with server-side stock locking and transaction-safe order creation
- Admin dashboard, product creation/deactivation and order status management
- EUR pricing and free-shipping threshold
- MySQL schema and sample product catalogue

## Local setup (XAMPP)


## Free PHP + MySQL deployment (InfinityFree)


## GitHub portfolio workflow


## Important limitations and production checklist
- Checkout is a demonstration only: no real payment is collected and no card details are stored.
- For real payments, integrate a hosted payment provider such as Stripe Checkout and verify signed webhooks server-side. Never store raw card details.
- Before commercial launch add email verification, password reset, rate limiting, secure cookie settings, privacy/cookie controls, GDPR-compliant data handling, legal pages, backups, monitoring and automated tests.
- Product photography is loaded from remote Unsplash URLs; replace with images you have permission to use.
- Free shared hosting has limits and is for portfolio demos, not a production business. Check the host's current plan terms.
