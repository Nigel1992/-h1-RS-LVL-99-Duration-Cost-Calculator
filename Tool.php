<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuneScape duration/price calculator for level 99 in any skill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .result h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .result p {
            margin: 5px 0;
        }

        .error {
            color: #f00;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>RuneScape Level 99 Duration & Cost Calculator</h1>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"><br>

    <label for="xp_per_hour">XP per Hour:</label>
    <input type="number" name="xp_per_hour" id="xp_per_hour" required value="<?php echo isset($_POST['xp_per_hour']) ? htmlspecialchars($_POST['xp_per_hour']) : ''; ?>"><br>

    <label for="price_per_item">Price per Item:</label>
    <input type="number" name="price_per_item" id="price_per_item" required value="<?php echo isset($_POST['price_per_item']) ? htmlspecialchars($_POST['price_per_item']) : ''; ?>"><br>

    <label for="xp_per_item">XP per Item:</label>
    <input type="number" name="xp_per_item" id="xp_per_item" required value="<?php echo isset($_POST['xp_per_item']) ? htmlspecialchars($_POST['xp_per_item']) : ''; ?>"><br>

    <label for="skill">Select Skill:</label>
    <select name="skill" id="skill">
        <option value="Prayer">Prayer</option>
        <option value="Magic">Magic</option>
        <option value="Construction">Construction</option>
        <option value="Herblore">Herblore</option>
        <option value="Crafting">Crafting</option>
        <option value="Fletching">Fletching</option>
        <option value="Smithing">Smithing</option>
        <option value="Cooking">Cooking</option>
        <option value="Farming">Farming</option>
    </select><br>

    <input type="submit" value="Calculate">
</form>

<?php

// Function to fetch player information from the RuneScape Hiscores API
function getPlayerInfo($username) {
    // API endpoint
    $url = "https://secure.runescape.com/m=hiscore/index_lite.ws?player=" . urlencode($username);
    echo "<p>Fetching player information from: $url</p>";

    // Fetch data from the API
    $data = @file_get_contents($url);

    // Check if data was fetched successfully
    if ($data === false) {
        return false; // Unable to fetch data
    }

    // Split the fetched data into an array
    $stats = explode("\n", $data);

    // Parse the player's stats
    $playerInfo = array();
    $skills = array(
        "Overall",
        "Attack",
        "Defence",
        "Strength",
        "Constitution",
        "Ranged",
        "Prayer",
        "Magic",
        "Cooking",
        "Woodcutting",
        "Fletching",
        "Fishing",
        "Firemaking",
        "Crafting",
        "Smithing",
        "Mining"
    );

    foreach ($skills as $skill) {
        $statData = explode(",", $stats[array_search($skill, $skills)]);
        $playerInfo[$skill] = array(
            'rank' => $statData[0],
            'level' => $statData[1],
            'xp' => $statData[2]
        );
    }

    return $playerInfo;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $info = getPlayerInfo($username);

    if ($info !== false) {
        $skill = $_POST["skill"];
        $xpPerHour = $_POST["xp_per_hour"];
        $pricePerItem = $_POST["price_per_item"];
        $xpPerItem = $_POST["xp_per_item"];

        $xpRequired = 13034431 - $info[$skill]["xp"];
        $hoursRequired = ceil($xpRequired / $xpPerHour);
        $totalCost = ceil($xpRequired / $xpPerItem) * $pricePerItem;
        $formattedCost = number_format($totalCost, 0);

        echo "<div class='result'>";
        echo "<h2>Current $skill Level for Player $username: " . $info[$skill]["level"] . "</h2>";
        echo "<h3>Estimated Time and Cost to Reach Level 99 $skill:</h3>";
        echo "<p>XP Required: $xpRequired</p>";
        echo "<p>XP per Hour: $xpPerHour</p>";
        echo "<p>Hours Required: $hoursRequired</p>";
        echo "<p>Total Cost: $formattedCost coins</p>";

        // Calculate days required for different hours per day
        $hoursPerDay = array(1, 2, 4, 6, 8, 10, 12, 16, 20, 24);
        echo "<h3>Days Required for Different Hours per Day:</h3>";
        echo "<ul>";
        foreach ($hoursPerDay as $hours) {
            $days = ceil($hoursRequired / $hours);
            echo "<li>$hours hours/day: $days days</li>";
        }
        echo "</ul>";

        echo "</div>";
    } else {
        echo "<p class='error'>Failed to fetch player information. Please try again.</p>";
    }
}

?>

</body>
</html>
