import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from '../api/axios';
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
  const { rating } = useRating();
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

  useEffect(() => {
    setAllPosts(defaultPostData);
    getPosts();
  }, [rating]);

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
