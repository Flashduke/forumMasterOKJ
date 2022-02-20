import Layout from './components/Layout';
import RequireAuth from './components/RequireAuth';
import Admin from './components/Admin';
import { MotionConfig } from 'framer-motion';
import { Routes, Route } from 'react-router-dom';
import Home from './components/Home';
import Notifications from './components/Notifications';

function App() {
  return (
    <MotionConfig reducedMotion="user">
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route path="/" element={<Home />} />
          <Route path="/notifications" element={<Notifications />} />
          <Route element={<RequireAuth />}>
            <Route path="admin" element={<Admin />} />
          </Route>
        </Route>
      </Routes>
    </MotionConfig>
  );
}

export default App;
