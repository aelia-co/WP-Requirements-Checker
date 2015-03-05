# Aelia_WP_Requirements_Checker
A handy class to allow plugins to check for missing requirements and gracefully inform the site administrator when they are not met.

# How it works
The class is designed to be inherited and extended by adding the requirements of a specific plugin. The descendant class will only have to declare the requirements as properties. A single call to the `check_requirements()` method will verify everything and, if necessary, inform the administrator of any missing requirement.

### Important
The class is designed to execute the requirement checks **every time the plugin is loaded**. This is done on purpose, as it happened multiple times that customers "accidentally" removed requirements after installing them, because they forgot what they were for. When that happened, a plugin that passed the requirement checks during activation crashed miserably. This is the type of incident we must avoid, and the only way to do so is, to use a metaphor, "*checking that the chair is there every time we want to sit on it*".

The performance impact of such approach is negligible, as the only heavy operation is the retrieval of the installed plugins, for dependency checking. The base class is shared by its descendants, and the plugin list is cached, therefore such operation occurs only once.

# Usage
Using the class is simple, and it requires a few steps.

## 1. Add the following files in your plugin
* `aelia-wp-requirementscheck.php`. This is the main file, containing the requirement checking logic.
* `aelia-install.js`. This file contains some JavaScript to perform the automatic installation of required plugins via Ajax. You can put it anywhere in your plugin folder, as long as it can be accessed by the browser.

## 2. Write your subclass
Using file `aelia-wp-sample-plugin-requirementscheck.php` as a starting point, implement your custom class to check the plugin requirements. Make sure that you set the `$js_dir` property to the path where you save the `aelia-install.js` file, or automatic installation and activation of plugins won't work.

## 3. Write your main plugin files as follows
~~~
// Load your custom requirement checking class
require_once(dirname(__FILE__) . '/path/to/your-requirementchecks-file.php');

if(Your_RequirementChecks_Class::factory()->check_requirements()) {
	/* Write your plugin main code here. This code will be executed only if all
	 * requirements are met.
	 */
}
~~~

## 4. Done! Time for testing
If you did everything correctly, your plugin should now show one or more messages when the requirements are missing. Please note that a plugin whose requirements are missing **will stay active**, but it won't actually load itself (see step #3). This is a useful feature, as the plugin will automatically "come to life" as soon as the requirements are met, without having to activate it again manually.

# Who is using the library?
This class, with some changes for the respective ecommerce systems, is used by  [our plugins for WooCommerce](http://aelia.co/shop/product-category/woocommerce/) and [Easy Digital downloads](http://aelia.co/shop/product-category/easy-digital-downloads-2/), which count thousands of installations globally. It's also part of our flexible framework plugins, the [Aelia Foundation Classes for WooCommerce](http://aelia.co/downloads/wc-aelia-foundation-classes.zip) and [Easy Digital Downloads](http://aelia.co/downloads/edd-aelia-foundation-classes.zip).

If you would like to see it in action, you can try our free [EU VAT Assistant](https://wordpress.org/plugins/woocommerce-eu-vat-assistant/), a powerful plugin that helps with compliance with the new EU VAT regulations, and our free [Skrill/Moneybookers Payment Gateway](https://wordpress.org/plugins/woocommerce-skrill-moneybookers-gateway/), both for WooCommerce.

# Notes, caveats, etc

### Due diligence information
This library was written for internal use by the [Aelia Team](http://aelia.co) and it was made public after a request posted on the [Advanced WordPress Facebook group](https://www.facebook.com/groups/advancedwp/914294188632796/). Due to that, it may contain some bugs that are related to its initial design.

### Multiple versions of the base class on the same site
On any website it's possible to have multiple plugins that rely on this class for requirement checking. It's not possible to determine which plugin will load it first, therefore it's also not possible to determine which version of the class will be loaded. Perhaps your plugin uses version 1.5.5, but someone else's plugin uses version 1.5.3.

At [Aelia](http://aelia.co/), backward compatibility is a must, and, unless the base class was modified, **it should not cause any issue**. Based on our tests, the only side effect of having an older version loaded before a new one is that some features are missing, or that different messages are displayed. The logic used to check the requirements does not change.

### Coding standards
You will find that our class doesn't follow all WordPress coding standards. We are aware of that, it was a deliberate choice. The library was designed to be used internally, and we adopted coding standards that work best for us. In any case, you should not have to modify the base class to use it in your plugins, you can include it as is.
