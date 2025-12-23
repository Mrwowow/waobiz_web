# WaoBiz API Structure Overview

## 📊 Visual API Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        WaoBiz POS API                           │
│                    /connector/api/*                              │
└─────────────────────────────────────────────────────────────────┘
                              │
        ┌─────────────────────┴─────────────────────┐
        │                                           │
   ┌────▼────┐                                 ┌────▼────┐
   │ Public  │                                 │  Admin  │
   │ Routes  │                                 │ Routes  │
   │ (No Auth)│                                │ (Auth)  │
   └────┬────┘                                 └────┬────┘
        │                                           │
        │                                           │
┌───────┴──────────┐                   ┌────────────┴────────────┐
│                  │                   │                         │
│ • Store Config   │                   │ • Products              │
│ • Business       │                   │ • Sales                 │
│   Products       │                   │ • Contacts              │
│                  │                   │ • Users                 │
└──────────────────┘                   │ • Expenses              │
                                       │ • Cash Register         │
                                       │ • Brands                │
                                       │ • Categories            │
                                       │ • Taxes                 │
                                       │ • Units                 │
                                       │ • Business Locations    │
                                       │ • Tables                │
                                       │ • Types of Service      │
                                       │ • Attendance            │
                                       │ • Field Force           │
                                       │ • CRM                   │
                                       └─────────────────────────┘
```

## 🏗️ API Groups & Endpoints

### 1. 🛍️ Products (4 endpoints)
```
GET    /product                    List all products
GET    /product/{ids}              Get specific product(s)
GET    /variation/{ids}            Get product variations
GET    /selling-price-group        Get price groups
GET    /business/{id}/products     Get business products (PUBLIC)
```

### 2. 👥 Contacts (5 endpoints)
```
GET    /contactapi                 List contacts
POST   /contactapi                 Create contact
GET    /contactapi/{ids}           Get specific contact(s)
PUT    /contactapi/{id}            Update contact
POST   /contactapi-payment         Record payment
```

### 3. 💰 Sales (6+ endpoints)
```
GET    /sell                       List sales
POST   /sell                       Create sale
GET    /sell/{ids}                 Get specific sale(s)
PUT    /sell/{id}                  Update sale
DELETE /sell/{id}                  Delete sale
POST   /sell-return                Create sale return
GET    /list-sell-return           List sale returns
POST   /update-shipping-status     Update shipping status
```

### 4. 👤 Users (6 endpoints)
```
GET    /user                       List users
GET    /user/{ids}                 Get specific user(s)
GET    /user/loggedin              Get logged-in user
POST   /user-registration          Register new user
POST   /update-password            Update password
POST   /forget-password            Reset password
```

### 5. 💸 Expenses (4 endpoints)
```
GET    /expense                    List expenses
POST   /expense                    Create expense
GET    /expense/{ids}              Get specific expense(s)
PUT    /expense/{id}               Update expense
GET    /expense-refund             List expense refunds
GET    /expense-categories         List categories
```

### 6. 💵 Cash Register (4 endpoints)
```
GET    /cash-register              List registers
POST   /cash-register              Create/open register
GET    /cash-register/{ids}        Get specific register(s)
PUT    /cash-register/{id}         Update/close register
```

### 7. 🏷️ Brands (2 endpoints)
```
GET    /brand                      List brands
GET    /brand/{ids}                Get specific brand(s)
```

### 8. 📑 Categories (2 endpoints)
```
GET    /taxonomy                   List categories
GET    /taxonomy/{ids}             Get specific category(s)
```

### 9. 📏 Units (2 endpoints)
```
GET    /unit                       List units
GET    /unit/{ids}                 Get specific unit(s)
```

### 10. 💹 Taxes (2 endpoints)
```
GET    /tax                        List taxes
GET    /tax/{ids}                  Get specific tax(s)
```

### 11. 📍 Business Locations (2 endpoints)
```
GET    /business-location          List locations
GET    /business-location/{ids}    Get specific location(s)
```

### 12. 🪑 Tables (2 endpoints)
```
GET    /table                      List tables
GET    /table/{ids}                Get specific table(s)
```

### 13. 🔧 Types of Service (2 endpoints)
```
GET    /types-of-service           List service types
GET    /types-of-service/{ids}     Get specific type(s)
```

### 14. ⏰ Attendance (4 endpoints)
```
GET    /get-attendance/{user_id}   Get attendance
POST   /clock-in                   Clock in
POST   /clock-out                  Clock out
GET    /holidays                   List holidays
```

### 15. 🚗 Field Force (3 endpoints)
```
GET    /field-force                List visits
POST   /field-force/create         Create visit
POST   /field-force/update-visit-status/{id}  Update status
```

### 16. 📞 CRM (7 endpoints)
```
GET    /crm/follow-ups             List follow-ups
POST   /crm/follow-ups             Create follow-up
GET    /crm/follow-ups/{ids}       Get specific follow-up(s)
PUT    /crm/follow-ups/{id}        Update follow-up
GET    /crm/follow-up-resources    Get resources
GET    /crm/leads                  List leads
POST   /crm/call-logs              Save call logs
```

### 17. 🏪 Store Configuration (4 endpoints)
```
GET    /store/config/{storeName}           Get by name (PUBLIC)
GET    /store/config/business/{id}         Get by business ID
POST   /store/config                       Create configuration
PUT    /store/config/{id}                  Update configuration
POST   /store/config/{id}                  Update (with files)
```

### 18. 🔄 Common Resources (Multiple endpoints)
```
GET    /payment-accounts           Get payment accounts
GET    /payment-methods            Get payment methods
GET    /business-details           Get business details
GET    /profit-loss-report         Get P&L report
GET    /product-stock-report       Get stock report
GET    /notifications              Get notifications
GET    /get-location               Get location
```

### 19. 👑 Superadmin (2 endpoints)
```
GET    /active-subscription        Get subscription
GET    /packages                   Get packages
```

### 20. 🔔 Product Sell Events (3 endpoints)
```
GET    /new_product                New product notification
GET    /new_sell                   New sell notification
GET    /new_contactapi             New contact notification
```

## 🔐 Authentication Flow

```
┌──────────────┐
│   Client     │
└──────┬───────┘
       │
       │ 1. POST /login (username + password)
       ▼
┌──────────────┐
│   Server     │
└──────┬───────┘
       │
       │ 2. Returns access_token
       ▼
┌──────────────┐
│   Client     │
│  Stores Token│
└──────┬───────┘
       │
       │ 3. All subsequent requests:
       │    Authorization: Bearer {token}
       ▼
┌──────────────┐
│  API Calls   │
│  Authenticated│
└──────────────┘
```

## 📦 Data Flow Example: Creating a Sale

```
Frontend                API Server              Database
   │                       │                       │
   │  POST /sell          │                       │
   │  + product_lines     │                       │
   │  + contact_id        │                       │
   │  + payment           │                       │
   ├──────────────────────>│                       │
   │                       │                       │
   │                       │  Validate request     │
   │                       │  Check stock          │
   │                       │  Calculate totals     │
   │                       ├──────────────────────>│
   │                       │                       │
   │                       │  INSERT transaction   │
   │                       │  INSERT sell_lines    │
   │                       │  INSERT payment       │
   │                       │  UPDATE stock         │
   │                       │<──────────────────────┤
   │                       │                       │
   │  200 OK              │                       │
   │  + sale_data         │                       │
   │<──────────────────────┤                       │
   │                       │                       │
```

## 🗂️ Database Relations

```
┌──────────────┐
│   Business   │
└──────┬───────┘
       │
       ├─────────────────┐
       │                 │
       ▼                 ▼
┌──────────────┐  ┌──────────────┐
│   Products   │  │   Contacts   │
└──────┬───────┘  └──────┬───────┘
       │                 │
       │                 │
       │  ┌──────────────┴───────┐
       │  │                      │
       ▼  ▼                      ▼
┌──────────────┐          ┌──────────────┐
│Transactions/ │──────────│  Payments    │
│    Sells     │          └──────────────┘
└──────┬───────┘
       │
       ▼
┌──────────────┐
│  Sell Lines  │
│ (Line Items) │
└──────────────┘
```

## 📊 Request/Response Pattern

### Standard List Response
```json
{
  "data": [
    { "id": 1, ... },
    { "id": 2, ... }
  ],
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "to": 10,
    "total": 100,
    "per_page": 10,
    "last_page": 10
  }
}
```

### Standard Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Standard Error Response
```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

## 🎯 Common Query Parameters

Most LIST endpoints support:

| Parameter | Description | Example |
|-----------|-------------|---------|
| `per_page` | Items per page | `?per_page=20` |
| `page` | Page number | `?page=2` |
| `location_id` | Filter by location | `?location_id=1` |
| `start_date` | Start date filter | `?start_date=2025-01-01` |
| `end_date` | End date filter | `?end_date=2025-12-31` |
| `order_by` | Sort field | `?order_by=created_at` |
| `order_direction` | Sort direction | `?order_direction=desc` |

## 🔄 Pagination Pattern

```
GET /product?per_page=10&page=1
GET /product?per_page=10&page=2
GET /product?per_page=10&page=3
...

# Disable pagination
GET /product?per_page=-1
```

## 🎨 Frontend Integration Examples

### React/Next.js
```javascript
const fetchProducts = async () => {
  const response = await fetch(
    'http://localhost/connector/api/business/30/products',
    {
      headers: {
        'Accept': 'application/json'
      }
    }
  );
  return response.json();
};
```

### Vue.js
```javascript
async fetchStoreConfig() {
  const response = await axios.get(
    '/connector/api/store/config/nailshop-lagos'
  );
  this.storeConfig = response.data.data;
}
```

### Angular
```typescript
getProducts(businessId: number): Observable<any> {
  return this.http.get(
    `${this.apiUrl}/business/${businessId}/products`
  );
}
```

## 📱 Mobile Integration

### React Native
```javascript
const token = await AsyncStorage.getItem('token');
const response = await fetch(url, {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json'
  }
});
```

### Flutter
```dart
final response = await http.get(
  Uri.parse('$apiUrl/product'),
  headers: {
    'Authorization': 'Bearer $token',
    'Accept': 'application/json',
  },
);
```

## 🧪 Testing Strategy

```
1. Unit Tests
   └─ Test individual controller methods

2. Integration Tests
   └─ Test complete workflows (create → read → update → delete)

3. API Tests
   └─ Test with Postman/Newman
   └─ Automated with CI/CD

4. Load Tests
   └─ Test performance under load
   └─ Use tools like Apache JMeter
```

## 📈 API Metrics to Monitor

- **Response Time**: Average time to respond
- **Success Rate**: Percentage of successful requests
- **Error Rate**: Percentage of failed requests
- **Request Volume**: Number of requests per time period
- **Popular Endpoints**: Most frequently used endpoints
- **Authentication Failures**: Failed login attempts

## 🔒 Security Checklist

- ✅ Bearer token authentication
- ✅ HTTPS in production
- ✅ Input validation
- ✅ SQL injection protection (Laravel ORM)
- ✅ XSS protection
- ✅ CSRF protection
- ⚠️ Rate limiting (recommended)
- ⚠️ API versioning (recommended)
- ⚠️ Request logging (recommended)

## 📚 Documentation Files

| File | Purpose | Size |
|------|---------|------|
| `openapi.yaml` | OpenAPI 3.0 spec | 76KB |
| `API_DOCUMENTATION.md` | Complete guide | 57KB |
| `API_DOCUMENTATION_SUMMARY.md` | Statistics | 20KB |
| `STORE_CONFIGURATION_API.md` | Store config guide | 15KB |
| `API_QUICK_START.md` | Quick start guide | 10KB |
| `API_STRUCTURE.md` | This file | ~12KB |

**Total Documentation**: ~190KB / 60+ pages

---

**Ready to use!** 🚀

Import `openapi.yaml` into Swagger UI, Postman, or your preferred API tool.
