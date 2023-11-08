# M2Commerce: Magento 2 Bulk Add to Cart

## Description
This extension allows customers to add products in the cart in bulk from listing, search and advanced search pages
You can enable and disable the feature from admin configuration.

## Configuration

There are several configuration options for this extension, which can be found at **STORES > Configuration > Commerce Enterprise > Bulk Add to Cart**.

## Installation
### Magento® Marketplace

This extension will also be available on the Magento® Marketplace when approved.

1. Go to Magento® 2 root folder
2. Require/Download this extension:

   Enter following commands to install extension.

   ```
   composer require m2commerce/bulk-add-to-cart"
   ```

   Wait while composer is updated.

   #### OR

   You can also download code from this repo under Magento® 2 following directory:

    ```
    app/code/M2Commerce/BulkAddToCart
    ```    

3. Enter following commands to enable the module:

   ```
   php bin/magento module:enable M2Commerce_BulkAddToCart
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:clean
   php bin/magento cache:flush
   ```

4. If Magento® is running in production mode, deploy static content:

   ```
   php bin/magento setup:static-content:deploy
   ```
