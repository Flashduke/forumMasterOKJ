import { Outlet } from 'react-router-dom';
import Navbar from './Navbar';

function Layout() {
  return (
    <main className="App dark">
      <Navbar />
      <Outlet />
    </main>
  );
}

export default Layout;
