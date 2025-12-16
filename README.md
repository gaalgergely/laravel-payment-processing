# Laravel Payment Processing Demo

This project is a Laravel 7 demo that showcases multi-platform payment processing. Authenticated users can submit payments in multiple currencies and complete them through PayPal or Stripe with provider-specific approval flows.

## Features
- Dashboard with authenticated payment form for entering amount, currency, and payment platform.
- Dynamic UI that reveals platform-specific inputs (Stripe card widget, PayPal notice) based on the selected provider.
- PayPal integration: creates orders, redirects for approval, and captures the transaction after the user returns.
- Stripe integration: creates and confirms PaymentIntents, including a dedicated 3D Secure/Strong Customer Authentication step when required.
- Currency and payment platform records seeded for quick setup across USD, EUR, GBP, and JPY.
- Simple flash-message feedback for successful payments and graceful fallbacks for cancel/error states.

## Architecture overview
- **Controllers**: `HomeController` renders the dashboard with available currencies and platforms; `PaymentController` handles pay/approval/cancel endpoints and delegates to platform services.
- **Resolver**: `PaymentPlatformResolver` maps a platform ID to a service class defined in `config/services.php`, enabling polymorphic payment handling.
- **Services**: `PayPalService` and `StripeService` encapsulate provider-specific API calls and approval logic, both using the shared `ConsumesExternalServices` trait for authenticated HTTP requests.
- **Models**: `Currency` and `PaymentPlatform` back the selectable options in the UI and are populated via migrations/seeders.

## Getting started
1. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```
2. **Configure environment**
   - Copy `.env.example` to `.env` and set your database credentials.
   - Add your payment credentials:
     ```env
     PAYPAL_BASE_URI=https://api-m.sandbox.paypal.com
     PAYPAL_CLIENT_ID=your-client-id
     PAYPAL_CLIENT_SECRET=your-client-secret

     STRIPE_BASE_URI=https://api.stripe.com
     STRIPE_KEY=pk_test_xxx
     STRIPE_SECRET=sk_test_xxx
     ```
3. **Generate app key and run migrations/seeders**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
4. **Serve the app**
   ```bash
   php artisan serve
   ```
   Register/login, then submit a payment using the provided form.

## Extending the demo
- Add a new provider by creating a service class with `handlePayment` and `handleApproval` methods, registering it under `config/services.php`, and seeding a matching `PaymentPlatform` entry.
- Implement webhooks for asynchronous events (e.g., refunds, chargebacks) to complement the controller-based approval flow.
- Enhance UX with richer error messaging, loading states during payment submission, or currency-specific validation rules.

## License
This demo is open-sourced software licensed under the [MIT license](LICENSE).
