<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <label>Title:</label><br>
        <input type="text" name="title"><br>
        <label>Image URL:</label><br>
        <input type="text" name="image"><br>
        <label>Description:</label><br>
        <textarea name="description"></textarea><br>
        <button type="submit">Create Post</button>
    </form>
</body>
</html>
