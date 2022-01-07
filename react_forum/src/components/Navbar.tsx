function Navbar() {
  return (
    <nav className="navbar">
        <h2><a className="brand" href="/">Forum</a></h2>
        <ul className="navbar-nav">
            <li className="nav-item"><a className="btn hollow" href="/">Login</a></li>
            <li className="nav-item"><a className="btn full" href="/">Signup</a></li>
        </ul>
    </nav>
  );
}

export default Navbar;
