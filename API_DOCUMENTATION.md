# WaoBiz POS API Documentation

Version: 1.0.0
Last Updated: November 12, 2025

---

## Table of Contents

1. [Introduction](#introduction)
2. [Authentication](#authentication)
3. [Base URL](#base-url)
4. [Request/Response Format](#requestresponse-format)
5. [Error Handling](#error-handling)
6. [Common Error Codes](#common-error-codes)
7. [Rate Limiting](#rate-limiting)
8. [Pagination](#pagination)
9. [API Endpoints](#api-endpoints)
   - [Products](#products)
   - [Contacts (Customers/Suppliers)](#contacts)
   - [Sales](#sales)
   - [Users](#users)
   - [Brands](#brands)
   - [Taxes](#taxes)
   - [Units](#units)
   - [Categories](#categories)
   - [Business Locations](#business-locations)
   - [Tables](#tables)
   - [Types of Service](#types-of-service)
   - [Attendance](#attendance)
   - [Field Force](#field-force)
   - [CRM](#crm)
   - [Store Configuration (Public)](#store-configuration)
10. [Code Examples](#code-examples)
11. [SDK and Client Libraries](#sdk-and-client-libraries)
12. [Changelog](#changelog)

---

## Introduction

The WaoBiz POS API is a comprehensive RESTful API that provides programmatic access to all features of the WaoBiz Point of Sale system. This API enables developers to:

- Manage products, inventory, and pricing
- Handle customer and supplier relationships
- Process sales transactions and payments
- Manage users and permissions
- Track field force activities
- Implement CRM workflows
- Access business analytics

This documentation provides complete details on all available endpoints, request/response formats, authentication requirements, and best practices.

---

## Authentication

All API endpoints (except public ones) require authentication using Bearer token.

### Obtaining an Access Token

Authentication tokens are obtained through your WaoBiz admin panel under Settings > API Settings.

### Using the Token

Include the token in the `Authorization` header of every request:

```
Authorization: Bearer YOUR_ACCESS_TOKEN_HERE
```

### Example Request with Authentication

```bash
curl -X GET "http://your-domain.com/connector/api/product" \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

### Token Security

- Never share your API tokens publicly
- Store tokens securely (environment variables, secure vaults)
- Rotate tokens periodically
- Use HTTPS in production environments

---

## Base URL

All API endpoints are relative to your WaoBiz installation:

**Development:**
```
http://localhost/connector/api
```

**Production:**
```
https://your-domain.com/connector/api
```

---

## Request/Response Format

### Request Format

- **Content-Type:** `application/json`
- **Accept:** `application/json`
- **Date Format:** `YYYY-MM-DD` for dates, `YYYY-MM-DD HH:MM:SS` for datetime

### Response Format

All responses are returned in JSON format with the following structure:

**Success Response:**
```json
{
  "data": {
    // Response data here
  }
}
```

**Paginated Response:**
```json
{
  "data": [...],
  "links": {
    "first": "http://...",
    "last": "http://...",
    "prev": null,
    "next": "http://..."
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 10,
    "per_page": 10,
    "to": 10,
    "total": 100
  }
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

---

## Error Handling

The API uses standard HTTP status codes to indicate success or failure:

### HTTP Status Codes

| Code | Status | Description |
|------|--------|-------------|
| 200 | OK | Request successful |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Invalid request format or parameters |
| 401 | Unauthorized | Missing or invalid authentication token |
| 403 | Forbidden | Authenticated but insufficient permissions |
| 404 | Not Found | Resource not found |
| 422 | Unprocessable Entity | Validation errors |
| 429 | Too Many Requests | Rate limit exceeded |
| 500 | Internal Server Error | Server error |

---

## Common Error Codes

### Authentication Errors

**401 Unauthorized**
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

**Solution:** Ensure you're sending a valid Bearer token in the Authorization header.

### Permission Errors

**403 Forbidden**
```json
{
  "success": false,
  "message": "Unauthorized action"
}
```

**Solution:** The authenticated user doesn't have permission for this action. Check user roles and permissions.

### Validation Errors

**422 Unprocessable Entity**
```json
{
  "success": false,
  "message": "The given data was invalid",
  "errors": {
    "email": ["The email field is required."],
    "mobile": ["The mobile number format is invalid."]
  }
}
```

**Solution:** Check the `errors` object for specific field validation issues.

### Resource Not Found

**404 Not Found**
```json
{
  "success": false,
  "message": "Resource not found"
}
```

**Solution:** Verify the resource ID exists and you have access to it.

---

## Rate Limiting

API requests are rate-limited to ensure fair usage and system stability.

**Default Limits:**
- 60 requests per minute for authenticated users
- 10 requests per minute for unauthenticated endpoints

**Response Headers:**
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1605564600
```

**Rate Limit Exceeded Response (429):**
```json
{
  "success": false,
  "message": "Too Many Requests"
}
```

---

## Pagination

Most list endpoints support pagination. Use these parameters to control pagination:

### Pagination Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `per_page` | integer | 10 | Number of records per page (max 100, -1 for no pagination) |
| `page` | integer | 1 | Page number to retrieve |

### Example Request

```bash
curl -X GET "http://your-domain.com/connector/api/product?per_page=20&page=2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Pagination Response

```json
{
  "data": [...],
  "links": {
    "first": "http://example.com/api/product?page=1",
    "last": "http://example.com/api/product?page=5",
    "prev": "http://example.com/api/product?page=1",
    "next": "http://example.com/api/product?page=3"
  },
  "meta": {
    "current_page": 2,
    "from": 11,
    "last_page": 5,
    "per_page": 10,
    "to": 20,
    "total": 50
  }
}
```

---

## API Endpoints

### Products

#### List Products

Get a paginated list of products with filtering and sorting.

**Endpoint:** `GET /product`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `order_by` | string | No | Sort by: `product_name`, `newest` |
| `order_direction` | string | No | Sort direction: `asc`, `desc` |
| `brand_id` | string | No | Comma-separated brand IDs |
| `category_id` | string | No | Comma-separated category IDs |
| `sub_category_id` | string | No | Comma-separated sub-category IDs |
| `location_id` | integer | No | Filter by location |
| `selling_price_group` | integer | No | Include price groups (0/1) |
| `send_lot_detail` | integer | No | Include lot details (0/1) |
| `name` | string | No | Search by product name |
| `sku` | string | No | Search by SKU |
| `per_page` | integer | No | Records per page (default: 10) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/product?category_id=1&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Men's Reverse Fleece Crew",
      "business_id": 1,
      "type": "single",
      "sku": "AS0001",
      "enable_stock": 1,
      "alert_quantity": "5.0000",
      "image_url": "http://localhost/img/default.png",
      "brand": {
        "id": 1,
        "name": "Levis"
      },
      "unit": {
        "id": 1,
        "actual_name": "Pieces",
        "short_name": "Pc(s)"
      },
      "category": {
        "id": 1,
        "name": "Men's"
      },
      "product_variations": [
        {
          "id": 1,
          "name": "DUMMY",
          "variations": [
            {
              "id": 1,
              "name": "DUMMY",
              "sub_sku": "AS0001",
              "default_sell_price": "70.0000",
              "sell_price_inc_tax": "77.0000",
              "variation_location_details": [
                {
                  "location_id": 1,
                  "qty_available": "20.0000"
                }
              ]
            }
          ]
        }
      ]
    }
  ],
  "links": {
    "first": "http://localhost/connector/api/product?page=1",
    "last": "http://localhost/connector/api/product?page=10",
    "prev": null,
    "next": "http://localhost/connector/api/product?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 10,
    "per_page": 20,
    "to": 20,
    "total": 200
  }
}
```

---

#### Get Specific Products

Retrieve one or more products by their IDs.

**Endpoint:** `GET /product/{product_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_ids` | string | Yes | Comma-separated product IDs (e.g., "1,2,3") |

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `selling_price_group` | integer | No | Include price groups (0/1) |
| `send_lot_detail` | integer | No | Include lot details (0/1) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/product/1,2,3" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Men's Reverse Fleece Crew",
      // ... product details
    }
  ]
}
```

---

#### List Product Variations

Get product variations with comprehensive filtering.

**Endpoint:** `GET /variation/{variation_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `variation_ids` | string | No | Comma-separated variation IDs (optional) |

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | string | No | Filter by product IDs (comma-separated) |
| `location_id` | integer | No | Filter by location |
| `brand_id` | integer | No | Filter by brand |
| `category_id` | integer | No | Filter by category |
| `not_for_selling` | integer | No | Filter by selling status (0/1) |
| `name` | string | No | Search by name |
| `sku` | string | No | Search by SKU |
| `per_page` | integer | No | Records per page |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/variation?product_id=1,2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

#### List Selling Price Groups

Get all selling price groups for the business.

**Endpoint:** `GET /selling-price-group`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/selling-price-group" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Retail",
      "business_id": 1,
      "is_active": 1
    },
    {
      "id": 2,
      "name": "Wholesale",
      "business_id": 1,
      "is_active": 1
    }
  ]
}
```

---

### Contacts

#### List Contacts

Get a paginated list of contacts (customers/suppliers/leads).

**Endpoint:** `GET /contactapi`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `type` | string | Yes | Contact type: `customer`, `supplier`, `both`, `lead` |
| `name` | string | No | Search by name |
| `biz_name` | string | No | Search by business name |
| `mobile_num` | string | No | Search by mobile number |
| `contact_id` | string | No | Search by contact ID (e.g., "CO0005") |
| `order_by` | string | No | Sort by: `name`, `supplier_business_name` |
| `direction` | string | No | Sort direction: `asc`, `desc` |
| `per_page` | integer | No | Records per page (default: 10) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/contactapi?type=customer&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "business_id": 1,
      "type": "customer",
      "name": "Walk-In Customer",
      "email": null,
      "contact_id": "CO0005",
      "mobile": "(378) 400-1234",
      "city": "Phoenix",
      "state": "Arizona",
      "country": "USA",
      "balance": "3728.0500",
      "created_at": "2018-01-03 20:45:20"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

#### Create Contact

Create a new contact (customer/supplier/lead).

**Endpoint:** `POST /contactapi`

**Authentication:** Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `type` | string | Yes | Contact type: `customer`, `supplier`, `both`, `lead` |
| `supplier_business_name` | string | Conditional | Required if type is `supplier` |
| `first_name` | string | Yes | First name |
| `middle_name` | string | No | Middle name |
| `last_name` | string | No | Last name |
| `prefix` | string | No | Title (Mr., Mrs., etc.) |
| `mobile` | string | Yes | Mobile number |
| `landline` | string | No | Landline number |
| `alternate_number` | string | No | Alternate contact number |
| `email` | string | No | Email address |
| `tax_number` | string | No | Tax/VAT number |
| `address_line_1` | string | No | Address line 1 |
| `address_line_2` | string | No | Address line 2 |
| `city` | string | No | City |
| `state` | string | No | State/Province |
| `country` | string | No | Country |
| `zip_code` | string | No | ZIP/Postal code |
| `dob` | string | No | Date of birth (YYYY-MM-DD) |
| `customer_group_id` | integer | No | Customer group ID |
| `pay_term_number` | number | No | Payment term number |
| `pay_term_type` | string | No | Payment term type: `days`, `months` |
| `opening_balance` | number | No | Opening balance |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/contactapi" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "customer",
    "first_name": "John",
    "last_name": "Doe",
    "mobile": "1234567890",
    "email": "john@example.com",
    "address_line_1": "123 Main St",
    "city": "New York",
    "state": "NY",
    "country": "USA",
    "zip_code": "10001"
  }'
```

**Response (201 Created):**

```json
{
  "data": {
    "id": 52,
    "type": "customer",
    "name": "John Doe",
    "mobile": "1234567890",
    "email": "john@example.com",
    "contact_id": "CO0052",
    // ... other fields
  }
}
```

---

#### Get Specific Contacts

Retrieve one or more contacts by their IDs.

**Endpoint:** `GET /contactapi/{contact_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `contact_ids` | string | Yes | Comma-separated contact IDs (e.g., "1,2,3") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/contactapi/1,2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

#### Update Contact

Update an existing contact.

**Endpoint:** `PUT /contactapi/{contact_id}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `contact_id` | integer | Yes | Contact ID to update |

**Request Body:** Same fields as Create Contact (all optional)

**Example Request:**

```bash
curl -X PUT "http://your-domain.com/connector/api/contactapi/52" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "mobile": "9876543210",
    "city": "Los Angeles"
  }'
```

---

#### Add Contact Payment

Record a payment for a contact.

**Endpoint:** `POST /contactapi-payment`

**Authentication:** Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `contact_id` | integer | Yes | Contact ID |
| `amount` | number | Yes | Payment amount |
| `method` | string | Yes | Payment method: `cash`, `card`, `cheque`, `bank_transfer`, `other` |
| `paid_on` | string | Yes | Payment datetime (YYYY-MM-DD HH:MM:SS) |
| `account_id` | integer | No | Account ID |
| `note` | string | No | Payment note |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/contactapi-payment" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "contact_id": 1,
    "amount": 500.00,
    "method": "cash",
    "paid_on": "2025-11-12 14:30:00",
    "note": "Partial payment for invoice #123"
  }'
```

**Response (201 Created):**

```json
{
  "success": true,
  "msg": "Payment added successfully",
  "data": {
    "id": 145,
    "transaction_id": null,
    "amount": "500.00",
    "method": "cash",
    "paid_on": "2025-11-12 14:30:00"
  }
}
```

---

### Sales

#### List Sales

Get a paginated list of sales transactions.

**Endpoint:** `GET /sell`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `location_id` | integer | No | Filter by location |
| `contact_id` | integer | No | Filter by customer |
| `status` | string | No | Sale status: `final`, `draft`, `quotation`, `proforma` |
| `payment_status` | string | No | Comma-separated: `due`, `partial`, `paid`, `overdue` |
| `start_date` | string | No | Start date (YYYY-MM-DD) |
| `end_date` | string | No | End date (YYYY-MM-DD) |
| `user_id` | integer | No | Filter by user who created the sale |
| `service_staff_id` | integer | No | Filter by service staff |
| `shipping_status` | string | No | Shipping status: `ordered`, `packed`, `shipped`, `delivered`, `cancelled` |
| `source` | string | No | Filter by sale source |
| `only_subscriptions` | integer | No | Filter subscription invoices (0/1) |
| `send_purchase_details` | integer | No | Include purchase details (0/1) |
| `order_by_date` | string | No | Sort by date: `asc`, `desc` |
| `per_page` | integer | No | Records per page (default: 10) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/sell?status=final&payment_status=paid&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 6,
      "business_id": 1,
      "location_id": 1,
      "type": "sell",
      "status": "final",
      "payment_status": "paid",
      "contact_id": 4,
      "invoice_no": "AS0001",
      "transaction_date": "2018-04-10 13:23:21",
      "total_before_tax": "770.0000",
      "tax_amount": "0.0000",
      "discount_amount": "0.0000",
      "shipping_charges": "0.0000",
      "final_total": "770.0000",
      "sell_lines": [
        {
          "id": 1,
          "product_id": 2,
          "variation_id": 3,
          "quantity": 10,
          "unit_price": "70.0000",
          "unit_price_inc_tax": "77.0000",
          "tax_id": 1
        }
      ],
      "payment_lines": [
        {
          "id": 1,
          "amount": "770.0000",
          "method": "cash",
          "paid_on": "2018-01-09 17:30:35"
        }
      ],
      "invoice_url": "http://localhost/invoice/6dfd77eb...",
      "payment_link": "http://localhost/pay/6dfd77eb..."
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

### Users

#### List Users

Get all users for the business.

**Endpoint:** `GET /user`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `service_staff` | integer | No | Filter service staff (0/1) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/user" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "user_type": "user",
      "surname": "Mr.",
      "first_name": "Admin",
      "last_name": "User",
      "username": "admin",
      "email": "admin@example.com",
      "business_id": 1,
      "status": "active"
    }
  ]
}
```

---

#### Get Specific Users

Retrieve one or more users by their IDs.

**Endpoint:** `GET /user/{user_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `user_ids` | string | Yes | Comma-separated user IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/user/1,2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

#### Get Logged In User

Get details of the currently authenticated user.

**Endpoint:** `GET /user/loggedin`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/user/loggedin" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": {
    "id": 9,
    "user_type": "user",
    "surname": "Mr.",
    "first_name": "Super",
    "last_name": "Admin",
    "username": "superadmin",
    "email": "superadmin@example.com",
    "business_id": 1,
    "status": "active"
  }
}
```

---

#### Update Password

Update the password for the authenticated user.

**Endpoint:** `POST /update-password`

**Authentication:** Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `current_password` | string | Yes | Current password |
| `new_password` | string | Yes | New password |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/update-password" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "current_password": "oldpassword123",
    "new_password": "newpassword456"
  }'
```

**Response (200 OK):**

```json
{
  "success": 1,
  "msg": "Password updated successfully"
}
```

---

#### Register User

Create a new user account.

**Endpoint:** `POST /user-registration`

**Authentication:** Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `email` | string | Yes | Email address |
| `user_type` | string | Yes | User type: `user`, `user_customer` |
| `first_name` | string | No | First name |
| `last_name` | string | No | Last name |
| `surname` | string | No | Title |
| `username` | string | No | Username |
| `password` | string | No | Password |
| `is_active` | string | No | Status: `active`, `inactive`, `terminated` |
| `allow_login` | boolean | No | Allow login (true/false) |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/user-registration" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "newuser@example.com",
    "user_type": "user",
    "first_name": "Jane",
    "last_name": "Smith",
    "username": "janesmith",
    "password": "password123",
    "is_active": "active"
  }'
```

---

#### Forgot Password

Send new password to user's email.

**Endpoint:** `POST /forget-password`

**Authentication:** Not Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `email` | string | Yes | User's email address |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/forget-password" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'
```

---

### Brands

#### List Brands

Get all brands for the business.

**Endpoint:** `GET /brand`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/brand" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "business_id": 1,
      "name": "Levis",
      "description": null,
      "created_at": "2018-01-03 21:19:47"
    },
    {
      "id": 2,
      "business_id": 1,
      "name": "Espirit",
      "description": null,
      "created_at": "2018-01-03 21:19:58"
    }
  ]
}
```

---

#### Get Specific Brands

Retrieve one or more brands by their IDs.

**Endpoint:** `GET /brand/{brand_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `brand_ids` | string | Yes | Comma-separated brand IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/brand/1,2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Taxes

#### List Taxes

Get all tax rates for the business.

**Endpoint:** `GET /tax`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/tax" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "business_id": 1,
      "name": "VAT@10%",
      "amount": 10,
      "is_tax_group": 0,
      "created_at": "2018-01-04 02:40:07"
    },
    {
      "id": 4,
      "business_id": 1,
      "name": "GST@18%",
      "amount": 18,
      "is_tax_group": 1,
      "created_at": "2018-01-04 02:42:19"
    }
  ]
}
```

---

#### Get Specific Taxes

Retrieve one or more tax rates by their IDs.

**Endpoint:** `GET /tax/{tax_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `tax_ids` | string | Yes | Comma-separated tax IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/tax/1,4" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Units

#### List Units

Get all units of measurement for the business.

**Endpoint:** `GET /unit`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/unit" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "business_id": 1,
      "actual_name": "Pieces",
      "short_name": "Pc(s)",
      "allow_decimal": 0,
      "base_unit_id": null,
      "base_unit_multiplier": null,
      "base_unit": null
    },
    {
      "id": 15,
      "business_id": 1,
      "actual_name": "Dozen",
      "short_name": "dz",
      "allow_decimal": 0,
      "base_unit_id": 1,
      "base_unit_multiplier": "12.0000",
      "base_unit": {
        "id": 1,
        "actual_name": "Pieces",
        "short_name": "Pc(s)"
      }
    }
  ]
}
```

---

#### Get Specific Units

Retrieve one or more units by their IDs.

**Endpoint:** `GET /unit/{unit_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `unit_ids` | string | Yes | Comma-separated unit IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/unit/1,15" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Categories

#### List Categories

Get all categories/taxonomies for the business.

**Endpoint:** `GET /taxonomy`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `type` | string | No | Category type: `product`, `device`, `hrm_department` |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/taxonomy?type=product" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Men's",
      "business_id": 1,
      "parent_id": 0,
      "category_type": "product",
      "sub_categories": [
        {
          "id": 4,
          "name": "Jeans",
          "parent_id": 1
        },
        {
          "id": 5,
          "name": "Shirts",
          "parent_id": 1
        }
      ]
    }
  ]
}
```

---

#### Get Specific Categories

Retrieve one or more categories by their IDs.

**Endpoint:** `GET /taxonomy/{category_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `category_ids` | string | Yes | Comma-separated category IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/taxonomy/1,2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Business Locations

#### List Business Locations

Get all business locations with permitted access.

**Endpoint:** `GET /business-location`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/business-location" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "business_id": 1,
      "name": "Awesome Shop",
      "landmark": "Linking Street",
      "country": "USA",
      "state": "Arizona",
      "city": "Phoenix",
      "zip_code": "85001",
      "mobile": null,
      "email": null,
      "is_active": 1,
      "payment_methods": [
        {
          "name": "cash",
          "label": "Cash",
          "account_id": "1"
        },
        {
          "name": "card",
          "label": "Card",
          "account_id": null
        }
      ]
    }
  ]
}
```

---

#### Get Specific Business Locations

Retrieve one or more business locations by their IDs.

**Endpoint:** `GET /business-location/{location_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `location_ids` | string | Yes | Comma-separated location IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/business-location/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Tables

#### List Tables

Get all restaurant tables for the business.

**Endpoint:** `GET /table`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `location_id` | integer | No | Filter by location ID |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/table?location_id=1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 5,
      "business_id": 1,
      "location_id": 1,
      "name": "Table 1",
      "description": null,
      "created_at": "2020-06-04 22:36:37"
    }
  ]
}
```

---

#### Get Specific Tables

Retrieve one or more tables by their IDs.

**Endpoint:** `GET /table/{table_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `table_ids` | string | Yes | Comma-separated table IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/table/5" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Types of Service

#### List Types of Service

Get all types of service configured for the business.

**Endpoint:** `GET /types-of-service`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/types-of-service" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "name": "Home Delivery",
      "description": null,
      "business_id": 1,
      "location_price_group": {
        "1": "0"
      },
      "packing_charge": "10.0000",
      "packing_charge_type": "fixed",
      "enable_custom_fields": 0
    }
  ]
}
```

---

#### Get Specific Types of Service

Retrieve one or more types of service by their IDs.

**Endpoint:** `GET /types-of-service/{types_of_service_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `types_of_service_ids` | string | Yes | Comma-separated IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/types-of-service/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

### Attendance

**Note:** All attendance endpoints require the Essentials module to be installed and the user must have the "essentials.allow_users_for_attendance_from_api" permission.

#### Get User Attendance

Get the latest attendance record for a user.

**Endpoint:** `GET /attendance/{user_id}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `user_id` | integer | Yes | User ID |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/attendance/1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": {
    "id": 4,
    "user_id": 1,
    "business_id": 1,
    "clock_in_time": "2020-09-12 13:13:00",
    "clock_out_time": "2020-09-12 13:15:00",
    "ip_address": null,
    "clock_in_note": "test clock in from api",
    "clock_out_note": "test clock out from api",
    "created_at": "2020-09-12 13:14:39"
  }
}
```

---

#### Clock In

Record clock in time for a user.

**Endpoint:** `POST /attendance/clock-in`

**Authentication:** Required

**Permissions:** User must have "essentials.allow_users_for_attendance_from_api" permission

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `user_id` | integer | Yes | User ID |
| `clock_in_time` | string | No | Clock in time (YYYY-MM-DD HH:MM:SS). Current time if not provided. |
| `clock_in_note` | string | No | Note about clock in |
| `ip_address` | string | No | IP address |
| `latitude` | string | Conditional | Required if location tracking is enabled |
| `longitude` | string | Conditional | Required if location tracking is enabled |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/attendance/clock-in" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "clock_in_time": "2025-11-12 09:00:00",
    "clock_in_note": "Started work",
    "latitude": "40.7128",
    "longitude": "-74.0060"
  }'
```

**Response (200 OK):**

```json
{
  "success": true,
  "msg": "Clocked In successfully",
  "type": "clock_in"
}
```

---

#### Clock Out

Record clock out time for a user.

**Endpoint:** `POST /attendance/clock-out`

**Authentication:** Required

**Permissions:** User must have "essentials.allow_users_for_attendance_from_api" permission

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `user_id` | integer | Yes | User ID |
| `clock_out_time` | string | No | Clock out time (YYYY-MM-DD HH:MM:SS). Current time if not provided. |
| `clock_out_note` | string | No | Note about clock out |
| `latitude` | string | Conditional | Required if location tracking is enabled |
| `longitude` | string | Conditional | Required if location tracking is enabled |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/attendance/clock-out" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "clock_out_time": "2025-11-12 17:00:00",
    "clock_out_note": "End of shift",
    "latitude": "40.7128",
    "longitude": "-74.0060"
  }'
```

**Response (200 OK):**

```json
{
  "success": true,
  "msg": "Clocked Out successfully",
  "type": "clock_out"
}
```

---

#### List Holidays

Get holidays with optional filtering.

**Endpoint:** `GET /holidays`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `location_id` | integer | No | Filter by location |
| `start_date` | string | No | Start date (YYYY-MM-DD) |
| `end_date` | string | No | End date (YYYY-MM-DD) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/holidays?start_date=2020-06-25&end_date=2020-12-31" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 2,
      "name": "Independence Day",
      "start_date": "2020-08-15",
      "end_date": "2020-09-15",
      "business_id": 1,
      "location_id": null,
      "note": "test holiday",
      "created_at": "2020-09-15 11:25:56"
    }
  ]
}
```

---

### Field Force

**Note:** All field force endpoints require the FieldForce module to be installed.

#### List Field Force Visits

Get field force visits with comprehensive filtering.

**Endpoint:** `GET /field-force`

**Authentication:** Required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `contact_id` | integer | No | Filter by contact ID |
| `assigned_to` | integer | No | Filter by assigned user ID |
| `status` | string | No | Filter by status: `assigned`, `finished` |
| `start_date` | string | No | Start date for visit_on (YYYY-MM-DD) |
| `end_date` | string | No | End date for visit_on (YYYY-MM-DD) |
| `per_page` | integer | No | Records per page (default: 10) |
| `order_by_date` | string | No | Sort by date: `asc`, `desc` |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/field-force?status=assigned&per_page=15" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 7,
      "visit_id": "2022/0161",
      "business_id": 1,
      "contact_id": null,
      "visit_to": "from api",
      "visit_address": "asdddd",
      "assigned_to": 9,
      "latitude": null,
      "longitude": null,
      "visited_address": null,
      "status": "assigned",
      "visit_on": "2022-01-16 17:23:00",
      "visited_on": null,
      "visit_for": "test from api new",
      "comments": null,
      "meet_with": "Name",
      "meet_with_mobileno": "123456789",
      "meet_with_designation": "dr",
      "contact": null,
      "user": {
        "id": 9,
        "first_name": "Super",
        "last_name": "Admin"
      }
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

#### Create Field Force Visit

Create a new field force visit.

**Endpoint:** `POST /field-force`

**Authentication:** Required

**Permissions:** User must have "visit.create" permission

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `contact_id` | integer | Conditional | Contact ID (required if visit_to not provided) |
| `visit_to` | string | Conditional | Name of visiting person (required if contact_id not provided) |
| `visit_address` | string | Conditional | Address (required if contact_id not provided) |
| `assigned_to` | integer | Yes | User ID to assign the visit to |
| `visit_on` | string | No | Visit datetime (YYYY-MM-DD HH:MM:SS). Current time if not provided. |
| `visit_for` | string | No | Purpose of visit |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/field-force" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "contact_id": 6,
    "assigned_to": 9,
    "visit_on": "2025-11-15 10:00:00",
    "visit_for": "Product demonstration"
  }'
```

**Response (201 Created):**

```json
{
  "data": {
    "id": 8,
    "visit_id": "2025/0032",
    "contact_id": 6,
    "assigned_to": 9,
    "visit_on": "2025-11-15 10:00:00",
    "visit_for": "Product demonstration",
    "status": "assigned",
    "business_id": 1,
    "created_at": "2025-11-12 14:30:00"
  }
}
```

---

#### Update Field Force Visit Status

Update the status and details of a field force visit.

**Endpoint:** `PUT /field-force/{id}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `id` | integer | Yes | Visit ID |

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `status` | string | No | Status: `assigned`, `finished`, `met_contact`, `did_not_meet_contact` |
| `reason_to_not_meet_contact` | string | Conditional | Required if status is `did_not_meet_contact` |
| `visited_on` | string | No | Visit datetime (YYYY-MM-DD HH:MM:SS) |
| `visited_address` | string | No | Full address of the visit |
| `latitude` | number | No | Latitude (used if full address not provided) |
| `longitude` | number | No | Longitude (used if full address not provided) |
| `comments` | string | No | Additional comments |
| `photo` | string | No | Base64 encoded image or file upload |
| `meet_with` | string | No | Name of person met |
| `meet_with_mobileno` | string | No | Mobile number of person met |
| `meet_with_designation` | string | No | Designation of person met |

**Example Request:**

```bash
curl -X PUT "http://your-domain.com/connector/api/field-force/8" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "finished",
    "visited_on": "2025-11-15 11:30:00",
    "visited_address": "123 Main St, New York, NY",
    "latitude": 40.7128,
    "longitude": -74.0060,
    "comments": "Successful product demo",
    "meet_with": "John Smith",
    "meet_with_mobileno": "1234567890",
    "meet_with_designation": "Manager"
  }'
```

**Response (200 OK):**

```json
{
  "data": {
    "id": 8,
    "visit_id": "2025/0032",
    "status": "finished",
    "visited_on": "2025-11-15 11:30:00",
    "visited_address": "123 Main St, New York, NY",
    "latitude": "40.7128",
    "longitude": "-74.0060",
    "comments": "Successful product demo",
    "meet_with": "John Smith",
    "meet_with_mobileno": "1234567890",
    "meet_with_designation": "Manager"
  }
}
```

---

### CRM

**Note:** All CRM endpoints require the CRM module to be installed.

#### List Follow-Ups

Get CRM follow-ups with comprehensive filtering.

**Endpoint:** `GET /crm/follow-ups`

**Authentication:** Required

**Permissions:** User must have "crm.access_all_schedule" or "crm.access_own_schedule" permission

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `start_date` | string | No | Start date (YYYY-MM-DD) |
| `end_date` | string | No | End date (YYYY-MM-DD) |
| `status` | string | No | Filter by status (get from /crm/follow-up-resources) |
| `follow_up_type` | string | No | Filter by type (get from /crm/follow-up-resources) |
| `order_by` | string | No | Column to sort by (e.g., start_datetime) |
| `direction` | string | No | Sort direction: `asc`, `desc` |
| `per_page` | integer | No | Records per page (default: 10) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/crm/follow-ups?status=scheduled&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 1,
      "business_id": 1,
      "contact_id": 50,
      "title": "Test Follow up",
      "status": "scheduled",
      "start_datetime": "2020-12-16 15:15:00",
      "end_datetime": "2020-12-16 15:15:00",
      "description": "<p>test</p>",
      "schedule_type": "call",
      "allow_notification": 0,
      "notify_via": {
        "sms": 0,
        "mail": 1
      },
      "notify_before": null,
      "notify_type": "minute",
      "created_by": 1,
      "customer": {
        "id": 50,
        "name": "Lead 4",
        "mobile": "234567"
      }
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

#### Create Follow-Up

Create a new CRM follow-up.

**Endpoint:** `POST /crm/follow-ups`

**Authentication:** Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `title` | string | Yes | Follow-up title |
| `contact_id` | integer | Yes | Contact ID |
| `description` | string | No | Follow-up description |
| `schedule_type` | string | Yes | Type: `call`, `sms`, `meeting`, `email` |
| `user_id` | array | Yes | Array of user IDs to assign |
| `notify_before` | integer | No | Notification time before start |
| `notify_type` | string | No | Notification type: `minute`, `hour`, `day` |
| `status` | string | No | Status: `scheduled`, `open`, `canceled`, `completed` |
| `notify_via` | object | No | Notification channels: `{"sms": 0, "mail": 1}` |
| `start_datetime` | string | Yes | Start datetime (YYYY-MM-DD HH:MM:SS) |
| `end_datetime` | string | Yes | End datetime (YYYY-MM-DD HH:MM:SS) |
| `followup_additional_info` | object | No | Additional info as key-value pairs |
| `allow_notification` | integer | No | Enable notifications (0/1) |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/crm/follow-ups" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Meeting with client",
    "contact_id": 1,
    "description": "Discuss new project requirements",
    "schedule_type": "meeting",
    "user_id": [2, 5],
    "notify_before": 30,
    "notify_type": "minute",
    "status": "scheduled",
    "notify_via": {
      "sms": 0,
      "mail": 1
    },
    "start_datetime": "2025-11-20 14:00:00",
    "end_datetime": "2025-11-20 15:00:00",
    "followup_additional_info": {
      "meeting_room": "Conference Room A"
    },
    "allow_notification": 1
  }'
```

**Response (201 Created):**

```json
{
  "data": {
    "id": 20,
    "title": "Meeting with client",
    "contact_id": 1,
    "schedule_type": "meeting",
    "status": "scheduled",
    "start_datetime": "2025-11-20 14:00:00",
    "end_datetime": "2025-11-20 15:00:00",
    "business_id": 1,
    "created_by": 1,
    "created_at": "2025-11-12 14:30:00"
  }
}
```

---

#### Get Specific Follow-Ups

Retrieve one or more follow-ups by their IDs.

**Endpoint:** `GET /crm/follow-ups/{follow_up_ids}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `follow_up_ids` | string | Yes | Comma-separated follow-up IDs (e.g., "1,2") |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/crm/follow-ups/1,2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

#### Update Follow-Up

Update an existing CRM follow-up.

**Endpoint:** `PUT /crm/follow-ups/{follow_up_id}`

**Authentication:** Required

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `follow_up_id` | integer | Yes | Follow-up ID |

**Request Body:** Same fields as Create Follow-Up (all required)

**Example Request:**

```bash
curl -X PUT "http://your-domain.com/connector/api/crm/follow-ups/20" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated meeting with client",
    "contact_id": 1,
    "schedule_type": "meeting",
    "user_id": [2, 5],
    "start_datetime": "2025-11-20 15:00:00",
    "end_datetime": "2025-11-20 16:00:00"
  }'
```

---

#### Get Follow-Up Resources

Get dropdown options for follow-up creation (statuses, types, etc.).

**Endpoint:** `GET /crm/follow-up-resources`

**Authentication:** Required

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/crm/follow-up-resources" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": {
    "statuses": {
      "scheduled": "Scheduled",
      "open": "Open",
      "canceled": "Cancelled",
      "completed": "Completed"
    },
    "follow_up_types": {
      "call": "Call",
      "sms": "Sms",
      "meeting": "Meeting",
      "email": "Email"
    },
    "notify_type": {
      "minute": "Minute",
      "hour": "Hour",
      "day": "Day"
    },
    "notify_via": {
      "sms": "Sms",
      "mail": "Email"
    }
  }
}
```

---

#### List Leads

Get CRM leads with comprehensive filtering.

**Endpoint:** `GET /crm/leads`

**Authentication:** Required

**Permissions:** User must have "crm.access_all_leads" or "crm.access_own_leads" permission

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `assigned_to` | string | No | Comma-separated user IDs |
| `name` | string | No | Search by lead name |
| `biz_name` | string | No | Search by business name |
| `mobile_num` | string | No | Search by mobile number |
| `contact_id` | string | No | Search by contact ID |
| `order_by` | string | No | Column to sort by: `name`, `supplier_business_name` |
| `direction` | string | No | Sort direction: `asc`, `desc` |
| `per_page` | integer | No | Records per page (default: 10) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/crm/leads?assigned_to=1,2&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response (200 OK):**

```json
{
  "data": [
    {
      "id": 49,
      "contact_id": "CO0010",
      "name": "Lead 3",
      "supplier_business_name": "POS",
      "email": null,
      "mobile": "9437638555",
      "type": "lead",
      "crm_source": "55",
      "crm_life_stage": "60",
      "last_follow_up": "2021-01-07 10:26:00",
      "upcoming_follow_up": null,
      "source": {
        "id": 55,
        "name": "Facebook"
      },
      "life_stage": {
        "id": 60,
        "name": "Open Deal"
      },
      "lead_users": [
        {
          "id": 10,
          "first_name": "WooCommerce",
          "last_name": "User"
        }
      ]
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

#### Save Call Logs

Bulk save call logs from mobile device.

**Endpoint:** `POST /crm/call-logs`

**Authentication:** Required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `call_logs` | array | Yes | Array of call log objects |

**Call Log Object:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `mobile_number` | string | Yes | Mobile number |
| `mobile_name` | string | No | Contact name saved in mobile |
| `call_type` | string | No | Call type: `call`, `sms` |
| `start_time` | string | No | Start datetime (YYYY-MM-DD HH:MM:SS) |
| `end_time` | string | No | End datetime (YYYY-MM-DD HH:MM:SS) |
| `duration` | string | No | Duration in seconds |

**Example Request:**

```bash
curl -X POST "http://your-domain.com/connector/api/crm/call-logs" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "call_logs": [
      {
        "mobile_number": "+1234567890",
        "mobile_name": "John Doe",
        "call_type": "call",
        "start_time": "2025-11-12 10:00:00",
        "end_time": "2025-11-12 10:05:00",
        "duration": "300"
      },
      {
        "mobile_number": "+9876543210",
        "mobile_name": "Jane Smith",
        "call_type": "call",
        "start_time": "2025-11-12 11:00:00",
        "end_time": "2025-11-12 11:10:00",
        "duration": "600"
      }
    ]
  }'
```

**Response (200 OK):**

```json
{
  "success": true
}
```

---

### Store Configuration

**Note:** These are public endpoints that don't require authentication.

#### Get Store Configuration by Name

Public endpoint to retrieve store configuration for e-commerce or public display.

**Endpoint:** `GET /store/config/{storeName}`

**Authentication:** Not Required (Public)

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `storeName` | string | Yes | Store name/slug |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/store/config/awesome-shop"
```

**Response (200 OK):**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "business_id": 1,
    "store_name": "awesome-shop",
    "business_name": "Awesome Shop",
    "logo": "logo.png",
    "logo_url": "http://localhost/uploads/logo.png",
    "banner": "banner.jpg",
    "banner_url": "http://localhost/uploads/banner.jpg",
    "theme_color": "#f97316",
    "whatsapp_number": "1234567890",
    "email": "shop@example.com",
    "phone": "1234567890",
    "address": "123 Main St, City, State 12345",
    "currency": "NGN",
    "is_active": true
  }
}
```

**Error Response (404 Not Found):**

```json
{
  "success": false,
  "message": "Store not found"
}
```

---

#### Get Business Products (Public)

Public endpoint to get products for e-commerce display.

**Endpoint:** `GET /business/{business_id}/products`

**Authentication:** Not Required (Public)

**URL Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `business_id` | integer | Yes | Business ID |

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `order_by` | string | No | Sort by: `product_name`, `newest` |
| `order_direction` | string | No | Sort direction: `asc`, `desc` |
| `brand_id` | string | No | Comma-separated brand IDs |
| `category_id` | string | No | Comma-separated category IDs |
| `location_id` | integer | No | Filter by location |
| `per_page` | integer | No | Records per page (default: 10) |

**Example Request:**

```bash
curl -X GET "http://your-domain.com/connector/api/business/1/products?category_id=1&per_page=20"
```

---

## Code Examples

### PHP (cURL)

```php
<?php

$api_url = 'http://your-domain.com/connector/api/product';
$token = 'YOUR_ACCESS_TOKEN';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code == 200) {
    $data = json_decode($response, true);
    print_r($data);
} else {
    echo "Error: " . $response;
}
```

### Python (Requests)

```python
import requests

api_url = 'http://your-domain.com/connector/api/product'
token = 'YOUR_ACCESS_TOKEN'

headers = {
    'Authorization': f'Bearer {token}',
    'Accept': 'application/json'
}

response = requests.get(api_url, headers=headers)

if response.status_code == 200:
    data = response.json()
    print(data)
else:
    print(f"Error: {response.text}")
```

### JavaScript (Fetch API)

```javascript
const apiUrl = 'http://your-domain.com/connector/api/product';
const token = 'YOUR_ACCESS_TOKEN';

fetch(apiUrl, {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

### Node.js (Axios)

```javascript
const axios = require('axios');

const apiUrl = 'http://your-domain.com/connector/api/product';
const token = 'YOUR_ACCESS_TOKEN';

axios.get(apiUrl, {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json'
  }
})
.then(response => {
  console.log(response.data);
})
.catch(error => {
  console.error('Error:', error.response?.data || error.message);
});
```

### Creating a Contact

```bash
curl -X POST "http://your-domain.com/connector/api/contactapi" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "customer",
    "first_name": "John",
    "last_name": "Doe",
    "mobile": "1234567890",
    "email": "john@example.com",
    "city": "New York",
    "state": "NY",
    "country": "USA"
  }'
```

### Recording Attendance

```bash
# Clock In
curl -X POST "http://your-domain.com/connector/api/attendance/clock-in" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "clock_in_note": "Started work",
    "latitude": "40.7128",
    "longitude": "-74.0060"
  }'

# Clock Out
curl -X POST "http://your-domain.com/connector/api/attendance/clock-out" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "clock_out_note": "End of shift",
    "latitude": "40.7128",
    "longitude": "-74.0060"
  }'
```

---

## SDK and Client Libraries

### Official SDKs

Currently, WaoBiz POS API doesn't have official SDKs, but you can use standard HTTP clients in your preferred language:

- **PHP:** Guzzle, cURL
- **Python:** Requests, httpx
- **JavaScript/Node.js:** Axios, node-fetch
- **Java:** OkHttp, Apache HttpClient
- **Ruby:** HTTParty, Faraday
- **.NET/C#:** HttpClient, RestSharp

### Postman Collection

Import the OpenAPI specification (`openapi.yaml`) into Postman for interactive testing:

1. Open Postman
2. Click "Import"
3. Select the `openapi.yaml` file
4. Configure your environment with base URL and token
5. Start making requests

---

## Changelog

### Version 1.0.0 (November 12, 2025)

**Initial Release:**
- Complete API documentation for all endpoints
- Product management APIs
- Contact (Customer/Supplier/Lead) management
- Sales transaction APIs
- User management and authentication
- Attendance tracking (Essentials module)
- Field Force visit management
- CRM follow-ups and lead management
- Public store configuration endpoints
- Comprehensive error handling documentation
- Code examples in multiple languages
- OpenAPI 3.0 specification

---

## Support

For API support, please contact:

- **Email:** support@waobiz.com
- **Documentation:** Check this guide first
- **GitHub Issues:** Report bugs and request features
- **Community Forum:** Ask questions and share solutions

---

## Best Practices

1. **Use HTTPS in Production:** Always use HTTPS to encrypt API communications
2. **Implement Rate Limiting:** Respect rate limits to avoid throttling
3. **Handle Errors Gracefully:** Implement proper error handling for all API calls
4. **Cache Responses:** Cache static data like brands, taxes, categories
5. **Use Pagination:** Don't fetch all records at once; use pagination
6. **Validate Input:** Validate all input before sending to API
7. **Log API Calls:** Log all API interactions for debugging
8. **Keep Tokens Secure:** Never expose tokens in client-side code
9. **Use Webhooks:** Implement webhooks for real-time updates (when available)
10. **Test in Development:** Always test in development before production

---

**End of Documentation**

For the latest updates and changes, please refer to the changelog section or visit the official WaoBiz documentation portal.
