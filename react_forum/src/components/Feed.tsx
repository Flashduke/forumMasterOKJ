import { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from '../api/axios';
import useAuth from '../hooks/useAuth';
import useRating from '../hooks/useRating';
import { defaultPostData, postData } from '../models/Post';
import Post from './Post';

type Props = {
  community?: string;
  onCommunityPage?: boolean;
  profile?: string;
  onProfilePage?: boolean;
};

function Feed({ community, onCommunityPage, profile, onProfilePage }: Props) {
  const { auth } = useAuth();
  const { rating, setRated } = useRating();
  const navigate = useNavigate();

  const [allPosts, setAllPosts] = useState<postData>(defaultPostData);

  const getPosts = async () => {
    try {
      const response = await axios.get(
        `/post/read.php${
          community
            ? '?community=' + community
            : profile
            ? '?profile=' + profile
            : ''
        }`,
        { withCredentials: true }
      );
      const responseObj = response?.data;
      setAllPosts({ isLoaded: true, posts: responseObj?.posts });
    } catch (err) {
      console.error(err);
      navigate('/404');
    }
  };

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
      console.log(rating);
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    getPosts();
  }, []);

  useEffect(() => {
    getRated();
    getPosts();
  }, [auth]);

  return (
    <section role="feed" className="feed">
      {!allPosts.isLoaded ? (
        <p>Loading...</p>
      ) : (
        allPosts.posts.map((post, index) => (
          <Post
            key={index}
            post={post}
            onCommunityPage={onCommunityPage}
            onProfilePage={onProfilePage}
          />
        ))
      )}
    </section>
  );
}

export default Feed;
