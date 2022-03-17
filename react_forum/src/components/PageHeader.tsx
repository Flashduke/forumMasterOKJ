import { useMediaQuery } from 'react-responsive';
import { Link } from 'react-router-dom';

type Props = {
  type: string;
  name?: string;
  peopleCount?: number;
  description?: string;
  createdAt?: Date;
  icon?: string;
  banner?: string;
};

const IMG_URL = 'http://localhost/forumMasterOKJ/php_rest_forum/img/';

function PageHeader({
  type,
  name,
  peopleCount,
  description,
  createdAt,
  icon,
  banner,
}: Props) {
  const isMobile = useMediaQuery({ query: '(max-width: 600px)' });
  return (
    <header className="page-header">
      <div className="banner" role="banner">
        <img
          src={IMG_URL + type + '/banners/' + icon}
          alt={name + ' banner'}
          onError={({ currentTarget }) => {
            currentTarget.onerror = null; // prevents looping
            currentTarget.src = IMG_URL + 'unnamed.png';
          }}
        />
      </div>
      <div className="header-content">
        <div className="header-icon-wrapper">
          <img
            src={IMG_URL + type + '/icons/' + banner}
            alt={name + ' icon'}
            className="header-icon"
            onError={({ currentTarget }) => {
              currentTarget.onerror = null; // prevents looping
              currentTarget.src = IMG_URL + 'unnamed.png';
            }}
          />
        </div>
        {type === 'post' && (
          <Link to={`/${type.substring(1, 2)}/${name}`}>
            <h1>{name}</h1>
          </Link>
        )}
        {type !== 'post' && (
          <>
            <div className="header-info">
              <h1>{name}</h1>
              {isMobile && (
                <>
                  <span>{'Description'}</span>
                  <br />
                  <span>
                    {type === 'profile' ? 'Followers: ' : 'Members: '}
                    {peopleCount}
                  </span>
                </>
              )}
            </div>
            <button className="btn hollow">
              {type === 'profile'
                ? true
                  ? 'Followed'
                  : 'Follow'
                : type === 'community' && (true ? 'Joined' : 'Join')}
            </button>
            {type !== 'profile' && isMobile && (
              <button className="btn full">Create Post</button>
            )}
          </>
        )}
      </div>
    </header>
  );
}

export default PageHeader;
