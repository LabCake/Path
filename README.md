# Path
A class made in PHP7 inspired by nodes path module, for modified and creating path strings, aswell as read folder/file information

Resolve path
```php
// This will return a path to /hello/world
Path::resolve("hello", "world");
```

Basename
```php
Path::resolve("test.php");
```

Dirname
```php
Path::dirname("/var/www/test.php");
```

Extension name
```php
Path::extname("test.php");
```

Parse
```php
Path::parse("test.php");
```

Exists
```php
Path::exists("test.php");
```

Create directory
```php
// This will create all the folders needed untill the last one is created
Path::mkdir("/this/is/a/path/to/create");
```

Remove directory
```php
// This will remove all the subfolders and files in the selected path recursively
Path::rmdir("/remove/this/folder");
```


Documentation not yet complete