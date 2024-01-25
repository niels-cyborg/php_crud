<ul class="nav">
  <li><a href="index.php">Producten</a></li>
  <li><a href="login.php">Login</a></li>
</ul>
<style>
    ul.nav {
    display:flex;
    justify-content: space-between;
    margin:0;
    margin-bottom: 5vh;
    padding:0;
    list-style:none;
    height:36px; line-height:36px;
    background:#0d7963; /* you can change the backgorund color here. */
    font-family:Arial, Helvetica, sans-serif;
    font-size:13px;
}
ul.nav li {
    border-right:1px solid #189b80; /* you can change the border color matching to your background color */
    float:left;
}
ul.nav a {
    display:block;
    padding:0 28px;
    color:#ccece6;
    text-decoration:none;
}
ul.nav a:hover,
ul.nav li.current a {
    background:#086754;
}
</style>