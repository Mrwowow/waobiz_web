# WaoBiz POS API - Complete Documentation

<div align="center">

![API Version](https://img.shields.io/badge/API-v1.0.0-blue)
![OpenAPI](https://img.shields.io/badge/OpenAPI-3.0.3-green)
![Endpoints](https://img.shields.io/badge/Endpoints-70+-orange)
![Documentation](https://img.shields.io/badge/Docs-190KB-purple)

**Comprehensive API documentation for WaoBiz POS System**

[Quick Start](#-quick-start) • [Documentation](#-documentation-files) • [Examples](#-code-examples) • [Tools](#-tools-setup)

</div>

---

## 🎯 Quick Start

### 1. Choose Your Path

```
👨‍💻 Frontend Developer  →  Start with API_QUICK_START.md
🔧 Backend Developer   →  Start with API_STRUCTURE.md
📱 Mobile Developer    →  Import openapi.yaml to your tool
📊 Project Manager     →  Read API_DOCUMENTATION_SUMMARY.md
```

### 2. Test Your First Request

```bash
# Public endpoint (no auth required)
curl http://localhost/connector/api/business/30/products

# Authenticated endpoint
curl http://localhost/connector/api/product \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Explore Full Documentation

Open [API_INDEX.md](API_INDEX.md) for complete navigation guide.

---

## 📚 Documentation Files

### Core Documentation (Start Here!)

| File | Size | Purpose | Start With This If... |
|------|------|---------|----------------------|
| **[API_INDEX.md](API_INDEX.md)** | 10KB | 📑 Complete navigation guide | You want to find the right doc quickly |
| **[API_QUICK_START.md](API_QUICK_START.md)** | 8KB | 🚀 Get started in 10 minutes | You want to test the API immediately |
| **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** | 57KB | 📘 Complete API reference | You need detailed endpoint docs |
| **[API_STRUCTURE.md](API_STRUCTURE.md)** | 15KB | 🏗️ Architecture & diagrams | You want to understand the big picture |

### Specialized Guides

| File | Size | Purpose |
|------|------|---------|
| **[STORE_CONFIGURATION_API.md](STORE_CONFIGURATION_API.md)** | 13KB | 🏪 Public storefront development guide |
| **[API_DOCUMENTATION_SUMMARY.md](API_DOCUMENTATION_SUMMARY.md)** | 20KB | 📊 Statistics, coverage, and roadmap |

### Technical Specifications

| File | Size | Purpose |
|------|------|---------|
| **[openapi.yaml](openapi.yaml)** | 76KB | ⚙️ OpenAPI 3.0.3 specification for tools |

### Total Documentation Package
- **7 comprehensive files**
- **199 KB total size**
- **100+ pages of content**
- **70+ endpoints documented**

---

## 🎓 API Overview

### What's Available?

```
┌─────────────────────────────────────────────────────────┐
│                    WaoBiz POS API                       │
│                   70+ Endpoints                         │
│                   16 API Groups                         │
└─────────────────────────────────────────────────────────┘

📦 Products (4)        💰 Sales (6+)         👥 Contacts (5)
🏷️ Brands (2)         📑 Categories (2)     💸 Expenses (4)
💵 Cash Register (4)   👤 Users (6)          📏 Units (2)
💹 Taxes (2)          📍 Locations (2)      🪑 Tables (2)
⏰ Attendance (4)     🚗 Field Force (3)    📞 CRM (7)
🏪 Store Config (4)   🔧 Service Types (2)  🔄 Common (5+)
```

### Authentication

```
🔓 Public Endpoints  : 2 (Store config, Business products)
🔐 Auth Required     : 68+ (All other endpoints)
```

---

## 💻 Code Examples

### JavaScript/Node.js
```javascript
// Public endpoint - No auth
const products = await fetch(
  'http://localhost/connector/api/business/30/products'
).then(r => r.json());

// Authenticated endpoint
const response = await fetch(
  'http://localhost/connector/api/product',
  {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  }
);
```

### Python
```python
import requests

# Public endpoint
products = requests.get(
    'http://localhost/connector/api/business/30/products'
).json()

# Authenticated endpoint
headers = {
    'Authorization': f'Bearer {token}',
    'Accept': 'application/json'
}
response = requests.get(
    'http://localhost/connector/api/product',
    headers=headers
)
```

### PHP
```php
// Public endpoint
$products = file_get_contents(
    'http://localhost/connector/api/business/30/products'
);

// Authenticated endpoint
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'http://localhost/connector/api/product',
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Accept: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true
]);
$response = curl_exec($curl);
```

### cURL
```bash
# Public endpoint
curl http://localhost/connector/api/business/30/products

# Authenticated endpoint
curl http://localhost/connector/api/product \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**More examples**: See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## 🛠️ Tools & Setup

### Swagger UI (Interactive Documentation)

```bash
# Install
composer require darkaonline/l5-swagger

# Publish configuration
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# Copy OpenAPI spec
cp openapi.yaml storage/api-docs/api-docs.yaml

# Access at: http://localhost/api/documentation
```

### Postman (API Testing)

1. Open Postman
2. Import → Select `openapi.yaml`
3. All 70+ endpoints ready to test!

### ReDoc (Beautiful Docs)

```bash
# Create viewer
cat > public/api-docs.html << 'EOF'
<!DOCTYPE html>
<html>
<head><title>WaoBiz API</title></head>
<body>
    <redoc spec-url='../openapi.yaml'></redoc>
    <script src="https://cdn.jsdelivr.net/npm/redoc@latest/bundles/redoc.standalone.js"></script>
</body>
</html>
EOF

# Access at: http://localhost/api-docs.html
```

---

## 🔐 Authentication

### Get Access Token

```bash
POST /connector/api/login
Content-Type: application/json

{
  "username": "admin",
  "password": "your_password"
}

# Response
{
  "success": true,
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": { ... }
}
```

### Use Token in Requests

```bash
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

---

## 📊 API Groups

| Group | Endpoints | Description | Authentication |
|-------|-----------|-------------|----------------|
| 🛍️ Products | 4 | Product catalog, variations, pricing | Required* |
| 👥 Contacts | 5 | Customers, suppliers, payments | Required |
| 💰 Sales | 6+ | Transactions, returns, shipping | Required |
| 👤 Users | 6 | Auth, registration, password | Required |
| 💸 Expenses | 4 | Expense tracking, categories | Required |
| 💵 Cash Register | 4 | Register operations | Required |
| 🏷️ Brands | 2 | Brand management | Required |
| 📑 Categories | 2 | Product categories | Required |
| 📏 Units | 2 | Units of measurement | Required |
| 💹 Taxes | 2 | Tax rates | Required |
| 📍 Locations | 2 | Business locations | Required |
| 🪑 Tables | 2 | Restaurant tables | Required |
| 🔧 Services | 2 | Service types | Required |
| ⏰ Attendance | 4 | Employee clock in/out | Required |
| 🚗 Field Force | 3 | Field visit management | Required |
| 📞 CRM | 7 | Follow-ups, leads, calls | Required |
| 🏪 Store Config | 4 | Store settings | Mixed** |

\* One public endpoint: `GET /business/{id}/products`
\** Two public endpoints for storefront

---

## 🎯 Common Use Cases

### 1. Build Public E-commerce Storefront
```bash
# Get store configuration
GET /connector/api/store/config/nailshop-lagos

# Get products
GET /connector/api/business/30/products?per_page=20
```
**See**: [STORE_CONFIGURATION_API.md](STORE_CONFIGURATION_API.md)

### 2. Process a Sale (POS)
```bash
# Create sale transaction
POST /connector/api/sell
{
  "contact_id": 5,
  "location_id": 1,
  "products": [
    {
      "product_id": 10,
      "variation_id": 15,
      "quantity": 2,
      "unit_price": 100
    }
  ],
  "payment": {
    "method": "cash",
    "amount": 200
  }
}
```
**See**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md) → Sales section

### 3. Manage Inventory
```bash
# List products
GET /connector/api/product?location_id=1&per_page=50

# Get product details
GET /connector/api/product/123

# Check stock
GET /connector/api/product-stock-report
```
**See**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md) → Products section

### 4. Customer Management
```bash
# List customers
GET /connector/api/contactapi?type=customer

# Create customer
POST /connector/api/contactapi
{
  "type": "customer",
  "name": "John Doe",
  "mobile": "1234567890",
  "email": "john@example.com"
}

# Record payment
POST /connector/api/contactapi-payment
{
  "contact_id": 5,
  "amount": 500,
  "method": "cash"
}
```
**See**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md) → Contacts section

---

## 📱 Platform Support

### Web
- ✅ React / Next.js
- ✅ Vue.js / Nuxt.js
- ✅ Angular
- ✅ Vanilla JavaScript
- ✅ jQuery

### Mobile
- ✅ React Native
- ✅ Flutter
- ✅ Ionic
- ✅ Native iOS (Swift)
- ✅ Native Android (Kotlin/Java)

### Backend
- ✅ Node.js
- ✅ Python
- ✅ PHP
- ✅ Java
- ✅ .NET/C#
- ✅ Ruby

---

## 🚨 Response Formats

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

### Paginated Response
```json
{
  "data": [ ... ],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  },
  "meta": {
    "current_page": 1,
    "total": 100,
    "per_page": 10
  }
}
```

---

## ⚡ Performance Tips

1. **Use pagination**: `?per_page=20` instead of fetching all
2. **Filter early**: Use query parameters to reduce data
3. **Cache responses**: Store static data like brands, categories
4. **Batch requests**: Use comma-separated IDs when possible
5. **Disable pagination**: Use `?per_page=-1` only when necessary

---

## 🔒 Security Best Practices

- ✅ Use HTTPS in production
- ✅ Store tokens securely
- ✅ Rotate tokens regularly
- ✅ Validate all inputs
- ✅ Handle errors gracefully
- ✅ Never expose tokens in logs
- ✅ Implement rate limiting
- ✅ Monitor for suspicious activity

**Full guide**: [API_DOCUMENTATION.md](API_DOCUMENTATION.md) → Security section

---

## 📈 What's Next?

### Immediate Actions
1. ✅ Read [API_QUICK_START.md](API_QUICK_START.md)
2. ✅ Import [openapi.yaml](openapi.yaml) to your tool
3. ✅ Test authentication
4. ✅ Try sample requests

### Development
1. Choose your endpoints from [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
2. Follow code examples
3. Implement error handling
4. Test thoroughly

### Production
1. Setup Swagger UI
2. Configure monitoring
3. Implement caching
4. Setup CI/CD
5. Document your integration

---

## 📞 Support & Resources

### Documentation
- 📖 Complete guide: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- 🚀 Quick start: [API_QUICK_START.md](API_QUICK_START.md)
- 🗺️ Navigation: [API_INDEX.md](API_INDEX.md)
- 🏗️ Architecture: [API_STRUCTURE.md](API_STRUCTURE.md)

### Tools
- ⚙️ OpenAPI spec: [openapi.yaml](openapi.yaml)
- 🔍 Swagger UI: (setup required)
- 📮 Postman: (import openapi.yaml)

### Help
- Check documentation files above
- Review code examples
- Test with sample data
- Contact development team

---

## 📊 Statistics

- **API Version**: 1.0.0
- **OpenAPI Version**: 3.0.3
- **Total Endpoints**: 70+
- **Public Endpoints**: 2
- **API Groups**: 16
- **Controllers**: 22
- **Documentation Size**: 199 KB
- **Documentation Pages**: 100+
- **Code Examples**: 10+ languages

---

## 🎉 Ready to Build!

```
1. Start with → API_QUICK_START.md
2. Import → openapi.yaml to your tool
3. Build → Your amazing application!
```

**Need help?** Check [API_INDEX.md](API_INDEX.md) for navigation.

---

<div align="center">

**WaoBiz POS API Documentation**

Generated: November 12, 2025 | Version: 1.0.0

Made with ❤️ for developers

[Quick Start](API_QUICK_START.md) • [Full Docs](API_DOCUMENTATION.md) • [OpenAPI](openapi.yaml)

</div>
