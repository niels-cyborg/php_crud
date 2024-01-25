<nav>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="admin.php">Admin</a></li>
    <li><a href="productShow.php">Producten</a></li>
    <li><a href="userShow.php">Users</a></li>
    <li><a href="productAdd.php">Producten toevoegen</a></li>
    <li><a href="userAdd.php">Users toevoegen</a></li>
  </ul>
</nav>

<style>* {
  padding: 0;
  margin: 0;
}

body {
  font-family: Arial, Tahoma, Serif;
  color: #263238;
}

nav {
  display: flex; /* 1 */
  justify-content: space-between; /* 2 */
  padding: 1rem 2rem; /* 3 */
  background: #cfd8dc; /* 4 */
}

nav ul {
  display: flex; /* 5 */
  list-style: none; /* 6 */
}

nav li {
  padding-left: 1rem; /* 7! */
}

nav a {
  text-decoration: none;
  color: #0d47a1
}

@media only screen and (max-width: 600px) {
  nav {
    flex-direction: column;
  }
  nav ul {
    flex-direction: column;
    padding-top: 0.5rem;
  }
  nav li {
    padding: 0.5rem 0;
  }
} 

</style>

