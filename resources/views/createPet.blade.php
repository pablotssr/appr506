<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Pet</title>
</head>
<body>
    <h1>Create Pet</h1>
    <form action="{{ route('pets.store') }}" method="post">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <button type="submit">Create Pet</button>
    </form>
</body>
</html>