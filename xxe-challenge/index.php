<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlData = $_POST['xmlInput'];

    // Allow external entities (for older PHP versions)
    libxml_disable_entity_loader(false);
    
    $dom = new DOMDocument();
    // Load XML with options to resolve entities and load DTD
    if (!$dom->loadXML($xmlData, LIBXML_NOENT | LIBXML_DTDLOAD)) {
        die("<p style='color: #ff0066;'>❌ Invalid XML document!</p>");
    }

    // Convert DOM to SimpleXML for easier access
    $vaultData = simplexml_import_dom($dom);
    
    // Fake "Processing" delay (for realism)
    sleep(2);

    // Output the content of the root element (data) with black text
    echo "<div style='text-align: center; font-family: \"Poppins\", sans-serif; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 0 20px rgba(255, 0, 102, 0.5);'>";
    echo "<h2 style='color: #00ff99;'>✅ Document Processed Successfully!</h2>";
    echo "<p style='color: #000000;'><strong>Security Log ID:</strong> " . htmlspecialchars($vaultData) . "</p>";
    echo "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureDoc Validator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000000, #1a0033); /* Black to deep purple */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: rgba(0, 0, 0, 0.8); /* Dark semi-transparent */
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(255, 0, 102, 0.5); /* Neon pink shadow */
            max-width: 650px;
            width: 100%;
            border: 2px solid #ff00ff; /* Bright magenta border */
        }
        h2 {
            color: #00ff99; /* Neon green */
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 8px rgba(0, 255, 153, 0.8); /* Glowing green shadow */
        }
        p {
            color: #ffff00; /* Bright yellow */
            font-size: 16px;
        }
        .upload-box {
            background: rgba(255, 0, 102, 0.1); /* Neon pink tint */
            padding: 30px;
            border-radius: 15px;
            border: 3px dashed #ff0066; /* Hot pink dashed */
            transition: border-color 0.3s ease;
        }
        .upload-box:hover {
            border-color: #00ff99; /* Neon green on hover */
        }
        textarea {
            width: 100%;
            height: 180px;
            padding: 15px;
            border: 2px solid #ff00ff; /* Magenta border */
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.5); /* Darker bg */
            color: #00ffff; /* Cyan text */
            font-size: 14px;
            resize: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        textarea:focus {
            border-color: #ffff00; /* Yellow on focus */
            box-shadow: 0 0 15px rgba(255, 255, 0, 0.8); /* Bright yellow glow */
        }
        button {
            background: linear-gradient(90deg, #ff0066, #ff00ff); /* Pink to magenta */
            color: #00ffff; /* Cyan text */
            padding: 14px;
            border: none;
            border-radius: 50px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-top: 20px;
            text-transform: uppercase;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 0, 102, 0.8); /* Neon pink glow */
            background: linear-gradient(90deg, #00ff99, #00ffff); /* Green to cyan */
        }
        .loading {
            display: none;
            font-size: 18px;
            color: #ff00ff; /* Magenta spinner */
            margin-top: 20px;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }
        .hint {
            margin-top: 25px;
            font-size: 18px; /* Bigger text */
            color: #ff00ff; /* Neon magenta */
            font-weight: 700; /* Bold */
            text-transform: uppercase; /* All caps */
        }
        .hint a {
            display: inline-block; /* For box styling */
            padding: 4px 12px; /* Box padding */
            background: #ffffff; /* White background */
            color: #ff0066; /* Hot pink text */
            text-decoration: underline; /* Underlined */
            border: 2px solid #00ffff; /* Cyan border */
            border-radius: 8px; /* Rounded corners */
            font-size: 20px; /* Slightly bigger */
            font-weight: 900; /* Extra bold */
            text-shadow: 0 0 5px rgba(255, 0, 102, 0.8); /* Pink glow */
            animation: rabbitHole 1.5s infinite alternate; /* Pulsing effect */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hint a:hover {
            transform: scale(1.1); /* Zoom on hover */
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.8), 0 0 30px rgba(255, 0, 102, 0.8); /* Cyan and pink glow */
            background: #ffff00; /* Yellow background on hover */
            color: #ff00ff; /* Magenta text on hover */
        }
        @keyframes rabbitHole {
            0% { transform: scale(1); box-shadow: 0 0 10px rgba(0, 255, 255, 0.5); }
            100% { transform: scale(1.05); box-shadow: 0 0 20px rgba(255, 0, 102, 0.8); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-lock"></i> SecureDoc XML Validator</h2>
        <p>Validate your XML with maximum swagger!</p>

        <div class="upload-box">
            <form method="POST" action="" id="docForm">
                <textarea name="xmlInput" placeholder="Drop your XML here, bro!"></textarea>
                <button type="submit">Validate Document</button>
            </form>
        </div>

        <p class="loading"><i class="fas fa-spinner fa-spin"></i> Processing...</p>

        <p class="hint">🔒 Admin-only <a href="/admin">reports</a> are lit!</p>
    </div>

    <script>
        document.getElementById('docForm').addEventListener('submit', function() {
            document.querySelector('.loading').style.display = 'block';
        });
    </script>
</body>
</html>
