import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import axios from '../api/axios';
import { defaultPostData, postData } from '../models/Post';
import Post from './Post';

type Props = {};

function Feed({}: Props) {
  const [allPosts, setAllPosts] = useState<postData>(defaultPostData);

  const getPosts = async () => {
    try {
      const response = await axios.get('/post/read.php', {
        withCredentials: true,
      });
      const responseObj = response?.data;
      setAllPosts({ isLoaded: true, posts: responseObj?.posts });
      console.log(responseObj);
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    getPosts();
  }, []);

  return (
    <section role="feed" className="feed">
      {!allPosts.isLoaded ? (
        <p>Loading...</p>
      ) : (
        allPosts.posts.map((post, index) => <Post key={index} post={post}></Post>)
      )}
    </section>
  );
}

export default Feed;
