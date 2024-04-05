# INSTALLATION:
* composer install
* create dirs in root path:
  * /public -> for PDF's
  * /temp -> for QR code's
<hr>

# ENDPOINTS:
## /login.php
* Body: {
  "username": "user123",
  "password": "password123"
  }
<hr>

## /post.php
* Body: {
  "value": "text from form"
  }
* Headers: Content-Type: application/json
* Authorization: Bearer Token > token123
<hr>

# CREATED BY:
Maciej Kołodziejski

kolomaciej@gmail.com