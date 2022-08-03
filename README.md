# Magento 2 Company Accounts GraphQL

## 1. How to install

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-company-accounts-graphql
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

**Note:**
Mageplaza Company Accounts GraphQL requires installing [Mageplaza Company Accounts](https://www.mageplaza.com/magento-2-company-accounts-extension/) in your Magento installation.

## 2. How to use

To perform GraphQL queries in Magento, please do the following requirements:

- Use Magento 2.3.x or higher. Set your site to [developer mode](https://www.mageplaza.com/devdocs/enable-disable-developer-mode-magento-2.html).
- Set GraphQL endpoint as `http://<magento2-server>/graphql` in url box, click **Set endpoint**. 
(e.g. `http://dev.site.com/graphql`)
- To view the queries that the **Mageplaza Company Accounts GraphQL** extension supports, you can look in `Docs > Query` in the right corner

## 3. Devdocs

- [Company Accounts API & examples](https://documenter.getpostman.com/view/10589000/Tz5ncyZC#c58a2ad3-a5be-4a18-ac0e-ab1353e1faf0)
- [Company Accounts GraphQL & examples](https://documenter.getpostman.com/view/10589000/Tz5ncyZE#3b8a65ab-511b-45dd-99e3-2df4b09fb947)

Click on Run in Postman to add these collections to your workspace quickly.

![Magento 2 blog graphql pwa](https://i.imgur.com/lhsXlUR.gif)

## 4. Contribute to this module

Feel free to **Fork** and contribute to this module and create a pull request so we will merge your changes main branch.

## 5. Get Support

- Feel free to [contact us](https://www.mageplaza.com/contact.html) if you have any further questions.
- Like this project, Give us a **Star** ![star](https://i.imgur.com/S8e0ctO.png)