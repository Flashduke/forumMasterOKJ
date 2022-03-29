import { useEffect, useState } from 'react';
import { useMediaQuery } from 'react-responsive';
import { Link } from 'react-router-dom';
import { BASE_URL } from '../api/axios';
import useAxiosPrivate from '../hooks/useAxiosPrivate';

type Props = {
  id?: string;
  type: string;
  name?: string;
  peopleCount?: number;
  description?: string;
  createdAt?: Date;
  icon?: string;
  banner?: string;
};

const IMG_URL = BASE_URL + 'img/';

function PageHeader({
  id,
  type,
  name,
  peopleCount,
  description,
  createdAt,
  icon,
  banner,
}: Props) {
  const isMobile = useMediaQuery({ query: '(max-width: 600px)' });
  const axiosPrivate = useAxiosPrivate();
  const controller = new AbortController();

  const [followOrJoin, setFollowOrJoinState] = useState(false);

  const getFollowingOrJoined = async () => {
    try {
      const response = await axiosPrivate.get(
        `${type === 'profile' ? 'follow' : 'join'}/check.php?${type}ID=` + id
      );
      response?.data?.state && setFollowOrJoinState(response?.data?.state);
      console.log(followOrJoin);
    } catch (err) {
      console.error(err);
    }
  };

  const handleClick = async (followOrJoinState: boolean) => {
    try {
      if (!followOrJoinState) {
        const response = await axiosPrivate.delete(
          `${type === 'profile' ? 'follow' : 'join'}/delete.php`,
          {
            signal: controller.signal,
            data: JSON.stringify({ [type + 'ID']: id }),
          }
        );
      }
      if (followOrJoinState) {
        const response = await axiosPrivate.post(
          `${type === 'profile' ? 'follow' : 'join'}/create.php`,
          JSON.stringify({
            [type + 'ID']: id,
          }),
          { signal: controller.signal }
        );
      }
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    getFollowingOrJoined();
  }, [id]);

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
              currentTarget.src =
                IMG_URL +
                (type === 'post' ? 'community' : type) +
                '/icons/' +
                'default.png';
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
                  <span>{description}</span>
                  <br />
                  <span>
                    {type === 'profile' ? 'Followers: ' : 'Members: '}
                    {peopleCount}
                  </span>
                </>
              )}
            </div>
            <button
              className="btn hollow"
              onClick={() => {
                setFollowOrJoinState((value) => !value);
                handleClick(!followOrJoin);
              }}
            >
              {type === 'profile'
                ? followOrJoin
                  ? 'Following'
                  : 'Follow'
                : type === 'community' && (followOrJoin ? 'Joined' : 'Join')}
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
