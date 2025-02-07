# LearnMart - Online Course Platform

LearnMart is a web-based online course platform that allows users to enroll in and purchase courses. The platform provides a seamless learning experience with a user-friendly interface, secure payment integration, and responsive design.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Backend**: PHP
- **Database**: MySQL
- **Development Environment**: XAMPP
- **Payment Gateway**: Razorpay

## Features
- **User Authentication**: Registration, Login, and Profile Management.
- **Course Management**: Browse, Purchase, and Enroll in Courses.
- **Secure Payment**: Integrated with Razorpay for smooth transactions.
- **Responsive Design**: Optimized for all devices using Bootstrap.
- **Admin Dashboard**: Manage courses, users, and payments.
- **Interactive Learning**: Video lessons.

## Installation Guide
1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/LearnMart.git
   cd LearnMart
   ```

2. **Setup Database**
   - Import `database.sql` into your MySQL database using phpMyAdmin.
   - Configure database credentials in `config.php`.

3. **Install Dependencies**
   - Ensure XAMPP is installed and running.
   - Place the project inside the `htdocs` folder of XAMPP.

4. **Configure Razorpay**
   - Sign up on Razorpay and obtain API keys.
   - Update `payment.php` with your Razorpay credentials.

5. **Run the Project**
   - Start Apache and MySQL from XAMPP Control Panel.
   - Open `http://localhost/LearnMart` in your browser.

## Razorpay Integration
- **Checkout Flow**: The Razorpay payment gateway is integrated for smooth transactions.
- **Transaction Handling**: Payments are verified using Razorpay Webhooks.

## Demo
[Watch Demo](https://github.com/fathimathahseenaa/LearnMart/Output/Output.mp4)

## Contributing
Feel free to contribute by submitting issues or pull requests.

## License
This project is licensed under the MIT License.

## Contact
For inquiries, reach out to **fathimathahseenaa@gmail.com**

