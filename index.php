<?php
if (isset($_GET['key'])) {
    $key = strtolower($_GET['key']);
    $data = json_decode(file_get_contents('urls.json'), true);

    if (isset($data[$key])) {
        header("Location: " . $data[$key]);
        exit;
    } else {
        echo "Invalid key.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h1 class="text-2xl font-bold mb-4 text-center">URL Shortener</h1>
    <form id="urlForm" class="space-y-4">
        <input
                type="url"
                name="url"
                id="urlInput"
                placeholder="https://example.com"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
        >
            Shorten URL
        </button>
    </form>
    <div id="result" class="mt-4 text-center text-green-600 font-semibold"></div>
</div>

<script>
    const form = document.getElementById('urlForm');
    const input = document.getElementById('urlInput');
    const result = document.getElementById('result');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        result.textContent = "Creating link...";

        try {
            const response = await fetch('save.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({url: input.value})
            });

            const text = await response.text();
            result.innerHTML = text;
            input.value = '';
        } catch (err) {
            result.textContent = "Error creating link. Try again.";
        }
    });
</script>
</body>
</html>