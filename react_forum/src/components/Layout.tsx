import { Outlet } from 'react-router-dom';
import { RatingProvider } from '../context/RatingProvider';
import Navbar from './Navbar';

function Layout() {
  return (
    <>
      <Navbar />
      <main className="App">
        <RatingProvider>
          <Outlet />
        </RatingProvider>
      </main>
    </>
  );
}

export default Layout;
