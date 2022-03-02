import Layout from './components/Layout';
import RequireAuth from './components/RequireAuth';
import Admin from './components/Admin';
import { MotionConfig } from 'framer-motion';
import { Routes, Route } from 'react-router-dom';
import Home from './components/Home';
import Notifications from './components/Notifications';
import Community from './components/Community';
import Profile from './components/Profile';

function App() {
  return (
    <MotionConfig reducedMotion="user">
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route path="/" element={<Home />} />
          <Route path="/communities" element={<Home />} />
          <Route path="/c/:community" element={<Community />} />
          <Route path="/c/:community/:postID" element={<Home />} />
          <Route path="/profiles" element={<Home />} />
          <Route path="/p/:profile" element={<Profile />} />
          <Route element={<RequireAuth />}>
            <Route path="/notifications" element={<Notifications />} />
            <Route path="/admin" element={<Admin />} />
          </Route>
        </Route>
      </Routes>
    </MotionConfig>
  );
}

export default App;
