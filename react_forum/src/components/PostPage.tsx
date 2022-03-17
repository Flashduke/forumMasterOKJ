import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from '../api/axios';
import useAuth from '../hooks/useAuth';
import { defaultSinglePostData, singlePostData } from '../models/Post';
import PageWrapper from './PageWrapper';
import Post from './Post';

type Props = {};

function PostPage({}: Props) {
  const { auth } = useAuth();

  const params = useParams();
  const [singlePost, setSinglePost] = useState<singlePostData>(
    defaultSinglePostData
  );

  const getSinglePost = async () => {
    try {
      const response = await axios.get(
        '/post/read_single.php?id=' + params.postID,
        { withCredentials: true }
      );
      const responseObj = response?.data;
      setSinglePost({ isLoaded: true, post: responseObj });
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    setSinglePost(defaultSinglePostData);
    getSinglePost();
  }, [auth?.email]);

  return (
    <>
      {!singlePost.isLoaded ? (
        <p>Loading...</p>
      ) : (
        <PageWrapper type="post" post={singlePost.post}>
          <Post post={singlePost.post} onPostPage={true}></Post>
        </PageWrapper>
      )}
    </>
  );
}

export default PostPage;
