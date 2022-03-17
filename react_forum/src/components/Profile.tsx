import { useNavigate, useParams } from 'react-router-dom';
import Feed from './Feed';
import PageWrapper from './PageWrapper';

type Props = {};

const Profile = (props: Props) => {
  const params = useParams();
  const navigate = useNavigate();

  return (
    <PageWrapper type='profile' name={params.profile}>
        <Feed profile={params.profile} onProfilePage={true} />
    </PageWrapper>
  );
};

export default Profile;
