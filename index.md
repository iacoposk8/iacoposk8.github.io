<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ site.title }}</title>
</head>
<body>
    <header>
        <h1>{{ site.title }}</h1>
        <p>{{ site.description }}</p>
    </header>
    <main>
        <h2>Welcome to my site</h2>
        <p>This is the main content of the site.</p>
    </main>
    <footer>
        <p>&copy; {{ site.time | date: '%Y' }} {{ site.title }}. All rights reserved.</p>
    </footer>
</body>
</html>