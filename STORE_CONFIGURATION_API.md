# Store Configuration API Documentation

## Overview

The Store Configuration API allows you to manage public-facing store configurations for businesses. This includes store branding, contact information, business hours, payment methods, and SEO settings.

## Base URL

```
http://your-domain.com/connector/api
```

## Authentication

- **Public Endpoints**: No authentication required
- **Admin Endpoints**: Requires Bearer token authentication

```
Authorization: Bearer {your_access_token}
```

---

## Endpoints

### 1. Get Store Configuration by Store Name (Public)

Retrieve store configuration using the URL-friendly store name. This endpoint is public and does not require authentication.

**Endpoint**: `GET /store/config/{storeName}`

**URL Parameters**:
- `storeName` (required): The unique store name/slug

**Example Request**:
```bash
curl -X GET "http://your-domain.com/connector/api/store/config/nailshop-lagos" \
  -H "Accept: application/json"
```

**Success Response (200)**:
```json
{
  "success": true,
  "data": {
    "id": 2,
    "business_id": 30,
    "store_name": "nailshop-lagos",
    "business_name": "NAILSHOP LAGOS",
    "logo": "/uploads/store_logos/1731423600_673316d0a1234.jpg",
    "logo_url": "http://localhost/uploads/store_logos/1731423600_673316d0a1234.jpg",
    "banner": "/uploads/store_banners/1731423600_673316d0b5678.jpg",
    "banner_url": "http://localhost/uploads/store_banners/1731423600_673316d0b5678.jpg",
    "theme_color": "#f97316",
    "custom_css": ".custom-header { background: blue; }",
    "whatsapp_number": "08105184157",
    "email": "houseofarastudio@yahoo.com",
    "phone": "08105184157",
    "address": "16, Odozi Street, Ojodu, Lagos, Nigeria",
    "description": "Head Office: 16, Odozie Street, Ojodu Berger",
    "currency": "NGN",
    "opening_hours": "9:00 AM",
    "closing_hours": "10:00 PM",
    "is_active": true,
    "social_media": {
      "facebook": null,
      "instagram": null,
      "twitter": null
    },
    "payment_methods": [],
    "delivery_options": {
      "pickup": true,
      "delivery": true,
      "deliveryFee": 4000
    },
    "seo_title": "NAILSHOP LAGOS - Best Nail Services",
    "seo_description": "Professional nail services in Lagos",
    "seo_keywords": "nail salon, lagos, beauty",
    "created_at": "2025-11-12T14:19:15.000000Z",
    "updated_at": "2025-11-12T14:20:46.000000Z"
  }
}
```

**Error Response (404)**:
```json
{
  "success": false,
  "message": "Store not found"
}
```

---

### 2. Get Store Configuration by Business ID (Admin)

Retrieve store configuration using the business ID. Requires authentication.

**Endpoint**: `GET /store/config/business/{business_id}`

**Authentication**: Required

**URL Parameters**:
- `business_id` (required): The business ID

**Example Request**:
```bash
curl -X GET "http://your-domain.com/connector/api/store/config/business/30" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {your_token}"
```

**Success Response (200)**:
```json
{
  "success": true,
  "data": {
    "id": 2,
    "business_id": 30,
    "store_name": "nailshop-lagos",
    "business_name": "NAILSHOP LAGOS",
    ...
  }
}
```

**Error Response (404)**:
```json
{
  "success": false,
  "message": "Store configuration not found"
}
```

---

### 3. Create Store Configuration (Admin)

Create a new store configuration for a business. Requires authentication.

**Endpoint**: `POST /store/config`

**Authentication**: Required

**Content-Type**: `multipart/form-data` (if uploading files) or `application/json`

**Request Body Parameters**:

| Parameter | Type | Required | Description | Example |
|-----------|------|----------|-------------|---------|
| business_id | integer | Yes | The business ID | 30 |
| store_name | string | Yes | URL-safe store name (lowercase, hyphens only) | nailshop-lagos |
| business_name | string | Yes | Display name of the business | NAILSHOP LAGOS |
| logo | file | No | Logo image (jpg, jpeg, png, gif, max 2MB) | - |
| banner | file | No | Banner image (jpg, jpeg, png, gif, max 2MB) | - |
| theme_color | string | No | Hex color code | #f97316 |
| whatsapp_number | string | No | WhatsApp contact number | 08105184157 |
| email | string | No | Contact email | contact@shop.com |
| phone | string | No | Contact phone number | 08105184157 |
| address | string | No | Physical address | 16, Odozi Street, Lagos |
| description | string | No | Store description | Welcome to our store |
| currency | string | No | Currency code (ISO 4217) | NGN |
| opening_hours | string | No | Opening hours | 9:00 AM |
| closing_hours | string | No | Closing hours | 10:00 PM |
| is_active | boolean | No | Store active status | true |
| social_media | string/JSON | No | Social media links as JSON | {"facebook": "url", "instagram": "@handle"} |
| payment_methods | string/JSON | No | Payment methods as JSON array | ["cash", "card", "bank_transfer"] |
| delivery_options | string/JSON | No | Delivery configuration as JSON | {"pickup": true, "delivery": true, "deliveryFee": 4000} |
| custom_css | string | No | Custom CSS for styling | .header { color: blue; } |
| seo_title | string | No | SEO page title | Best Shop in Lagos |
| seo_description | string | No | SEO meta description | Professional services |
| seo_keywords | string | No | SEO keywords | shop, lagos, beauty |

**Example Request (JSON)**:
```bash
curl -X POST "http://your-domain.com/connector/api/store/config" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{
    "business_id": 30,
    "store_name": "nailshop-lagos",
    "business_name": "NAILSHOP LAGOS",
    "theme_color": "#f97316",
    "whatsapp_number": "08105184157",
    "email": "houseofarastudio@yahoo.com",
    "phone": "08105184157",
    "address": "16, Odozi Street, Ojodu, Lagos, Nigeria",
    "currency": "NGN",
    "opening_hours": "9:00 AM",
    "closing_hours": "10:00 PM",
    "is_active": true,
    "social_media": "{\"facebook\": null, \"instagram\": null}",
    "delivery_options": "{\"pickup\": true, \"delivery\": true, \"deliveryFee\": 4000}"
  }'
```

**Example Request (with file upload - multipart/form-data)**:
```bash
curl -X POST "http://your-domain.com/connector/api/store/config" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {your_token}" \
  -F "business_id=30" \
  -F "store_name=nailshop-lagos" \
  -F "business_name=NAILSHOP LAGOS" \
  -F "logo=@/path/to/logo.jpg" \
  -F "banner=@/path/to/banner.jpg" \
  -F "theme_color=#f97316"
```

**Success Response (201)**:
```json
{
  "success": true,
  "message": "Store configuration created successfully",
  "data": {
    "id": 2,
    "business_id": 30,
    "store_name": "nailshop-lagos",
    "business_name": "NAILSHOP LAGOS",
    "logo": "/uploads/store_logos/1731423600_673316d0a1234.jpg",
    "logo_url": "http://localhost/uploads/store_logos/1731423600_673316d0a1234.jpg",
    "banner": "/uploads/store_banners/1731423600_673316d0b5678.jpg",
    "banner_url": "http://localhost/uploads/store_banners/1731423600_673316d0b5678.jpg",
    ...
  }
}
```

**Error Response (422)**:
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "store_name": ["The store name has already been taken."],
    "business_id": ["The business id has already been taken."]
  }
}
```

---

### 4. Update Store Configuration (Admin)

Update an existing store configuration. Requires authentication.

**Endpoint**: `PUT /store/config/{id}` or `POST /store/config/{id}`

**Note**: Use `POST` with `_method=PUT` when uploading files due to Laravel limitations with PUT and multipart/form-data.

**Authentication**: Required

**URL Parameters**:
- `id` (required): The store configuration ID

**Request Body Parameters**:

All parameters are optional. Only send the fields you want to update.

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| store_name | string | URL-safe store name | nailshop-lagos |
| business_name | string | Display name | NAILSHOP LAGOS UPDATED |
| logo | file | Logo image file | - |
| banner | file | Banner image file | - |
| theme_color | string | Hex color code | #3b82f6 |
| whatsapp_number | string | WhatsApp number | 08105184157 |
| email | string | Email address | contact@shop.com |
| phone | string | Phone number | 08105184157 |
| address | string | Physical address | 16, Odozi Street |
| description | string | Store description | Updated description |
| currency | string | Currency code | NGN |
| opening_hours | string | Opening hours | 8:00 AM |
| closing_hours | string | Closing hours | 10:00 PM |
| is_active | boolean | Active status | true |
| social_media | string/JSON | Social media links | {"facebook": "url"} |
| payment_methods | string/JSON | Payment methods | ["cash", "card"] |
| delivery_options | string/JSON | Delivery options | {"pickup": true} |
| custom_css | string | Custom CSS | .header { color: red; } |
| seo_title | string | SEO title | Updated title |
| seo_description | string | SEO description | Updated description |
| seo_keywords | string | SEO keywords | updated, keywords |

**Example Request (JSON)**:
```bash
curl -X PUT "http://your-domain.com/connector/api/store/config/2" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{
    "business_name": "NAILSHOP LAGOS - UPDATED",
    "theme_color": "#3b82f6",
    "description": "Updated description"
  }'
```

**Example Request (with file upload)**:
```bash
curl -X POST "http://your-domain.com/connector/api/store/config/2" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {your_token}" \
  -F "_method=PUT" \
  -F "business_name=NAILSHOP LAGOS" \
  -F "theme_color=#f97316" \
  -F "banner=@/path/to/new-banner.jpg" \
  -F "delivery_options={\"pickup\":true,\"delivery\":true,\"deliveryFee\":4000}"
```

**Success Response (200)**:
```json
{
  "success": true,
  "message": "Store configuration updated successfully",
  "data": {
    "id": 2,
    "business_id": 30,
    "store_name": "nailshop-lagos",
    "business_name": "NAILSHOP LAGOS - UPDATED",
    "theme_color": "#3b82f6",
    ...
  }
}
```

**Error Response (404)**:
```json
{
  "success": false,
  "message": "Store configuration not found"
}
```

**Error Response (422)**:
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "theme_color": ["The theme color format is invalid."]
  }
}
```

---

## Data Types and Formats

### Store Name
- Must be URL-safe (lowercase letters, numbers, and hyphens only)
- Unique across all stores
- Example: `nailshop-lagos`, `awesome-shop-123`

### Theme Color
- Must be a valid hex color code
- Format: `#RRGGBB`
- Example: `#f97316`, `#3b82f6`

### Currency
- Must be a valid ISO 4217 currency code (3 letters)
- Example: `NGN`, `USD`, `GBP`

### JSON Fields
Can be sent as either:
1. JSON string: `"{\"facebook\": \"url\"}"`
2. Parsed JSON object: `{"facebook": "url"}`

**Social Media Format**:
```json
{
  "facebook": "https://facebook.com/page",
  "instagram": "@username",
  "twitter": "@username",
  "linkedin": "https://linkedin.com/company"
}
```

**Payment Methods Format**:
```json
["cash", "card", "bank_transfer", "mobile_money"]
```

**Delivery Options Format**:
```json
{
  "pickup": true,
  "delivery": true,
  "deliveryFee": 4000
}
```

---

## File Upload Requirements

### Logo
- Formats: JPEG, JPG, PNG, GIF
- Max size: 2MB
- Recommended dimensions: 200x200px (square)

### Banner
- Formats: JPEG, JPG, PNG, GIF
- Max size: 2MB
- Recommended dimensions: 1200x400px (landscape)

### Upload Directory
- Files are stored in `/public/uploads/`
- Logos: `/public/uploads/store_logos/`
- Banners: `/public/uploads/store_banners/`

---

## Error Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created successfully |
| 400 | Bad request |
| 401 | Unauthenticated |
| 403 | Unauthorized |
| 404 | Resource not found |
| 422 | Validation error |
| 500 | Server error |

---

## Common Use Cases

### 1. Build a Public Storefront
Use the public endpoint to fetch store configuration:
```javascript
fetch('http://your-domain.com/connector/api/store/config/nailshop-lagos')
  .then(response => response.json())
  .then(data => {
    const config = data.data;
    // Apply theme color
    document.documentElement.style.setProperty('--theme-color', config.theme_color);
    // Apply custom CSS
    if (config.custom_css) {
      const style = document.createElement('style');
      style.textContent = config.custom_css;
      document.head.appendChild(style);
    }
  });
```

### 2. Admin Dashboard - Manage Store Settings
```javascript
// Fetch current configuration
const config = await fetch('http://your-domain.com/connector/api/store/config/business/30', {
  headers: {
    'Authorization': 'Bearer ' + token
  }
}).then(r => r.json());

// Update configuration
const formData = new FormData();
formData.append('_method', 'PUT');
formData.append('business_name', 'Updated Name');
formData.append('banner', bannerFile);

await fetch('http://your-domain.com/connector/api/store/config/' + config.data.id, {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer ' + token
  },
  body: formData
});
```

---

## Testing

You can test the endpoints using:
- Postman
- cURL
- Your favorite HTTP client

Make sure to:
1. Create a store configuration first before attempting to update
2. Use the correct authentication token for admin endpoints
3. Use proper content-type headers (multipart/form-data for files, application/json for JSON)

---

## Support

For issues or questions, please contact the development team or check the main API documentation.
