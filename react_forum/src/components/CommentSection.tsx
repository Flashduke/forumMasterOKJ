import { useEffect, useState } from 'react';
import axios from '../api/axios';
import useRating from '../hooks/useRating';
import { commentData, defaultCommentData } from '../models/Comment';
import Comment from './Comment';

type Props = { postID?: string; profile?: string; onProfilePage?: boolean };

function CommentSection({ postID, profile, onProfilePage }: Props) {
  const { rating } = useRating();
  const [allComments, setAllComments] =
    useState<commentData>(defaultCommentData);

  const getComments = async () => {
    try {
      const response = await axios.get(
        `/comment/read.php${
          postID ? '?postID=' + postID : profile && '?profile=' + profile
        }`,
        { withCredentials: true }
      );
      const responseObj = response?.data;
      setAllComments({ isLoaded: true, comments: responseObj?.comments });
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    setAllComments(defaultCommentData);
    getComments();
  }, [rating]);
  return (
    <section>
      {!allComments.isLoaded ? (
        <p>Loading...</p>
      ) : (
        allComments.comments.map((comment, index) => (
          <Comment
            key={index}
            comment={comment}
            onProfilePage={onProfilePage}
          />
        ))
      )}
    </section>
  );
}

export default CommentSection;
