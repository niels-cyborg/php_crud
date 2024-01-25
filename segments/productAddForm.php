<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      padding: 20px;
    }

    h2 {
      color: #333;
      margin-top: 5vh;
    }

    form {
      background-color: #fff;
      margin-top: 5vh;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      resize: vertical;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h2>Producten toevoegen.</h2>
  <form action="productAdd.php" method="POST">
    <label for="titel">Titel:</label>
    <input type="text" id="titel" name="titel" required><br><br>

    <label for="beschrijving">Beschrijving:</label>
    <textarea id="beschrijving" name="beschrijving" required></textarea><br><br>

    <label for="inhoud">Inhoud:</label>
    <textarea id="inhoud" name="inhoud" required></textarea><br><br>

    <input type="submit" value="Toevoegen">
  </form>
</body>
</html>
