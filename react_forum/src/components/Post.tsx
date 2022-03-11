import ReactMarkdown from 'react-markdown';
import { Link, useNavigate } from 'react-router-dom';
import remarkGfm from 'remark-gfm';
import TimeAgo from 'timeago-react';
import { formatAuthor, formatCount } from '../helpers';
import useAuth from '../hooks/useAuth';
import { IPost } from '../models/Post';
import Comment from './Comment';
import Rating from './Rating';

type Props = {
  post: IPost;
  onCommunityPage?: boolean;
  onProfilePage?: boolean;
  onPostPage?: boolean;
};

function Post({ post, onCommunityPage, onProfilePage, onPostPage }: Props) {
  const { auth } = useAuth();

  const navigate = useNavigate();

  const handleChildElementClick = (e: React.MouseEvent<HTMLElement>) => {
    e.stopPropagation();
  };

  return (
    <article
      className={`post ${!onPostPage && 'post-preview'}`}
      aria-labelledby={'post_' + post.id}
      onClick={() =>
        !onPostPage &&
        navigate(`/c/${post.communityName.replace(' ', '_')}/${post.id}`)
      }
    >
      <header>
        <h2 id={'post_' + post.id}>{post.title}</h2>
        <span className="content-info">
          Posted{' '}
          {!onCommunityPage && !onPostPage && (
            <>
              on{' '}
              <Link
                to={'/c/' + post.communityName.replace(' ', '_')}
                onClick={(e) => handleChildElementClick(e)}
              >
                {post.communityName}
              </Link>{' '}
            </>
          )}
          {!onProfilePage && !onPostPage && (
            <>
              by{' '}
              <Link
                to={'/p/' + post.author}
                onClick={(e) => handleChildElementClick(e)}
              >
                {formatAuthor(post.author, auth?.name)}
              </Link>
              {', '}
            </>
          )}
          <TimeAgo datetime={post.createdAt} />
        </span>
      </header>
      <section aria-label="Post body" className="post-body">
        <ReactMarkdown
          components={{
            h1: 'h3',
            h2: 'h4',
            h3: 'h5',
            h4: 'h5',
            h5: 'h5',
            h6: 'h5',
          }}
          children={post.content}
          remarkPlugins={[remarkGfm]}
        />
      </section>
      <div
        className="interact"
        aria-label="Interaction Like, Dislike, Comment"
        onClick={(e) => handleChildElementClick(e)}
      >
        <Link
          to={`/c/${post.communityName.replace(' ', '_')}/${post.id}`}
          className="btn to-post"
          aria-label="Go to post"
        >
          Go to post
        </Link>
        <Rating
          type="post"
          id={post.id}
          thumbsUps={post.thumbsUps}
          thumbsDowns={post.thumbsDowns}
        />
        <Link
          to={`/c/${post.communityName.replace(' ', '_')}/${post.id}`}
          aria-label="comment"
          className="btn"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="1.2rem"
            height="1.2rem"
            fill="currentColor"
            className="bi bi-chat-right-text-fill"
            viewBox="0 0 16 16"
          >
            <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353V2zM3.5 3h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1 0-1zm0 2.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1 0-1zm0 2.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z" />
          </svg>{' '}
        </Link>

        <p aria-label="Comment count">{formatCount(post.commentCount)}</p>
      </div>
      {onPostPage && <section></section>}
    </article>
  );
}
export default Post;
