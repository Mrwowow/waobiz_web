# Database Schema for Store Configurations

This directory contains database migration files and schema documentation for the Store Configuration feature.

## Table: `store_configurations`

Stores public storefront configuration settings that allow businesses to create and customize their online store.

### Schema Overview

| Column | Type | Description | Constraints |
|--------|------|-------------|-------------|
| `id` | BIGINT/BIGSERIAL | Primary key | Auto-increment |
| `business_id` | INTEGER | Reference to business in main system | UNIQUE, NOT NULL |
| `store_name` | VARCHAR(255) | URL slug for the store (e.g., "awesome-shop") | UNIQUE, NOT NULL |
| `business_name` | VARCHAR(255) | Display name of the business | NOT NULL |
| `logo` | TEXT | URL or path to logo image | NULL |
| `banner` | TEXT | URL or path to banner image | NULL |
| `theme_color` | VARCHAR(7) | Hex color code for theme | DEFAULT '#f97316' |
| `whatsapp_number` | VARCHAR(20) | WhatsApp contact number | NULL |
| `email` | VARCHAR(255) | Contact email address | NULL |
| `phone` | VARCHAR(20) | Contact phone number | NULL |
| `address` | TEXT | Physical address | NULL |
| `description` | TEXT | Store description | NULL |
| `currency` | VARCHAR(3) | Currency code (ISO 4217) | DEFAULT 'NGN' |
| `opening_hours` | VARCHAR(50) | Store opening hours | NULL |
| `closing_hours` | VARCHAR(50) | Store closing hours | NULL |
| `is_active` | BOOLEAN/TINYINT | Store active status | DEFAULT TRUE/1 |
| `social_media` | JSON/JSONB | Social media links | NULL |
| `payment_methods` | JSON/JSONB | Available payment methods | NULL |
| `delivery_options` | JSON/JSONB | Delivery configuration | NULL |
| `custom_css` | TEXT | Custom CSS for advanced styling | NULL |
| `seo_title` | VARCHAR(255) | SEO page title | NULL |
| `seo_description` | TEXT | SEO meta description | NULL |
| `seo_keywords` | TEXT | SEO keywords | NULL |
| `created_at` | TIMESTAMP | Record creation timestamp | DEFAULT CURRENT_TIMESTAMP |
| `updated_at` | TIMESTAMP | Record update timestamp | AUTO UPDATE |

### JSON Column Structures

#### `social_media`
```json
{
  "facebook": "https://facebook.com/yourpage",
  "instagram": "@yourusername",
  "twitter": "@yourusername",
  "linkedin": "https://linkedin.com/company/yourcompany"
}
```

#### `payment_methods`
```json
["cash", "card", "bank_transfer", "mobile_money", "paypal"]
```

#### `delivery_options`
```json
{
  "pickup": true,
  "delivery": true,
  "deliveryFee": 500
}
```

### Indexes

- `PRIMARY KEY` on `id`
- `UNIQUE` constraint on `store_name`
- `UNIQUE` constraint on `business_id`
- Index on `store_name` for fast lookups
- Index on `is_active` for filtering active stores
- Index on `business_id` for business-based queries

## Migration Files

### MySQL/MariaDB
Use: `database/migrations/create_store_configurations_table.sql`

```bash
mysql -u username -p database_name < database/migrations/create_store_configurations_table.sql
```

### PostgreSQL
Use: `database/migrations/create_store_configurations_table_postgresql.sql`

```bash
psql -U username -d database_name -f database/migrations/create_store_configurations_table_postgresql.sql
```

### Prisma
The schema is defined in `prisma/schema.prisma` as the `StoreConfiguration` model.

To apply the schema:
```bash
npx prisma migrate dev --name add_store_configurations
npx prisma generate
```

## Usage Example

### Creating a Store Configuration

```typescript
import { prisma } from '@/lib/prisma';

const storeConfig = await prisma.storeConfiguration.create({
  data: {
    businessId: 1,
    storeName: 'awesome-shop',
    businessName: 'Awesome Shop',
    logo: 'https://example.com/logo.png',
    themeColor: '#3b82f6',
    whatsappNumber: '+1234567890',
    email: 'contact@awesomeshop.com',
    phone: '+1234567890',
    address: '123 Main St, City, Country',
    description: 'Welcome to our online store',
    currency: 'USD',
    isActive: true,
    socialMedia: {
      facebook: 'https://facebook.com/awesomeshop',
      instagram: '@awesomeshop'
    },
    paymentMethods: ['cash', 'card', 'bank_transfer'],
    deliveryOptions: {
      pickup: true,
      delivery: true,
      deliveryFee: 10
    }
  }
});
```

### Retrieving Store Configuration

```typescript
// By store name (for public access)
const config = await prisma.storeConfiguration.findUnique({
  where: { storeName: 'awesome-shop' }
});

// By business ID
const config = await prisma.storeConfiguration.findUnique({
  where: { businessId: 1 }
});

// Get all active stores
const activeStores = await prisma.storeConfiguration.findMany({
  where: { isActive: true }
});
```

### Updating Store Configuration

```typescript
const updated = await prisma.storeConfiguration.update({
  where: { storeName: 'awesome-shop' },
  data: {
    themeColor: '#10b981',
    description: 'Updated store description'
  }
});
```

## API Integration

### Public Endpoint (No Authentication Required)
```
GET /api/store/config/:storeName
```

Returns the store configuration for the given store name.

### Admin Endpoints (Authentication Required)
```
POST   /api/store/config         - Create new store configuration
PUT    /api/store/config/:id     - Update store configuration
DELETE /api/store/config/:id     - Delete store configuration
GET    /api/store/config         - Get all store configurations (admin)
```

## Security Considerations

1. **Public Access**: The store configuration is intentionally public to allow anyone to view the storefront.
2. **Write Protection**: Only authenticated admin users should be able to create/update/delete store configurations.
3. **Validation**: Always validate `store_name` to ensure it's URL-safe (lowercase, hyphens only).
4. **XSS Prevention**: Sanitize `custom_css` field to prevent XSS attacks.
5. **Rate Limiting**: Implement rate limiting on public endpoints to prevent abuse.

## Best Practices

1. **Store Name Format**: Use lowercase with hyphens (e.g., `my-awesome-store`)
2. **Image URLs**: Store full URLs or relative paths consistently
3. **Currency Codes**: Use ISO 4217 currency codes (3 letters)
4. **Phone Numbers**: Store in international format (e.g., `+1234567890`)
5. **Theme Colors**: Always use hex color codes (e.g., `#f97316`)
6. **JSON Validation**: Validate JSON structures before saving
7. **Soft Delete**: Consider using `is_active = false` instead of hard deleting records

## Troubleshooting

### Unique Constraint Violations
If you get a unique constraint error on `store_name` or `business_id`, it means:
- A store with that name already exists
- A business already has a store configuration

### JSON Parse Errors
Ensure JSON columns contain valid JSON:
```typescript
// Good
socialMedia: { facebook: "https://..." }

// Bad
socialMedia: "facebook: https://..." // This is a string, not JSON
```

## Migration History

- **2024-11-10**: Initial creation of `store_configurations` table
