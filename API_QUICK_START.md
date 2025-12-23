# API Quick Start Guide

## 🚀 Getting Started with WaoBiz API

Your complete API documentation has been generated and is ready to use!

## 📚 Documentation Files

### 1. OpenAPI Specification
**File**: `openapi.yaml` (76KB)
- Complete OpenAPI 3.0.3 specification
- Import into Swagger UI, Postman, or any API client
- 70+ endpoints documented
- All request/response schemas included

### 2. Comprehensive Documentation
**File**: `API_DOCUMENTATION.md` (57KB)
- Human-readable documentation
- Code examples in 5 languages
- Authentication guides
- Error handling
- Best practices

### 3. Summary Report
**File**: `API_DOCUMENTATION_SUMMARY.md` (20KB)
- Statistics and coverage analysis
- Implementation recommendations
- Known limitations

### 4. Store Configuration Guide
**File**: `STORE_CONFIGURATION_API.md` (existing)
- Detailed guide for store configuration endpoints
- Real-world examples

## 🛠️ Using the Documentation

### Option 1: Swagger UI (Recommended)

1. **Install Swagger UI**:
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/waobiz
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

2. **Copy OpenAPI spec**:
```bash
cp openapi.yaml storage/api-docs/api-docs.yaml
```

3. **Access Swagger UI**:
Open: `http://localhost/api/documentation`

### Option 2: Postman

1. Open Postman
2. Click "Import"
3. Select `openapi.yaml`
4. All 70+ endpoints will be imported as a collection

### Option 3: Redoc (Beautiful Documentation)

1. Create HTML file:
```bash
cat > /Applications/XAMPP/xamppfiles/htdocs/waobiz/public/api-docs.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>WaoBiz API Documentation</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Roboto:300,400,700" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; }
    </style>
</head>
<body>
    <redoc spec-url='../openapi.yaml'></redoc>
    <script src="https://cdn.jsdelivr.net/npm/redoc@latest/bundles/redoc.standalone.js"></script>
</body>
</html>
EOF
```

2. Access: `http://localhost/api-docs.html`

## 🔐 Authentication

All authenticated endpoints require a Bearer token:

```bash
Authorization: Bearer {your_access_token}
```

### Get Access Token

**Endpoint**: `POST /connector/api/login` (documented in UserController)

```bash
curl -X POST "http://localhost/connector/api/login" \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "your_password"
  }'
```

## 📖 API Groups

Your API is organized into 16 groups:

| Group | Endpoints | Description |
|-------|-----------|-------------|
| **Products** | 4 | Product management, variations, pricing |
| **Contacts** | 5 | Customers, suppliers, payments |
| **Sales** | 6 | Sales transactions, returns, shipping |
| **Users** | 6 | Authentication, registration, password |
| **Expenses** | 4 | Expense management, categories |
| **Cash Register** | 4 | Cash register operations |
| **Brands** | 2 | Brand management |
| **Categories** | 2 | Product categories/taxonomy |
| **Units** | 2 | Product units |
| **Taxes** | 2 | Tax rates |
| **Business Locations** | 2 | Location management |
| **Tables** | 2 | Restaurant tables |
| **Types of Service** | 2 | Service types |
| **Store Configuration** | 4 | Public store settings |
| **Attendance** | 4 | Clock in/out, holidays |
| **Field Force** | 3 | Field visit management |

## 🎯 Most Common Endpoints

### 1. Products
```bash
# Get business products (public)
GET /connector/api/business/{business_id}/products

# List products (authenticated)
GET /connector/api/product
```

### 2. Sales
```bash
# Create sale
POST /connector/api/sell

# List sales
GET /connector/api/sell
```

### 3. Contacts
```bash
# List contacts
GET /connector/api/contactapi

# Create contact
POST /connector/api/contactapi
```

### 4. Store Configuration
```bash
# Get store config (public)
GET /connector/api/store/config/{storeName}

# Update store config (admin)
PUT /connector/api/store/config/{id}
```

## 💡 Quick Examples

### Example 1: Fetch Products (No Auth)
```bash
curl -X GET "http://localhost/connector/api/business/30/products?per_page=20&order_by=product_name&order_direction=asc"
```

### Example 2: Create Contact (With Auth)
```bash
curl -X POST "http://localhost/connector/api/contactapi" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "customer",
    "name": "John Doe",
    "email": "john@example.com",
    "mobile": "1234567890"
  }'
```

### Example 3: Get Store Configuration (Public)
```bash
curl -X GET "http://localhost/connector/api/store/config/nailshop-lagos"
```

## 🔧 Testing Tools

### 1. cURL (Command Line)
```bash
# Test endpoint
curl -X GET "http://localhost/connector/api/product" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### 2. HTTPie (User-Friendly CLI)
```bash
# Install
brew install httpie  # macOS

# Test endpoint
http GET localhost/connector/api/product \
  Authorization:"Bearer YOUR_TOKEN"
```

### 3. Postman (GUI)
- Import `openapi.yaml`
- Set up environment variables
- Test all endpoints interactively

### 4. Insomnia (GUI Alternative)
- Import `openapi.yaml`
- Beautiful interface
- GraphQL support (if needed)

## 📊 Response Formats

All responses follow a consistent format:

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
  "errors": { ... }
}
```

### Paginated Response
```json
{
  "data": [ ... ],
  "links": { ... },
  "meta": {
    "current_page": 1,
    "total": 100
  }
}
```

## 🚨 Common Error Codes

| Code | Meaning | Action |
|------|---------|--------|
| 200 | Success | Request completed successfully |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Check request parameters |
| 401 | Unauthenticated | Add/refresh Bearer token |
| 403 | Forbidden | Check user permissions |
| 404 | Not Found | Resource doesn't exist |
| 422 | Validation Error | Fix request data |
| 500 | Server Error | Contact support |

## 🔍 Searching & Filtering

Most list endpoints support:

### Pagination
```
?per_page=20&page=2
```

### Filtering
```
?location_id=1&category_id=5&brand_id=3
```

### Search
```
?name=product&sku=ABC123
```

### Sorting
```
?order_by=created_at&order_direction=desc
```

## 📦 Database Status

Current test data:
- **Store Configurations**: 2 records
  - ID 1: test-store (business_id: 1)
  - ID 2: nailshop-lagos (business_id: 30)

To create more test data, use the documented POST endpoints.

## 🎓 Learning Resources

1. **Read the Full Documentation**: `API_DOCUMENTATION.md`
2. **Check the Summary**: `API_DOCUMENTATION_SUMMARY.md`
3. **Store Config Guide**: `STORE_CONFIGURATION_API.md`
4. **OpenAPI Spec**: `openapi.yaml`

## 🛡️ Security Best Practices

1. **Always use HTTPS in production**
2. **Never commit access tokens**
3. **Rotate tokens regularly**
4. **Use environment variables for sensitive data**
5. **Implement rate limiting**
6. **Validate all input data**
7. **Use prepared statements (already done in Laravel)**

## 🚀 Next Steps

### For Developers:
1. Import `openapi.yaml` into your API client
2. Set up authentication
3. Test the endpoints you need
4. Integrate into your application

### For Frontend Developers:
1. Use the public endpoints for storefront
2. Use authenticated endpoints for admin panel
3. Refer to code examples in `API_DOCUMENTATION.md`

### For DevOps:
1. Set up Swagger UI in production
2. Configure API rate limiting
3. Monitor API usage
4. Set up error tracking

### For Product Managers:
1. Review available endpoints
2. Check API coverage
3. Plan new features based on capabilities

## 💬 Support

For questions or issues:
1. Check `API_DOCUMENTATION.md` for detailed guides
2. Review `API_DOCUMENTATION_SUMMARY.md` for known limitations
3. Contact the development team

## 📝 Updates

Documentation generated: **November 12, 2025**

To regenerate documentation after API changes:
```bash
# If using L5-Swagger
php artisan l5-swagger:generate

# Manual update
# Update openapi.yaml and markdown files as needed
```

---

**Happy Coding! 🎉**
