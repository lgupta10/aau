<?php
$page_title = $page_title ?? 'LG Cool Store - Streetwear Essentials';
$page_description = $page_description ?? 'Shop affordable streetwear essentials.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($page_description) ?>">
    <title><?= e($page_title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Space+Grotesk:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
```

3. **Create `header.php`** - I'll give you this code next
4. **Create `footer.php`** - I'll give you this code next

### **Step 3: Create main PHP files**

In the root folder `C:\Users\gupta\aau\wnm608\gupta.lupanch\`:

- `index.php`
- `products.php`
- `product_detail.php`
- `cart.php`
- `sale.php`
- `about.php`
- `contact.php`
- etc.

## 🎯 **Final Structure Should Look Like:**
```
C:\Users\gupta\aau\wnm608\gupta.lupanch\
├── index.php                    ← Create here
├── products.php                 ← Create here
├── product_detail.php           ← Create here
├── cart.php                     ← Create here
├── sale.php                     ← Create here
├── about.php                    ← Create here
├── contact.php                  ← Create here
├── parts\
│   ├── functions.php            ← Create here
│   ├── meta.php                 ← Create here
│   ├── header.php               ← Create here
│   └── footer.php               ← Create here
├── css\
│   └── styles.css               ← Already exists
├── js\
│   └── main.js                  ← Already exists
└── images\                      ← Already exists