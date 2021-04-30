# Product Order System API [PHP]
Product Order System PHP API. Manage product and orders, tracking order status.

```
git clone https://github.com/RakibDevs/php-order-api.git
```

Create a Database and Run `product-order.sql` SQL.

Open `Config/DB.php` and update credentials,
```
$this->host     = "localhost";
$this->database = "order";
$this->username = "root";
$this->password = "";
```
API Documentation: https://documenter.getpostman.com/view/11223504/TzRLkAWw

Response Example,

```
{
    "status": "success",
    "message": "Products",
    "data": [
        {
            "id": "1",
            "title": "Happy Addons",
            "sku": "WE001",
            "category_id": "1",
            "description": "Powerful elementor widgets to create websites",
            "price": "39",
            "image": "/assets/images/ha.svg",
            "created_by": null,
            "created_at": null,
            "updated_at": null,
            "category_name": "WordPress"
        },
        {
            "id": "2",
            "title": "WP ERP",
            "sku": "WE002",
            "category_id": "1",
            "description": "Automate your business or company operation",
            "price": "156",
            "image": "/assets/images/erp.svg",
            "created_by": null,
            "created_at": null,
            "updated_at": null,
            "category_name": "WordPress"
        },
        
    ]
}

