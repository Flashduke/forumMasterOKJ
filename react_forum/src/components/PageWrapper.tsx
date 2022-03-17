import { useEffect, useState } from 'react';
import { useMediaQuery } from 'react-responsive';
import axios from '../api/axios';
import { communityData, defaultCommunityData } from '../models/Community';
import { IPost } from '../models/Post';
import { defaultProfileData, profileData } from '../models/Profile';
import PageAbout from './PageAbout';
import PageHeader from './PageHeader';

type Props = {
  type: string;
  name?: string;
  children: JSX.Element;
  post?: IPost;
};

function PageWrapper({ type, name, children, post }: Props) {
  const isMobile = useMediaQuery({ query: '(max-width: 600px)' });

  const [community, setCommunity] =
    useState<communityData>(defaultCommunityData);
  const [profile, setProfile] = useState<profileData>(defaultProfileData);

  const getCommunity = async (readName: string) => {
    try {
      const response = await axios.get(
        `/community/read_single.php?name=${readName}`,
        { withCredentials: true }
      );
      const data = response?.data;
      setCommunity({ isLoaded: true, data });
    } catch (err) {
      console.error(err);
    }
  };

  const getProfile = async (readName: string) => {
    try {
      const response = await axios.get(
        `/profile/read_single.php?name=${readName}`,
        { withCredentials: true }
      );
      const data = response?.data;
      setProfile({ isLoaded: true, data });
    } catch (err) {
      console.error(err);
    }
  };

  useEffect(() => {
    if (type === 'post') {
      getCommunity(post.communityName);
      getProfile(post.author);
    }
    if (type === 'community') {
      getCommunity(name);
      setProfile({ isLoaded: true, data: null });
    }
    if (type === 'profile') {
      getProfile(name);
      setCommunity({ isLoaded: true, data: null });
    }
    if (type === 'home') {
      setProfile({ isLoaded: true, data: null });
      setCommunity({ isLoaded: true, data: null });
    }
  }, []);
  return (
    <>
      {type !== 'home' && type !== 'post' ? (
        <PageHeader
          type={type}
          name={name}
          peopleCount={
            profile
              ? profile?.data?.followerCount
              : community && community?.data?.memberCount
          }
          description={
            profile
              ? profile?.data?.description
              : community && community?.data?.description
          }
          createdAt={
            profile
              ? profile?.data?.createdAt
              : community && community?.data?.createdAt
          }
          icon={
            profile ? profile?.data?.icon : community && community?.data?.icon
          }
          banner={
            profile
              ? profile?.data?.banner
              : community && community?.data?.banner
          }
        />
      ) : (
        type === 'post' &&
        isMobile && <PageHeader type="post" name={post.communityName} />
      )}

      <div className="content">
        <main>{children}</main>
        <aside>
          <div className="sticky">
            {community.isLoaded && profile.isLoaded ? (
              type === 'home' ? (
                <PageAbout
                  type="home"
                  description="This is the Forum's front page, here you can see the latest posts."
                />
              ) : type !== 'post' ? (
                <PageAbout
                  type={type}
                  peopleCount={
                    profile.data
                      ? profile?.data?.followerCount
                      : community.data !== null && community?.data?.memberCount
                  }
                  description={
                    profile.data
                      ? profile?.data?.description
                      : community?.data && community?.data?.description
                  }
                  createdAt={
                    profile.data
                      ? profile?.data?.createdAt
                      : community.data && community?.data?.createdAt
                  }
                />
              ) : (
                <>
                  <PageAbout
                    type={'community'}
                    name={community.data.name}
                    peopleCount={community.data.memberCount}
                    description={community.data.description}
                    createdAt={community.data.createdAt}
                  />
                  <PageAbout
                    type={'profile'}
                    name={profile.data.name}
                    peopleCount={profile.data.followerCount}
                    description={profile.data.description}
                    createdAt={profile.data.createdAt}
                  />
                </>
              )
            ) : (
              <span>Loading...</span>
            )}
          </div>
        </aside>
      </div>
    </>
  );
}

export default PageWrapper;
