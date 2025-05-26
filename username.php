  <?php
$username = $_SESSION['uname'] ?? 'Guest';
?>
<div class="user-menu">
    <img src="Logo.png" alt="User Icon">
    <span><?php echo htmlspecialchars($username); ?></span>
    <a class="profile-link" href="profile.php?return=request.php">Profile</a>
    <a class="logout-link" href="logout.php">Logout</a>
</div>

<div class="form-box">
    
    <h2>Select Cities</h2>
     <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="request.php" method="POST">
    <div class="city-list">

        <?php
            $cities = [
                "Dhaka", "Delhi", "Beijing", "Sydney", "Karachi",
                "Jakarta", "London", "Berlin", "Rome", "New York",
                "Mexico City", "Istanbul", "Toronto", "Los Angeles",
                "Paris", "Tokyo", "Cairo", "Bangkok", "Moscow", "Bucharest"
            ];

            foreach ($cities as $city) {
                echo "<div class='city-item'><input type='checkbox' name='cities[]' value='$city' onclick='return checkCityLimit(this)'> $city</div>";

            }
        ?>
    </div>
    <input type="submit" value="Submit">
</form>
<script>
function checkCityLimit(checkbox) {
  const selectedCities = document.querySelectorAll('input[name="cities[]"]:checked');
  // If trying to check this box and already 10 are selected, block it:
  if (checkbox.checked === false && selectedCities.length >= 10) {
    alert("You can select a maximum of 10 cities.");
    return false; // Prevent the checkbox from being checked
  }
  return true; // Allow change
}
</script>

</div>
</body>
</html>
