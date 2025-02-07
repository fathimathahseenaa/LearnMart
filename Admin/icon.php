<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard with Floating + Icon</title>
  <style>
    /* Basic Reset */
    body, html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      height: 100%;
      overflow-x: hidden;
    }

    /* Dashboard Page Styling */
    #dashboard {
      padding: 20px;
    }

    /* Floating + Icon */
    #plus-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #28a745;  /* Change icon color */
      color: white;
      padding: 20px;  /* Increased padding for a larger button */
      border-radius: 50%;  /* Ensure the icon is circular */
      font-size: 30px; /* Font size of the "+" symbol */
      cursor: pointer;
      z-index: 100;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Options Menu */
    #options-menu {
      position: fixed;
      bottom: 95px; /* Increased the space between the icon and options */
      right: 50px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      z-index: 99;
      display: none;
    }

    #options-menu ul {
      list-style: none;
      padding: 10px;
      margin: 0;
    }

    #options-menu ul li {
      padding: 10px;
      cursor: pointer;
      text-align: center;
    }

    #options-menu ul li:hover {
      background-color:rgb(129, 188, 143);
    }
  </style>
</head>
<body>

  <div id="dashboard">
    <h1>Welcome to your Dashboard</h1>
    <p>Click the + icon to create or update something.</p>
  </div>

  <!-- Floating + Icon -->
  <div id="plus-icon">
    +
  </div>

  <!-- Options Menu -->
  <div id="options-menu">
    <ul>
      <li id="create-option">Create</li>
      <li id="update-option">Update</li>
    </ul>
  </div>

  <script>
    // Get references to elements
    const plusIcon = document.getElementById('plus-icon');
    const optionsMenu = document.getElementById('options-menu');
    const createOption = document.getElementById('create-option');
    const updateOption = document.getElementById('update-option');

    // Function to toggle the visibility of the options menu
    plusIcon.addEventListener('click', function () {
      optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Navigate to the Create or Update page
    createOption.addEventListener('click', function () {
      window.location.href = '/create-page'; // Replace with your create page URL
    });

    updateOption.addEventListener('click', function () {
      window.location.href = '/update-page'; // Replace with your update page URL
    });
  </script>

</body>
</html>
