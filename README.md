![Screenshot](https://github.com/tomatophp/tomato-builder/blob/master/art/screenshot.png)

# Tomato builder

Schema Digram Builder to convert digram to full dashboard and flutter apps CRUDs

## Installation

```bash
composer require tomatophp/tomato-builder
```
after install your package please run this command

```bash
php artisan tomato-builder:install
```

add node packages

```bash
yarn add @vue-flow/background @vue-flow/core @vue-flow/node-toolbar 
```

```bash
yarn build
```

add this line to your app.js

```js

import TomatoDiagram from "../../vendor/tomatophp/tomato-builder/resources/js/components/TomatoDiagram.vue";


createApp({
    render: renderSpladeApp({ el })
})
    .use(SpladePlugin, {
        max_keep_alive: 10,
        transform_anchors: false,
        progress_bar: true,
    })
    .component("TomatoDiagram", TomatoDiagram)
    ...
    .mount(el);

```



## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="tomato-builder-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="tomato-builder-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="tomato-builder-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="tomato-builder-migrations"
```

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/VZc8nBJ3ZU)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/plugins/laravel-package-generator)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
