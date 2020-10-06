# Bespoke Demo Module for Magento 2
This module aims to do 1 thing - export today's orders with specific fields to a CSV format. The module is supposed to be very basic, and it's purpose is to showcase the basic skills needed to develop a Magento 2 module.

To use the module, create a folder in ```app/code``` titled ```AlexGlover```, and pull the module into that folder. You can then enable it with ```php bin/magento module:enable AlexGlover_OrderExportDemo```.

To export the CSV, go to the main menu and click the "Sales" sub menu, and then click the "Exporter" menu item underneath "Order Export Demo". A button in the top right will be presented to the user to allow them to quickly get the aforementioned CSV of todays orders.
