<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuneScape Leveling Cost & Duration Calculator</title>
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

        input[type="checkbox"] {
            margin-bottom: 10px;
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

<h1>RuneScape Leveling Cost & Duration Calculator</h1>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"><br>

    <label for="xp_per_hour">XP/Hour:</label>
    <input type="number" name="xp_per_hour" id="xp_per_hour" required value="<?php echo isset($_POST['xp_per_hour']) ? htmlspecialchars($_POST['xp_per_hour']) : ''; ?>"><br>

    <label for="xp_per_item">XP/Item:</label>
    <input type="number" name="xp_per_item" id="xp_per_item" <?php echo isset($_POST['use_xp_item']) && $_POST['use_xp_item'] == 'on' ? 'disabled' : ''; ?> value="<?php echo isset($_POST['xp_per_item']) ? htmlspecialchars($_POST['xp_per_item']) : ''; ?>"><br>
    
    <label for="price_per_item">Price/Item [each]:</label>
    <input type="number" name="price_per_item" id="price_per_item" <?php echo isset($_POST['use_price_item']) && $_POST['use_price_item'] == 'on' ? 'disabled' : ''; ?> value="<?php echo isset($_POST['price_per_item']) ? htmlspecialchars($_POST['price_per_item']) : ''; ?>"><br>

    <input type="checkbox" name="use_xp_item" id="use_xp_item" <?php echo isset($_POST['use_xp_item']) && $_POST['use_xp_item'] == 'on' ? 'checked' : ''; ?>>
    <label for="use_xp_item">Exclude XP/Item</label><br>
    
    <input type="checkbox" name="use_price_item" id="use_price_item" <?php echo isset($_POST['use_price_item']) && $_POST['use_price_item'] == 'on' ? 'checked' : ''; ?>>
    <label for="use_price_item">Exclude Price/Item</label><br>

    <label for="selected_skill">Select a Skill:</label>
<select name="selected_skill" id="selected_skill">
    <?php
        $skills = array(
            "Prayer", "Magic", "Construction", "Herblore", "Crafting", "Fletching", "Smithing", "Cooking", 
            "Farming", "Agility", "Thieving", "Ranged", "Mining", "Woodcutting", "Firemaking", "Runecrafting", 
            "Hunter", "Construction", "Slayer", "Fishing", "Herblore", "Crafting", "Fletching", "Smithing", 
            "Cooking", "Farming", "Summoning", "Dungeoneering", "Divination", "Invention", "Archaeology", 
            "Necromancy"
        );

        sort($skills); // Sort the array alphabetically

        foreach ($skills as $skill) {
            $selected = isset($_POST['selected_skill']) && $_POST['selected_skill'] === $skill ? 'selected' : '';
            echo "<option value='$skill' $selected>$skill</option>";
        }
    ?>
</select>
<br><br>

    <label for="selected_level">Enter a Level:</label>
    (Type MAX for 200m XP)
    <br>
    <input type="text" name="selected_level" id="selected_level" placeholder="Enter level" required value="<?php echo isset($_POST['selected_level']) ? htmlspecialchars($_POST['selected_level']) : ''; ?>"><br>

    <input type="submit" value="Calculate">
</form>

<?php

// Function to fetch player information from the RuneScape Hiscores API
function getPlayerInfo($username) {
    // API endpoint
    $url = "https://secure.runescape.com/m=hiscore/index_lite.ws?player=" . urlencode($username);
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
        "Mining",
        "Herblore",
        "Agility",
        "Thieving",
        "Slayer",
        "Farming",
        "Runecrafting",
        "Hunter",
        "Construction",
        "Summoning",
        "Dungeoneering",
        "Divination",
        "Invention",
        "Archaeology",
        "Necromancy"
    );
    foreach ($skills as $idx => $skill) {
        $stat = explode(",", $stats[$idx]);
        $playerInfo[$skill] = array(
            "rank" => $stat[0],
            "level" => $stat[1],
            "xp" => $stat[2]
        );
    }
    return $playerInfo;
}

// Function to get XP for a given level from the CSV file
function getXPForLevel($level) {
    // Path to the CSV file
    $csvFilePath = __DIR__ . "/xp.csv";
    // Fetch data from the CSV file
    $data = @file_get_contents($csvFilePath);
    // Check if data was fetched successfully
    if ($data === false) {
        return false; // Unable to fetch data
    }
    // Split the CSV data into an array of lines
    $lines = explode("\n", $data);
    // Search for the level in the CSV data
    foreach ($lines as $line) {
        $data = explode(',', $line);
        if ($data[0] == $level) {
            return $data[1]; // Return XP for the level
        }
    }
    return false; // Level not found
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $xpPerHour = $_POST["xp_per_hour"];
    $xpPerItem = isset($_POST["use_xp_item"]) && $_POST["use_xp_item"] == 'on' ? 0 : $_POST["xp_per_item"];
    $pricePerItem = isset($_POST["use_price_item"]) && $_POST["use_price_item"] == 'on' ? 0 : $_POST["price_per_item"];
    $selectedSkill = $_POST["selected_skill"];
    $selectedLevel = $_POST["selected_level"];

    // Fetch player information
    $info = getPlayerInfo($username);

    if ($info) {
        // Get XP for the selected level
        $xpForSelectedLevel = getXPForLevel($selectedLevel);

        if ($xpForSelectedLevel !== false) {
            // Calculate XP required for selected level
            $xpRequired = $xpForSelectedLevel - $info[$selectedSkill]["xp"];

            // Check if XP required is negative
            if ($xpRequired < 0) {
                echo "<p class='error'>The level you provided is lower than your current level or not in hiscores yet.</p>";
            } else {
                // Calculate hours required
                $hoursRequired = floor($xpRequired / $xpPerHour);

                // Calculate minutes required
                $minutesRequired = ceil(($xpRequired % $xpPerHour) / ($xpPerHour / 60));

                // Calculate number of items required
                $itemsRequired = $xpPerItem == 0 ? 0 : ceil($xpRequired / $xpPerItem);

                // Calculate total cost
                $totalCost = $pricePerItem == 0 ? 0 : ($itemsRequired * $pricePerItem);

                // Format total cost
                $formattedCost = number_format($totalCost, 0);

                // Output the results
                echo "<div class='result'>";
                echo "<h2>$username's Current $selectedSkill Level: " . $info[$selectedSkill]["level"] . "</h2>";
                echo "<h3>Estimated Time and Cost to Reach Level $selectedLevel $selectedSkill:</h3>";
                echo "<p><u><b>XP Required</u></b>: $xpRequired</p>";
                echo "<p><u><b>XP per Hour</u></b>: $xpPerHour</p>";
                if ($hoursRequired > 0) {
                    echo "<p><u><b>Hours Required</u></b>: $hoursRequired hours";
                    if ($minutesRequired > 0) {
                        echo " and $minutesRequired minutes";
                    }
                    echo "</p>";
                } else {
                    echo "<p><u><b>Minutes Required</u></b>: $minutesRequired minutes</p>";
                }
                if ($xpPerItem != 0) {
                    echo "<p><u><b>Items Required</u></b>: $itemsRequired</p>";
                    echo "<p><u><b>Total Cost</u></b>: $formattedCost coins</p>";
                }
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
            }
        } else {
            echo "<p class='error'>Level $selectedLevel not found. Please enter a valid level.</p>";
        }
    } else {
        echo "<p class='error'>Failed to fetch player information. Please try again.</p>";
    }
}

?>

</body>
</html>
