# AddMenu
## The plugin to add custom Nav in my custom theme

activate this plugin and add code in place if you need
```php
<?php if(Utils::isPluginAvailable('AddMenu')): ?>
    <?php \TypechoPlugin\AddMenu\Plugin::render(); ?>
<?php endif; ?>
``` 