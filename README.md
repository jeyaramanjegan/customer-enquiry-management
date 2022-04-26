# customer-enquiry-management

## Overview

This is a Magento 2 Enquiry Management extension for Merchants to be able to have options to collect and manage customer’s enquiry from Magento Admin itself. It has the following features:

-	Enquiry form for customers to submit their enquiry
-	Admin Enquiry Management page to manage enquiries
-	Admin Email configuration for enquiries.

Supported Versions: form Magento 2.2

## Manual Installation

Extract the zip file in app > code > Jegan > Enquiry  

Then execute the setup upgrade commands

php bin/magento setup:upgrade

php bin/magento setup:di:compile

## Composer Installation

composer config repositories.jeyaramanjegan-customer-enquiry-management git "https://github.com/jeyaramanjegan/customer-enquiry-management.git"

composer require jegan/customer-enquiry-management dev-master

Then execute the setup upgrade commands

php bin/magento setup:upgrade

php bin/magento setup:di:compile

**Features Included**

**1. JEGANS ENQUIRY **

![image-1](https://user-images.githubusercontent.com/48308523/163392588-b5e0b0e9-adb7-4b4d-8678-bb8ed13a3145.png)

**2. Enable the Extension and settings**

Its having Customer Enquiry Email template as well as Admin Reply Email Template

Admin > JEGANS ENQUIRY > Settings > Enquiry form

![image-2](https://user-images.githubusercontent.com/48308523/163393086-624bdc59-926e-442e-9728-c83a20dd0a51.png)

**3. Customer Enquiry form **

![image-3](https://user-images.githubusercontent.com/48308523/163393302-526bafcf-5ac3-4619-8aed-75ef7a67cd3a.png)

**4. Admin Grid Features **

Admin > JEGANS ENQUIRY > Customer Enquiry

![image-4](https://user-images.githubusercontent.com/48308523/163393496-b937c25e-197b-4c85-a2c0-acef0c20f4bc.png)

**5. Create New Enquiry by Merchants (Backoffice)**

Admin > JEGANS ENQUIRY > Customer Enquiry > Add New Contact List

![image-8](https://user-images.githubusercontent.com/48308523/163394064-37b09cb9-8509-42bc-8bcf-c0ebf359cf32.png)

**Admin Enquiry form**

![image-5](https://user-images.githubusercontent.com/48308523/163394100-57310464-7610-408d-aee7-f63dd45869cd.png)

**6. Admin Email for enquiries**

Admin > JEGANS ENQUIRY > Customer Enquiry > Action > Select > Reply

![image-6](https://user-images.githubusercontent.com/48308523/163394344-d54a6687-a1f7-4ce2-9363-8f4ff6b2ef8b.png)

**Admin Email form**

![image-7](https://user-images.githubusercontent.com/48308523/163394541-d2f3e7f9-b0f6-4aab-a25f-9cf987de51d1.png)

**Admin Email to Customer**

![Email-to-customer](https://user-images.githubusercontent.com/48308523/165077271-53b4ec09-7fb5-4cc0-8169-535896e682a9.png)



