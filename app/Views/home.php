<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teflo Framework</title>
  <style>
    :root {
      --bg-color: #f0f4f8;
      --text-color: #1e293b;
      --card-bg: #ffffff;
      --button-bg: #6366f1;
      --button-text: #ffffff;
    }

    [data-theme="dark"] {
      --bg-color: #0f172a;
      --text-color: #f1f5f9;
      --card-bg: #1e293b;
      --button-bg: #38bdf8;
      --button-text: #0f172a;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 40px 20px;
      min-height: 100vh;
      transition: background 0.3s, color 0.3s;
    }

    .container {
      background-color: var(--card-bg);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      width: 100%;
      text-align: center;
      transition: background 0.3s;
    }

    h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    .badge {
      background: var(--button-bg);
      color: var(--button-text);
      padding: 6px 14px;
      font-size: 0.9rem;
      border-radius: 9999px;
      font-weight: bold;
      display: inline-block;
      margin-bottom: 20px;
    }

    .button {
      background: var(--button-bg);
      color: var(--button-text);
      border: none;
      padding: 10px 16px;
      border-radius: 9999px;
      cursor: pointer;
      margin-top: 20px;
      font-weight: bold;
    }

    .getting-started {
      text-align: left;
      margin-top: 30px;
    }

    pre {
      background-color: #e2e8f0;
      padding: 10px;
      border-radius: 8px;
      overflow-x: auto;
    }

    [data-theme="dark"] pre {
      background-color: #334155;
    }
  </style>
</head>
<body>
  <div class="container" id="theme-container">
    <span class="badge">Teflo PHP Framework</span>
    <h1>Welcome to Teflo!</h1>
    <p>A lightweight and fast PHP framework designed for simplicity 🚀</p>

    <button class="button" onclick="toggleTheme()">Toggle Dark/Light Theme</button>

    <div class="getting-started">
      <h2>🚀 Getting Started</h2>
      <p>To run your Teflo project locally:</p>
      <pre><code>composer install
php -S localhost:8000 -t public</code></pre>

      <p>Then visit <strong>http://localhost:8000</strong> in your browser.</p>

      <p>Edit your routes in <code>routes/web.php</code></p>
      <p>Edit views in <code>app/Views/</code></p>
      <p>Add controllers in <code>app/Controllers/</code></p>
    </div>
  </div>

  <script>
    function toggleTheme() {
      const currentTheme = document.body.getAttribute('data-theme');
      document.body.setAttribute('data-theme', currentTheme === 'dark' ? 'light' : 'dark');
    }

    // Optional: remember theme
    if (!document.body.getAttribute('data-theme')) {
      document.body.setAttribute('data-theme', 'light');
    }
  </script>
</body>
</html>
