import { Outlet } from 'react-router-dom';
import { RatingProvider } from '../context/RatingProvider';
import Navbar from './Navbar';

function Layout() {
  return (
    <>
      <Navbar />
      <div className="content">
        <Outlet />
      </div>
    </>
  );
}

export default Layout;
