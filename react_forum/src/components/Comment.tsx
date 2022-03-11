import ReactMarkdown from 'react-markdown';
import { Link } from 'react-router-dom';
import remarkGfm from 'remark-gfm';
import TimeAgo from 'timeago-react';
import { formatAuthor } from '../helpers';
import useAuth from '../hooks/useAuth';
import { IComment } from '../models/Comment';
import Rating from './Rating';

type Props = { comment: IComment; onProfilePage?: boolean };

function Comment({ comment, onProfilePage }: Props) {
  const { auth } = useAuth();
  return (
    <article className="comment">
      <div className="content-info">
        <div className={`profile-pic ${onProfilePage && 'transparent'}`}></div>
        <span>
          <Link to={'/p/' + comment.author}>
            {formatAuthor(comment.author, auth?.name)}
          </Link>{' '}
          commented{' '}
          {onProfilePage && (
            <>
              on{' '}
              <Link to={`/${comment.communityName}/${comment.postID}`}>
                {comment.postTitle}
              </Link>
              {', '}
            </>
          )}
          {onProfilePage && (
            <>
              in{' '}
              <Link to={'/c/' + comment.communityName.replace(' ', '_')}>
                {comment.communityName}
              </Link>{' '}
            </>
          )}
          <TimeAgo datetime={comment.createdAt} />
        </span>
      </div>
      <section className="comment-body">
        <ReactMarkdown
          components={{
            h1: 'h3',
            h2: 'h4',
            h3: 'h5',
            h4: 'h5',
            h5: 'h5',
            h6: 'h5',
          }}
          children={comment.content}
          remarkPlugins={[remarkGfm]}
        />
      </section>
      <div className="interact" aria-label="Interaction Like, Dislike">
        <Rating
          type="post"
          id={comment.id}
          thumbsUps={comment.thumbsUps}
          thumbsDowns={comment.thumbsDowns}
        />
      </div>
    </article>
  );
}

export default Comment;
