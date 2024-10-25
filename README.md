# Credxpay
Credit card based banking website

Credxpay Documentation
Table of Contents
Project Overview
Features
Architecture
User Registration and Login
Payment Process
Dealing with Credit Cards
Security Measures
Blockchain Integration
Technical Stack
Future Enhancements
Project Overview
Credxpay is a blockchain-based solution designed for tokenizing credit card information to facilitate secure digital transactions. The platform allows users to register their credit card details and receive a unique "cred ID" for online payments. During transactions, users enter their cred ID, which initiates a payment authorization request through the Credxpay system.

Features
User Registration: Users can create accounts with multiple credit cards, each linked to a unique cred ID.
Payment Authorization: Users can use their cred ID to authorize payments on participating vendor sites.
Transaction Dashboard: Users can view completed transactions and remaining balances.
Two-Step Verification: Enhanced security through personal security questions during registration and login.
Blockchain Tokenization: Securely tokenizes credit card information for transactions.
Real-time Notifications: Users receive notifications for payment requests and confirmations.
Architecture
Frontend: Built with HTML, CSS, and JavaScript (with Laravel for routing and views).
Backend: PHP with the Laravel framework for business logic and API endpoints.
Database: MySQL for storing user information, credit card details, transactions, and security questions.
Blockchain: Used for generating tokens and securely storing transaction records.
User Registration and Login
Registration:
Users provide personal information, credit card details, and set up multiple security questions.
Each credit card is associated with a unique cred ID, and all are linked to a single user ID.
Login:
Users log in using their credentials and answer a randomly selected security question from their registration list for added security.
Payment Process
Initiating Payment: Users enter their cred ID at the vendor's site (e.g., Amazon).
Payment Request: The vendor's site sends a payment request to the Credxpay system, indicating the amount and user details.
User Confirmation: Users are notified of the payment request and can confirm or deny the transaction.
Transaction Processing: Upon confirmation, the transaction is processed using the stored credit card details, and a token is generated for the transaction.
Transaction Record: The transaction is recorded on the dashboard and securely stored on the blockchain.
Dealing with Credit Cards
Adding a Credit Card:

Users can add multiple credit cards during registration or from their profile settings.
For each card, users enter the card number, expiration date, CVV, and billing address.
The system generates a unique cred ID for each credit card.
Storing Credit Card Details:

Credit card information should be securely tokenized. Only the token representing the card is stored in the database.
Sensitive data (like the card number) is encrypted before storage.
Using a Credit Card for Transactions:

When a user initiates a payment, the system retrieves the corresponding credit card token based on the user's selected cred ID.
The payment processor handles the transaction using the token instead of the actual card details, reducing the risk of exposure.
Updating or Removing a Credit Card:

Users can update their credit card details or remove a card from their profile settings.
The system securely deletes the old card token and replaces it with the updated one.
Transaction History:

All transactions using credit cards are logged in the system.
Users can view their transaction history, which includes transaction amounts, vendor details, and timestamps.
Security Measures
Two-Step Verification: Implementing personal questions during registration and at login.
Tokenization: Credit card information is never stored in plain text; only tokens are used during transactions.
SSL Encryption: All data exchanged between the user and the server is encrypted using SSL.
Blockchain Integration
Token Generation: Each transaction generates a unique token stored on the blockchain.
Transaction History: The blockchain serves as an immutable ledger, keeping records of all transactions for auditing and security purposes.
Decentralization: By leveraging blockchain technology, the platform enhances trust and security.
Technical Stack
Frontend: HTML, CSS, JavaScript, Vue.js (optional)
Backend: PHP, Laravel
Database: MySQL
Blockchain: Ethereum (or any preferred blockchain platform)
Hosting: (To be determined based on deployment)
Future Enhancements
Mobile App: Developing a mobile version of the platform for easier access.
Expanded Vendor Partnerships: Collaborating with more e-commerce platforms for broader acceptance.
Enhanced Security Features: Implementing biometric authentication and advanced fraud detection measures.
