# develop

## debugging from vscodium to browser

web site: https://code.visualstudio.com/docs/nodejs/browser-debugging

Browser needs to be launched in debug mode

```
edge.exe --remote-debugging-port=9222 --user-data-dir=remote-debug-profile
```

"C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe"


`vscode/launch.json`
```
{
  "version": "0.2.0",
  "configurations": [
    {
      "type": "msedge",
      "request": "attach",
      "name": "Attach to browser",
      "port": 9222
    }
  ]
}
```

## Cache Control

php
```php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
```

.htaccess
```.htaccess
<IfModule mod_headers.c>
    Header set Cache-Control "no-cache, no-store, must-revalidate"
    Header set Pragma "no-cache"
    Header set Expires 0
</IfModule>
```

html
```html
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
```
