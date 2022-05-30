<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail</title>
</head>
<body>
    <h1>Mail inviata da {{ $lead->name }}</h1>
    <h2>Indirizzo mail: {{ $lead->email }}</h2>
    <h2>Testo:</h2>
    <h3>{{ $lead->message }}</h3>
    
</body>
</html>