# uniqueID
Youtube-like IDs with PHP

### Usage

```php
// Include uniqueID.php
require_once("uniqueID.php");

// Create an instance of uniqueID
$uniqueID = new uniqueID();

// Generate an ID
$id = $uniqueID->generate();
echo $id; // 2398161031202658563

// Shorten an ID
$shortId = $uniqueID->shorten($id);
echo $shortId; // f63GFpTjuJQ

// Expand an ID
$id = $uniqueID->expand($shortId);
echo $id; // 2398161031202658563
```

### Options

```php
// Generate an ID within a specific range
$id = $uniqueID->generate(0, 1000000);
echo $id; // 807657

// Shorten an ID with a little bit of salt
$salt = "Kd7afD8dDKJ";
$shortId = $uniqueID->shorten($id, $salt);
echo $shortId; // 7cPX

// Expand an ID with a little bit of salt
$id = $uniqueID->expand($shortId, $salt);
echo $id; // 807657
```
