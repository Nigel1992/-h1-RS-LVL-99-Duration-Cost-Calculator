# RuneScape Leveling Cost & Duration Calculator

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Example](#example)
4. [How to Use](#how-to-use)
5. [Notes](#notes)
6. [Credits](#credits)
7. [License](#license)
8. [Changelog](#changelog)

## Overview
This web application provides a convenient way to estimate the time and cost required to reach a specific level in a chosen skill in the game RuneScape. By inputting your current in-game username, desired skill, target level, and other relevant parameters, the calculator will provide you with an estimate of the hours, minutes, and cost required to achieve your goal.

## Features
- Input your RuneScape username to fetch your current skill levels.
- Select the skill you want to level up.
- Specify the target level you want to achieve.
- Input your XP/Hour rate to estimate the time required.
- Optionally input XP/Item and Price/Item values to calculate the total cost.
- Get detailed estimates for hours, minutes, and cost required to reach your goal.
- See how the duration changes based on different hours per day.

## Example [version 1.1.1]
Using my account, prayer with Dragon Bones + Burial Powder
![image](https://github.com/Nigel1992/RuneScape-Leveling-Cost-Duration-Calculator/assets/5491930/3482c184-4799-449a-b6bb-c2a2979d3052)


## How to Use
1. Clone or download the repository to your local machine.
2. Open the `index.php` file in your preferred text editor or IDE.
3. Make sure you have PHP installed on your machine to run the script.
4. Start a local server or upload the files to a web server.
5. Access the application through a web browser.
6. Fill in the form fields with your desired inputs and click "Calculate".
7. View the estimated time and cost to reach your target level.

## Notes
- If the provided target level is lower than your current level or not in the hiscores yet, an error message will be displayed.
- The XP required is fetched from a CSV file containing the XP values for each level in RuneScape.
- The cost estimation is based on the XP/Item and Price/Item values provided, if applicable.

## Credits
This application utilizes the RuneScape Hiscores API to fetch player information and calculates XP requirements based on data from a CSV file.

## License
This project is licensed under the MIT License. See the LICENSE file for details.

## Changelog

### [Version 1.1.1] - [2024-05-06]
#### Changed

- Added feature to display the user's in-game avatar dynamically based on the provided username.
- Integrated JavaScript to fetch and display the avatar image above the player's current skill level information.
- Updated HTML and PHP code to include the in-game avatar display functionality.
- Improved user experience by providing visual representation of the user's in-game identity.


### Version 1.1.0 - 2024-05-06
#### Changed
- Updated background and text colors for better readability and user experience.
- Enhanced styling of form elements to maintain consistency and improve aesthetics.
- Added checkbox functionality to remember username with JavaScript implementation.
- Improved input field styling to ensure better alignment and appearance.
- Enhanced JavaScript logic for checkbox functionality, enabling dynamic field behavior.
- Refined result display format and error messages for clarity and user guidance.
- Optimized code structure and formatting for improved maintainability.
- Added clickable information icons next to each input field for better user guidance.
- Rearranged the layout to display information boxes above each input label and below the main text for improved visibility and user-friendliness.
- Implemented JavaScript functionality to toggle the visibility of information boxes when the corresponding information icon is clicked.

## NOTE
This code was made by AI and tested by me.
<br>
Feel free to contact me on Discord for any help or suggestions: nigel.92

## Third-Party URLs

- RuneScape Hiscores API: [https://secure.runescape.com/m=hiscore/index_lite.ws](https://secure.runescape.com/m=hiscore/index_lite.ws) - Used to fetch player information such as levels and experience points.
- RuneScape Avatar API: [http://secure.runescape.com/m=avatar-rs/USERNAME/chat.png](http://secure.runescape.com/m=avatar-rs/USERNAME/chat.png) - Utilized to display the user's in-game avatar dynamically based on the provided username.
