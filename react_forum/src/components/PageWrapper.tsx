import { AnimatePresence } from 'framer-motion';
import { useEffect, useState } from 'react';
import { useMediaQuery } from 'react-responsive';
import axios from '../api/axios';
import { communityData, defaultCommunityData } from '../models/Community';
import { IPost } from '../models/Post';
import { defaultProfileData, profileData } from '../models/Profile';
import CreateContent from './CreateContent';
import Modal from './Modal';
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

  const [modalOpen, setModalOpen] = useState(false);
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
          id={
            profile.data
              ? profile?.data?.id
              : community.data && community?.data?.id
          }
          peopleCount={
            profile.data
              ? profile?.data?.followerCount
              : community.data && community?.data?.memberCount
          }
          description={
            profile?.data
              ? profile?.data?.description
              : community?.data && community?.data?.description
          }
          createdAt={
            profile?.data
              ? profile?.data?.createdAt
              : community?.data && community?.data?.createdAt
          }
          icon={
            profile?.data
              ? profile?.data?.icon
              : community?.data && community?.data?.icon
          }
          banner={
            profile?.data
              ? profile?.data?.banner
              : community?.data && community?.data?.banner
          }
        />
      ) : (
        type === 'post' &&
        isMobile && <PageHeader type="post" name={post.communityName} />
      )}

      <div className="content">
        <main>
          {type !== 'profile' && community.isLoaded && (
            <div className="post">
              <CreateContent
                type="post"
                cID={community?.data?.id}
              ></CreateContent>
            </div>
          )}
          {children}
        </main>
        <aside>
          <div className="sticky">
            {community.isLoaded && profile.isLoaded ? (
              type === 'home' ? (
                <PageAbout
                  type="home"
                  description="This is the Forum's front page, here you can see the latest posts."
                  handleOpen={() => setModalOpen(true)}
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
                  handleOpen={() => setModalOpen(true)}
                />
              ) : (
                <>
                  <PageAbout
                    type={'community'}
                    name={community.data.name}
                    peopleCount={community.data.memberCount}
                    description={community.data.description}
                    createdAt={community.data.createdAt}
                    handleOpen={() => setModalOpen(true)}
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
      <AnimatePresence
        initial={false}
        exitBeforeEnter={true}
        onExitComplete={() => null}
      >
        {modalOpen && (
          <Modal handleClose={() => setModalOpen(false)}>
            <CreateContent type="post" cID={community?.data?.id} />
          </Modal>
        )}
      </AnimatePresence>
    </>
  );
}

export default PageWrapper;
