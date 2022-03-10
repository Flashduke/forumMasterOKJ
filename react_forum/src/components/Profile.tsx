import { useNavigate, useParams } from 'react-router-dom';
import Feed from './Feed';

type Props = {};

const Profile = (props: Props) => {
  const params = useParams();
  const navigate = useNavigate();

  return (
    <>
      <main>
        {params.profile} Profile
        <Feed profile={params.profile} onProfilePage={true} />
      </main>
      <aside></aside>
    </>
  );
};

export default Profile;
