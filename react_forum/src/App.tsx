import Layout from './components/Layout';
import RequireAuth from './components/RequireAuth';
import Admin from './components/Admin';
import { MotionConfig } from 'framer-motion';
import { Routes, Route, Navigate } from 'react-router-dom';
import Home from './components/Home';
import Notifications from './components/Notifications';
import Community from './components/Community';
import Profile from './components/Profile';
import { useEffect, useLayoutEffect } from 'react';
import PostPage from './components/PostPage';
import useRating from './hooks/useRating';
import useAuth from './hooks/useAuth';
import axios from './api/axios';
import useLocalStorage from 'use-local-storage';

function App() {
  const { auth } = useAuth();
  const { setRated } = useRating();

  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const [theme, setTheme] = useLocalStorage('theme', prefersDark ? 'dark' : 'light');

  const getRated = async () => {
    try {
      const response = await axios.get(
        'rated_content/read.php?profile=' + auth?.name,
        { withCredentials: true }
      );
      const likedComments = response?.data?.liked_comments;
      const dislikedComments = response?.data?.disliked_comments;
      const likedPosts = response?.data?.liked_posts;
      const dislikedPosts = response?.data?.disliked_posts;
      setRated({
        likedComments,
        dislikedComments,
        likedPosts,
        dislikedPosts,
      });
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    document.body.classList.remove('light', 'dark');
    document.body.classList.add(theme);
  }, [theme]);

  useEffect(() => {
    getRated();
  }, [auth?.email]);

  return (
    <MotionConfig reducedMotion="user">
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route path="/" element={<Home />} />
          <Route path="/communities" element={<Home />} />
          <Route path="/c" element={<Navigate to="/communities" />} />
          <Route path="/c/:community" element={<Community />} />
          <Route path="/c/:community/:postID" element={<PostPage />} />
          <Route path="/profiles" element={<Home />} />
          <Route path="/p" element={<Navigate to="/profiles" />} />
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
